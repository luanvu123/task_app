<?php

namespace App\Services;

use App\Models\Propose;
use App\Models\ProposeItem;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\UploadedFile;
use Carbon\Carbon;

class ProposeService
{
    /**
     * Create a new propose with items
     */
    public function createPropose(array $data, array $items, array $attachments = []): Propose
    {
        return DB::transaction(function () use ($data, $items, $attachments) {
            // Handle file uploads
            $uploadedAttachments = $this->handleFileUploads($attachments, 'proposes/attachments');

            // Create the propose
            $propose = Propose::create(array_merge($data, [
                'attachments' => $uploadedAttachments,
                'status' => Propose::STATUS_DRAFT,
            ]));

            // Create propose items
            foreach ($items as $itemData) {
                $item = new ProposeItem($itemData);
                $propose->items()->save($item);
            }

            // Calculate total amount
            $propose->calculateTotalAmount();

            Log::info('Propose created', ['propose_id' => $propose->id, 'user_id' => $data['proposed_by']]);

            return $propose->load('items');
        });
    }

    /**
     * Update propose with items
     */
    public function updatePropose(Propose $propose, array $data, array $items, array $attachments = []): Propose
    {
        if (!$propose->canBeEdited()) {
            throw new \Exception('Đề xuất này không thể chỉnh sửa.');
        }

        return DB::transaction(function () use ($propose, $data, $items, $attachments) {
            // Handle new file uploads
            $existingAttachments = $propose->attachments ?? [];
            if (!empty($attachments)) {
                $newAttachments = $this->handleFileUploads($attachments, 'proposes/attachments');
                $existingAttachments = array_merge($existingAttachments, $newAttachments);
            }

            // Update the propose
            $propose->update(array_merge($data, [
                'attachments' => $existingAttachments,
            ]));

            // Update items
            $this->updateProposeItems($propose, $items);

            // Recalculate total amount
            $propose->calculateTotalAmount();

            Log::info('Propose updated', ['propose_id' => $propose->id]);

            return $propose->load('items');
        });
    }

    /**
     * Submit propose for review
     */
    public function submitPropose(Propose $propose): bool
    {
        if ($propose->status !== Propose::STATUS_DRAFT) {
            throw new \Exception('Chỉ có thể gửi đề xuất ở trạng thái nháp.');
        }

        if ($propose->items()->count() === 0) {
            throw new \Exception('Đề xuất phải có ít nhất một mục hàng hóa/dịch vụ.');
        }

        $propose->update(['status' => Propose::STATUS_SUBMITTED]);

        // Notify reviewers
        $this->notifyReviewers($propose);

        Log::info('Propose submitted', ['propose_id' => $propose->id]);

        return true;
    }

    /**
     * Review propose
     */
    public function reviewPropose(
        Propose $propose,
        User $reviewer,
        string $action,
        string $comments = null
    ): bool {
        if (!in_array($propose->status, [Propose::STATUS_SUBMITTED, Propose::STATUS_UNDER_REVIEW])) {
            throw new \Exception('Đề xuất này không thể xem xét.');
        }

        $newStatus = match($action) {
            'approve' => Propose::STATUS_PENDING_APPROVAL,
            'request_changes' => Propose::STATUS_SUBMITTED,
            'reject' => Propose::STATUS_REJECTED,
            default => throw new \Exception('Hành động không hợp lệ.')
        };

        $propose->update([
            'status' => $newStatus,
            'reviewed_by' => $reviewer->id,
            'reviewed_at' => now(),
            'review_comments' => $comments
        ]);

        // Send notifications based on action
        if ($action === 'approve') {
            $this->notifyApprovers($propose);
        } else {
            $this->notifyProposer($propose, 'reviewed');
        }

        Log::info('Propose reviewed', [
            'propose_id' => $propose->id,
            'reviewer_id' => $reviewer->id,
            'action' => $action
        ]);

        return true;
    }

    /**
     * Approve or reject propose
     */
    public function approvePropose(
        Propose $propose,
        User $approver,
        string $action,
        float $approvedAmount = null,
        string $comments = null
    ): bool {
        if ($propose->status !== Propose::STATUS_PENDING_APPROVAL) {
            throw new \Exception('Đề xuất này không thể phê duyệt.');
        }

        $approvedAmount = $approvedAmount ?? $propose->total_amount;

        $newStatus = match($action) {
            'approve' => Propose::STATUS_APPROVED,
            'partial_approve' => Propose::STATUS_PARTIALLY_APPROVED,
            'reject' => Propose::STATUS_REJECTED,
            default => throw new \Exception('Hành động không hợp lệ.')
        };

        $propose->update([
            'status' => $newStatus,
            'approved_by' => $approver->id,
            'approved_at' => now(),
            'approved_amount' => $approvedAmount,
            'approval_comments' => $comments
        ]);

        // Update item approval status if partially approved
        if ($action === 'partial_approve') {
            $this->handlePartialApproval($propose, $approvedAmount);
        }

        // Send notifications
        $this->notifyProposer($propose, 'approved');

        if (in_array($newStatus, [Propose::STATUS_APPROVED, Propose::STATUS_PARTIALLY_APPROVED])) {
            $this->notifyProcurementTeam($propose);
        }

        Log::info('Propose approved/rejected', [
            'propose_id' => $propose->id,
            'approver_id' => $approver->id,
            'action' => $action,
            'approved_amount' => $approvedAmount
        ]);

        return true;
    }

    /**
     * Cancel propose
     */
    public function cancelPropose(Propose $propose, User $user, string $reason = null): bool
    {
        if (!in_array($propose->status, [
            Propose::STATUS_DRAFT,
            Propose::STATUS_SUBMITTED,
            Propose::STATUS_UNDER_REVIEW
        ])) {
            throw new \Exception('Đề xuất này không thể hủy.');
        }

        $propose->update([
            'status' => Propose::STATUS_CANCELLED,
            'implementation_notes' => $reason ? "Hủy bỏ: {$reason}" : 'Đề xuất đã được hủy bỏ.'
        ]);

        Log::info('Propose cancelled', ['propose_id' => $propose->id, 'user_id' => $user->id]);

        return true;
    }

    /**
     * Update procurement status for items
     */
    public function updateProcurementStatus(ProposeItem $item, string $status, array $data = []): bool
    {
        $allowedStatuses = [
            ProposeItem::PROCUREMENT_NOT_STARTED,
            ProposeItem::PROCUREMENT_QUOTATION_REQUESTED,
            ProposeItem::PROCUREMENT_QUOTATION_RECEIVED,
            ProposeItem::PROCUREMENT_VENDOR_SELECTED,
            ProposeItem::PROCUREMENT_ORDER_PLACED,
            ProposeItem::PROCUREMENT_IN_TRANSIT,
            ProposeItem::PROCUREMENT_DELIVERED,
            ProposeItem::PROCUREMENT_COMPLETED,
            ProposeItem::PROCUREMENT_CANCELLED
        ];

        if (!in_array($status, $allowedStatuses)) {
            throw new \Exception('Trạng thái mua sắm không hợp lệ.');
        }

        $updateData = array_merge($data, ['procurement_status' => $status]);

        // Auto-set delivery dates based on status
        if ($status === ProposeItem::PROCUREMENT_DELIVERED && !isset($data['actual_delivery_date'])) {
            $updateData['actual_delivery_date'] = now()->toDateString();
        }

        $item->update($updateData);

        // Update propose completion percentage
        $this->updateProposeCompletion($item->propose);

        Log::info('Procurement status updated', [
            'item_id' => $item->id,
            'propose_id' => $item->propose_id,
            'status' => $status
        ]);

        return true;
    }

    /**
     * Add vendor quotation to item
     */
    public function addVendorQuotation(ProposeItem $item, array $quotationData): bool
    {
        $existingQuotes = $item->vendor_quotes ?? [];

        $quotation = [
            'vendor_id' => $quotationData['vendor_id'],
            'vendor_name' => $quotationData['vendor_name'],
            'unit_price' => $quotationData['unit_price'],
            'total_price' => $quotationData['unit_price'] * $item->quantity,
            'currency' => $quotationData['currency'] ?? 'VND',
            'delivery_time' => $quotationData['delivery_time'] ?? null,
            'warranty_period' => $quotationData['warranty_period'] ?? null,
            'notes' => $quotationData['notes'] ?? null,
            'quoted_at' => now()->toISOString(),
            'valid_until' => isset($quotationData['valid_until']) ?
                Carbon::parse($quotationData['valid_until'])->toISOString() : null,
        ];

        $existingQuotes[] = $quotation;

        $item->update([
            'vendor_quotes' => $existingQuotes,
            'procurement_status' => ProposeItem::PROCUREMENT_QUOTATION_RECEIVED
        ]);

        Log::info('Vendor quotation added', [
            'item_id' => $item->id,
            'vendor_id' => $quotationData['vendor_id']
        ]);

        return true;
    }

    /**
     * Generate propose statistics
     */
    public function getStatistics(array $filters = []): array
    {
        $query = Propose::query();

        // Apply filters
        if (isset($filters['department_id'])) {
            $query->where('department_id', $filters['department_id']);
        }

        if (isset($filters['project_id'])) {
            $query->where('project_id', $filters['project_id']);
        }

        if (isset($filters['date_from'])) {
            $query->where('created_at', '>=', $filters['date_from']);
        }

        if (isset($filters['date_to'])) {
            $query->where('created_at', '<=', $filters['date_to']);
        }

        return [
            'total_proposes' => $query->count(),
            'by_status' => $query->groupBy('status')
                ->selectRaw('status, count(*) as count')
                ->pluck('count', 'status')
                ->toArray(),
            'by_priority' => $query->groupBy('priority')
                ->selectRaw('priority, count(*) as count')
                ->pluck('count', 'priority')
                ->toArray(),
            'by_type' => $query->groupBy('propose_type')
                ->selectRaw('propose_type, count(*) as count')
                ->pluck('count', 'propose_type')
                ->toArray(),
            'total_amount' => $query->sum('total_amount'),
            'approved_amount' => $query->whereIn('status', [
                Propose::STATUS_APPROVED,
                Propose::STATUS_PARTIALLY_APPROVED
            ])->sum('approved_amount'),
            'average_approval_time' => $this->calculateAverageApprovalTime($query),
            'urgent_proposes' => $query->where('is_urgent', true)->count(),
        ];
    }

    /**
     * Handle file uploads
     */
    private function handleFileUploads(array $files, string $directory): array
    {
        $uploadedFiles = [];

        foreach ($files as $file) {
            if ($file instanceof UploadedFile) {
                $path = $file->store($directory, 'public');
                $uploadedFiles[] = [
                    'name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'size' => $file->getSize(),
                    'mime_type' => $file->getMimeType(),
                    'uploaded_at' => now()->toISOString(),
                ];
            }
        }

        return $uploadedFiles;
    }

    /**
     * Update propose items
     */
    private function updateProposeItems(Propose $propose, array $items): void
    {
        $existingItemIds = [];

        foreach ($items as $itemData) {
            if (isset($itemData['id']) && $itemData['id']) {
                // Update existing item
                $item = $propose->items()->findOrFail($itemData['id']);
                $item->update($itemData);
                $existingItemIds[] = $item->id;
            } else {
                // Create new item
                $item = new ProposeItem($itemData);
                $propose->items()->save($item);
                $existingItemIds[] = $item->id;
            }
        }

        // Delete removed items
        $propose->items()->whereNotIn('id', $existingItemIds)->delete();
    }

    /**
     * Handle partial approval logic
     */
    private function handlePartialApproval(Propose $propose, float $approvedAmount): void
    {
        $totalAmount = $propose->total_amount;
        $approvalRatio = $approvedAmount / $totalAmount;

        // Update item approval status based on priority and approval ratio
        $propose->items()->orderBy('priority', 'desc')->orderBy('is_essential', 'desc')->each(function ($item) use ($approvalRatio) {
            if ($approvalRatio >= 1) {
                $item->update(['approval_status' => ProposeItem::APPROVAL_STATUS_APPROVED]);
            } elseif ($item->is_essential || $item->priority === 'critical') {
                $item->update(['approval_status' => ProposeItem::APPROVAL_STATUS_APPROVED]);
                $approvalRatio -= ($item->final_amount / $item->propose->total_amount);
            } else {
                $item->update(['approval_status' => ProposeItem::APPROVAL_STATUS_REJECTED]);
            }
        });
    }

    /**
     * Update propose completion percentage
     */
    private function updateProposeCompletion(Propose $propose): void
    {
        $totalItems = $propose->items()->count();
        $completedItems = $propose->items()->whereIn('procurement_status', [
            ProposeItem::PROCUREMENT_COMPLETED,
            ProposeItem::PROCUREMENT_DELIVERED
        ])->count();

        $completionPercentage = $totalItems > 0 ? ($completedItems / $totalItems) * 100 : 0;

        $propose->update(['completion_percentage' => round($completionPercentage)]);

        // Mark as completed if all items are done
        if ($completionPercentage >= 100 && $propose->status !== Propose::STATUS_COMPLETED) {
            $propose->update([
                'status' => Propose::STATUS_COMPLETED,
                'completion_date' => now()
            ]);
        }
    }

    /**
     * Calculate average approval time
     */
    private function calculateAverageApprovalTime($query): float
    {
        $approvedProposes = $query->whereNotNull('approved_at')->get();

        if ($approvedProposes->isEmpty()) {
            return 0;
        }

        $totalHours = $approvedProposes->sum(function ($propose) {
            return $propose->created_at->diffInHours($propose->approved_at);
        });

        return round($totalHours / $approvedProposes->count(), 2);
    }

    /**
     * Send notifications to reviewers
     */
    private function notifyReviewers(Propose $propose): void
    {
        // Implementation depends on your notification system
        // This could use Mail, Queue jobs, or Laravel Notifications

        Log::info('Notifying reviewers', ['propose_id' => $propose->id]);

        // Example: Find reviewers and send notification
        // $reviewers = User::role('reviewer')->get();
        // Notification::send($reviewers, new ProposeSubmittedNotification($propose));
    }

    /**
     * Send notifications to approvers
     */
    private function notifyApprovers(Propose $propose): void
    {
        Log::info('Notifying approvers', ['propose_id' => $propose->id]);

        // Similar to notifyReviewers but for approvers
    }

    /**
     * Send notification to proposer
     */
    private function notifyProposer(Propose $propose, string $action): void
    {
        Log::info('Notifying proposer', [
            'propose_id' => $propose->id,
            'proposer_id' => $propose->proposed_by,
            'action' => $action
        ]);

        // Send notification to the person who created the propose
    }

    /**
     * Send notification to procurement team
     */
    private function notifyProcurementTeam(Propose $propose): void
    {
        Log::info('Notifying procurement team', ['propose_id' => $propose->id]);

        // Notify procurement team that a propose has been approved
    }
}

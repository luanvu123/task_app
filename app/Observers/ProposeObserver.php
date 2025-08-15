<?php

namespace App\Observers;

use App\Models\Propose;
use App\Models\ProposeItem;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class ProposeObserver
{
    /**
     * Handle the Propose "creating" event.
     */
    public function creating(Propose $propose): void
    {
        // Set default values
        if (empty($propose->propose_code)) {
            $propose->propose_code = $propose->generateProposeCode();
        }

        if (empty($propose->currency)) {
            $propose->currency = 'VND';
        }

        if (empty($propose->status)) {
            $propose->status = Propose::STATUS_DRAFT;
        }

        Log::info('Creating propose', ['title' => $propose->title, 'proposed_by' => $propose->proposed_by]);
    }

    /**
     * Handle the Propose "created" event.
     */
    public function created(Propose $propose): void
    {
        Log::info('Propose created', [
            'id' => $propose->id,
            'code' => $propose->propose_code,
            'title' => $propose->title,
            'proposed_by' => $propose->proposed_by
        ]);

        // Clear relevant caches
        $this->clearStatisticsCache();
        $this->clearUserProposeCache($propose->proposed_by);
    }

    /**
     * Handle the Propose "updating" event.
     */
    public function updating(Propose $propose): void
    {
        $originalStatus = $propose->getOriginal('status');
        $newStatus = $propose->status;

        // Log status changes
        if ($originalStatus !== $newStatus) {
            Log::info('Propose status changing', [
                'id' => $propose->id,
                'code' => $propose->propose_code,
                'from' => $originalStatus,
                'to' => $newStatus
            ]);

            // Set timestamps for status changes
            $this->setStatusTimestamps($propose, $newStatus);
        }

        // Validate status transitions
        $this->validateStatusTransition($propose, $originalStatus, $newStatus);
    }

    /**
     * Handle the Propose "updated" event.
     */
    public function updated(Propose $propose): void
    {
        $changes = $propose->getChanges();

        Log::info('Propose updated', [
            'id' => $propose->id,
            'code' => $propose->propose_code,
            'changes' => array_keys($changes)
        ]);

        // Clear caches when propose is updated
        $this->clearStatisticsCache();
        $this->clearUserProposeCache($propose->proposed_by);

        // Handle specific field updates
        if (isset($changes['status'])) {
            $this->handleStatusChange($propose, $propose->getOriginal('status'), $changes['status']);
        }

        if (isset($changes['total_amount'])) {
            Log::info('Propose amount changed', [
                'id' => $propose->id,
                'old_amount' => $propose->getOriginal('total_amount'),
                'new_amount' => $changes['total_amount']
            ]);
        }
    }

    /**
     * Handle the Propose "deleting" event.
     */
    public function deleting(Propose $propose): void
    {
        Log::info('Deleting propose', [
            'id' => $propose->id,
            'code' => $propose->propose_code,
            'status' => $propose->status
        ]);

        // Validate deletion
        if (!$propose->canBeEdited()) {
            throw new \Exception('Cannot delete propose in status: ' . $propose->status);
        }
    }

    /**
     * Handle the Propose "deleted" event.
     */
    public function deleted(Propose $propose): void
    {
        Log::info('Propose deleted', [
            'id' => $propose->id,
            'code' => $propose->propose_code
        ]);

        // Clear caches
        $this->clearStatisticsCache();
        $this->clearUserProposeCache($propose->proposed_by);

        // Clean up associated files if they exist
        if ($propose->attachments) {
            foreach ($propose->attachments as $attachment) {
                if (isset($attachment['path'])) {
                    \Storage::disk('public')->delete($attachment['path']);
                }
            }
        }
    }

    /**
     * Handle the Propose "forceDeleted" event.
     */
    public function forceDeleted(Propose $propose): void
    {
        Log::info('Propose force deleted', [
            'id' => $propose->id,
            'code' => $propose->propose_code
        ]);

        // Same cleanup as soft delete
        $this->deleted($propose);
    }

    /**
     * Set appropriate timestamps based on status
     */
    private function setStatusTimestamps(Propose $propose, string $newStatus): void
    {
        switch ($newStatus) {
            case Propose::STATUS_UNDER_REVIEW:
                if (!$propose->reviewed_at) {
                    $propose->reviewed_at = now();
                }
                break;

            case Propose::STATUS_APPROVED:
            case Propose::STATUS_PARTIALLY_APPROVED:
            case Propose::STATUS_REJECTED:
                if (!$propose->approved_at) {
                    $propose->approved_at = now();
                }
                break;

            case Propose::STATUS_COMPLETED:
                if (!$propose->completion_date) {
                    $propose->completion_date = now();
                }
                break;
        }
    }

    /**
     * Validate status transitions
     */
    private function validateStatusTransition(Propose $propose, ?string $fromStatus, string $toStatus): void
    {
        $validTransitions = [
            Propose::STATUS_DRAFT => [
                Propose::STATUS_SUBMITTED,
                Propose::STATUS_CANCELLED
            ],
            Propose::STATUS_SUBMITTED => [
                Propose::STATUS_UNDER_REVIEW,
                Propose::STATUS_REJECTED,
                Propose::STATUS_CANCELLED,
                Propose::STATUS_DRAFT // Allow back to draft for corrections
            ],
            Propose::STATUS_UNDER_REVIEW => [
                Propose::STATUS_PENDING_APPROVAL,
                Propose::STATUS_REJECTED,
                Propose::STATUS_SUBMITTED // Back for more changes
            ],
            Propose::STATUS_PENDING_APPROVAL => [
                Propose::STATUS_APPROVED,
                Propose::STATUS_PARTIALLY_APPROVED,
                Propose::STATUS_REJECTED
            ],
            Propose::STATUS_APPROVED => [
                Propose::STATUS_COMPLETED,
                Propose::STATUS_CANCELLED
            ],
            Propose::STATUS_PARTIALLY_APPROVED => [
                Propose::STATUS_COMPLETED,
                Propose::STATUS_CANCELLED
            ],
            Propose::STATUS_REJECTED => [
                Propose::STATUS_CANCELLED
            ],
            Propose::STATUS_CANCELLED => [], // Terminal state
            Propose::STATUS_COMPLETED => [] // Terminal state
        ];

        if ($fromStatus && isset($validTransitions[$fromStatus])) {
            if (!in_array($toStatus, $validTransitions[$fromStatus])) {
                throw new \Exception("Invalid status transition from {$fromStatus} to {$toStatus}");
            }
        }
    }

    /**
     * Handle status change side effects
     */
    private function handleStatusChange(Propose $propose, ?string $oldStatus, string $newStatus): void
    {
        // Update related models based on status change
        switch ($newStatus) {
            case Propose::STATUS_APPROVED:
            case Propose::STATUS_PARTIALLY_APPROVED:
                // Mark all items as approved (or handle partial approval)
                if ($newStatus === Propose::STATUS_APPROVED) {
                    $propose->items()->update([
                        'approval_status' => ProposeItem::APPROVAL_STATUS_APPROVED
                    ]);
                }
                break;

            case Propose::STATUS_REJECTED:
                // Mark all items as rejected
                $propose->items()->update([
                    'approval_status' => ProposeItem::APPROVAL_STATUS_REJECTED
                ]);
                break;

            case Propose::STATUS_CANCELLED:
                // Cancel all item procurements
                $propose->items()->update([
                    'procurement_status' => ProposeItem::PROCUREMENT_CANCELLED
                ]);
                break;
        }

        // Log important status changes
        if (in_array($newStatus, [
            Propose::STATUS_APPROVED,
            Propose::STATUS_REJECTED,
            Propose::STATUS_COMPLETED,
            Propose::STATUS_CANCELLED
        ])) {
            Log::info('Important status change', [
                'propose_id' => $propose->id,
                'code' => $propose->propose_code,
                'old_status' => $oldStatus,
                'new_status' => $newStatus,
                'amount' => $propose->total_amount
            ]);
        }
    }

    /**
     * Clear statistics cache
     */
    private function clearStatisticsCache(): void
    {
        Cache::tags(['propose-statistics'])->flush();

        // Clear specific cache keys
        $cacheKeys = [
            'propose_stats_overall',
            'propose_stats_monthly',
            'propose_stats_by_department',
            'propose_stats_by_project'
        ];

        foreach ($cacheKeys as $key) {
            Cache::forget($key);
        }
    }

    /**
     * Clear user-specific propose cache
     */
    private function clearUserProposeCache(int $userId): void
    {
        $cacheKeys = [
            "user_proposes_{$userId}",
            "user_propose_stats_{$userId}",
            "user_draft_proposes_{$userId}"
        ];

        foreach ($cacheKeys as $key) {
            Cache::forget($key);
        }
    }
}

/**
 * ProposeItem Observer
 */
class ProposeItemObserver
{
    /**
     * Handle the ProposeItem "creating" event.
     */
    public function creating(ProposeItem $item): void
    {
        // Set default values
        if (empty($item->tax_percent)) {
            $item->tax_percent = 10; // Default VAT 10%
        }

        if (empty($item->discount_percent)) {
            $item->discount_percent = 0;
        }

        if (empty($item->approval_status)) {
            $item->approval_status = ProposeItem::APPROVAL_STATUS_PENDING;
        }

        if (empty($item->procurement_status)) {
            $item->procurement_status = ProposeItem::PROCUREMENT_NOT_STARTED;
        }
    }

    /**
     * Handle the ProposeItem "created" event.
     */
    public function created(ProposeItem $item): void
    {
        Log::info('Propose item created', [
            'id' => $item->id,
            'propose_id' => $item->propose_id,
            'name' => $item->name,
            'final_amount' => $item->final_amount
        ]);
    }

    /**
     * Handle the ProposeItem "updating" event.
     */
    public function updating(ProposeItem $item): void
    {
        // Recalculate totals if quantity or price changed
        $priceFields = ['quantity', 'unit_price', 'discount_percent', 'tax_percent'];
        $changes = $item->getDirty();

        if (array_intersect_key($changes, array_flip($priceFields))) {
            $item->calculateTotals();
        }
    }

    /**
     * Handle the ProposeItem "updated" event.
     */
    public function updated(ProposeItem $item): void
    {
        $changes = $item->getChanges();

        Log::info('Propose item updated', [
            'id' => $item->id,
            'propose_id' => $item->propose_id,
            'changes' => array_keys($changes)
        ]);

        // Update parent propose total if amount changed
        if (isset($changes['final_amount'])) {
            $item->propose->calculateTotalAmount();
        }

        // Log important status changes
        if (isset($changes['procurement_status'])) {
            Log::info('Item procurement status changed', [
                'item_id' => $item->id,
                'propose_id' => $item->propose_id,
                'old_status' => $item->getOriginal('procurement_status'),
                'new_status' => $changes['procurement_status']
            ]);
        }
    }

    /**
     * Handle the ProposeItem "deleted" event.
     */
    public function deleted(ProposeItem $item): void
    {
        Log::info('Propose item deleted', [
            'id' => $item->id,
            'propose_id' => $item->propose_id,
            'name' => $item->name
        ]);

        // Update parent propose total
        if ($item->propose) {
            $item->propose->calculateTotalAmount();
        }
    }
}

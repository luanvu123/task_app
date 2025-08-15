<?php

namespace App\Http\Controllers;

use App\Models\Propose;
use App\Models\ProposeItem;
use App\Models\Project;
use App\Models\Department;
use App\Models\Vendor;
use App\Models\ItemCategory;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\JsonResponse;

class ProposesController extends Controller
{
     function __construct()
    {
        $this->middleware('permission:propose-list|propose-create|propose-edit|propose-delete', ['only' => ['index','show']]);
        $this->middleware('permission:propose-create', ['only' => ['create','store']]);
        $this->middleware('permission:propose-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:propose-delete', ['only' => ['destroy']]);
        $this->middleware('permission:propose-submit', ['only' => ['submit']]);
        $this->middleware('permission:propose-review', ['only' => ['review']]);
        $this->middleware('permission:propose-approve', ['only' => ['approve']]);
        $this->middleware('permission:propose-cancel', ['only' => ['cancel']]);
        $this->middleware('permission:propose-statistics', ['only' => ['statistics']]);
        $this->middleware('permission:propose-export', ['only' => ['export']]);
        $this->middleware('permission:propose-download-attachment', ['only' => ['downloadAttachment']]);
    }
    /**
     * Display a listing of the proposes.
     */
    public function index(Request $request): View
    {
        $query = Propose::with(['project', 'proposedBy', 'department', 'vendor', 'items'])
            ->latest();

        // Lọc theo trạng thái
        if ($request->filled('status')) {
            $query->byStatus($request->status);
        }

        // Lọc theo độ ưu tiên
        if ($request->filled('priority')) {
            $query->byPriority($request->priority);
        }

        // Lọc theo dự án
        if ($request->filled('project_id')) {
            $query->byProject($request->project_id);
        }

        // Lọc theo bộ phận
        if ($request->filled('department_id')) {
            $query->byDepartment($request->department_id);
        }

        // Lọc theo loại đề xuất
        if ($request->filled('propose_type')) {
            $query->where('propose_type', $request->propose_type);
        }

        // Lọc chỉ đề xuất cấp thiết
        if ($request->boolean('urgent_only')) {
            $query->urgent();
        }

        // Tìm kiếm
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('propose_code', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $proposes = $query->paginate(15)->withQueryString();

        // Dữ liệu cho filter
        $projects = Project::select('id', 'name')->get();
        $departments = Department::select('id', 'name')->get();

        return view('proposes.index', compact('proposes', 'projects', 'departments'));
    }

    /**
     * Show the form for creating a new propose.
     */
    public function create(): View
    {
        $projects = Project::select('id', 'name')->get();
        $departments = Department::select('id', 'name')->get();
        $vendors = Vendor::active()->select('id', 'name')->get();
        $categories = ItemCategory::where('is_active', true)->get();

        return view('proposes.create', compact('projects', 'departments', 'vendors', 'categories'));
    }

    /**
     * Store a newly created propose in storage.
     */
   /**
 * Store a newly created propose in storage.
 */
public function store(Request $request): RedirectResponse
{
    // Validate input first
    if (!$request->has('items') || empty($request->input('items'))) {
        return redirect()->back()
            ->withInput()
            ->with('error', 'Phải có ít nhất một mục hàng hóa/dịch vụ.');
    }

    $validated = $request->validate([
        'project_id' => 'required|exists:projects,id',
        'department_id' => 'required|exists:departments,id',
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'justification' => 'required|string',
        'expected_benefit' => 'nullable|string',
        'propose_type' => 'required|in:equipment,supplies,services,software,training,travel,other',
        'priority' => 'required|in:low,medium,high,urgent',
        'is_urgent' => 'boolean',
        'needed_by_date' => 'nullable|date|after:today',
        'budget_source' => 'required|in:project_budget,department_budget,additional_budget,external_funding',
        'vendor_id' => 'nullable|exists:vendors,id',
        'expected_delivery_date' => 'nullable|date|after:today|before_or_equal:needed_by_date',
        'attachments.*' => 'file|max:10240|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png,gif',

        // Items data
        'items' => 'required|array|min:1',
        'items.*.name' => 'required|string|max:255',
        'items.*.description' => 'nullable|string',
        'items.*.quantity' => 'required|numeric|min:0.01',
        'items.*.unit_price' => 'required|numeric|min:0',
        'items.*.unit' => 'required|string|max:50',
        'items.*.category_id' => 'nullable|exists:item_categories,id',
        'items.*.brand' => 'nullable|string|max:100',
        'items.*.model' => 'nullable|string|max:100',
        'items.*.specifications' => 'nullable|string',
        'items.*.priority' => 'required|in:low,medium,high,critical',
        'items.*.is_essential' => 'boolean',
        'items.*.needed_by_date' => 'nullable|date|after:today',
    ], [
        // Custom error messages
        'items.required' => 'Phải có ít nhất một mục hàng hóa/dịch vụ.',
        'items.min' => 'Phải có ít nhất một mục hàng hóa/dịch vụ.',
        'items.*.name.required' => 'Tên hàng hóa/dịch vụ là bắt buộc.',
        'items.*.quantity.required' => 'Số lượng là bắt buộc.',
        'items.*.quantity.min' => 'Số lượng phải lớn hơn 0.',
        'items.*.unit_price.required' => 'Đơn giá là bắt buộc.',
        'items.*.unit_price.min' => 'Đơn giá phải lớn hơn hoặc bằng 0.',
        'items.*.unit.required' => 'Đơn vị là bắt buộc.',
        'items.*.priority.required' => 'Độ ưu tiên là bắt buộc.',
        'expected_delivery_date.before_or_equal' => 'Ngày giao hàng dự kiến phải trước hoặc bằng ngày cần thiết.',
        'attachments.*.mimes' => 'File đính kèm phải có định dạng: pdf, doc, docx, xls, xlsx, jpg, jpeg, png, gif.',
        'attachments.*.max' => 'Mỗi file đính kèm không được vượt quá 10MB.',
    ]);

    DB::beginTransaction();

    try {
        // Handle file uploads
        $attachments = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                try {
                    $path = $file->store('proposes/attachments', 'public');
                    $attachments[] = [
                        'name' => $file->getClientOriginalName(),
                        'path' => $path,
                        'size' => $file->getSize(),
                        'mime_type' => $file->getMimeType()
                    ];
                } catch (\Exception $e) {
                    \Log::error('File upload error: ' . $e->getMessage());
                    throw new \Exception('Lỗi khi tải file: ' . $file->getClientOriginalName());
                }
            }
        }

        // Create the propose - use null coalescing operator for optional fields
        $propose = Propose::create([
            'project_id' => $validated['project_id'],
            'proposed_by' => Auth::id(),
            'department_id' => $validated['department_id'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'justification' => $validated['justification'],
            'expected_benefit' => $validated['expected_benefit'] ?? null,
            'propose_type' => $validated['propose_type'],
            'priority' => $validated['priority'],
            'is_urgent' => $request->boolean('is_urgent'),
            'needed_by_date' => $validated['needed_by_date'] ?? null,
            'budget_source' => $validated['budget_source'],
            'vendor_id' => $validated['vendor_id'] ?? null,
            'expected_delivery_date' => $validated['expected_delivery_date'] ?? null,
            'attachments' => empty($attachments) ? null : $attachments,
            'status' => Propose::STATUS_DRAFT,
        ]);

        // Validate that we have items before processing
        if (empty($validated['items'])) {
            throw new \Exception('Phải có ít nhất một mục hàng hóa/dịch vụ.');
        }

        // Create propose items
        foreach ($validated['items'] as $index => $itemData) {
            try {
                $item = new ProposeItem([
                    'name' => $itemData['name'],
                    'description' => $itemData['description'] ?? null,
                    'quantity' => $itemData['quantity'],
                    'unit_price' => $itemData['unit_price'],
                    'unit' => $itemData['unit'],
                    'category_id' => $itemData['category_id'] ?? null,
                    'brand' => $itemData['brand'] ?? null,
                    'model' => $itemData['model'] ?? null,
                    'specifications' => $itemData['specifications'] ?? null,
                    'priority' => $itemData['priority'],
                    'is_essential' => ($itemData['is_essential'] ?? false) == '1',
                    'needed_by_date' => $itemData['needed_by_date'] ?? null,
                    'tax_percent' => 10, // Default VAT
                ]);

                $propose->items()->save($item);
            } catch (\Exception $e) {
                \Log::error('Error creating item ' . ($index + 1) . ': ' . $e->getMessage());
                throw new \Exception('Lỗi khi tạo mục hàng hóa thứ ' . ($index + 1) . ': ' . $e->getMessage());
            }
        }

        // Calculate total amount
        $propose->calculateTotalAmount();

        // Verify that items were created successfully
        if ($propose->items()->count() === 0) {
            throw new \Exception('Không thể tạo các mục hàng hóa/dịch vụ.');
        }

        DB::commit();

        return redirect()->route('proposes.show', $propose)
            ->with('success', 'Đề xuất đã được tạo thành công với ' . $propose->items()->count() . ' mục hàng hóa/dịch vụ.');

    } catch (\Illuminate\Validation\ValidationException $e) {
        DB::rollback();

        // Clean up uploaded files if transaction failed
        foreach ($attachments as $attachment) {
            if (Storage::disk('public')->exists($attachment['path'])) {
                Storage::disk('public')->delete($attachment['path']);
            }
        }

        throw $e; // Re-throw validation exceptions

    } catch (\Exception $e) {
        DB::rollback();

        // Clean up uploaded files if transaction failed
        foreach ($attachments as $attachment) {
            if (Storage::disk('public')->exists($attachment['path'])) {
                Storage::disk('public')->delete($attachment['path']);
            }
        }

        // Log the error for debugging
        \Log::error('Propose creation error: ' . $e->getMessage(), [
            'user_id' => Auth::id(),
            'request_data' => $request->except(['attachments', '_token']),
            'trace' => $e->getTraceAsString()
        ]);

        return redirect()->back()
            ->withInput()
            ->with('error', $e->getMessage());
    }
}
    /**
     * Display the specified propose.
     */
    public function show(Propose $propose): View
    {
        $propose->load([
            'project',
            'proposedBy',
            'department',
            'reviewedBy',
            'approvedBy',
            'vendor',
            'items.category',
            'items.preferredVendor'
        ]);

        return view('proposes.show', compact('propose'));
    }

    /**
     * Show the form for editing the specified propose.
     */
    public function edit(Propose $propose): View
    {
        if (!$propose->canBeEdited()) {
            abort(403, 'Đề xuất này không thể chỉnh sửa.');
        }

        $propose->load('items');
        $projects = Project::select('id', 'name')->get();
        $departments = Department::select('id', 'name')->get();
        $vendors = Vendor::active()->select('id', 'name')->get();
        $categories = ItemCategory::where('is_active', true)->get();

        return view('proposes.edit', compact('propose', 'projects', 'departments', 'vendors', 'categories'));
    }

    /**
     * Update the specified propose in storage.
     */
   /**
 * Update the specified propose in storage.
 */
public function update(Request $request, Propose $propose): RedirectResponse
{
    if (!$propose->canBeEdited()) {
        return redirect()->back()->with('error', 'Đề xuất này không thể chỉnh sửa.');
    }

    // Validate input first
    if (!$request->has('items') || empty($request->input('items'))) {
        return redirect()->back()
            ->withInput()
            ->with('error', 'Phải có ít nhất một mục hàng hóa/dịch vụ.');
    }

    $validated = $request->validate([
        'project_id' => 'required|exists:projects,id',
        'department_id' => 'required|exists:departments,id',
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'justification' => 'required|string',
        'expected_benefit' => 'nullable|string',
        'propose_type' => 'required|in:equipment,supplies,services,software,training,travel,other',
        'priority' => 'required|in:low,medium,high,urgent',
        'is_urgent' => 'boolean',
        'needed_by_date' => 'nullable|date|after:today',
        'budget_source' => 'required|in:project_budget,department_budget,additional_budget,external_funding',
        'vendor_id' => 'nullable|exists:vendors,id',
        'expected_delivery_date' => 'nullable|date|after:today|before_or_equal:needed_by_date',
        'attachments.*' => 'file|max:10240|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png,gif',
        'removed_attachments' => 'nullable|string',
 'status' => 'required|in:draft,submitted,under_review,pending_approval,approved,partially_approved,rejected,cancelled,completed',
        // Items data
        'items' => 'required|array|min:1',
        'items.*.id' => 'nullable|exists:propose_items,id',
        'items.*.name' => 'required|string|max:255',
        'items.*.description' => 'nullable|string',
        'items.*.quantity' => 'required|numeric|min:0.01',
        'items.*.unit_price' => 'required|numeric|min:0',
        'items.*.unit' => 'required|string|max:50',
        'items.*.category_id' => 'nullable|exists:item_categories,id',
        'items.*.brand' => 'nullable|string|max:100',
        'items.*.model' => 'nullable|string|max:100',
        'items.*.specifications' => 'nullable|string',
        'items.*.priority' => 'required|in:low,medium,high,critical',
        'items.*.is_essential' => 'boolean',
        'items.*.needed_by_date' => 'nullable|date|after:today',
    ], [
        // Custom error messages
        'items.required' => 'Phải có ít nhất một mục hàng hóa/dịch vụ.',
        'items.min' => 'Phải có ít nhất một mục hàng hóa/dịch vụ.',
        'items.*.name.required' => 'Tên hàng hóa/dịch vụ là bắt buộc.',
        'items.*.quantity.required' => 'Số lượng là bắt buộc.',
        'items.*.quantity.min' => 'Số lượng phải lớn hơn 0.',
        'items.*.unit_price.required' => 'Đơn giá là bắt buộc.',
        'items.*.unit_price.min' => 'Đơn giá phải lớn hơn hoặc bằng 0.',
        'items.*.unit.required' => 'Đơn vị là bắt buộc.',
        'items.*.priority.required' => 'Độ ưu tiên là bắt buộc.',
        'expected_delivery_date.before_or_equal' => 'Ngày giao hàng dự kiến phải trước hoặc bằng ngày cần thiết.',
        'attachments.*.mimes' => 'File đính kèm phải có định dạng: pdf, doc, docx, xls, xlsx, jpg, jpeg, png, gif.',
        'attachments.*.max' => 'Mỗi file đính kèm không được vượt quá 10MB.',
    ]);

    DB::beginTransaction();

    try {
        // Handle attachment removal
        $existingAttachments = $propose->attachments ?? [];
        if ($request->filled('removed_attachments')) {
            $removedIndexes = explode(',', $request->removed_attachments);
            foreach ($removedIndexes as $index) {
                if (isset($existingAttachments[$index])) {
                    // Delete the file from storage
                    if (Storage::disk('public')->exists($existingAttachments[$index]['path'])) {
                        Storage::disk('public')->delete($existingAttachments[$index]['path']);
                    }
                    unset($existingAttachments[$index]);
                }
            }
            // Re-index the array
            $existingAttachments = array_values($existingAttachments);
        }

        // Handle new file uploads
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                try {
                    $path = $file->store('proposes/attachments', 'public');
                    $existingAttachments[] = [
                        'name' => $file->getClientOriginalName(),
                        'path' => $path,
                        'size' => $file->getSize(),
                        'mime_type' => $file->getMimeType()
                    ];
                } catch (\Exception $e) {
                    \Log::error('File upload error during update: ' . $e->getMessage());
                    throw new \Exception('Lỗi khi tải file: ' . $file->getClientOriginalName());
                }
            }
        }

        // Update the propose
        $propose->update([
            'project_id' => $validated['project_id'],
            'department_id' => $validated['department_id'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'justification' => $validated['justification'],
            'expected_benefit' => $validated['expected_benefit'] ?? null,
            'propose_type' => $validated['propose_type'],
            'priority' => $validated['priority'],
            'is_urgent' => $request->boolean('is_urgent'),
            'needed_by_date' => $validated['needed_by_date'] ?? null,
            'budget_source' => $validated['budget_source'],
            'vendor_id' => $validated['vendor_id'] ?? null,
            'expected_delivery_date' => $validated['expected_delivery_date'] ?? null,
            'attachments' => empty($existingAttachments) ? null : $existingAttachments,
            'status' => $validated['status'],
        ]);

        // Handle propose items update
        $existingItemIds = [];
        $processedItems = 0;

        foreach ($validated['items'] as $itemData) {
            try {
                if (isset($itemData['id']) && $itemData['id']) {
                    // Update existing item
                    $item = $propose->items()->findOrFail($itemData['id']);

                    // Verify this item belongs to this propose
                    if ($item->propose_id !== $propose->id) {
                        throw new \Exception('Mục hàng hóa không thuộc về đề xuất này.');
                    }

                    $item->update([
                        'name' => $itemData['name'],
                        'description' => $itemData['description'] ?? null,
                        'quantity' => $itemData['quantity'],
                        'unit_price' => $itemData['unit_price'],
                        'unit' => $itemData['unit'],
                        'category_id' => $itemData['category_id'] ?? null,
                        'brand' => $itemData['brand'] ?? null,
                        'model' => $itemData['model'] ?? null,
                        'specifications' => $itemData['specifications'] ?? null,
                        'priority' => $itemData['priority'],
                        'is_essential' => ($itemData['is_essential'] ?? false) == '1',
                        'needed_by_date' => $itemData['needed_by_date'] ?? null,
                    ]);
                    $existingItemIds[] = $item->id;
                    $processedItems++;
                } else {
                    // Create new item
                    $item = new ProposeItem([
                        'name' => $itemData['name'],
                        'description' => $itemData['description'] ?? null,
                        'quantity' => $itemData['quantity'],
                        'unit_price' => $itemData['unit_price'],
                        'unit' => $itemData['unit'],
                        'category_id' => $itemData['category_id'] ?? null,
                        'brand' => $itemData['brand'] ?? null,
                        'model' => $itemData['model'] ?? null,
                        'specifications' => $itemData['specifications'] ?? null,
                        'priority' => $itemData['priority'],
                        'is_essential' => ($itemData['is_essential'] ?? false) == '1',
                        'needed_by_date' => $itemData['needed_by_date'] ?? null,
                        'tax_percent' => 10,
                    ]);

                    $propose->items()->save($item);
                    $existingItemIds[] = $item->id;
                    $processedItems++;
                }
            } catch (\Exception $e) {
                \Log::error('Error updating item: ' . $e->getMessage());
                throw new \Exception('Lỗi khi cập nhật mục hàng hóa: ' . $e->getMessage());
            }
        }

        // Delete removed items (items that exist in DB but not in the current form submission)
        $deletedCount = $propose->items()->whereNotIn('id', $existingItemIds)->delete();

        // Verify we still have items
        if ($processedItems === 0) {
            throw new \Exception('Phải có ít nhất một mục hàng hóa/dịch vụ.');
        }

        // Recalculate total amount
        $propose->calculateTotalAmount();

        // Verify final item count
        if ($propose->items()->count() === 0) {
            throw new \Exception('Không thể cập nhật các mục hàng hóa/dịch vụ.');
        }

        DB::commit();

        $message = 'Đề xuất đã được cập nhật thành công.';
        if ($deletedCount > 0) {
            $message .= " Đã xóa {$deletedCount} mục hàng hóa.";
        }

        return redirect()->route('proposes.show', $propose)
            ->with('success', $message . " Tổng cộng: {$propose->items()->count()} mục hàng hóa/dịch vụ.");

    } catch (\Illuminate\Validation\ValidationException $e) {
        DB::rollback();
        throw $e; // Re-throw validation exceptions

    } catch (\Exception $e) {
        DB::rollback();

        // Log the error for debugging
        \Log::error('Propose update error: ' . $e->getMessage(), [
            'propose_id' => $propose->id,
            'user_id' => Auth::id(),
            'request_data' => $request->except(['attachments', '_token']),
            'trace' => $e->getTraceAsString()
        ]);

        return redirect()->back()
            ->withInput()
            ->with('error', $e->getMessage());
    }
}

    /**
     * Remove the specified propose from storage.
     */
    public function destroy(Propose $propose): RedirectResponse
    {
        if (!$propose->canBeEdited()) {
            return redirect()->back()->with('error', 'Đề xuất này không thể xóa.');
        }

        // Delete associated files
        if ($propose->attachments) {
            foreach ($propose->attachments as $attachment) {
                Storage::disk('public')->delete($attachment['path']);
            }
        }

        $propose->delete();

        return redirect()->route('proposes.index')
            ->with('success', 'Đề xuất đã được xóa thành công.');
    }

    /**
     * Submit propose for review
     */
    public function submit(Propose $propose): RedirectResponse
    {
        if ($propose->status !== Propose::STATUS_DRAFT) {
            return redirect()->back()->with('error', 'Chỉ có thể gửi đề xuất ở trạng thái nháp.');
        }

        if ($propose->items()->count() === 0) {
            return redirect()->back()->with('error', 'Đề xuất phải có ít nhất một mục hàng hóa/dịch vụ.');
        }

        $propose->update([
            'status' => Propose::STATUS_SUBMITTED
        ]);

        return redirect()->back()->with('success', 'Đề xuất đã được gửi để xem xét.');
    }

    /**
     * Review propose
     */
    public function review(Request $request, Propose $propose): RedirectResponse
    {
        $request->validate([
            'action' => 'required|in:approve,request_changes,reject',
            'comments' => 'nullable|string'
        ]);

        if (!in_array($propose->status, [Propose::STATUS_SUBMITTED, Propose::STATUS_UNDER_REVIEW])) {
            return redirect()->back()->with('error', 'Đề xuất này không thể xem xét.');
        }

        $newStatus = match($request->action) {
            'approve' => Propose::STATUS_PENDING_APPROVAL,
            'request_changes' => Propose::STATUS_SUBMITTED,
            'reject' => Propose::STATUS_REJECTED,
        };

        $propose->update([
            'status' => $newStatus,
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
            'review_comments' => $request->comments
        ]);

        $message = match($request->action) {
            'approve' => 'Đề xuất đã được xem xét và chuyển đến phê duyệt.',
            'request_changes' => 'Đã yêu cầu chỉnh sửa đề xuất.',
            'reject' => 'Đề xuất đã bị từ chối.',
        };

        return redirect()->back()->with('success', $message);
    }

    /**
     * Approve propose
     */
    public function approve(Request $request, Propose $propose): RedirectResponse
    {
        $request->validate([
            'action' => 'required|in:approve,partial_approve,reject',
            'approved_amount' => 'nullable|numeric|min:0',
            'comments' => 'nullable|string'
        ]);

        if ($propose->status !== Propose::STATUS_PENDING_APPROVAL) {
            return redirect()->back()->with('error', 'Đề xuất này không thể phê duyệt.');
        }

        $approvedAmount = $request->approved_amount ?? $propose->total_amount;
        $newStatus = match($request->action) {
            'approve' => Propose::STATUS_APPROVED,
            'partial_approve' => Propose::STATUS_PARTIALLY_APPROVED,
            'reject' => Propose::STATUS_REJECTED,
        };

        $propose->update([
            'status' => $newStatus,
            'approved_by' => Auth::id(),
            'approved_at' => now(),
            'approved_amount' => $approvedAmount,
            'approval_comments' => $request->comments
        ]);

        $message = match($request->action) {
            'approve' => 'Đề xuất đã được phê duyệt.',
            'partial_approve' => 'Đề xuất đã được phê duyệt một phần.',
            'reject' => 'Đề xuất đã bị từ chối phê duyệt.',
        };

        return redirect()->back()->with('success', $message);
    }

    /**
     * Cancel propose
     */
    public function cancel(Request $request, Propose $propose): RedirectResponse
    {
        if (!in_array($propose->status, [
            Propose::STATUS_DRAFT,
            Propose::STATUS_SUBMITTED,
            Propose::STATUS_UNDER_REVIEW
        ])) {
            return redirect()->back()->with('error', 'Đề xuất này không thể hủy.');
        }

        $propose->update(['status' => Propose::STATUS_CANCELLED]);

        return redirect()->back()->with('success', 'Đề xuất đã được hủy.');
    }

    /**
     * Get propose statistics for dashboard
     */
    public function statistics(): JsonResponse
    {
        $stats = [
            'total' => Propose::count(),
            'draft' => Propose::byStatus(Propose::STATUS_DRAFT)->count(),
            'submitted' => Propose::byStatus(Propose::STATUS_SUBMITTED)->count(),
            'under_review' => Propose::byStatus(Propose::STATUS_UNDER_REVIEW)->count(),
            'pending_approval' => Propose::byStatus(Propose::STATUS_PENDING_APPROVAL)->count(),
            'approved' => Propose::byStatus(Propose::STATUS_APPROVED)->count(),
            'rejected' => Propose::byStatus(Propose::STATUS_REJECTED)->count(),
            'total_amount' => Propose::sum('total_amount'),
            'approved_amount' => Propose::whereIn('status', [
                Propose::STATUS_APPROVED,
                Propose::STATUS_PARTIALLY_APPROVED
            ])->sum('approved_amount'),
        ];

        return response()->json($stats);
    }

    /**
     * Export proposes to Excel
     */
    public function export(Request $request)
    {
        // Implementation for Excel export
        // You would typically use Laravel Excel package here
        return response()->json(['message' => 'Export feature coming soon']);
    }

    /**
     * Download attachment
     */
    public function downloadAttachment(Propose $propose, $index)
    {
        $attachments = $propose->attachments ?? [];

        if (!isset($attachments[$index])) {
            abort(404);
        }

        $attachment = $attachments[$index];

        if (!Storage::disk('public')->exists($attachment['path'])) {
            abort(404);
        }

        return Storage::disk('public')->download($attachment['path'], $attachment['name']);
    }
}

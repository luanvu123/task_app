<?php

namespace App\Http\Controllers;

use App\Models\ReportManager;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ReportManagerController extends Controller
{
     function __construct()
    {

        $this->middleware('permission:reportmanager-list|reportmanager-create|reportmanager-edit|reportmanager-delete', ['only' => ['index','store']]);
$this->middleware('permission:reportmanager-approve', ['only' => ['approve']]);
$this->middleware('permission:reportmanager-reject', ['only' => ['reject']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ReportManager::with(['department', 'reporter', 'recipient']);

        // Lọc theo người dùng hiện tại
        $user = Auth::user();
        if ($user->hasRole('Trưởng phòng')) {
            // Trưởng phòng chỉ xem báo cáo của phòng mình
            $query->where('department_id', $user->department_id);
        } elseif ($user->hasRole('Giám đốc')) {
            // Giám đốc xem tất cả báo cáo gửi cho mình
            $query->where('recipient_id', $user->id);
        }

        // Filters
        if ($request->filled('status')) {
            $query->byStatus($request->status);
        }

        if ($request->filled('department_id')) {
            $query->byDepartment($request->department_id);
        }

        if ($request->filled('report_type')) {
            $query->byType($request->report_type);
        }

        if ($request->filled('priority')) {
            $query->byPriority($request->priority);
        }

        if ($request->filled('date_from')) {
            $query->where('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('created_at', '<=', $request->date_to . ' 23:59:59');
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        // Sort
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $reports = $query->paginate(15)->appends($request->all());

        $departments = Department::where('status', 'active')->get();

        return view('reportManagers.index', compact('reports', 'departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();

        // Chỉ trưởng phòng mới được tạo báo cáo
        if (!$user->hasRole('Trưởng phòng')) {
            return redirect()->route('reportManagers.index')
                ->with('error', 'Bạn không có quyền tạo báo cáo.');
        }

        $departments = Department::where('status', 'active')->get();
        $directors = User::role('Giám đốc')->get();

        return view('reportManagers.create', compact('departments', 'directors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        if (!$user->hasRole('Trưởng phòng')) {
            return redirect()->route('reportManagers.index')
                ->with('error', 'Bạn không có quyền tạo báo cáo.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'report_type' => 'required|in:monthly,quarterly,yearly,project_completion,urgent,other',
            'recipient_id' => 'required|exists:users,id',
            'priority' => 'required|in:low,medium,high,urgent',
            'report_period_start' => 'nullable|date',
            'report_period_end' => 'nullable|date|after_or_equal:report_period_start',
            'attachments.*' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png|max:10240',
        ], [
            'title.required' => 'Tiêu đề báo cáo là bắt buộc.',
            'content.required' => 'Nội dung báo cáo là bắt buộc.',
            'report_type.required' => 'Loại báo cáo là bắt buộc.',
            'recipient_id.required' => 'Người nhận báo cáo là bắt buộc.',
            'priority.required' => 'Mức độ ưu tiên là bắt buộc.',
            'report_period_end.after_or_equal' => 'Ngày kết thúc phải sau ngày bắt đầu.',
            'attachments.*.mimes' => 'File đính kèm phải có định dạng: pdf, doc, docx, xls, xlsx, jpg, jpeg, png.',
            'attachments.*.max' => 'File đính kèm không được vượt quá 10MB.',
        ]);

        // Xử lý file đính kèm
        $attachments = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('report_attachments', 'public');
                $attachments[] = [
                    'name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'size' => $file->getSize(),
                    'mime_type' => $file->getMimeType(),
                ];
            }
        }

        $report = ReportManager::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'report_type' => $validated['report_type'],
            'department_id' => $user->department_id,
            'reporter_id' => $user->id,
            'recipient_id' => $validated['recipient_id'],
            'priority' => $validated['priority'],
            'report_period_start' => $validated['report_period_start'],
            'report_period_end' => $validated['report_period_end'],
            'attachments' => $attachments,
            'status' => $request->has('submit') ? 'submitted' : 'draft',
            'submitted_at' => $request->has('submit') ? now() : null,
        ]);

        $message = $request->has('submit')
            ? 'Báo cáo đã được tạo và gửi thành công!'
            : 'Báo cáo đã được lưu nháp thành công!';

        return redirect()->route('reportManagers.show', $report)
            ->with('success', $message);
    }

    /**
     * Display the specified resource.
     */
    public function show(ReportManager $reportManager)
    {
        $user = Auth::user();

        // Kiểm tra quyền xem
        if (!$this->canView($reportManager, $user)) {
            return redirect()->route('reportManagers.index')
                ->with('error', 'Bạn không có quyền xem báo cáo này.');
        }

        // Đánh dấu đã xem nếu là người nhận
        if ($user->id == $reportManager->recipient_id && $reportManager->status == 'submitted') {
            $reportManager->markAsReviewed();
        }

        $reportManager->load(['department', 'reporter', 'recipient']);

        return view('reportManagers.show', compact('reportManager'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ReportManager $reportManager)
    {
        $user = Auth::user();

        // Chỉ người tạo báo cáo mới được sửa và chỉ khi còn ở trạng thái draft
        if ($reportManager->reporter_id != $user->id || !$reportManager->canBeEdited()) {
            return redirect()->route('reportManagers.show', $reportManager)
                ->with('error', 'Bạn không thể chỉnh sửa báo cáo này.');
        }

        $departments = Department::where('status', 'active')->get();
        $directors = User::role('Giám đốc')->get();

        return view('reportManagers.edit', compact('reportManager', 'departments', 'directors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ReportManager $reportManager)
    {
        $user = Auth::user();

        if ($reportManager->reporter_id != $user->id || !$reportManager->canBeEdited()) {
            return redirect()->route('reportManagers.show', $reportManager)
                ->with('error', 'Bạn không thể chỉnh sửa báo cáo này.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'report_type' => 'required|in:monthly,quarterly,yearly,project_completion,urgent,other',
            'recipient_id' => 'required|exists:users,id',
            'priority' => 'required|in:low,medium,high,urgent',
            'report_period_start' => 'nullable|date',
            'report_period_end' => 'nullable|date|after_or_equal:report_period_start',
            'attachments.*' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png|max:10240',
        ], [
            'title.required' => 'Tiêu đề báo cáo là bắt buộc.',
            'content.required' => 'Nội dung báo cáo là bắt buộc.',
            'report_type.required' => 'Loại báo cáo là bắt buộc.',
            'recipient_id.required' => 'Người nhận báo cáo là bắt buộc.',
            'priority.required' => 'Mức độ ưu tiên là bắt buộc.',
            'report_period_end.after_or_equal' => 'Ngày kết thúc phải sau ngày bắt đầu.',
        ]);

        // Xử lý file đính kèm mới
        $attachments = $reportManager->attachments ?? [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('report_attachments', 'public');
                $attachments[] = [
                    'name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'size' => $file->getSize(),
                    'mime_type' => $file->getMimeType(),
                ];
            }
        }

        $updateData = [
            'title' => $validated['title'],
            'content' => $validated['content'],
            'report_type' => $validated['report_type'],
            'recipient_id' => $validated['recipient_id'],
            'priority' => $validated['priority'],
            'report_period_start' => $validated['report_period_start'],
            'report_period_end' => $validated['report_period_end'],
            'attachments' => $attachments,
        ];

        // Nếu nhấn nút gửi
        if ($request->has('submit')) {
            $updateData['status'] = 'submitted';
            $updateData['submitted_at'] = now();
        }

        $reportManager->update($updateData);

        $message = $request->has('submit')
            ? 'Báo cáo đã được cập nhật và gửi thành công!'
            : 'Báo cáo đã được cập nhật thành công!';

        return redirect()->route('reportManagers.show', $reportManager)
            ->with('success', $message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ReportManager $reportManager)
    {
        $user = Auth::user();

        // Chỉ người tạo báo cáo mới được xóa và chỉ khi còn ở trạng thái draft
        if ($reportManager->reporter_id != $user->id || $reportManager->status != 'draft') {
            return redirect()->route('reportManagers.index')
                ->with('error', 'Bạn không thể xóa báo cáo này.');
        }

        // Xóa file đính kèm
        if ($reportManager->attachments) {
            foreach ($reportManager->attachments as $attachment) {
                Storage::disk('public')->delete($attachment['path']);
            }
        }

        $reportManager->delete();

        return redirect()->route('reportManagers.index')
            ->with('success', 'Báo cáo đã được xóa thành công!');
    }

    /**
     * Approve report (Director only)
     */
    public function approve(Request $request, ReportManager $reportManager)
    {
        $user = Auth::user();

        if (!$user->hasRole('Giám đốc') || $reportManager->recipient_id != $user->id) {
            return redirect()->back()->with('error', 'Bạn không có quyền phê duyệt báo cáo này.');
        }

        $request->validate([
            'feedback' => 'nullable|string|max:1000',
        ]);

        if ($reportManager->approve($request->feedback)) {
            return redirect()->back()->with('success', 'Báo cáo đã được phê duyệt thành công!');
        }

        return redirect()->back()->with('error', 'Không thể phê duyệt báo cáo này.');
    }

    /**
     * Reject report (Director only)
     */
    public function reject(Request $request, ReportManager $reportManager)
    {
        $user = Auth::user();

        if (!$user->hasRole('Giám đốc') || $reportManager->recipient_id != $user->id) {
            return redirect()->back()->with('error', 'Bạn không có quyền từ chối báo cáo này.');
        }

        $request->validate([
            'feedback' => 'required|string|max:1000',
        ], [
            'feedback.required' => 'Lý do từ chối là bắt buộc.',
        ]);

        if ($reportManager->reject($request->feedback)) {
            return redirect()->back()->with('success', 'Báo cáo đã được từ chối!');
        }

        return redirect()->back()->with('error', 'Không thể từ chối báo cáo này.');
    }

    /**
     * Download attachment
     */
    public function downloadAttachment(ReportManager $reportManager, $index)
    {
        $user = Auth::user();

        if (!$this->canView($reportManager, $user)) {
            abort(403, 'Bạn không có quyền tải file này.');
        }

        if (!isset($reportManager->attachments[$index])) {
            abort(404, 'File không tồn tại.');
        }

        $attachment = $reportManager->attachments[$index];
        $filePath = storage_path('app/public/' . $attachment['path']);

        if (!file_exists($filePath)) {
            abort(404, 'File không tồn tại trên hệ thống.');
        }

        return response()->download($filePath, $attachment['name']);
    }

    /**
     * Remove attachment
     */
    public function removeAttachment(ReportManager $reportManager, $index)
    {
        $user = Auth::user();

        if ($reportManager->reporter_id != $user->id || !$reportManager->canBeEdited()) {
            return response()->json(['error' => 'Bạn không thể xóa file đính kèm.'], 403);
        }

        if (!isset($reportManager->attachments[$index])) {
            return response()->json(['error' => 'File không tồn tại.'], 404);
        }

        $attachments = $reportManager->attachments;
        $removedAttachment = $attachments[$index];

        // Xóa file khỏi storage
        Storage::disk('public')->delete($removedAttachment['path']);

        // Xóa khỏi array
        unset($attachments[$index]);
        $attachments = array_values($attachments); // Re-index array

        $reportManager->update(['attachments' => $attachments]);

        return response()->json(['success' => 'File đã được xóa thành công.']);
    }

    /**
     * Check if user can view the report
     */
    private function canView(ReportManager $reportManager, $user)
    {
        // Người tạo báo cáo
        if ($reportManager->reporter_id == $user->id) {
            return true;
        }

        // Người nhận báo cáo
        if ($reportManager->recipient_id == $user->id) {
            return true;
        }

        // Admin có thể xem tất cả
        if ($user->hasRole('Admin')) {
            return true;
        }

        return false;
    }
}

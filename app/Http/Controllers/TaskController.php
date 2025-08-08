<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::with(['project.department', 'assignee'])
            ->latest()
            ->get()
            ->groupBy('status');

        $projects = Project::with('department')->get();
        $users = User::active()->get();

        // Lấy thống kê
        $taskStats = [
            'total' => Task::count(),
            'in_progress' => Task::byStatus(Task::STATUS_IN_PROGRESS)->count(),
            'needs_review' => Task::byStatus(Task::STATUS_NEEDS_REVIEW)->count(),
            'completed' => Task::byStatus(Task::STATUS_COMPLETED)->count(),
            'overdue' => Task::where('end_date', '<', now())
                ->where('status', '!=', Task::STATUS_COMPLETED)
                ->count(),
        ];

        // Lấy tasks gần đây
        $recentTasks = Task::with(['project', 'assignee'])
            ->latest()
            ->take(5)
            ->get();

        // Truyền thêm các constants để sử dụng trong view
        $taskPriorities = Task::getPriorities();
        $taskStatuses = Task::getStatuses();

        return view('tasks.index', compact(
            'tasks',
            'projects',
            'users',
            'taskStats',
            'recentTasks',
            'taskPriorities',
            'taskStatuses'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $projects = Project::with('members')->get();
        $users = User::active()->get();
        return view('tasks.create', compact('projects', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'project_id' => 'required|exists:projects,id',
            'user_id' => 'required|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'priority' => 'required|in:low,medium,high,urgent',
            'description' => 'nullable|string',
            'image_and_document' => 'nullable|array',
            'image_and_document.*' => 'file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120',
        ], [
            'name.required' => 'Tên công việc là bắt buộc',
            'project_id.required' => 'Vui lòng chọn dự án',
            'user_id.required' => 'Vui lòng chọn người thực hiện',
            'start_date.required' => 'Ngày bắt đầu là bắt buộc',
            'end_date.required' => 'Ngày kết thúc là bắt buộc',
            'end_date.after' => 'Ngày kết thúc phải sau ngày bắt đầu',
        ]);

        $task = new Task($validated);

        // Xử lý upload files
        if ($request->hasFile('image_and_document')) {
            $files = [];
            foreach ($request->file('image_and_document') as $file) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('tasks', $filename, 'public');
                $files[] = [
                    'name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'size' => $file->getSize(),
                    'type' => $file->getMimeType()
                ];
            }
            $task->image_and_document = $files;
        }

        $task->save();

        return response()->json([
            'success' => true,
            'message' => 'Tạo công việc thành công!',
            'task' => $task->load(['project', 'assignee'])
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        $task->load(['project.department', 'assignee']);
        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        $projects = Project::with('members')->get();
        $users = User::active()->get();
        return view('tasks.edit', compact('task', 'projects', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'project_id' => 'required|exists:projects,id',
            'user_id' => 'required|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'priority' => 'required|in:low,medium,high,urgent',
            'status' => 'required|in:in_progress,needs_review,completed',
            'description' => 'nullable|string',
            'image_and_document' => 'nullable|array',
            'image_and_document.*' => 'file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120',
        ], [
            'name.required' => 'Tên công việc là bắt buộc',
            'project_id.required' => 'Vui lòng chọn dự án',
            'user_id.required' => 'Vui lòng chọn người thực hiện',
            'start_date.required' => 'Ngày bắt đầu là bắt buộc',
            'end_date.required' => 'Ngày kết thúc là bắt buộc',
            'end_date.after' => 'Ngày kết thúc phải sau ngày bắt đầu',
        ]);

        // Xử lý upload files mới
        if ($request->hasFile('image_and_document')) {
            // Xóa files cũ
            if ($task->image_and_document) {
                foreach ($task->image_and_document as $file) {
                    Storage::disk('public')->delete($file['path']);
                }
            }

            // Upload files mới
            $files = [];
            foreach ($request->file('image_and_document') as $file) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('tasks', $filename, 'public');
                $files[] = [
                    'name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'size' => $file->getSize(),
                    'type' => $file->getMimeType()
                ];
            }
            $validated['image_and_document'] = $files;
        }

        $task->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật công việc thành công!',
            'task' => $task->load(['project', 'assignee'])
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        // Xóa files
        if ($task->image_and_document) {
            foreach ($task->image_and_document as $file) {
                Storage::disk('public')->delete($file['path']);
            }
        }

        $task->delete();

        return response()->json([
            'success' => true,
            'message' => 'Xóa công việc thành công!'
        ]);
    }

    /**
     * Update task status
     */
    public function updateStatus(Request $request, Task $task)
    {
        $validated = $request->validate([
            'status' => 'required|in:in_progress,needs_review,completed'
        ]);

        $task->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật trạng thái thành công!',
            'task' => $task->load(['project', 'assignee'])
        ]);
    }

    /**
     * Get project members
     */
    public function getProjectMembers(Project $project)
    {
        $members = $project->members()->get();
        return response()->json($members);
    }
}

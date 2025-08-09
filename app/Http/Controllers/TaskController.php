<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
class TaskController extends Controller
{
    public function getUsersByProject(Request $request)
{
    $projectId = $request->project_id;

    if (!$projectId) {
        return response()->json([]);
    }

    $project = Project::find($projectId);

    if (!$project) {
        return response()->json([]);
    }

    // Cách 1: Lấy tất cả users trong cùng department với project
    $users = User::active()
        ->where('department_id', $project->department_id)
        ->select('id', 'name', 'email', 'position')
        ->get();

    // Cách 2: Chỉ lấy members của project (nếu có bảng project_users)
    // $users = $project->members()
    //     ->where('status', 'active')
    //     ->select('users.id', 'users.name', 'users.email', 'users.position')
    //     ->get();

    // Cách 3: Kết hợp cả 2 - ưu tiên members của project, sau đó là users cùng department
    // $projectMembers = $project->members()
    //     ->where('status', 'active')
    //     ->select('users.id', 'users.name', 'users.email', 'users.position')
    //     ->get();

    // $departmentUsers = User::active()
    //     ->where('department_id', $project->department_id)
    //     ->whereNotIn('id', $projectMembers->pluck('id'))
    //     ->select('id', 'name', 'email', 'position')
    //     ->get();

    // $users = $projectMembers->merge($departmentUsers);

    return response()->json($users);
}
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $user = Auth::user();

    // Lấy tất cả tasks của department
    $allTasks = Task::with(['project.department', 'assignee'])
        ->whereHas('project', function ($query) use ($user) {
            $query->where('department_id', $user->department_id);
        })
        ->latest()
        ->get();

    // Group tasks theo status và đảm bảo tất cả status đều có key
    $tasks = collect([
        Task::STATUS_IN_PROGRESS => collect(),
        Task::STATUS_NEEDS_REVIEW => collect(),
        Task::STATUS_COMPLETED => collect(),
    ])->merge($allTasks->groupBy('status'));

    // Chỉ lấy projects cùng department với thông tin members
    $projects = Project::with(['department', 'members'])
        ->where('department_id', $user->department_id)
        ->get();

    // Lấy tất cả users trong department (dùng cho trường hợp fallback)
    $users = User::active()
        ->where('department_id', $user->department_id)
        ->select('id', 'name', 'email', 'position', 'department_id')
        ->get();

    // Lấy thống kê chỉ trong department
    $taskStats = [
        'total' => $allTasks->count(),
        'in_progress' => $allTasks->where('status', Task::STATUS_IN_PROGRESS)->count(),
        'needs_review' => $allTasks->where('status', Task::STATUS_NEEDS_REVIEW)->count(),
        'completed' => $allTasks->where('status', Task::STATUS_COMPLETED)->count(),
        'overdue' => $allTasks->filter(function($task) {
            return $task->isOverdue();
        })->count(),
    ];

    // Lấy tasks gần đây trong department
    $recentTasks = $allTasks->take(5);

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
        $user = Auth::user();

        // Chỉ lấy projects trong department của user
        $projects = Project::with('members')
            ->where('department_id', $user->department_id)
            ->get();

        // Chỉ lấy users trong department
        $users = User::active()
            ->where('department_id', $user->department_id)
            ->get();

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

        $user = Auth::user();

        // Kiểm tra project có thuộc department của user không
        $project = Project::findOrFail($validated['project_id']);
        if ($project->department_id !== $user->department_id) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn không có quyền tạo task cho dự án này.'
            ], 403);
        }

        // Kiểm tra user được assign có thuộc department không
        $assignee = User::findOrFail($validated['user_id']);
        if ($assignee->department_id !== $user->department_id) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn chỉ có thể giao việc cho nhân viên trong phòng ban của mình.'
            ], 403);
        }

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
        // Kiểm tra task có thuộc department của user không
        $user = Auth::user();
        if ($task->project->department_id != $user->department_id) {
            abort(403, 'Bạn không có quyền xem task này.');
        }

        $task->load(['project.department', 'assignee']);
        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        $user = Auth::user();
        if (!$user->isDepartmentHead() && $task->user_id != $user->id) {
            abort(403, 'Bạn không có quyền chỉnh sửa task này.');
        }

        if ($task->project->department_id != $user->department_id) {
            abort(403, 'Task này không thuộc phòng ban của bạn.');
        }

        // Chỉ lấy projects và users trong department
        $projects = Project::with('members')
            ->where('department_id', $user->department_id)
            ->get();

        $users = User::active()
            ->where('department_id', $user->department_id)
            ->get();

        return view('tasks.edit', compact('task', 'projects', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $user = Auth::user();

        // Kiểm tra quyền: chỉ department head hoặc người được giao task
        if (!$user->isDepartmentHead() && $task->user_id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn không có quyền cập nhật task này.'
            ], 403);
        }

        // Kiểm tra task có thuộc department không
        if ($task->project->department_id !== $user->department_id) {
            return response()->json([
                'success' => false,
                'message' => 'Task này không thuộc phòng ban của bạn.'
            ], 403);
        }

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

        // Kiểm tra project có thuộc department không (nếu có thay đổi)
        if ($validated['project_id'] !== $task->project_id) {
            $project = Project::findOrFail($validated['project_id']);
            if ($project->department_id !== $user->department_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bạn không thể chuyển task sang dự án khác phòng ban.'
                ], 403);
            }
        }

        // Kiểm tra user được assign có thuộc department không (nếu có thay đổi)
        if ($validated['user_id'] !== $task->user_id) {
            $assignee = User::findOrFail($validated['user_id']);
            if ($assignee->department_id !== $user->department_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bạn chỉ có thể giao việc cho nhân viên trong phòng ban của mình.'
                ], 403);
            }
        }

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
        $user = Auth::user();

        // Chỉ department head mới có quyền xóa task
        if (!$user->isDepartmentHead()) {
            return response()->json([
                'success' => false,
                'message' => 'Chỉ trưởng phòng mới có quyền xóa công việc.'
            ], 403);
        }

        // Kiểm tra task có thuộc department không
        if ($task->project->department_id !== $user->department_id) {
            return response()->json([
                'success' => false,
                'message' => 'Task này không thuộc phòng ban của bạn.'
            ], 403);
        }

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
        $user = Auth::user();

        // Chỉ người được giao task hoặc department head mới có quyền cập nhật status
        if ($task->user_id !== $user->id && !$user->isDepartmentHead()) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn không có quyền cập nhật trạng thái task này.'
            ], 403);
        }

        // Kiểm tra task có thuộc department không
        if ($task->project->department_id !== $user->department_id) {
            return response()->json([
                'success' => false,
                'message' => 'Task này không thuộc phòng ban của bạn.'
            ], 403);
        }

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
        $user = Auth::user();

        // Kiểm tra project có thuộc department không
        if ($project->department_id !== $user->department_id) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn không có quyền xem thành viên của dự án này.'
            ], 403);
        }

        $members = $project->members()
            ->where('department_id', $user->department_id) // Chỉ lấy members cùng department
            ->get();

        return response()->json($members);
    }
}

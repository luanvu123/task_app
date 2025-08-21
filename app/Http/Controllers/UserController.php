<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Project;
use App\Models\Task;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;


class UserController extends Controller
{
     function __construct()
    {
         $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index','show']]);
         $this->middleware('permission:user-create', ['only' => ['create','store']]);
         $this->middleware('permission:user-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): View
    {
        $query = User::query();
        $departments = Department::where('status', 'active')->get();

        // Lọc theo trạng thái nếu có
        if ($request->has('status') && in_array($request->status, ['active', 'inactive', 'suspended'])) {
            $query->where('status', $request->status);
        }

        // Lọc theo từ khóa tìm kiếm nếu có
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('position', 'like', "%{$search}%");
            });
        }

        // Sắp xếp
        $sortBy = $request->get('sort_by', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');

        if (in_array($sortBy, ['name', 'email', 'created_at', 'status', 'position'])) {
            $query->orderBy($sortBy, $sortDirection);
        }

        // Phân trang
        $users = $query->paginate(12)->appends($request->query());

        return view('users.index', compact('users', 'departments'));
    }

    public function leader(Request $request): View
    {
        try {
            // Lấy danh sách users có role "Trưởng phòng"
            $leaders = User::whereHas('roles', function ($query) {
                $query->where('name', 'Trưởng phòng');
            })
            ->with([
                'department',
                'managedDepartment.employees',
                'managedDepartment.projects' => function ($query) {
                    $query->latest()->limit(1); // Lấy project gần nhất
                }
            ])
            ->where('status', 'active') // Chỉ lấy user đang active
            ->get();

            // Thêm thông tin bổ sung cho mỗi leader
            $leaders = $leaders->map(function ($leader) {
                $managedDepartment = $leader->managedDepartment;

                if ($managedDepartment) {
                    // Lấy project gần nhất của phòng ban
                    $latestProject = $managedDepartment->projects()
                        ->latest('created_at')
                        ->first();

                    // Đếm số lượng task trong project gần nhất
                    $taskCount = 0;
                    if ($latestProject) {
                        $taskCount = $latestProject->tasks()->count();
                    }

                    // Thêm thông tin vào object leader
                    $leader->latest_project = $latestProject;
                    $leader->task_count = $taskCount;
                    $leader->staff_count = $managedDepartment->employees()->count();
                } else {
                    $leader->latest_project = null;
                    $leader->task_count = 0;
                    $leader->staff_count = 0;
                }

                return $leader;
            });

            return view('users.leader', compact('leaders'));

        } catch (\Exception $e) {
            // Log error và redirect về trang users với message
            \Log::error('Error in leader method: ' . $e->getMessage());

            return redirect()->route('users.index')
                ->with('error', 'Không thể tải danh sách trưởng phòng. Vui lòng thử lại sau.');
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        // Trả về view tạo user mới (nếu cần trang riêng)
        // Trong trường hợp này chúng ta dùng modal nên có thể không cần
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): RedirectResponse
    {
        // Validation rules
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|min:2',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|string|min:8|max:255',
            'department_id' => 'required|exists:departments,id',
            'phone' => 'nullable|string|max:20|regex:/^[\d\s\+\-\(\)]+$/',
            'dob' => 'nullable|date|before:today|after:1900-01-01',
            'address' => 'nullable|string|max:1000',
            'description' => 'nullable|string|max:2000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // max 2MB
            'position' => 'nullable|string|max:100',
            'gender' => ['nullable', Rule::in(['male', 'female', 'other'])],
            'status' => ['required', Rule::in(['active', 'inactive', 'suspended'])],
        ], [
            // Custom error messages in Vietnamese
            'name.required' => 'Họ và tên là bắt buộc.',
            'name.min' => 'Họ và tên phải có ít nhất 2 ký tự.',
            'name.max' => 'Họ và tên không được vượt quá 255 ký tự.',
            'email.required' => 'Email là bắt buộc.',
            'email.email' => 'Email không đúng định dạng.',
            'email.unique' => 'Email này đã được sử dụng.',
            'email.max' => 'Email không được vượt quá 255 ký tự.',
            'password.required' => 'Mật khẩu là bắt buộc.',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
            'password.max' => 'Mật khẩu không được vượt quá 255 ký tự.',
            'department_id.required' => 'Phòng ban là bắt buộc.',
            'department_id.exists' => 'Phòng ban được chọn không tồn tại.',
            'phone.regex' => 'Số điện thoại không đúng định dạng.',
            'phone.max' => 'Số điện thoại không được vượt quá 20 ký tự.',
            'dob.date' => 'Ngày sinh không đúng định dạng.',
            'dob.before' => 'Ngày sinh phải trước ngày hôm nay.',
            'dob.after' => 'Ngày sinh không hợp lệ.',
            'address.max' => 'Địa chỉ không được vượt quá 1000 ký tự.',
            'description.max' => 'Mô tả không được vượt quá 2000 ký tự.',
            'image.image' => 'File phải là hình ảnh.',
            'image.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif.',
            'image.max' => 'Kích thước hình ảnh không được vượt quá 2MB.',
            'position.max' => 'Chức vụ không được vượt quá 100 ký tự.',
            'gender.in' => 'Giới tính không hợp lệ.',
            'status.required' => 'Trạng thái là bắt buộc.',
            'status.in' => 'Trạng thái không hợp lệ.',
        ]);

        try {
            // Xử lý upload ảnh
            $imagePath = null;
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $image = $request->file('image');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('users/avatars', $imageName, 'public');
            }

            // Lấy thông tin department để hiển thị trong thông báo
            $department = Department::find($validatedData['department_id']);

            // Tạo user mới
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'department_id' => $validatedData['department_id'],
                'phone' => $validatedData['phone'] ?? null,
                'dob' => $validatedData['dob'] ?? null,
                'address' => $validatedData['address'] ?? null,
                'description' => $validatedData['description'] ?? null,
                'image' => $imagePath,
                'position' => $validatedData['position'] ?? null,
                'gender' => $validatedData['gender'] ?? null,
                'status' => $validatedData['status'],
            ]);

            // Thông báo thành công
            return redirect()->route('users.index')
                ->with('success', 'Tạo nhân viên mới thành công! Nhân viên ' . $user->name . ' đã được thêm vào phòng ban ' . $department->name . '.');

        } catch (\Exception $e) {
            // Xóa file ảnh nếu có lỗi xảy ra sau khi upload
            if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }

            // Log lỗi
            \Log::error('Error creating user: ' . $e->getMessage(), [
                'request_data' => $request->except('password'),
                'user_ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            // Thông báo lỗi
            return redirect()->back()
                ->withInput($request->except('password'))
                ->with('error', 'Có lỗi xảy ra khi tạo nhân viên. Vui lòng thử lại.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   public function show($id): View
    {
        $user = User::findOrFail($id);

        // Lấy danh sách roles của user
        $userRoles = $user->getRoleNames();

        // Lấy danh sách projects mà user tham gia (bao gồm cả project được quản lý và project tham gia)
        $userProjects = $user->projects()
            ->with(['department', 'manager', 'members', 'tasks'])
            ->where('status', '!=', Project::STATUS_COMPLETED)
            ->where('status', '!=', Project::STATUS_CANCELLED)
            ->orderBy('priority', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(6) // Giới hạn 6 project gần đây nhất
            ->get();

        // Nếu user là manager, thêm các project mà họ quản lý
        $managedProjects = $user->managedProjects()
            ->with(['department', 'manager', 'members', 'tasks'])
            ->where('status', '!=', Project::STATUS_COMPLETED)
            ->where('status', '!=', Project::STATUS_CANCELLED)
            ->orderBy('priority', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        // Merge và loại bỏ duplicate projects
        $allProjects = $userProjects->merge($managedProjects)->unique('id')->take(6);

        // Lấy danh sách tasks hiện tại của user
        $currentTasks = $user->tasks()
            ->with(['project', 'assignee'])
            ->where('status', '!=', Task::STATUS_COMPLETED)
            ->orderByRaw("FIELD(priority, 'urgent', 'high', 'medium', 'low')")
            ->orderBy('end_date', 'asc')
            ->limit(10) // Giới hạn 10 task gần đây nhất
            ->get();

        // Lấy thống kê task của user
        $taskStats = [
            'total' => $user->tasks()->count(),
            'in_progress' => $user->inProgressTasks()->count(),
            'needs_review' => $user->needsReviewTasks()->count(),
            'completed' => $user->completedTasks()->count(),
            'overdue' => $user->overdueTasks()->count(),
            'completion_rate' => $user->task_completion_rate
        ];

        // Lấy thống kê project
        $projectStats = [
            'total_projects' => $allProjects->count(),
            'managed_projects' => $user->managedProjects()->count(),
            'participating_projects' => $user->projects()->count(),
        ];

        return view('users.show', compact(
            'user',
            'userRoles',
            'allProjects',
            'currentTasks',
            'taskStats',
            'projectStats'
        ));
    }
      public function updatePersonalInfo(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'nationality' => 'nullable|string|max:100',
            'religion' => 'nullable|string|max:100',
            'marital_status' => 'nullable|in:single,married,divorced,widowed',
            'passport_no' => 'nullable|string|max:20',
            'emergency_contact' => 'nullable|string|max:20',
        ]);

        $user->update($request->only([
            'nationality',
            'religion',
            'marital_status',
            'passport_no',
            'emergency_contact'
        ]));

        return redirect()->back()->with('success', 'Thông tin cá nhân đã được cập nhật thành công!');
    }

    public function updateBankInfo(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'bank_name' => 'nullable|string|max:100',
            'account_no' => 'nullable|string|max:30',
            'ifsc_code' => 'nullable|string|max:11',
            'pan_no' => 'nullable|string|max:10',
            'upi_id' => 'nullable|string|max:100',
        ]);

        $user->update($request->only([
            'bank_name',
            'account_no',
            'ifsc_code',
            'pan_no',
            'upi_id'
        ]));

        return redirect()->back()->with('success', 'Thông tin ngân hàng đã được cập nhật thành công!');
    }


    public function destroy($id): RedirectResponse
    {
        User::find($id)->delete();
        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id): View
    {
        try {
            $user = User::findOrFail($id);

            // Lấy danh sách roles nếu sử dụng Spatie Permission
            $roles = [];
            $userRoles = [];
            $departments = Department::where('status', 'active')
                ->orderBy('name')
                ->get();
            if (class_exists('Spatie\Permission\Models\Role')) {
                $roles = \Spatie\Permission\Models\Role::pluck('name', 'name')->all();
                $userRoles = $user->roles->pluck('name', 'name')->all();
            }

            return view('users.edit', compact('user', 'roles', 'userRoles', 'departments'));

        } catch (\Exception $e) {
            \Log::error('Error loading user for edit: ' . $e->getMessage(), [
                'user_id' => $id,
                'user_ip' => request()->ip(),
            ]);

            return redirect()->route('users.index')
                ->with('error', 'Không tìm thấy nhân viên hoặc có lỗi xảy ra.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id): RedirectResponse
    {
        try {
            $user = User::findOrFail($id);

            // Validation rules
            $validatedData = $request->validate([
                'name' => 'required|string|max:255|min:2',
                'email' => 'required|email|max:255|unique:users,email,' . $id,
                'password' => 'nullable|string|min:8|max:255|confirmed',
                'phone' => 'nullable|string|max:20|regex:/^[\d\s\+\-\(\)]+$/',
                'dob' => 'nullable|date|before:today|after:1900-01-01',
                'address' => 'nullable|string|max:1000',
                'description' => 'nullable|string|max:2000',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'position' => 'nullable|string|max:100',
                'gender' => ['nullable', Rule::in(['male', 'female', 'other'])],
                'status' => ['required', Rule::in(['active', 'inactive', 'suspended'])],
                'department_id' => 'nullable|exists:departments,id',
                'roles' => 'nullable|array',
                'roles.*' => 'string|exists:roles,name',
            ], [
                // Custom error messages in Vietnamese
                'name.required' => 'Họ và tên là bắt buộc.',
                'name.min' => 'Họ và tên phải có ít nhất 2 ký tự.',
                'name.max' => 'Họ và tên không được vượt quá 255 ký tự.',
                'email.required' => 'Email là bắt buộc.',
                'email.email' => 'Email không đúng định dạng.',
                'email.unique' => 'Email này đã được sử dụng.',
                'email.max' => 'Email không được vượt quá 255 ký tự.',
                'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
                'password.max' => 'Mật khẩu không được vượt quá 255 ký tự.',
                'password.confirmed' => 'Xác nhận mật khẩu không khớp.',
                'phone.regex' => 'Số điện thoại không đúng định dạng.',
                'phone.max' => 'Số điện thoại không được vượt quá 20 ký tự.',
                'dob.date' => 'Ngày sinh không đúng định dạng.',
                'dob.before' => 'Ngày sinh phải trước ngày hôm nay.',
                'dob.after' => 'Ngày sinh không hợp lệ.',
                'department_id.exists' => 'Phòng ban được chọn không tồn tại.',
                'address.max' => 'Địa chỉ không được vượt quá 1000 ký tự.',
                'description.max' => 'Mô tả không được vượt quá 2000 ký tự.',
                'image.image' => 'File phải là hình ảnh.',
                'image.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif.',
                'image.max' => 'Kích thước hình ảnh không được vượt quá 2MB.',
                'position.max' => 'Chức vụ không được vượt quá 100 ký tự.',
                'gender.in' => 'Giới tính không hợp lệ.',
                'status.required' => 'Trạng thái là bắt buộc.',
                'status.in' => 'Trạng thái không hợp lệ.',
                'roles.array' => 'Vai trò phải là một mảng.',
                'roles.*.exists' => 'Vai trò được chọn không tồn tại.',
            ]);

            // Xử lý upload ảnh mới
            $imagePath = $user->image; // Giữ ảnh cũ nếu không upload ảnh mới
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                // Xóa ảnh cũ nếu có
                if ($user->image && Storage::disk('public')->exists($user->image)) {
                    Storage::disk('public')->delete($user->image);
                }

                // Upload ảnh mới
                $image = $request->file('image');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('users/avatars', $imageName, 'public');
            }

            // Chuẩn bị dữ liệu để cập nhật
            $updateData = [
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'phone' => $validatedData['phone'] ?? null,
                'dob' => $validatedData['dob'] ?? null,
                'address' => $validatedData['address'] ?? null,
                'description' => $validatedData['description'] ?? null,
                'image' => $imagePath,
                'position' => $validatedData['position'] ?? null,
                'gender' => $validatedData['gender'] ?? null,
                'status' => $validatedData['status'],
                'department_id' => $validatedData['department_id'] ?? null,
            ];

            // Cập nhật mật khẩu nếu có
            if (!empty($validatedData['password'])) {
                $updateData['password'] = Hash::make($validatedData['password']);
            }

            // Cập nhật thông tin user
            $user->update($updateData);

            // Cập nhật roles nếu sử dụng Spatie Permission
            if (class_exists('Spatie\Permission\Models\Role') && isset($validatedData['roles'])) {
                // Xóa tất cả roles hiện tại
                DB::table('model_has_roles')->where('model_id', $id)->delete();

                // Gán roles mới
                if (!empty($validatedData['roles'])) {
                    $user->assignRole($validatedData['roles']);
                }
            }

            // Thông báo thành công
            return redirect()->route('users.index')
                ->with('success', 'Cập nhật thông tin nhân viên thành công! Thông tin của ' . $user->name . ' đã được cập nhật.');

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('users.index')
                ->with('error', 'Không tìm thấy nhân viên cần cập nhật.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput($request->except('password', 'password_confirmation'));

        } catch (\Exception $e) {
            // Xóa file ảnh mới nếu có lỗi xảy ra sau khi upload
            if (isset($imagePath) && $imagePath !== $user->image && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }

            // Log lỗi
            \Log::error('Error updating user: ' . $e->getMessage(), [
                'user_id' => $id,
                'request_data' => $request->except('password', 'password_confirmation'),
                'user_ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            // Thông báo lỗi
            return redirect()->back()
                ->withInput($request->except('password', 'password_confirmation'))
                ->with('error', 'Có lỗi xảy ra khi cập nhật thông tin nhân viên. Vui lòng thử lại.');
        }
    }
        /**
 * Lấy thông tin nhân viên và dự án của trưởng phòng
 */
public function getStaffAndProject($leaderId)
{
    try {
        // Validate leader ID
        if (!is_numeric($leaderId)) {
            return response()->json([
                'success' => false,
                'message' => 'ID trưởng phòng không hợp lệ'
            ], 400);
        }

        $leader = User::with([
            'managedDepartment.employees' => function ($query) {
                $query->select([
                    'id', 'name', 'email', 'position', 'status',
                    'department_id', 'image', 'created_at'
                ])
                ->where('status', '!=', 'deleted')
                ->orderBy('name');
            },
            'managedDepartment.projects' => function ($query) {
                $query->latest('created_at')->limit(1);
            }
        ])->find($leaderId);

        if (!$leader) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy trưởng phòng'
            ], 404);
        }

        // Kiểm tra xem user có phải là trưởng phòng không
        $hasLeaderRole = $leader->hasRole('Trưởng phòng');
        if (!$hasLeaderRole) {
            return response()->json([
                'success' => false,
                'message' => 'User này không phải là trưởng phòng'
            ], 403);
        }

        if (!$leader->managedDepartment) {
            return response()->json([
                'success' => true,
                'staff' => [],
                'staff_count' => 0,
                'latest_project' => null,
                'message' => 'Trưởng phòng chưa được phân công phòng ban'
            ]);
        }

        // Format thông tin nhân viên
        $staff = $leader->managedDepartment->employees->map(function ($employee) {
            // Đếm tasks của employee (nếu có relationship)
            $taskCount = 0;
            try {
                if (method_exists($employee, 'tasks')) {
                    $taskCount = $employee->tasks()
                        ->whereIn('status', ['in_progress', 'needs_review', 'pending'])
                        ->count();
                }
            } catch (\Exception $e) {
                \Log::warning('Không thể đếm tasks cho employee: ' . $employee->id);
            }

            return [
                'id' => $employee->id,
                'name' => $employee->name,
                'email' => $employee->email,
                'position' => $employee->position ?? 'Chưa có chức vụ',
                'status' => $employee->status,
                'status_text' => $this->getUserStatusText($employee->status),
                'image_url' => $employee->image
                    ? asset('storage/' . $employee->image)
                    : asset('assets/images/xs/avatar3.jpg'),
                'task_count' => $taskCount,
                'joined_date' => $employee->created_at ? $employee->created_at->format('d/m/Y') : null
            ];
        });

        // Format thông tin dự án gần nhất
        $latestProject = null;
        if ($leader->managedDepartment->projects && $leader->managedDepartment->projects->isNotEmpty()) {
            $project = $leader->managedDepartment->projects->first();

            // Tính phần trăm hoàn thành (nếu có relationship với tasks)
            $completionPercentage = 0;
            try {
                if (method_exists($project, 'tasks')) {
                    $totalTasks = $project->tasks()->count();
                    if ($totalTasks > 0) {
                        $completedTasks = $project->tasks()
                            ->where('status', 'completed')
                            ->count();
                        $completionPercentage = round(($completedTasks / $totalTasks) * 100);
                    }
                }
            } catch (\Exception $e) {
                \Log::warning('Không thể tính completion percentage cho project: ' . $project->id);
            }

            $latestProject = [
                'id' => $project->id,
                'name' => $project->name,
                'description' => $project->description ?? 'Không có mô tả',
                'status' => $project->status,
                'status_text' => $this->getProjectStatusText($project->status),
                'priority' => $project->priority ?? 'medium',
                'start_date' => $project->start_date ? $project->start_date->format('Y-m-d') : null,
                'end_date' => $project->end_date ? $project->end_date->format('Y-m-d') : null,
                'start_date_formatted' => $project->start_date ? $project->start_date->format('d/m/Y') : 'Chưa xác định',
                'end_date_formatted' => $project->end_date ? $project->end_date->format('d/m/Y') : 'Chưa xác định',
                'budget' => $project->budget ?? 0,
                'formatted_budget' => $this->formatCurrency($project->budget ?? 0),
                'completion_percentage' => $completionPercentage,
                'created_at' => $project->created_at ? $project->created_at->format('d/m/Y') : null
            ];
        }

        return response()->json([
            'success' => true,
            'staff' => $staff->values()->toArray(),
            'staff_count' => $staff->count(),
            'latest_project' => $latestProject,
            'department_name' => $leader->managedDepartment->name,
            'leader_name' => $leader->name
        ]);

    } catch (\Exception $e) {
        \Log::error('Error in getStaffAndProject: ' . $e->getMessage(), [
            'leader_id' => $leaderId,
            'line' => $e->getLine(),
            'file' => $e->getFile(),
            'trace' => $e->getTraceAsString()
        ]);

        return response()->json([
            'success' => false,
            'error' => 'Lỗi server',
            'message' => 'Có lỗi xảy ra khi tải dữ liệu. Vui lòng thử lại sau.',
            'debug_message' => config('app.debug') ? $e->getMessage() : null
        ], 500);
    }
}

/**
 * Chuyển đổi status user thành text tiếng Việt
 */
private function getUserStatusText($status): string
{
    return match ($status) {
        'active' => 'Hoạt động',
        'inactive' => 'Không hoạt động',
        'suspended' => 'Bị đình chỉ',
        'pending' => 'Chờ kích hoạt',
        default => 'Không xác định'
    };
}

/**
 * Chuyển đổi status project thành text tiếng Việt
 */
private function getProjectStatusText($status): string
{
    return match ($status) {
        'planning' => 'Đang lên kế hoạch',
        'in_progress' => 'Đang thực hiện',
        'on_hold' => 'Tạm dừng',
        'completed' => 'Hoàn thành',
        'cancelled' => 'Đã hủy',
        'pending' => 'Chờ phê duyệt',
        default => 'Không xác định'
    };
}

/**
 * Format tiền tệ VNĐ
 */
private function formatCurrency($amount): string
{
    if (!is_numeric($amount)) {
        return '0 VNĐ';
    }

    return number_format($amount, 0, ',', '.') . ' VNĐ';
}

}

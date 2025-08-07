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
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): View
    {
        $query = User::query();

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

        return view('users.index', compact('users'));
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

            // Tạo user mới
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
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
                ->with('success', 'Tạo nhân viên mới thành công! Nhân viên ' . $user->name . ' đã được thêm vào hệ thống.');

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
        $user = User::find($id);

        return view('users.show',compact('user'));
    }


    public function destroy($id): RedirectResponse
    {
        User::find($id)->delete();
        return redirect()->route('users.index')
                        ->with('success','User deleted successfully');
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

            if (class_exists('Spatie\Permission\Models\Role')) {
                $roles = \Spatie\Permission\Models\Role::pluck('name', 'name')->all();
                $userRoles = $user->roles->pluck('name', 'name')->all();
            }

            return view('users.edit', compact('user', 'roles', 'userRoles'));

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
}

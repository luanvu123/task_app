@extends('layouts.app')

@section('content')


<style>
    .preview-image {
        max-width: 150px;
        max-height: 150px;
        object-fit: cover;
        border-radius: 10px;
        border: 3px solid #e5e7eb;
    }
    .form-group {
        margin-bottom: 1.5rem;
    }
    .required {
        color: #ef4444;
    }
    .card {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        border: none;
    }
    .btn {
        border-radius: 6px;
        font-weight: 500;
    }
    .form-control:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25);
    }
</style>

<div class="container-fluid px-4">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">Chỉnh sửa nhân viên</h1>
                    <p class="text-muted mb-0">Cập nhật thông tin nhân viên: {{ $user->name }}</p>
                </div>
                <div>
                    <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Quay lại
                    </a>
                </div>
            </div>

            <!-- Alert Messages -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <h6 class="mb-2"><i class="fas fa-exclamation-triangle me-2"></i>Có lỗi xảy ra:</h6>
                    <ul class="mb-0 ps-4">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Edit Form -->
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-user-edit me-2"></i>Thông tin nhân viên
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data" id="editUserForm">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Cột trái -->
                            <div class="col-md-8">
                                <!-- Thông tin cơ bản -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name" class="form-label">
                                                Họ và tên <span class="required">*</span>
                                            </label>
                                            <input type="text"
                                                   class="form-control @error('name') is-invalid @enderror"
                                                   id="name"
                                                   name="name"
                                                   value="{{ old('name', $user->name) }}"
                                                   required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email" class="form-label">
                                                Email <span class="required">*</span>
                                            </label>
                                            <input type="email"
                                                   class="form-control @error('email') is-invalid @enderror"
                                                   id="email"
                                                   name="email"
                                                   value="{{ old('email', $user->email) }}"
                                                   required>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Mật khẩu -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password" class="form-label">
                                                Mật khẩu mới (để trống nếu không thay đổi)
                                            </label>
                                            <input type="password"
                                                   class="form-control @error('password') is-invalid @enderror"
                                                   id="password"
                                                   name="password">
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text">Mật khẩu phải có ít nhất 8 ký tự</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password_confirmation" class="form-label">
                                                Xác nhận mật khẩu
                                            </label>
                                            <input type="password"
                                                   class="form-control"
                                                   id="password_confirmation"
                                                   name="password_confirmation">
                                            <div class="form-text">Nhập lại mật khẩu để xác nhận</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Thông tin liên hệ -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone" class="form-label">Số điện thoại</label>
                                            <input type="tel"
                                                   class="form-control @error('phone') is-invalid @enderror"
                                                   id="phone"
                                                   name="phone"
                                                   value="{{ old('phone', $user->phone) }}"
                                                   placeholder="0123456789">
                                            @error('phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="dob" class="form-label">Ngày sinh</label>
                                            <input type="date"
                                                   class="form-control @error('dob') is-invalid @enderror"
                                                   id="dob"
                                                   name="dob"
                                                   value="{{ old('dob', $user->dob?->format('Y-m-d') ?? '') }}">
                                            @error('dob')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Thông tin công việc -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="position" class="form-label">Chức vụ</label>
                                            <input type="text"
                                                   class="form-control @error('position') is-invalid @enderror"
                                                   id="position"
                                                   name="position"
                                                   value="{{ old('position', $user->position) }}"
                                                   placeholder="Nhân viên, Quản lý, ...">
                                            @error('position')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="gender" class="form-label">Giới tính</label>
                                            <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender">
                                                <option value="">-- Chọn giới tính --</option>
                                                <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Nam</option>
                                                <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Nữ</option>
                                                <option value="other" {{ old('gender', $user->gender) == 'other' ? 'selected' : '' }}>Khác</option>
                                            </select>
                                            @error('gender')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Địa chỉ -->
                                <div class="form-group">
                                    <label for="address" class="form-label">Địa chỉ</label>
                                    <textarea class="form-control @error('address') is-invalid @enderror"
                                              id="address"
                                              name="address"
                                              rows="2"
                                              placeholder="Nhập địa chỉ đầy đủ">{{ old('address', $user->address) }}</textarea>
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Mô tả -->
                                <div class="form-group">
                                    <label for="description" class="form-label">Mô tả / Ghi chú</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror"
                                              id="description"
                                              name="description"
                                              rows="3"
                                              placeholder="Thông tin bổ sung về nhân viên...">{{ old('description', $user->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Vai trò (nếu có) -->
                                @if (!empty($roles))
                                <div class="form-group">
                                    <label class="form-label">Vai trò</label>
                                    <div class="row">
                                        @foreach($roles as $role)
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input type="checkbox"
                                                       class="form-check-input"
                                                       id="role_{{ $role }}"
                                                       name="roles[]"
                                                       value="{{ $role }}"
                                                       {{ in_array($role, old('roles', array_keys($userRoles))) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="role_{{ $role }}">
                                                    {{ ucfirst($role) }}
                                                </label>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    @error('roles')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                @endif
                            </div>

                            <!-- Cột phải -->
                            <div class="col-md-4">
                                <!-- Trạng thái -->
                                <div class="form-group">
                                    <label for="status" class="form-label">
                                        Trạng thái <span class="required">*</span>
                                    </label>
                                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                        <option value="">-- Chọn trạng thái --</option>
                                        <option value="active" {{ old('status', $user->status) == 'active' ? 'selected' : '' }}>
                                            Hoạt động
                                        </option>
                                        <option value="inactive" {{ old('status', $user->status) == 'inactive' ? 'selected' : '' }}>
                                            Không hoạt động
                                        </option>
                                        <option value="suspended" {{ old('status', $user->status) == 'suspended' ? 'selected' : '' }}>
                                            Tạm ngưng
                                        </option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Ảnh đại diện -->
                                <div class="form-group">
                                    <label for="image" class="form-label">Ảnh đại diện</label>

                                    <!-- Preview ảnh hiện tại -->
                                    @if($user->image)
                                    <div class="mb-3">
                                        <p class="text-muted mb-2">Ảnh hiện tại:</p>
                                        <img src="{{ Storage::url($user->image) }}"
                                             alt="Avatar hiện tại"
                                             class="preview-image"
                                             id="current-image">
                                    </div>
                                    @endif

                                    <!-- Input file -->
                                    <input type="file"
                                           class="form-control @error('image') is-invalid @enderror"
                                           id="image"
                                           name="image"
                                           accept="image/*">
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">
                                        Chọn ảnh mới để thay thế (JPEG, PNG, JPG, GIF - Tối đa 2MB)
                                    </div>

                                    <!-- Preview ảnh mới -->
                                    <div class="mt-3" id="new-image-preview" style="display: none;">
                                        <p class="text-muted mb-2">Ảnh mới:</p>
                                        <img src="" alt="Preview" class="preview-image" id="preview-image">
                                    </div>
                                </div>

                                <!-- Thông tin tạo/cập nhật -->
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="card-title">Thông tin hệ thống</h6>
                                        <small class="text-muted">
                                            <strong>Tạo lúc:</strong><br>
                                            {{ $user->created_at ? $user->created_at->format('d/m/Y H:i') : 'N/A' }}
                                        </small><br>
                                        <small class="text-muted">
                                            <strong>Cập nhật lúc:</strong><br>
                                            {{ $user->updated_at ? $user->updated_at->format('d/m/Y H:i') : 'N/A' }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="row">
                            <div class="col-12">
                                <hr>
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('users.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-times me-2"></i>Hủy bỏ
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Cập nhật
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Preview ảnh khi chọn file mới
    const imageInput = document.getElementById('image');
    const newImagePreview = document.getElementById('new-image-preview');
    const previewImage = document.getElementById('preview-image');

    if (imageInput && newImagePreview && previewImage) {
        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];

            if (file) {
                // Kiểm tra loại file
                if (!file.type.match('image.*')) {
                    alert('Vui lòng chọn file ảnh!');
                    this.value = '';
                    newImagePreview.style.display = 'none';
                    return;
                }

                // Kiểm tra kích thước file (2MB = 2 * 1024 * 1024 bytes)
                if (file.size > 2 * 1024 * 1024) {
                    alert('Kích thước file không được vượt quá 2MB!');
                    this.value = '';
                    newImagePreview.style.display = 'none';
                    return;
                }

                // Hiển thị preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    newImagePreview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                newImagePreview.style.display = 'none';
            }
        });
    }

    // Validation form trước khi submit
    const form = document.getElementById('editUserForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const passwordConfirmation = document.getElementById('password_confirmation').value;

            // Kiểm tra xác nhận mật khẩu nếu có nhập mật khẩu mới
            if (password && password !== passwordConfirmation) {
                e.preventDefault();
                alert('Mật khẩu xác nhận không khớp!');
                document.getElementById('password_confirmation').focus();
                return false;
            }

            // Confirm trước khi submit
            if (!confirm('Bạn có chắc chắn muốn cập nhật thông tin nhân viên này?')) {
                e.preventDefault();
                return false;
            }
        });
    }

    // Auto-hide alerts sau 5 giây
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            if (alert.classList.contains('alert-success')) {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            }
        });
    }, 5000);

    // Format số điện thoại khi nhập
    const phoneInput = document.getElementById('phone');
    if (phoneInput) {
        phoneInput.addEventListener('input', function(e) {
            // Chỉ cho phép số, dấu cách, +, -, (, )
            let value = e.target.value.replace(/[^0-9\s\+\-\(\)]/g, '');
            e.target.value = value;
        });
    }

    // Giới hạn độ dài textarea
    const textareas = document.querySelectorAll('textarea');
    textareas.forEach(function(textarea) {
        const maxLength = textarea.getAttribute('maxlength');
        if (maxLength) {
            const counter = document.createElement('div');
            counter.className = 'form-text text-end';
            counter.style.fontSize = '12px';
            textarea.parentNode.appendChild(counter);

            function updateCounter() {
                const remaining = maxLength - textarea.value.length;
                counter.textContent = `${textarea.value.length}/${maxLength} ký tự`;
                counter.style.color = remaining < 50 ? '#dc3545' : '#6c757d';
            }

            textarea.addEventListener('input', updateCounter);
            updateCounter();
        }
    });
});
</script>
@endsection




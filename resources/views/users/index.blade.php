@extends('layouts.app')

@section('content')
    <div class="body d-flex py-lg-3 py-md-2">
        <div class="container-xxl">
            <div class="row clearfix">
                <div class="col-md-12">
                    <div class="card border-0 mb-4 no-bg">
                        <div class="card-header py-3 px-0 d-sm-flex align-items-center justify-content-between border-bottom">
                            <h3 class="fw-bold flex-fill mb-0 mt-sm-0">Danh sách Nhân viên</h3>
                            <button type="button" class="btn btn-dark me-1 mt-1 w-sm-100" data-bs-toggle="modal"
                                data-bs-target="#createemp"><i class="icofont-plus-circle me-2 fs-6"></i>Thêm
                                Nhân viên</button>
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle mt-1 w-sm-100" type="button"
                                    id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                                    Trạng thái
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton2">
                                    <li><a class="dropdown-item" href="#">Tất cả</a></li>
                                    <li><a class="dropdown-item" href="#">Đang hoạt động</a></li>
                                    <li><a class="dropdown-item" href="#">Không hoạt động</a></li>
                                    <li><a class="dropdown-item" href="#">Đã tạm dừng</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- Row End -->

            <div class="row g-3 row-cols-1 row-cols-sm-1 row-cols-md-1 row-cols-lg-2 row-cols-xl-2 row-cols-xxl-2 row-deck py-1 pb-4">
                @forelse($users as $user)
                <div class="col">
                    <div class="card teacher-card">
                        <div class="card-body d-flex">
                            <div class="profile-av pe-xl-4 pe-md-2 pe-sm-4 pe-4 text-center w220">
                                <img src="{{ $user->image ? asset('storage/' . $user->image) : asset('assets/images/lg/avatar3.jpg') }}"
                                     alt="{{ $user->name }}"
                                     class="avatar xl rounded-circle img-thumbnail shadow-sm">
                                <div class="about-info d-flex align-items-center mt-3 justify-content-center">
                                    <div class="followers me-2">
                                        <i class="icofont-tasks color-careys-pink fs-4"></i>
                                        <span class="">04</span>
                                    </div>
                                    <div class="star me-2">
                                        <i class="icofont-star text-warning fs-4"></i>
                                        <span class="">4.5</span>
                                    </div>
                                    <div class="own-video">
                                        <i class="icofont-data color-light-orange fs-4"></i>
                                        <span class="">04</span>
                                    </div>
                                </div>
                            </div>
                            <div class="teacher-info border-start ps-xl-4 ps-md-3 ps-sm-4 ps-4 w-100">
                                <h6 class="mb-0 mt-2 fw-bold d-block fs-6">{{ $user->name }}</h6>
                                <span class="@if($user->status == 'active') light-success-bg @elseif($user->status == 'inactive') light-danger-bg @else light-warning-bg @endif py-1 px-2 rounded-1 d-inline-block fw-bold small-11 mb-0 mt-1">
                                    {{ $user->position ?: 'Chưa xác định' }}
                                </span>

                                <div class="mt-2">
                                    <small class="text-muted d-block">
                                        <i class="icofont-email me-1"></i>{{ $user->email }}
                                    </small>
                                    @if($user->phone)
                                    <small class="text-muted d-block">
                                        <i class="icofont-phone me-1"></i>{{ $user->phone }}
                                    </small>
                                    @endif
                                    @if($user->dob)
                                    <small class="text-muted d-block">
                                        <i class="icofont-calendar me-1"></i>{{ \Carbon\Carbon::parse($user->dob)->format('d/m/Y') }}
                                    </small>
                                    @endif
                                </div>

                                <div class="video-setting-icon mt-3 pt-3 border-top">
                                    <p>{{ $user->description ?: 'Chưa có mô tả chi tiết về nhân viên này.' }}</p>
                                </div>

                               <div class="mt-2">
    <span class="badge
        @if($user->status == 'active') bg-success
        @elseif($user->status == 'inactive') bg-danger
        @else bg-warning @endif">
        @if($user->status == 'active') Hoạt động
        @elseif($user->status == 'inactive') Không hoạt động
        @else Tạm dừng @endif
    </span>

    @if($user->gender)
    <span class="badge bg-info ms-1">
        @if($user->gender == 'male') Nam
        @elseif($user->gender == 'female') Nữ
        @else Khác @endif
    </span>
    @endif

    {{-- Thêm thẻ Department --}}
    @if($user->department)
    <span class="badge bg-primary ms-1">
        <i class="fas fa-building me-1"></i>
        {{ $user->department->name }}
    </span>
    @endif
</div>

                                <div class="mt-3">
                                    <a href="#" class="btn btn-dark btn-sm mt-1">
                                        <i class="icofont-plus-circle me-2 fs-6"></i>Giao việc
                                    </a>
                                    <a href="{{ route('users.show', $user->id) }}" class="btn btn-dark btn-sm mt-1">
                                        <i class="icofont-eye me-2 fs-6"></i>Hồ sơ
                                    </a>
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-outline-primary btn-sm mt-1">
                                        <i class="icofont-edit me-2 fs-6"></i>Chỉnh sửa
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="card">
                        <div class="card-body text-center py-5">
                            <i class="icofont-users fs-1 text-muted mb-3"></i>
                            <h5>Chưa có nhân viên nào</h5>
                            <p class="text-muted">Nhấn nút "Thêm Nhân viên" để thêm nhân viên đầu tiên</p>
                        </div>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Modal Thêm Nhân viên -->
    <div class="modal fade" id="createemp" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content">
              <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="modal-header">
        <h5 class="modal-title fw-bold" id="createprojectlLabel">Thêm Nhân viên mới</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
    </div>
    <div class="modal-body">
        <div class="mb-3">
            <label for="name" class="form-label">Họ và tên <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="name" name="name" required
                placeholder="Nhập họ và tên nhân viên" value="{{ old('name') }}">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
            <input type="email" class="form-control" id="email" name="email" required
                placeholder="Nhập địa chỉ email" value="{{ old('email') }}">
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Mật khẩu <span class="text-danger">*</span></label>
            <input type="password" class="form-control" id="password" name="password" required
                placeholder="Nhập mật khẩu">
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Ảnh đại diện</label>
            <input class="form-control" type="file" id="image" name="image" accept="image/*">
        </div>

        <div class="row g-3 mb-3">
            <div class="col-sm-6">
                <label for="phone" class="form-label">Số điện thoại</label>
                <input type="text" class="form-control" id="phone" name="phone"
                    placeholder="Nhập số điện thoại" value="{{ old('phone') }}">
            </div>
            <div class="col-sm-6">
                <label for="dob" class="form-label">Ngày sinh</label>
                <input type="date" class="form-control" id="dob" name="dob" value="{{ old('dob') }}">
            </div>
        </div>

        <div class="row g-3 mb-3">
            <div class="col">
                <label for="position" class="form-label">Chức vụ</label>
                <select class="form-select" id="position" name="position">
                    <option value="">Chọn chức vụ</option>
                    <option value="UI/UX Designer" {{ old('position') == 'UI/UX Designer' ? 'selected' : '' }}>UI/UX Designer</option>
                    <option value="Frontend Developer" {{ old('position') == 'Frontend Developer' ? 'selected' : '' }}>Frontend Developer</option>
                    <option value="Backend Developer" {{ old('position') == 'Backend Developer' ? 'selected' : '' }}>Backend Developer</option>
                    <option value="Fullstack Developer" {{ old('position') == 'Fullstack Developer' ? 'selected' : '' }}>Fullstack Developer</option>
                    <option value="Quality Assurance" {{ old('position') == 'Quality Assurance' ? 'selected' : '' }}>Quality Assurance</option>
                    <option value="Project Manager" {{ old('position') == 'Project Manager' ? 'selected' : '' }}>Project Manager</option>
                    <option value="Business Analyst" {{ old('position') == 'Business Analyst' ? 'selected' : '' }}>Business Analyst</option>
                    <option value="Marketing" {{ old('position') == 'Marketing' ? 'selected' : '' }}>Marketing</option>
                    <option value="SEO Specialist" {{ old('position') == 'SEO Specialist' ? 'selected' : '' }}>SEO Specialist</option>
                    <option value="Khác" {{ old('position') == 'Khác' ? 'selected' : '' }}>Khác</option>
                </select>
            </div>
            <div class="col">
                <label for="gender" class="form-label">Giới tính</label>
                <select class="form-select" id="gender" name="gender">
                    <option value="">Chọn giới tính</option>
                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Nam</option>
                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Nữ</option>
                    <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Khác</option>
                </select>
            </div>
        </div>

        <!-- Thêm trường Department -->
        <div class="mb-3">
            <label for="department_id" class="form-label">Phòng ban <span class="text-danger">*</span></label>
            <select class="form-select" id="department_id" name="department_id" required>
                <option value="">Chọn phòng ban</option>
                @foreach(App\Models\Department::where('status', 'active')->get() as $department)
                    <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>
                        {{ $department->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">Địa chỉ</label>
            <textarea class="form-control" id="address" name="address" rows="2"
                placeholder="Nhập địa chỉ chi tiết">{{ old('address') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Mô tả (tùy chọn)</label>
            <textarea class="form-control" id="description" name="description" rows="3"
                placeholder="Thêm mô tả về nhân viên, kinh nghiệm, kỹ năng...">{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Trạng thái</label>
            <select class="form-select" id="status" name="status">
                <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Hoạt động</option>
                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Không hoạt động</option>
                <option value="suspended" {{ old('status') == 'suspended' ? 'selected' : '' }}>Tạm dừng</option>
            </select>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
        <button type="submit" class="btn btn-primary">Tạo nhân viên</button>
    </div>
</form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    // Xử lý preview ảnh khi chọn file
    document.getElementById('image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // Có thể thêm preview image ở đây nếu cần
                console.log('Image selected:', file.name);
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection

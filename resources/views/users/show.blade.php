@extends('layouts.app')

@section('content')
    <div class="body d-flex py-lg-3 py-md-2">
        <div class="container-xxl">
            <!-- Header -->
            <div class="row clearfix">
                <div class="col-md-12">
                    <div class="card border-0 mb-4 no-bg">
                        <div class="card-header py-3 px-0 d-flex align-items-center justify-content-between border-bottom">
                            <h3 class="fw-bold flex-fill mb-0">Hồ sơ nhân viên</h3>
                            <a href="{{ route('users.index') }}" class="btn btn-outline-primary">
                                <i class="icofont-arrow-left"></i> Quay lại
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Alert Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="row g-3">
                <!-- Main Profile Section -->
                <div class="col-xl-8 col-lg-12 col-md-12">
                    <!-- Profile Card -->
                    <div class="card teacher-card mb-3">
                        <div class="card-body d-flex teacher-fulldeatil">
                            <div class="profile-teacher pe-xl-4 pe-md-2 pe-sm-4 pe-0 text-center w220 mx-sm-0 mx-auto">
                                <a href="#">
                                    <img src="{{ $user->image_url }}" alt="Avatar"
                                        class="avatar xl rounded-circle img-thumbnail shadow-sm">
                                </a>
                                <div class="about-info d-flex align-items-center mt-3 justify-content-center flex-column">
                                    <h6 class="mb-0 fw-bold d-block fs-6">{{ $user->position ?? 'Chưa có chức vụ' }}</h6>
                                    <span class="text-muted small">ID: {{ str_pad($user->id, 5, '0', STR_PAD_LEFT) }}</span>
                                    <div class="mt-2">
                                        @foreach($userRoles as $role)
                                            <span class="badge bg-primary me-1">{{ $role }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="teacher-info border-start ps-xl-4 ps-md-3 ps-sm-4 ps-4 w-100">
                                <h6 class="mb-0 mt-2 fw-bold d-block fs-6">{{ $user->name }}</h6>
                                <span
                                    class="py-1 fw-bold small-11 mb-0 mt-1 text-muted">{{ $user->position ?? 'Chưa có chức vụ' }}</span>
                                <div class="mt-2 mb-3">
                                    <span
                                        class="badge {{ $user->status == 'active' ? 'bg-success' : ($user->status == 'inactive' ? 'bg-warning' : 'bg-danger') }}">
                                        {{ $user->status_text }}
                                    </span>
                                </div>
                                <p class="mt-2 small">{{ $user->description ?? 'Chưa có mô tả về nhân viên này.' }}</p>
                                <div class="row g-2 pt-2">
                                    <div class="col-xl-6">
                                        <div class="d-flex align-items-center">
                                            <i class="icofont-ui-touch-phone text-primary"></i>
                                            <span class="ms-2 small">{{ $user->phone ?? 'Chưa có số điện thoại' }}</span>
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="d-flex align-items-center">
                                            <i class="icofont-email text-primary"></i>
                                            <span class="ms-2 small">{{ $user->email }}</span>
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="d-flex align-items-center">
                                            <i class="icofont-birthday-cake text-primary"></i>
                                            <span class="ms-2 small">
                                                {{ $user->dob ? $user->dob->format('d/m/Y') : 'Chưa có ngày sinh' }}
                                                @if($user->age) ({{ $user->age }} tuổi) @endif
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="d-flex align-items-center">
                                            <i class="icofont-user-male text-primary"></i>
                                            <span class="ms-2 small">{{ $user->gender_text }}</span>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-flex align-items-center">
                                            <i class="icofont-address-book text-primary"></i>
                                            <span class="ms-2 small">{{ $user->address ?? 'Chưa có địa chỉ' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h6 class="fw-bold  py-3 mb-3">Current Work Project</h6>
                    <div class="teachercourse-list">
                        <div class="row g-3 gy-5 py-3 row-deck">
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center justify-content-between mt-5">
                                            <div class="lesson_name">
                                                <div class="project-block light-info-bg">
                                                    <i class="icofont-paint"></i>
                                                </div>
                                                <span class="small text-muted project_name fw-bold"> Social Geek Made
                                                </span>
                                                <h6 class="mb-0 fw-bold  fs-6  mb-2">UI/UX Design</h6>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-list avatar-list-stacked pt-2">
                                                <img class="avatar rounded-circle sm" src="assets/images/xs/avatar2.jpg"
                                                    alt="">
                                                <img class="avatar rounded-circle sm" src="assets/images/xs/avatar1.jpg"
                                                    alt="">
                                                <img class="avatar rounded-circle sm" src="assets/images/xs/avatar3.jpg"
                                                    alt="">
                                                <img class="avatar rounded-circle sm" src="assets/images/xs/avatar4.jpg"
                                                    alt="">
                                                <img class="avatar rounded-circle sm" src="assets/images/xs/avatar8.jpg"
                                                    alt="">
                                            </div>
                                        </div>
                                        <div class="row g-2 pt-4">
                                            <div class="col-6">
                                                <div class="d-flex align-items-center">
                                                    <i class="icofont-paper-clip"></i>
                                                    <span class="ms-2">5 Attach</span>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="d-flex align-items-center">
                                                    <i class="icofont-sand-clock"></i>
                                                    <span class="ms-2">4 Month</span>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="d-flex align-items-center">
                                                    <i class="icofont-group-students "></i>
                                                    <span class="ms-2">5 Members</span>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="d-flex align-items-center">
                                                    <i class="icofont-ui-text-chat"></i>
                                                    <span class="ms-2">10</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="dividers-block"></div>
                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                            <h4 class="small fw-bold mb-0">Progress</h4>
                                            <span class="small light-danger-bg  p-1 rounded"><i
                                                    class="icofont-ui-clock"></i> 35 Days Left</span>
                                        </div>
                                        <div class="progress" style="height: 8px;">
                                            <div class="progress-bar bg-secondary" role="progressbar" style="width: 25%"
                                                aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
                                            <div class="progress-bar bg-secondary ms-1" role="progressbar"
                                                style="width: 25%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">
                                            </div>
                                            <div class="progress-bar bg-secondary ms-1" role="progressbar"
                                                style="width: 10%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center justify-content-between mt-5">
                                            <div class="lesson_name">
                                                <div class="project-block bg-lightgreen">
                                                    <i class="icofont-vector-path"></i>
                                                </div>
                                                <span class="small text-muted project_name fw-bold"> Practice to Perfect
                                                </span>
                                                <h6 class="mb-0 fw-bold  fs-6  mb-2">Website Design</h6>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-list avatar-list-stacked pt-2">
                                                <img class="avatar rounded-circle sm" src="assets/images/xs/avatar2.jpg"
                                                    alt="">
                                                <img class="avatar rounded-circle sm" src="assets/images/xs/avatar1.jpg"
                                                    alt="">
                                                <img class="avatar rounded-circle sm" src="assets/images/xs/avatar3.jpg"
                                                    alt="">
                                                <img class="avatar rounded-circle sm" src="assets/images/xs/avatar4.jpg"
                                                    alt="">
                                            </div>
                                        </div>
                                        <div class="row g-2 pt-4">
                                            <div class="col-6">
                                                <div class="d-flex align-items-center">
                                                    <i class="icofont-paper-clip"></i>
                                                    <span class="ms-2">4 Attach</span>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="d-flex align-items-center">
                                                    <i class="icofont-sand-clock"></i>
                                                    <span class="ms-2">1 Month</span>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="d-flex align-items-center">
                                                    <i class="icofont-group-students "></i>
                                                    <span class="ms-2">4 Members</span>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="d-flex align-items-center">
                                                    <i class="icofont-ui-text-chat"></i>
                                                    <span class="ms-2">3</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="dividers-block"></div>
                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                            <h4 class="small fw-bold mb-0">Progress</h4>
                                            <span class="small light-danger-bg  p-1 rounded"><i
                                                    class="icofont-ui-clock"></i> 15 Days Left</span>
                                        </div>
                                        <div class="progress" style="height: 8px;">
                                            <div class="progress-bar bg-secondary" role="progressbar" style="width: 25%"
                                                aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
                                            <div class="progress-bar bg-secondary ms-1" role="progressbar"
                                                style="width: 25%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">
                                            </div>
                                            <div class="progress-bar bg-secondary ms-1" role="progressbar"
                                                style="width: 39%" aria-valuenow="39" aria-valuemin="0" aria-valuemax="100">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Personal & Bank Info -->
                    <div class="row g-3">
                        <!-- Personal Information -->
                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12">
                            <div class="card">
                                <div class="card-header py-3 d-flex justify-content-between">
                                    <h6 class="mb-0 fw-bold">Thông tin cá nhân</h6>
                                    <button type="button" class="btn p-0" data-bs-toggle="modal"
                                        data-bs-target="#editPersonalInfo">
                                        <i class="icofont-edit text-primary fs-6"></i>
                                    </button>
                                </div>
                                <div class="card-body">
                                    <ul class="list-unstyled mb-0">
                                        <li class="row flex-wrap mb-3">
                                            <div class="col-6">
                                                <span class="fw-bold">Quốc tịch</span>
                                            </div>
                                            <div class="col-6">
                                                <span class="text-muted">{{ $user->nationality ?? 'Chưa có' }}</span>
                                            </div>
                                        </li>
                                        <li class="row flex-wrap mb-3">
                                            <div class="col-6">
                                                <span class="fw-bold">Tôn giáo</span>
                                            </div>
                                            <div class="col-6">
                                                <span class="text-muted">{{ $user->religion ?? 'Chưa có' }}</span>
                                            </div>
                                        </li>
                                        <li class="row flex-wrap mb-3">
                                            <div class="col-6">
                                                <span class="fw-bold">Tình trạng hôn nhân</span>
                                            </div>
                                            <div class="col-6">
                                                <span
                                                    class="text-muted">{{ $user->marital_status_text ?? 'Chưa có' }}</span>
                                            </div>
                                        </li>
                                        <li class="row flex-wrap mb-3">
                                            <div class="col-6">
                                                <span class="fw-bold">Số hộ chiếu</span>
                                            </div>
                                            <div class="col-6">
                                                <span
                                                    class="text-muted">{{ $user->passport_no ? str_repeat('*', strlen($user->passport_no) - 4) . substr($user->passport_no, -4) : 'Chưa có' }}</span>
                                            </div>
                                        </li>
                                        <li class="row flex-wrap">
                                            <div class="col-6">
                                                <span class="fw-bold">Liên lạc khẩn cấp</span>
                                            </div>
                                            <div class="col-6">
                                                <span class="text-muted">{{ $user->emergency_contact ?? 'Chưa có' }}</span>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Bank Information -->
                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12">
                            <div class="card">
                                <div class="card-header py-3 d-flex justify-content-between">
                                    <h6 class="mb-0 fw-bold">Thông tin ngân hàng</h6>
                                    <button type="button" class="btn p-0" data-bs-toggle="modal"
                                        data-bs-target="#editBankInfo">
                                        <i class="icofont-edit text-primary fs-6"></i>
                                    </button>
                                </div>
                                <div class="card-body">
                                    <ul class="list-unstyled mb-0">
                                        <li class="row flex-wrap mb-3">
                                            <div class="col-6">
                                                <span class="fw-bold">Tên ngân hàng</span>
                                            </div>
                                            <div class="col-6">
                                                <span class="text-muted">{{ $user->bank_name ?? 'Chưa có' }}</span>
                                            </div>
                                        </li>
                                        <li class="row flex-wrap mb-3">
                                            <div class="col-6">
                                                <span class="fw-bold">Số tài khoản</span>
                                            </div>
                                            <div class="col-6">
                                                <span class="text-muted">{{ $user->masked_account_no ?? 'Chưa có' }}</span>
                                            </div>
                                        </li>
                                        <li class="row flex-wrap mb-3">
                                            <div class="col-6">
                                                <span class="fw-bold">Mã IFSC</span>
                                            </div>
                                            <div class="col-6">
                                                <span class="text-muted">{{ $user->ifsc_code ?? 'Chưa có' }}</span>
                                            </div>
                                        </li>
                                        <li class="row flex-wrap mb-3">
                                            <div class="col-6">
                                                <span class="fw-bold">Số PAN</span>
                                            </div>
                                            <div class="col-6">
                                                <span class="text-muted">{{ $user->masked_pan_no ?? 'Chưa có' }}</span>
                                            </div>
                                        </li>
                                        <li class="row flex-wrap">
                                            <div class="col-6">
                                                <span class="fw-bold">UPI ID</span>
                                            </div>
                                            <div class="col-6">
                                                <span class="text-muted">{{ $user->upi_id ?? 'Chưa có' }}</span>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Sidebar -->
                <div class="col-xl-4 col-lg-12 col-md-12">

                    <!-- Profile Status Card -->
                    <div class="card mb-3">
                        <div class="card-header py-3">
                            <h6 class="mb-0 fw-bold">Tình trạng hồ sơ</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="small">Thông tin cơ bản</span>
                                    <span class="badge {{ $user->has_complete_profile ? 'bg-success' : 'bg-warning' }}">
                                        {{ $user->has_complete_profile ? 'Đầy đủ' : 'Chưa đủ' }}
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="small">Thông tin ngân hàng</span>
                                    <span class="badge {{ $user->has_banking_info ? 'bg-success' : 'bg-warning' }}">
                                        {{ $user->has_banking_info ? 'Đầy đủ' : 'Chưa đủ' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Account Info -->
                    <div class="card">
                        <div class="card-header py-3">
                            <h6 class="mb-0 fw-bold">Thông tin tài khoản</h6>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2">
                                    <strong>Ngày tạo:</strong>
                                    <span class="text-muted">{{ $user->created_at->format('d/m/Y H:i') }}</span>
                                </li>
                                <li class="mb-2">
                                    <strong>Cập nhật lần cuối:</strong>
                                    <span class="text-muted">{{ $user->updated_at->format('d/m/Y H:i') }}</span>
                                </li>
                                <li class="mb-2">
                                    <strong>Email xác thực:</strong>
                                    <span class="badge {{ $user->email_verified_at ? 'bg-success' : 'bg-warning' }}">
                                        {{ $user->email_verified_at ? 'Đã xác thực' : 'Chưa xác thực' }}
                                    </span>
                                </li>
                                <li>
                                    <strong>Vai trò:</strong>
                                    <div class="mt-1">
                                        @forelse($userRoles as $role)
                                            <span class="badge bg-info me-1">{{ $role }}</span>
                                        @empty
                                            <span class="text-muted small">Chưa có vai trò</span>
                                        @endforelse
                                    </div>
                                </li>
                            </ul>
                        </div>

                    </div>
                    
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Sửa Thông tin Cá nhân -->
    <div class="modal fade" id="editPersonalInfo" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <form action="{{ route('users.updatePersonalInfo', $user->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold">Sửa thông tin cá nhân</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3 mb-3">
                            <div class="col">
                                <label for="nationality" class="form-label">Quốc tịch</label>
                                <input type="text" class="form-control" id="nationality" name="nationality"
                                    value="{{ old('nationality', $user->nationality) }}">
                            </div>
                            <div class="col">
                                <label for="religion" class="form-label">Tôn giáo</label>
                                <input type="text" class="form-control" id="religion" name="religion"
                                    value="{{ old('religion', $user->religion) }}">
                            </div>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col">
                                <label for="marital_status" class="form-label">Tình trạng hôn nhân</label>
                                <select class="form-select" id="marital_status" name="marital_status">
                                    <option value="">Chọn tình trạng</option>
                                    <option value="single" {{ old('marital_status', $user->marital_status) == 'single' ? 'selected' : '' }}>Độc thân</option>
                                    <option value="married" {{ old('marital_status', $user->marital_status) == 'married' ? 'selected' : '' }}>Đã kết hôn</option>
                                    <option value="divorced" {{ old('marital_status', $user->marital_status) == 'divorced' ? 'selected' : '' }}>Đã ly hôn</option>
                                    <option value="widowed" {{ old('marital_status', $user->marital_status) == 'widowed' ? 'selected' : '' }}>Góa</option>
                                </select>
                            </div>
                            <div class="col">
                                <label for="passport_no" class="form-label">Số hộ chiếu</label>
                                <input type="text" class="form-control" id="passport_no" name="passport_no"
                                    value="{{ old('passport_no', $user->passport_no) }}">
                            </div>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-6">
                                <label for="emergency_contact" class="form-label">Liên lạc khẩn cấp</label>
                                <input type="text" class="form-control" id="emergency_contact" name="emergency_contact"
                                    value="{{ old('emergency_contact', $user->emergency_contact) }}">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Sửa Thông tin Ngân hàng -->
    <div class="modal fade" id="editBankInfo" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <form action="{{ route('users.updateBankInfo', $user->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold">Sửa thông tin ngân hàng</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3 mb-3">
                            <div class="col">
                                <label for="bank_name" class="form-label">Tên ngân hàng</label>
                                <input type="text" class="form-control" id="bank_name" name="bank_name"
                                    value="{{ old('bank_name', $user->bank_name) }}">
                            </div>
                            <div class="col">
                                <label for="account_no" class="form-label">Số tài khoản</label>
                                <input type="text" class="form-control" id="account_no" name="account_no"
                                    value="{{ old('account_no', $user->account_no) }}">
                            </div>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col">
                                <label for="ifsc_code" class="form-label">Mã IFSC</label>
                                <input type="text" class="form-control" id="ifsc_code" name="ifsc_code"
                                    value="{{ old('ifsc_code', $user->ifsc_code) }}">
                            </div>
                            <div class="col">
                                <label for="pan_no" class="form-label">Số PAN</label>
                                <input type="text" class="form-control" id="pan_no" name="pan_no"
                                    value="{{ old('pan_no', $user->pan_no) }}">
                            </div>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-6">
                                <label for="upi_id" class="form-label">UPI ID</label>
                                <input type="text" class="form-control" id="upi_id" name="upi_id"
                                    value="{{ old('upi_id', $user->upi_id) }}">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

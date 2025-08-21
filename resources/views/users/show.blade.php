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
                                <span class="py-1 fw-bold small-11 mb-0 mt-1 text-muted">{{ $user->position ?? 'Chưa có chức vụ' }}</span>
                                <div class="mt-2 mb-3">
                                    <span class="badge {{ $user->status == 'active' ? 'bg-success' : ($user->status == 'inactive' ? 'bg-warning' : 'bg-danger') }}">
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

                    <!-- Current Work Projects -->
                    <div class="d-flex justify-content-between align-items-center py-3 mb-3">
                        <h6 class="fw-bold mb-0">Current Work Project</h6>
                        <div class="text-muted small">
                            <i class="icofont-ui-folder"></i> {{ $projectStats['total_projects'] }} dự án
                            @if($projectStats['managed_projects'] > 0)
                                | <i class="icofont-crown"></i> {{ $projectStats['managed_projects'] }} quản lý
                            @endif
                        </div>
                    </div>

                    <div class="teachercourse-list">
                        <div class="row g-3 gy-5 py-3 row-deck">
                            @forelse($allProjects as $project)
                                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center justify-content-between mt-5">
                                                <div class="lesson_name">
                                                    <div class="project-block {{ $project->priority == 'urgent' ? 'bg-danger' : ($project->priority == 'high' ? 'light-danger-bg' : ($project->priority == 'medium' ? 'light-warning-bg' : 'light-info-bg')) }}">
                                                        <i class="icofont-{{ $project->priority == 'urgent' ? 'fire-alt' : ($project->priority == 'high' ? 'exclamation-tringle' : 'paint') }}"></i>
                                                    </div>
                                                    <span class="small text-muted project_name fw-bold">{{ $project->customer_name ?? 'Nội bộ' }}</span>
                                                    <h6 class="mb-0 fw-bold fs-6 mb-2">{{ $project->name }}</h6>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-list avatar-list-stacked pt-2">
                                                    @if($project->manager)
                                                        <img class="avatar rounded-circle sm"
                                                             src="{{ $project->manager->image_url }}"
                                                             alt="{{ $project->manager->name }}"
                                                             title="Manager: {{ $project->manager->name }}">
                                                    @endif
                                                    @foreach($project->members->take(4) as $member)
                                                        <img class="avatar rounded-circle sm"
                                                             src="{{ $member->image_url }}"
                                                             alt="{{ $member->name }}"
                                                             title="{{ $member->name }}">
                                                    @endforeach
                                                    @if($project->members->count() > 4)
                                                        <span class="avatar rounded-circle sm text-center bg-secondary text-white">
                                                            +{{ $project->members->count() - 4 }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="row g-2 pt-4">
                                                <div class="col-6">
                                                    <div class="d-flex align-items-center">
                                                        <i class="icofont-tasks"></i>
                                                        <span class="ms-2">{{ $project->tasks->count() }} Tasks</span>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="d-flex align-items-center">
                                                        <i class="icofont-sand-clock"></i>
                                                        <span class="ms-2">
                                                            @if($project->end_date)
                                                                {{ $project->end_date->diffForHumans() }}
                                                            @else
                                                                Không có deadline
                                                            @endif
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="d-flex align-items-center">
                                                        <i class="icofont-group-students"></i>
                                                        <span class="ms-2">{{ $project->members->count() }} Members</span>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="d-flex align-items-center">
                                                        <i class="icofont-dollar"></i>
                                                        <span class="ms-2">{{ $project->formatted_budget ?? 'N/A' }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="dividers-block"></div>
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <h4 class="small fw-bold mb-0">Progress</h4>
                                                <span class="small {{ $project->isOverdue() ? 'light-danger-bg' : 'light-info-bg' }} p-1 rounded">
                                                    <i class="icofont-ui-clock"></i>
                                                    @if($project->end_date)
                                                        {{ $project->end_date > now() ? $project->end_date->diffForHumans() : 'Quá hạn' }}
                                                    @else
                                                        Không deadline
                                                    @endif
                                                </span>
                                            </div>
                                            <div class="progress" style="height: 8px;">
                                                <div class="progress-bar {{ $project->completion_percentage >= 75 ? 'bg-success' : ($project->completion_percentage >= 50 ? 'bg-warning' : 'bg-danger') }}"
                                                     role="progressbar"
                                                     style="width: {{ $project->completion_percentage }}%"
                                                     aria-valuenow="{{ $project->completion_percentage }}"
                                                     aria-valuemin="0"
                                                     aria-valuemax="100">
                                                </div>
                                            </div>
                                            <div class="text-center mt-1">
                                                <small class="text-muted">{{ $project->completion_percentage }}% hoàn thành</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body text-center py-5">
                                            <i class="icofont-folder-open fs-1 text-muted mb-3"></i>
                                            <h6 class="text-muted">Chưa có dự án nào</h6>
                                            <p class="small text-muted">Nhân viên này chưa tham gia dự án nào.</p>
                                        </div>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Task Statistics -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-3">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h5 class="text-primary">{{ $taskStats['total'] }}</h5>
                                    <small class="text-muted">Tổng tasks</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h5 class="text-warning">{{ $taskStats['in_progress'] }}</h5>
                                    <small class="text-muted">Đang làm</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h5 class="text-success">{{ $taskStats['completed'] }}</h5>
                                    <small class="text-muted">Hoàn thành</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h5 class="text-danger">{{ $taskStats['overdue'] }}</h5>
                                    <small class="text-muted">Quá hạn</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Personal & Bank Info (giữ nguyên như cũ) -->
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
                                                <span class="text-muted">{{ $user->marital_status_text ?? 'Chưa có' }}</span>
                                            </div>
                                        </li>
                                        <li class="row flex-wrap mb-3">
                                            <div class="col-6">
                                                <span class="fw-bold">Số hộ chiếu</span>
                                            </div>
                                            <div class="col-6">
                                                <span class="text-muted">{{ $user->passport_no ? str_repeat('*', strlen($user->passport_no) - 4) . substr($user->passport_no, -4) : 'Chưa có' }}</span>
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
                    <div class="card mb-3">
                        <div class="card-header py-3 d-flex justify-content-between">
                            <h6 class="mb-0 fw-bold">Current Task</h6>
                            <span class="badge bg-primary">{{ $taskStats['completion_rate'] }}% hoàn thành</span>
                        </div>
                        <div class="card-body">
                            <div class="planned_task client_task">
                                <div class="dd" data-plugin="nestable">
                                    <ol class="dd-list" style="padding-left: 0rem;">
                                        @forelse($currentTasks as $task)
                                            <li class="dd-item mb-3">
                                                <div class="dd-handle">
                                                    <div class="task-info d-flex align-items-center justify-content-between">
                                                        <h6 class="{{ $task->getPriorityBadgeColor() == 'bg-dark' ? 'bg-dark text-white' : $task->getStatusBadgeColor() }} py-1 px-2 rounded-1 d-inline-block fw-bold small-14 mb-0">
                                                            {{ $task->name }}
                                                        </h6>
                                                        <div class="task-priority d-flex flex-column align-items-center justify-content-center">
                                                            <div class="avatar-list avatar-list-stacked m-0">
                                                                <img class="avatar rounded-circle small-avt sm"
                                                                     src="{{ $task->assignee->image_url }}"
                                                                     alt="{{ $task->assignee->name }}"
                                                                     title="{{ $task->assignee->name }}">
                                                            </div>
                                                            <span class="badge {{ $task->status == 'in_progress' ? 'bg-warning' : ($task->status == 'needs_review' ? 'bg-info' : 'bg-success') }} text-end mt-1">
                                                                {{ $task->getStatuses()[$task->status] ?? $task->status }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <p class="py-2 mb-0">{{ Str::limit($task->description ?? 'Không có mô tả', 100) }}</p>
                                                    <div class="tikit-info row g-3 align-items-center">
                                                        <div class="col-sm">
                                                            <div class="d-flex align-items-center">
                                                                <i class="icofont-ui-calendar text-muted"></i>
                                                                <span class="ms-2 small text-muted">
                                                                    @if($task->end_date)
                                                                        {{ $task->end_date->format('d/m/Y') }}
                                                                        @if($task->isOverdue())
                                                                            <span class="text-danger">(Quá hạn)</span>
                                                                        @endif
                                                                    @else
                                                                        Không có deadline
                                                                    @endif
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm text-end">
                                                            <div class="small text-truncate light-danger-bg py-1 px-2 rounded-1 d-inline-block fw-bold small">
                                                                {{ $task->project->name }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        @empty
                                            <li class="dd-item">
                                                <div class="dd-handle text-center py-4">
                                                    <i class="icofont-tasks fs-1 text-muted mb-2"></i>
                                                    <p class="text-muted mb-0">Không có task nào đang thực hiện</p>
                                                </div>
                                            </li>
                                        @endforelse
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

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

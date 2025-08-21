@extends('layouts.app')

@section('title', 'Chi tiết Khách hàng: ' . $customer->name)

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="d-flex align-items-center mb-2">
                                <h2 class="mb-0 me-3">{{ $customer->name }}</h2>
                                @switch($customer->status)
                                    @case('active')
                                        <span class="badge bg-success fs-6">Đang hoạt động</span>
                                        @break
                                    @case('inactive')
                                        <span class="badge bg-secondary fs-6">Không hoạt động</span>
                                        @break
                                    @case('potential')
                                        <span class="badge bg-warning fs-6">Tiềm năng</span>
                                        @break
                                @endswitch
                            </div>
                            <div class="text-muted mb-2">
                                <i class="fas fa-id-card me-2"></i>
                                <code class="fs-5">{{ $customer->code }}</code>
                            </div>
                            <div class="d-flex align-items-center">
                                @if($customer->type == 'company')
                                    <span class="badge bg-primary me-2">
                                        <i class="fas fa-building me-1"></i>Công ty
                                    </span>
                                @else
                                    <span class="badge bg-info me-2">
                                        <i class="fas fa-user me-1"></i>Cá nhân
                                    </span>
                                @endif
                                <small class="text-muted">
                                    Tạo ngày {{ $customer->created_at->format('d/m/Y H:i') }}
                                </small>
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="btn-group" role="group">
                                <a href="{{ route('customers.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-1"></i>
                                    Quay lại
                                </a>
                                <a href="{{ route('customers.edit', $customer) }}" class="btn btn-primary">
                                    <i class="fas fa-edit me-1"></i>
                                    Chỉnh sửa
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Left Column: Customer Info -->
        <div class="col-md-4">
            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-6">
                    <div class="card text-center bg-primary text-white">
                        <div class="card-body">
                            <h3 class="mb-0">{{ $stats['total_projects'] }}</h3>
                            <small>Tổng dự án</small>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card text-center bg-success text-white">
                        <div class="card-body">
                            <h3 class="mb-0">{{ $stats['active_projects'] }}</h3>
                            <small>Đang thực hiện</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-6">
                    <div class="card text-center bg-info text-white">
                        <div class="card-body">
                            <h3 class="mb-0">{{ $stats['completed_projects'] }}</h3>
                            <small>Đã hoàn thành</small>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card text-center bg-warning text-white">
                        <div class="card-body">
                            <h4 class="mb-0">{{ number_format($stats['total_budget'], 0, ',', '.') }}</h4>
                            <small>Tổng ngân sách (VNĐ)</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customer Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Thông tin khách hàng
                    </h5>
                </div>
                <div class="card-body">
                    @if($customer->tax_code)
                        <div class="mb-3">
                            <strong>Mã số thuế:</strong>
                            <div class="mt-1">{{ $customer->tax_code }}</div>
                        </div>
                    @endif

                    @if($customer->address)
                        <div class="mb-3">
                            <strong>Địa chỉ:</strong>
                            <div class="mt-1">{{ $customer->address }}</div>
                        </div>
                    @endif

                    @if($customer->description)
                        <div class="mb-3">
                            <strong>Mô tả:</strong>
                            <div class="mt-1">{{ $customer->description }}</div>
                        </div>
                    @endif

                    @if($customer->additional_info && count($customer->additional_info) > 0)
                        <div class="mb-3">
                            <strong>Thông tin bổ sung:</strong>
                            <div class="mt-2">
                                @foreach($customer->additional_info as $key => $value)
                                    <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                                        <span class="text-muted">{{ $key }}:</span>
                                        <span>{{ $value }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Contact Information -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-address-book me-2"></i>
                        Thông tin liên hệ
                    </h5>
                </div>
                <div class="card-body">
                    @if($customer->email)
                        <div class="mb-3">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-envelope text-primary me-2"></i>
                                <strong>Email:</strong>
                            </div>
                            <div class="mt-1 ms-4">
                                <a href="mailto:{{ $customer->email }}">{{ $customer->email }}</a>
                            </div>
                        </div>
                    @endif

                    @if($customer->phone)
                        <div class="mb-3">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-phone text-success me-2"></i>
                                <strong>Số điện thoại:</strong>
                            </div>
                            <div class="mt-1 ms-4">
                                <a href="tel:{{ $customer->phone }}">{{ $customer->phone }}</a>
                            </div>
                        </div>
                    @endif

                    @if($customer->contact_person)
                        <div class="mb-3">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-user-tie text-info me-2"></i>
                                <strong>Người liên hệ:</strong>
                            </div>
                            <div class="mt-1 ms-4">
                                {{ $customer->contact_person }}
                                @if($customer->contact_position)
                                    <br><small class="text-muted">{{ $customer->contact_position }}</small>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Column: Projects -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-project-diagram me-2"></i>
                            Danh sách Dự án ({{ $customer->projects->count() }})
                        </h5>
                        @if($customer->status == 'active')
                            <a href="{{ route('projects.create', ['customer_id' => $customer->id]) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus me-1"></i>
                                Thêm dự án mới
                            </a>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    @if($customer->projects->count() > 0)
                        <!-- Projects Filter Tabs -->
                        <ul class="nav nav-pills mb-3" id="project-tabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="all-projects-tab" data-bs-toggle="pill" data-bs-target="#all-projects" type="button">
                                    Tất cả <span class="badge bg-secondary">{{ $customer->projects->count() }}</span>
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="active-projects-tab" data-bs-toggle="pill" data-bs-target="#active-projects" type="button">
                                    Đang thực hiện <span class="badge bg-success">{{ $stats['active_projects'] }}</span>
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="completed-projects-tab" data-bs-toggle="pill" data-bs-target="#completed-projects" type="button">
                                    Đã hoàn thành <span class="badge bg-info">{{ $stats['completed_projects'] }}</span>
                                </button>
                            </li>
                        </ul>

                        <!-- Projects Content -->
                        <div class="tab-content" id="project-content">
                            <!-- All Projects -->
                            <div class="tab-pane fade show active" id="all-projects">
                                @include('customers.partials.projects-list', ['projects' => $customer->projects])
                            </div>

                            <!-- Active Projects -->
                            <div class="tab-pane fade" id="active-projects">
                                @include('customers.partials.projects-list', ['projects' => $customer->activeProjects])
                            </div>

                            <!-- Completed Projects -->
                            <div class="tab-pane fade" id="completed-projects">
                                @include('customers.partials.projects-list', ['projects' => $customer->completedProjects])
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-project-diagram fa-3x text-muted mb-3"></i>
                            <h5>Chưa có dự án nào</h5>
                            <p class="text-muted">Khách hàng này chưa có dự án nào được tạo.</p>
                            @if($customer->status == 'active')
                                <a href="{{ route('projects.create', ['customer_id' => $customer->id]) }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-1"></i>
                                    Tạo dự án đầu tiên
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize Bootstrap tooltips
    $('[data-bs-toggle="tooltip"]').tooltip();

    // Auto-refresh project statistics every 30 seconds
    setInterval(function() {
        // You can implement AJAX refresh here if needed
    }, 30000);
});
</script>
@endpush
@endsection

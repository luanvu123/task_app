@extends('layouts.app')

@section('content')
<div class="body d-flex py-lg-3 py-md-2">
    <div class="container-xxl">
        <div class="row align-items-center">
            <div class="border-0 mb-4">
                <div class="card-header no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                    <h3 class="fw-bold mb-0 py-3 pb-2">Quản lý Phiếu Lương</h3>
                    <a href="{{ route('salaryslips.create') }}" class="btn btn-primary">
                        <i class="fa fa-plus me-2"></i>Tạo phiếu lương mới
                    </a>
                </div>
            </div>
        </div>

        <!-- Bộ lọc -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Bộ lọc tìm kiếm</h5>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('salaryslips.index') }}">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label for="user_id" class="form-label">Nhân viên</label>
                                    <select name="user_id" id="user_id" class="form-select">
                                        <option value="">-- Tất cả nhân viên --</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <label for="month" class="form-label">Tháng</label>
                                    <select name="month" id="month" class="form-select">
                                        <option value="">-- Tất cả --</option>
                                        @for($m = 1; $m <= 12; $m++)
                                            <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                                                Tháng {{ $m }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <label for="year" class="form-label">Năm</label>
                                    <select name="year" id="year" class="form-select">
                                        <option value="">-- Tất cả --</option>
                                        @for($y = date('Y'); $y >= date('Y') - 5; $y--)
                                            <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>
                                                {{ $y }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label for="status" class="form-label">Trạng thái</label>
                                    <select name="status" id="status" class="form-select">
                                        <option value="">-- Tất cả trạng thái --</option>
                                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Nháp</option>
                                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Đã duyệt</option>
                                        <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Đã thanh toán</option>
                                    </select>
                                </div>

                                <div class="col-md-2 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary me-2">
                                        <i class="fa fa-search me-1"></i>Tìm kiếm
                                    </button>
                                    <a href="{{ route('salaryslips.index') }}" class="btn btn-outline-secondary">
                                        <i class="fa fa-refresh"></i>
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Danh sách phiếu lương -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        @if($salaryslips->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>STT</th>
                                            <th>Nhân viên</th>
                                            <th>Tháng lương</th>
                                            <th class="text-end">Thu nhập</th>
                                            <th class="text-end">Khấu trừ</th>
                                            <th class="text-end">Thực nhận</th>
                                            <th class="text-center">Trạng thái</th>
                                            <th class="text-center">Người tạo</th>
                                            <th class="text-center">Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($salaryslips as $index => $salaryslip)
                                        <tr>
                                            <td>{{ $salaryslips->firstItem() + $index }}</td>
                                            <td>
                                                <div>
                                                    <strong>{{ $salaryslip->employee->name }}</strong>
                                                    <small class="d-block text-muted">{{ $salaryslip->employee->email }}</small>
                                                </div>
                                            </td>
                                            <td>
                                                <strong>{{ \Carbon\Carbon::parse($salaryslip->salary_date)->format('m/Y') }}</strong>
                                                <small class="d-block text-muted">{{ \Carbon\Carbon::parse($salaryslip->salary_date)->format('d/m/Y') }}</small>
                                            </td>
                                            <td class="text-end">
                                                <strong class="text-success">{{ $salaryslip->formatted_earnings_amount }}</strong>
                                            </td>
                                            <td class="text-end">
                                                <strong class="text-danger">{{ $salaryslip->formatted_deductions_amount }}</strong>
                                            </td>
                                            <td class="text-end">
                                                <strong class="text-primary">{{ $salaryslip->formatted_net_salary }}</strong>
                                            </td>
                                            <td class="text-center">
                                                @switch($salaryslip->status)
                                                    @case('draft')
                                                        <span class="badge bg-warning">Nháp</span>
                                                        @break
                                                    @case('approved')
                                                        <span class="badge bg-success">Đã duyệt</span>
                                                        @break
                                                    @case('paid')
                                                        <span class="badge bg-primary">Đã thanh toán</span>
                                                        @break
                                                @endswitch
                                            </td>
                                            <td class="text-center">
                                                <small>{{ $salaryslip->creator->name }}</small>
                                                <small class="d-block text-muted">{{ $salaryslip->created_at->format('d/m/Y') }}</small>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <a href="{{ route('salaryslips.show', $salaryslip) }}"
                                                       class="btn btn-outline-info" title="Xem chi tiết">
                                                        <i class="icofont-eye-open"></i>
                                                    </a>

                                                    @if($salaryslip->status == 'draft')
                                                        <a href="{{ route('salaryslips.edit', $salaryslip) }}"
                                                           class="btn btn-outline-warning" title="Chỉnh sửa">
                                                            <i class="icofont-ui-edit"></i>
                                                        </a>
                                                    @endif



                                                    @if($salaryslip->status == 'draft')
                                                        <form method="POST" action="{{ route('salaryslips.destroy', $salaryslip) }}"
                                                              class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa phiếu lương này?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-outline-danger" title="Xóa">
                                                                 <i class="icofont-trash"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div>
                                    Hiển thị {{ $salaryslips->firstItem() }} đến {{ $salaryslips->lastItem() }}
                                    trong tổng số {{ $salaryslips->total() }} phiếu lương
                                </div>
                                {{ $salaryslips->links() }}
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fa fa-file-text-o fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">Chưa có phiếu lương nào</h5>
                                <p class="text-muted">Nhấn nút "Tạo phiếu lương mới" để bắt đầu</p>
                                <a href="{{ route('salaryslips.create') }}" class="btn btn-primary">
                                    <i class="fa fa-plus me-2"></i>Tạo phiếu lương mới
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Thống kê tổng quan -->
        @if($salaryslips->count() > 0)
        <div class="row mt-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title">Tổng phiếu lương</h6>
                                <h3>{{ $salaryslips->total() }}</h3>
                            </div>
                            <i class="fa fa-file-text-o fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title">Đang chờ duyệt</h6>
                                <h3>{{ $salaryslips->where('status', 'draft')->count() }}</h3>
                            </div>
                            <i class="fa fa-clock-o fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title">Đã duyệt</h6>
                                <h3>{{ $salaryslips->where('status', 'approved')->count() }}</h3>
                            </div>
                            <i class="fa fa-check fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title">Đã thanh toán</h6>
                                <h3>{{ $salaryslips->where('status', 'paid')->count() }}</h3>
                            </div>
                            <i class="fa fa-credit-card fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

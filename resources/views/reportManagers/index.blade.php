@extends('layouts.app')

@section('title', 'Quản lý Báo cáo')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="card-title mb-0">Quản lý Báo cáo</h3>
                            <small class="text-muted">Danh sách báo cáo của hệ thống</small>
                        </div>
                        <div class="col-auto">
                            @if(auth()->user()->hasRole('Trưởng phòng'))
                            <a href="{{ route('reportManagers.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Tạo báo cáo mới
                            </a>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Filters -->
                    <form method="GET" action="{{ route('reportManagers.index') }}" class="mb-4">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label">Tìm kiếm</label>
                                <input type="text" name="search" class="form-control"
                                       placeholder="Tìm theo tiêu đề, nội dung..."
                                       value="{{ request('search') }}">
                            </div>

                            <div class="col-md-2">
                                <label class="form-label">Trạng thái</label>
                                <select name="status" class="form-select">
                                    <option value="">Tất cả</option>
                                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Bản nháp</option>
                                    <option value="submitted" {{ request('status') == 'submitted' ? 'selected' : '' }}>Đã gửi</option>
                                    <option value="reviewed" {{ request('status') == 'reviewed' ? 'selected' : '' }}>Đã xem</option>
                                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Đã phê duyệt</option>
                                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Từ chối</option>
                                </select>
                            </div>

                            @if(auth()->user()->hasRole('Giám đốc'))
                            <div class="col-md-2">
                                <label class="form-label">Phòng ban</label>
                                <select name="department_id" class="form-select">
                                    <option value="">Tất cả</option>
                                    @foreach($departments as $department)
                                    <option value="{{ $department->id }}"
                                            {{ request('department_id') == $department->id ? 'selected' : '' }}>
                                        {{ $department->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            @endif

                            <div class="col-md-2">
                                <label class="form-label">Loại báo cáo</label>
                                <select name="report_type" class="form-select">
                                    <option value="">Tất cả</option>
                                    <option value="monthly" {{ request('report_type') == 'monthly' ? 'selected' : '' }}>Báo cáo tháng</option>
                                    <option value="quarterly" {{ request('report_type') == 'quarterly' ? 'selected' : '' }}>Báo cáo quý</option>
                                    <option value="yearly" {{ request('report_type') == 'yearly' ? 'selected' : '' }}>Báo cáo năm</option>
                                    <option value="project_completion" {{ request('report_type') == 'project_completion' ? 'selected' : '' }}>Hoàn thành dự án</option>
                                    <option value="urgent" {{ request('report_type') == 'urgent' ? 'selected' : '' }}>Khẩn cấp</option>
                                    <option value="other" {{ request('report_type') == 'other' ? 'selected' : '' }}>Khác</option>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label class="form-label">Mức ưu tiên</label>
                                <select name="priority" class="form-select">
                                    <option value="">Tất cả</option>
                                    <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Thấp</option>
                                    <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Trung bình</option>
                                    <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>Cao</option>
                                    <option value="urgent" {{ request('priority') == 'urgent' ? 'selected' : '' }}>Khẩn cấp</option>
                                </select>
                            </div>

                            <div class="col-md-1">
                                <label class="form-label">&nbsp;</label>
                                <div>
                                    <button type="submit" class="btn btn-outline-primary">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <a href="{{ route('reportManagers.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-times"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- Table -->
                 <div class="table-responsive">
    <table class="table table-hover">
        <thead class="table-light">
            <tr>
                <th>STT</th> <!-- Thêm cột STT -->
                <th>Tiêu đề</th>
                <th>Loại</th>
                @if(auth()->user()->hasRole('Giám đốc'))
                <th>Phòng ban</th>
                <th>Người gửi</th>
                @else
                <th>Người nhận</th>
                @endif
                <th>Trạng thái</th>
                <th>Ưu tiên</th>
                <th>Ngày tạo</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reports as $report)
            <tr class="{{ $report->isOverdue() ? 'table-warning' : '' }}">
                <!-- Cột STT -->
                <td>
                    {{ ($reports->currentPage() - 1) * $reports->perPage() + $loop->iteration }}
                </td>

                <td>
                    <div class="d-flex align-items-center">
                        @if($report->isOverdue())
                        <i class="fas fa-exclamation-triangle text-warning me-2" title="Báo cáo quá hạn"></i>
                        @endif
                        <div>
                            <h6 class="mb-0">{{ Str::limit($report->title, 50) }}</h6>
                            @if($report->attachments && count($report->attachments) > 0)
                            <small class="text-muted">
                                <i class="fas fa-paperclip"></i> {{ count($report->attachments) }} file
                            </small>
                            @endif
                        </div>
                    </div>
                </td>
                <td>
                    <span class="badge bg-info">{{ $report->report_type_label }}</span>
                </td>
                @if(auth()->user()->hasRole('Giám đốc'))
                <td>{{ $report->department->name ?? 'N/A' }}</td>
                <td>{{ $report->reporter->name ?? 'N/A' }}</td>
                @else
                <td>{{ $report->recipient->name ?? 'N/A' }}</td>
                @endif
                <td>
                    <span class="badge bg-{{ $report->status_color }}">
                        {{ $report->status_label }}
                    </span>
                </td>
                <td>
                    <span class="badge bg-{{ $report->priority_color }}">
                        @switch($report->priority)
                            @case('low') Thấp @break
                            @case('medium') Trung bình @break
                            @case('high') Cao @break
                            @case('urgent') Khẩn cấp @break
                        @endswitch
                    </span>
                </td>
                <td>
                    <small>{{ $report->created_at->format('d/m/Y H:i') }}</small>
                    @if($report->submitted_at)
                    <br><small class="text-muted">Gửi: {{ $report->submitted_at->format('d/m/Y H:i') }}</small>
                    @endif
                </td>
                <td>
                    <div class="btn-group" role="group">
                        <a href="{{ route('reportManagers.show', $report) }}"
                           class="btn btn-sm btn-outline-primary" title="Xem chi tiết">
                            <i class="fas fa-eye"></i>
                        </a>

                        @if($report->reporter_id == auth()->id() && $report->canBeEdited())
                        <a href="{{ route('reportManagers.edit', $report) }}"
                           class="btn btn-sm btn-outline-warning" title="Chỉnh sửa">
                            <i class="fas fa-edit"></i>
                        </a>

                        <form method="POST" action="{{ route('reportManagers.destroy', $report) }}"
                              class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa báo cáo này?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Xóa">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" class="text-center py-4">
                    <div class="text-muted">
                        <i class="fas fa-file-alt fa-3x mb-3"></i>
                        <p class="mb-0">Không có báo cáo nào được tìm thấy.</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>


                    <!-- Pagination -->
                    @if($reports->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $reports->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.table-warning {
    --bs-table-bg: #fff3cd;
    --bs-table-border-color: #ffecb5;
}
</style>
@endpush

<?php // resources/views/proposes/index.blade.php ?>
@extends('layouts.app')

@section('title', 'Danh sách đề xuất')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Danh sách đề xuất</h3>
                        <div class="card-tools">
                            <a href="{{ route('proposes.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Tạo đề xuất mới
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <!-- Filters -->
                        <form method="GET" class="mb-4">
                            <div class="row">
                                <div class="col-md-3">
                                    <select name="status" class="form-control">
                                        <option value="">Tất cả trạng thái</option>
                                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Nháp
                                        </option>
                                        <option value="submitted" {{ request('status') == 'submitted' ? 'selected' : '' }}>Đã
                                            gửi</option>
                                        <option value="under_review" {{ request('status') == 'under_review' ? 'selected' : '' }}>Đang xem xét</option>
                                        <option value="pending_approval" {{ request('status') == 'pending_approval' ? 'selected' : '' }}>Chờ phê duyệt</option>
                                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Đã
                                            phê duyệt</option>
                                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Từ
                                            chối</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select name="project_id" class="form-control">
                                        <option value="">Tất cả dự án</option>
                                        @foreach($projects as $project)
                                            <option value="{{ $project->id }}" {{ request('project_id') == $project->id ? 'selected' : '' }}>
                                                {{ $project->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" name="search" class="form-control" placeholder="Tìm kiếm..."
                                        value="{{ request('search') }}">
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-outline-primary">Lọc</button>
                                    <a href="{{ route('proposes.index') }}" class="btn btn-outline-secondary">Reset</a>
                                </div>
                            </div>
                        </form>

                        <!-- Table -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                         <th>#</th>
                                        <th>Mã đề xuất</th>
                                        <th>Tiêu đề</th>
                                        <th>Dự án</th>
                                        <th>Người đề xuất</th>
                                        <th>Tổng tiền</th>
                                        <th>Trạng thái</th>
                                        <th>Ưu tiên</th>
                                        <th>Ngày tạo</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($proposes as $propose)
                                        <tr>
                                               <td>{{ $loop->iteration + ($proposes->currentPage() - 1) * $proposes->perPage() }}</td>
                                            <td>{{ $propose->propose_code }}</td>
                                            <td>
                                                <a href="{{ route('proposes.show', $propose) }}">
                                                    {{ $propose->title }}
                                                </a>
                                                @if($propose->is_urgent)
                                                    <span class="badge badge-danger ml-1">CẤP THIẾT</span>
                                                @endif
                                            </td>
                                            <td>{{ $propose->project->name ?? 'N/A' }}</td>
                                            <td>{{ $propose->proposedBy->name ?? 'N/A' }}</td>
                                            <td>{{ number_format($propose->total_amount) }} VNĐ</td>
                                            <td>
                                                @php
                                                    $statusClasses = [
                                                        'draft' => 'secondary',
                                                        'submitted' => 'info',
                                                        'under_review' => 'warning',
                                                        'pending_approval' => 'primary',
                                                        'approved' => 'success',
                                                        'rejected' => 'danger',
                                                        'cancelled' => 'dark'
                                                    ];
                                                    $statusLabels = [
                                                        'draft' => 'Nháp',
                                                        'submitted' => 'Đã gửi',
                                                        'under_review' => 'Đang xem xét',
                                                        'pending_approval' => 'Chờ phê duyệt',
                                                        'approved' => 'Đã phê duyệt',
                                                        'rejected' => 'Từ chối',
                                                        'cancelled' => 'Đã hủy'
                                                    ];
                                                @endphp
                                                <span class="badge bg-{{ $statusClasses[$propose->status] ?? 'secondary' }}">
                                                    {{ $statusLabels[$propose->status] ?? $propose->status }}
                                                </span>
                                            </td>
                                            <td>
                                                @php
                                                    $priorityClasses = [
                                                        'low' => 'success',
                                                        'medium' => 'warning',
                                                        'high' => 'danger',
                                                        'urgent' => 'dark'
                                                    ];
                                                    $priorityLabels = [
                                                        'low' => 'Thấp',
                                                        'medium' => 'Trung bình',
                                                        'high' => 'Cao',
                                                        'urgent' => 'Khẩn cấp'
                                                    ];
                                                @endphp
                                                <span
                                                    class="badge bg-{{ $priorityClasses[$propose->priority] ?? 'secondary' }}">
                                                    {{ $priorityLabels[$propose->priority] ?? $propose->priority }}
                                                </span>
                                            </td>

                                            <td>{{ $propose->created_at->format('d/m/Y') }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('proposes.show', $propose) }}"
                                                        class="btn btn-sm btn-info">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    @if($propose->canBeEdited())
                                                        <a href="{{ route('proposes.edit', $propose) }}"
                                                            class="btn btn-sm btn-warning">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center">Không có đề xuất nào</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        {{ $proposes->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

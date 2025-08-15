<?php // resources/views/proposes/dashboard.blade.php ?>
@extends('layouts.app')

@section('title', 'Dashboard Đề xuất')

@section('content')
<div class="container-fluid">
    <!-- Statistics Cards -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3 id="total-proposes">0</h3>
                    <p>Tổng đề xuất</p>
                </div>
                <div class="icon">
                    <i class="fas fa-file-alt"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3 id="pending-proposes">0</h3>
                    <p>Chờ xử lý</p>
                </div>
                <div class="icon">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3 id="approved-proposes">0</h3>
                    <p>Đã phê duyệt</p>
                </div>
                <div class="icon">
                    <i class="fas fa-check"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3 id="rejected-proposes">0</h3>
                    <p>Bị từ chối</p>
                </div>
                <div class="icon">
                    <i class="fas fa-times"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Budget Overview -->
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tổng quan ngân sách</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="text-center">
                                <h4 id="total-amount" class="text-primary">0 VNĐ</h4>
                                <small>Tổng tiền đề xuất</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center">
                                <h4 id="approved-amount" class="text-success">0 VNĐ</h4>
                                <small>Đã phê duyệt</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Trạng thái đề xuất</h3>
                </div>
                <div class="card-body">
                    <canvas id="statusChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Proposes -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Đề xuất gần đây</h3>
                    <div class="card-tools">
                        <a href="{{ route('proposes.index') }}" class="btn btn-sm btn-primary">
                            Xem tất cả
                        </a>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>Mã đề xuất</th>
                                <th>Tiêu đề</th>
                                <th>Người đề xuất</th>
                                <th>Trạng thái</th>
                                <th>Tổng tiền</th>
                                <th>Ngày tạo</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody id="recent-proposes">
                            <!-- Will be loaded via AJAX -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
$(document).ready(function() {
    loadStatistics();
    loadRecentProposes();
});

function loadStatistics() {
    $.ajax({
        url: '{{ route("proposes.statistics") }}',
        method: 'GET',
        success: function(data) {
            $('#total-proposes').text(data.total);
            $('#pending-proposes').text(data.submitted + data.under_review + data.pending_approval);
            $('#approved-proposes').text(data.approved);
            $('#rejected-proposes').text(data.rejected);

            $('#total-amount').text(new Intl.NumberFormat('vi-VN').format(data.total_amount) + ' VNĐ');
            $('#approved-amount').text(new Intl.NumberFormat('vi-VN').format(data.approved_amount) + ' VNĐ');

            // Create status chart
            const ctx = document.getElementById('statusChart').getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Nháp', 'Đã gửi', 'Đang xem xét', 'Chờ phê duyệt', 'Đã phê duyệt', 'Bị từ chối'],
                    datasets: [{
                        data: [
                            data.draft,
                            data.submitted,
                            data.under_review,
                            data.pending_approval,
                            data.approved,
                            data.rejected
                        ],
                        backgroundColor: [
                            '#6c757d',
                            '#17a2b8',
                            '#ffc107',
                            '#007bff',
                            '#28a745',
                            '#dc3545'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        }
    });
}

function loadRecentProposes() {
    $.ajax({
        url: '{{ route("proposes.index") }}?limit=10',
        method: 'GET',
        success: function(response) {
            // This would need to be implemented to return JSON data
            // For now, we'll show a placeholder
            $('#recent-proposes').html('<tr><td colspan="7" class="text-center">Đang tải...</td></tr>');
        }
    });
}
</script>
@endpush

                <!-- Items Section -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Danh sách hàng hóa/dịch vụ</h3>
                        <div class="card-tools">
                            <button type="button" id="add-item" class="btn btn-sm btn-success">
                                <i class="fas fa-plus"></i> Thêm mục
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="items-container">
                            <!-- Items will be added here -->
                        </div>
                        <div class="mt-3">
                            <strong>Tổng tiền: <span id="total-amount">0</span> VNĐ</strong>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Thao tác</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <button type="submit" name="action" value="save_draft" class="btn btn-secondary btn-block">
                                <i class="fas fa-save"></i> Lưu nháp
                            </button>
                        </div>
                        <div class="form-group">
                            <button type="submit" name="action" value="submit" class="btn btn-primary btn-block">
                                <i class="fas fa-paper-plane"></i> Gửi đề xuất
                            </button>
                        </div>
                        <div class="form-group">
                            <a href="{{ route('proposes.index') }}" class="btn btn-outline-secondary btn-block">
                                <i class="fas fa-arrow-left"></i> Quay lại
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Hướng dẫn</h3>
                    </div>
                    <div class="card-body">
                        <small>
                            <ul class="pl-3">
                                <li>Điền đầy đủ thông tin bắt buộc (*)</li>
                                <li>Thêm ít nhất một mục hàng hóa/dịch vụ</li>
                                <li>Mô tả rõ lý do đề xuất</li>
                                <li>Chọn độ ưu tiên phù hợp</li>
                                <li>Đính kèm tài liệu liên quan nếu có</li>
                            </ul>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Item Template -->
<template id="item-template">
    <div class="item-row border p-3 mb-3">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Tên hàng hóa/dịch vụ <span class="text-danger">*</span></label>
                    <input type="text" name="items[INDEX][name]" class="form-control item-name" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Danh mục</label>
                    <select name="items[INDEX][category_id]" class="form-control item-category">
                        <option value="">Chọn danh mục</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label>Mô tả</label>
            <textarea name="items[INDEX][description]" class="form-control item-description" rows="2"></textarea>
        </div>

        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label>Số lượng <span class="text-danger">*</span></label>
                    <input type="number" name="items[INDEX][quantity]" class="form-control item-quantity" step="0.01" min="0.01" required>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Đơn vị <span class="text-danger">*</span></label>
                    <input type="text" name="items[INDEX][unit]" class="form-control item-unit" required>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Đơn giá <span class="text-danger">*</span></label>
                    <input type="number" name="items[INDEX][unit_price]" class="form-control item-price" step="0.01" min="0" required>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Độ ưu tiên</label>
                    <select name="items[INDEX][priority]" class="form-control item-priority" required>
                        <option value="low">Thấp</option>
                        <option value="medium" selected>Trung bình</option>
                        <option value="high">Cao</option>
                        <option value="critical">Quan trọng</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Thương hiệu</label>
                    <input type="text" name="items[INDEX][brand]" class="form-control item-brand">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Model</label>
                    <input type="text" name="items[INDEX][model]" class="form-control item-model">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Cần trước ngày</label>
                    <input type="date" name="items[INDEX][needed_by_date]" class="form-control item-needed-date" min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                </div>
            </div>
        </div>

        <div class="form-group">
            <label>Thông số kỹ thuật</label>
            <textarea name="items[INDEX][specifications]" class="form-control item-specs" rows="2"></textarea>
        </div>

        <div class="form-group">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" name="items[INDEX][is_essential]" class="custom-control-input item-essential" id="essential-INDEX" value="1">
                <label class="custom-control-label" for="essential-INDEX">Bắt buộc có</label>
            </div>
        </div>

        <div class="text-right">
            <button type="button" class="btn btn-sm btn-danger remove-item">
                <i class="fas fa-trash"></i> Xóa
            </button>
        </div>
    </div>
</template>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    let itemIndex = 0;

    // Add item
    $('#add-item').click(function() {
        const template = $('#item-template').html();
        const itemHtml = template.replace(/INDEX/g, itemIndex);
        $('#items-container').append(itemHtml);
        itemIndex++;
        updateTotal();
    });

    // Remove item
    $(document).on('click', '.remove-item', function() {
        $(this).closest('.item-row').remove();
        updateTotal();
    });

    // Update total when quantity or price changes
    $(document).on('input', '.item-quantity, .item-price', function() {
        updateTotal();
    });

    // Add first item on page load
    $('#add-item').click();

    function updateTotal() {
        let total = 0;
        $('.item-row').each(function() {
            const quantity = parseFloat($(this).find('.item-quantity').val()) || 0;
            const price = parseFloat($(this).find('.item-price').val()) || 0;
            total += quantity * price;
        });

        // Add 10% VAT
        total = total * 1.1;

        $('#total-amount').text(new Intl.NumberFormat('vi-VN').format(total));
    }
});
</script>
@endpush

<?php // resources/views/proposes/show.blade.php ?>
@extends('layouts.app')

@section('title', 'Chi tiết đề xuất')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        {{ $propose->title }}
                        @if($propose->is_urgent)
                            <span class="badge badge-danger ml-2">CẤP THIẾT</span>
                        @endif
                    </h3>
                    <div class="card-tools">
                        <span class="badge badge-{{ $propose->status == 'approved' ? 'success' : ($propose->status == 'rejected' ? 'danger' : 'info') }} badge-lg">
                            {{ ucfirst(str_replace('_', ' ', $propose->status)) }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Mã đề xuất:</strong> {{ $propose->propose_code }}<br>
                            <strong>Dự án:</strong> {{ $propose->project->name ?? 'N/A' }}<br>
                            <strong>Bộ phận:</strong> {{ $propose->department->name ?? 'N/A' }}<br>
                            <strong>Người đề xuất:</strong> {{ $propose->proposedBy->name ?? 'N/A' }}
                        </div>
                        <div class="col-md-6">
                            <strong>Loại:</strong> {{ ucfirst($propose->propose_type) }}<br>
                            <strong>Độ ưu tiên:</strong>
                            @php
                                $priorityLabels = [
                                    'low' => 'Thấp',
                                    'medium' => 'Trung bình',
                                    'high' => 'Cao',
                                    'urgent' => 'Khẩn cấp'
                                ];
                            @endphp
                            {{ $priorityLabels[$propose->priority] ?? $propose->priority }}<br>
                            <strong>Nguồn ngân sách:</strong> {{ ucfirst(str_replace('_', ' ', $propose->budget_source)) }}<br>
                            <strong>Ngày tạo:</strong> {{ $propose->created_at->format('d/m/Y H:i') }}
                        </div>
                    </div>

                    <div class="mb-3">
                        <strong>Mô tả:</strong>
                        <p>{{ $propose->description }}</p>
                    </div>

                    <div class="mb-3">
                        <strong>Lý do đề xuất:</strong>
                        <p>{{ $propose->justification }}</p>
                    </div>

                    @if($propose->expected_benefit)
                    <div class="mb-3">
                        <strong>Lợi ích kỳ vọng:</strong>
                        <p>{{ $propose->expected_benefit }}</p>
                    </div>
                    @endif

                    @if($propose->needed_by_date)
                    <div class="mb-3">
                        <strong>Cần trước ngày:</strong> {{ \Carbon\Carbon::parse($propose->needed_by_date)->format('d/m/Y') }}
                    </div>
                    @endif

                    @if($propose->vendor)
                    <div class="mb-3">
                        <strong>Nhà cung cấp đề xuất:</strong> {{ $propose->vendor->name }}
                    </div>
                    @endif

                    @if($propose->attachments && count($propose->attachments) > 0)
                    <div class="mb-3">
                        <strong>Tài liệu đính kèm:</strong>
                        <ul>
                            @foreach($propose->attachments as $index => $attachment)
                            <li>
                                <a href="{{ route('proposes.download-attachment', [$propose, $index]) }}">
                                    {{ $attachment['name'] }} ({{ number_format($attachment['size']/1024, 1) }} KB)
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Items -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Danh sách hàng hóa/dịch vụ</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Tên</th>
                                    <th>Mô tả</th>
                                    <th>SL</th>
                                    <th>Đơn giá</th>
                                    <th>Thành tiền</th>
                                    <th>Độ ưu tiên</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($propose->items as $item)
                                <tr>
                                    <td>
                                        <strong>{{ $item->name }}</strong>
                                        @if($item->brand || $item->model)
                                            <br><small class="text-muted">
                                                {{ $item->brand }} {{ $item->model }}
                                            </small>
                                        @endif
                                        @if($item->is_essential)
                                            <br><span class="badge badge-warning">Bắt buộc</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $item->description }}
                                        @if($item->specifications)
                                            <br><small class="text-muted">{{ $item->specifications }}</small>
                                        @endif
                                    </td>
                                    <td>{{ $item->quantity }} {{ $item->unit }}</td>
                                    <td>{{ number_format($item->unit_price) }} VNĐ</td>
                                    <td>{{ number_format($item->total_amount) }} VNĐ</td>
                                    <td>
                                        @php
                                            $priorityClasses = [
                                                'low' => 'success',
                                                'medium' => 'info',
                                                'high' => 'warning',
                                                'critical' => 'danger'
                                            ];
                                            $priorityLabels = [
                                                'low' => 'Thấp',
                                                'medium' => 'Trung bình',
                                                'high' => 'Cao',
                                                'critical' => 'Quan trọng'
                                            ];
                                        @endphp
                                        <span class="badge badge-{{ $priorityClasses[$item->priority] ?? 'secondary' }}">
                                            {{ $priorityLabels[$item->priority] ?? $item->priority }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="4" class="text-right">Tổng cộng (chưa VAT):</th>
                                    <th>{{ number_format($propose->subtotal_amount) }} VNĐ</th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <th colspan="4" class="text-right">VAT (10%):</th>
                                    <th>{{ number_format($propose->tax_amount) }} VNĐ</th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <th colspan="4" class="text-right">Tổng tiền:</th>
                                    <th>{{ number_format($propose->total_amount) }} VNĐ</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Comments/Reviews -->
            @if($propose->review_comments || $propose->approval_comments)
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Nhận xét</h3>
                </div>
                <div class="card-body">
                    @if($propose->review_comments)
                    <div class="mb-3">
                        <strong>Nhận xét xem xét:</strong>
                        <p>{{ $propose->review_comments }}</p>
                        @if($propose->reviewedBy)
                        <small class="text-muted">
                            Bởi {{ $propose->reviewedBy->name }} - {{ $propose->reviewed_at->format('d/m/Y H:i') }}
                        </small>
                        @endif
                    </div>
                    @endif

                    @if($propose->approval_comments)
                    <div class="mb-3">
                        <strong>Nhận xét phê duyệt:</strong>
                        <p>{{ $propose->approval_comments }}</p>
                        @if($propose->approvedBy)
                        <small class="text-muted">
                            Bởi {{ $propose->approvedBy->name }} - {{ $propose->approved_at->format('d/m/Y H:i') }}
                        </small>
                        @endif
                    </div>
                    @endif

                    @if($propose->approved_amount && $propose->approved_amount != $propose->total_amount)
                    <div class="alert alert-info">
                        <strong>Số tiền được phê duyệt:</strong> {{ number_format($propose->approved_amount) }} VNĐ
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Thao tác</h3>
                </div>
                <div class="card-body">
                    @if($propose->canBeEdited())
                    <div class="mb-2">
                        <a href="{{ route('proposes.edit', $propose) }}" class="btn btn-warning btn-block">
                            <i class="fas fa-edit"></i> Chỉnh sửa
                        </a>
                    </div>
                    @endif

                    @if($propose->status == 'draft')
                    <div class="mb-2">
                        <form action="{{ route('proposes.submit', $propose) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-primary btn-block"
                                    onclick="return confirm('Bạn có chắc muốn gửi đề xuất này?')">
                                <i class="fas fa-paper-plane"></i> Gửi đề xuất
                            </button>
                        </form>
                    </div>
                    @endif

                    @if(in_array($propose->status, ['draft', 'submitted', 'under_review']))
                    <div class="mb-2">
                        <form action="{{ route('proposes.cancel', $propose) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-secondary btn-block"
                                    onclick="return confirm('Bạn có chắc muốn hủy đề xuất này?')">
                                <i class="fas fa-times"></i> Hủy đề xuất
                            </button>
                        </form>
                    </div>
                    @endif

                    @can('review', $propose)
                    @if(in_array($propose->status, ['submitted', 'under_review']))
                    <div class="mb-2">
                        <button type="button" class="btn btn-info btn-block" data-toggle="modal" data-target="#reviewModal">
                            <i class="fas fa-search"></i> Xem xét
                        </button>
                    </div>
                    @endif
                    @endcan

                    @can('approve', $propose)
                    @if($propose->status == 'pending_approval')
                    <div class="mb-2">
                        <button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#approveModal">
                            <i class="fas fa-check"></i> Phê duyệt
                        </button>
                    </div>
                    @endif
                    @endcan

                    <div class="mb-2">
                        <a href="{{ route('proposes.index') }}" class="btn btn-outline-secondary btn-block">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Thông tin bổ sung</h3>
                </div>
                <div class="card-body">
                    <small>
                        <strong>Trạng thái:</strong> {{ ucfirst(str_replace('_', ' ', $propose->status)) }}<br>
                        <strong>Ngày tạo:</strong> {{ $propose->created_at->format('d/m/Y H:i') }}<br>
                        @if($propose->updated_at != $propose->created_at)
                        <strong>Cập nhật cuối:</strong> {{ $propose->updated_at->format('d/m/Y H:i') }}<br>
                        @endif
                        @if($propose->reviewed_at)
                        <strong>Ngày xem xét:</strong> {{ $propose->reviewed_at->format('d/m/Y H:i') }}<br>
                        @endif
                        @if($propose->approved_at)
                        <strong>Ngày phê duyệt:</strong> {{ $propose->approved_at->format('d/m/Y H:i') }}<br>
                        @endif
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Review Modal -->
@can('review', $propose)
<div class="modal fade" id="reviewModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('proposes.review', $propose) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-header">
                    <h4 class="modal-title">Xem xét đề xuất</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Quyết định</label>
                        <select name="action" class="form-control" required>
                            <option value="">Chọn quyết định</option>
                            <option value="approve">Chuyển phê duyệt</option>
                            <option value="request_changes">Yêu cầu sửa đổi</option>
                            <option value="reject">Từ chối</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Nhận xét</label>
                        <textarea name="comments" class="form-control" rows="4"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Xác nhận</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endcan

<!-- Approve Modal -->
@can('approve', $propose)
<div class="modal fade" id="approveModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('proposes.approve', $propose) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-header">
                    <h4 class="modal-title">Phê duyệt đề xuất</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Quyết định</label>
                        <select name="action" class="form-control" required>
                            <option value="">Chọn quyết định</option>
                            <option value="approve">Phê duyệt toàn bộ</option>
                            <option value="partial_approve">Phê duyệt một phần</option>
                            <option value="reject">Từ chối</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Số tiền phê duyệt (VNĐ)</label>
                        <input type="number" name="approved_amount" class="form-control"
                               value="{{ $propose->total_amount }}" min="0">
                        <small class="text-muted">Để trống để phê duyệt toàn bộ số tiền đề xuất</small>
                    </div>
                    <div class="form-group">
                        <label>Nhận xét</label>
                        <textarea name="comments" class="form-control" rows="4"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Xác nhận</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endcan

@endsection

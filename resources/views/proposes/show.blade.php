@extends('layouts.app')

@section('title', 'Chi tiết đề xuất')

@section('content')
<div class="container-fluid">
    {{-- Display Success Message --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    {{-- Display Error Message --}}
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-8">
            {{-- Propose Header Card --}}
            <div class="card mb-3">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">
                            <i class="fas fa-file-alt"></i> {{ $propose->title }}
                        </h3>
                        <div>
                            @php
                                $statusBadgeClass = match($propose->status) {
                                    'draft' => 'bg-secondary',
                                    'submitted' => 'bg-primary',
                                    'under_review' => 'bg-info',
                                    'pending_approval' => 'bg-warning text-dark',
                                    'approved' => 'bg-success',
                                    'partially_approved' => 'bg-warning text-dark',
                                    'rejected' => 'bg-danger',
                                    'cancelled' => 'bg-secondary',
                                    'completed' => 'bg-success',
                                    default => 'bg-secondary'
                                };

                                $priorityBadgeClass = match($propose->priority) {
                                    'low' => 'bg-secondary',
                                    'medium' => 'bg-info',
                                    'high' => 'bg-warning text-dark',
                                    'urgent' => 'bg-danger',
                                    default => 'bg-secondary'
                                };
                            @endphp
                            <span class="badge {{ $statusBadgeClass }} me-2">
                                {{ $propose->getStatusText() }}
                            </span>
                            <span class="badge {{ $priorityBadgeClass }}">
                                {{ ucfirst($propose->priority) }}
                            </span>
                            @if($propose->is_urgent)
                                <span class="badge bg-danger ms-1">
                                    <i class="fas fa-exclamation-triangle"></i> Cấp thiết
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <strong><i class="fas fa-barcode"></i> Mã đề xuất:</strong><br>
                            <span class="badge bg-primary">{{ $propose->propose_code }}</span>
                        </div>
                        <div class="col-md-4">
                            <strong><i class="fas fa-calendar-alt"></i> Ngày tạo:</strong><br>
                            {{ $propose->created_at->format('d/m/Y H:i') }}
                        </div>
                        <div class="col-md-4">
                            <strong><i class="fas fa-user"></i> Người đề xuất:</strong><br>
                            {{ $propose->proposedBy->name ?? 'N/A' }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- Propose Details Card --}}
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle"></i> Thông tin chi tiết
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <strong><i class="fas fa-project-diagram"></i> Dự án:</strong><br>
                                <span class="text-primary">{{ $propose->project->name ?? 'N/A' }}</span>
                            </div>
                            <div class="mb-3">
                                <strong><i class="fas fa-building"></i> Bộ phận:</strong><br>
                                {{ $propose->department->name ?? 'N/A' }}
                            </div>
                            <div class="mb-3">
                                <strong><i class="fas fa-tags"></i> Loại đề xuất:</strong><br>
                                <span class="badge bg-light text-dark">{{ $propose->getProposeTypeText() }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <strong><i class="fas fa-dollar-sign"></i> Nguồn ngân sách:</strong><br>
                                {{ $propose->getBudgetSourceText() }}
                            </div>
                            @if($propose->vendor)
                                <div class="mb-3">
                                    <strong><i class="fas fa-store"></i> Nhà cung cấp đề xuất:</strong><br>
                                    {{ $propose->vendor->name }}
                                </div>
                            @endif
                            @if($propose->needed_by_date)
                                <div class="mb-3">
                                    <strong><i class="fas fa-clock"></i> Cần trước ngày:</strong><br>
                                    <span class="text-danger">{{ $propose->needed_by_date->format('d/m/Y') }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <hr>

                    <div class="mb-3">
                        <strong><i class="fas fa-file-text"></i> Mô tả:</strong><br>
                        <p class="mt-2">{{ $propose->description }}</p>
                    </div>

                    <div class="mb-3">
                        <strong><i class="fas fa-lightbulb"></i> Lý do đề xuất:</strong><br>
                        <p class="mt-2">{{ $propose->justification }}</p>
                    </div>

                    @if($propose->expected_benefit)
                        <div class="mb-3">
                            <strong><i class="fas fa-chart-line"></i> Lợi ích kỳ vọng:</strong><br>
                            <p class="mt-2">{{ $propose->expected_benefit }}</p>
                        </div>
                    @endif

                    @if($propose->expected_delivery_date)
                        <div class="mb-3">
                            <strong><i class="fas fa-truck"></i> Ngày giao hàng dự kiến:</strong><br>
                            {{ $propose->expected_delivery_date->format('d/m/Y') }}
                        </div>
                    @endif
                </div>
            </div>

            {{-- Items Card --}}
            <div class="card mb-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-list"></i> Danh sách hàng hóa/dịch vụ
                        <span class="badge bg-primary">{{ $propose->items->count() }} mục</span>
                    </h5>
                    <div class="text-right">
                        <h6 class="mb-0">
                            Tổng cộng: <span class="text-success font-weight-bold">
                                {{ number_format($propose->total_amount, 0, ',', '.') }} VND
                            </span>
                        </h6>
                        <small class="text-muted">(Đã bao gồm 10% VAT)</small>
                    </div>
                </div>
                <div class="card-body">
                    @if($propose->items->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th width="25%">Tên hàng hóa/dịch vụ</th>
                                        <th width="10%">Số lượng</th>
                                        <th width="10%">Đơn vị</th>
                                        <th width="15%">Đơn giá</th>
                                        <th width="15%">Thành tiền</th>
                                        <th width="10%">Độ ưu tiên</th>
                                        <th width="10%">Trạng thái</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($propose->items as $index => $item)
                                        @php
                                            $itemTotal = $item->quantity * $item->unit_price;
                                            $priorityClass = match($item->priority) {
                                                'critical' => 'bg-danger text-white',
                                                'high' => 'bg-warning',
                                                'medium' => 'bg-info text-white',
                                                'low' => 'bg-secondary text-white',
                                                default => 'bg-secondary text-white'
                                            };
                                        @endphp
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                <strong>{{ $item->name }}</strong>
                                                @if($item->description)
                                                    <br><small class="text-muted">{{ $item->description }}</small>
                                                @endif
                                                @if($item->brand || $item->model)
                                                    <br>
                                                    @if($item->brand)
                                                        <span class="badge bg-light text-dark">{{ $item->brand }}</span>
                                                    @endif
                                                    @if($item->model)
                                                        <span class="badge bg-light text-dark">{{ $item->model }}</span>
                                                    @endif
                                                @endif
                                                @if($item->category)
                                                    <br><small class="text-primary">{{ $item->category->name }}</small>
                                                @endif
                                            </td>
                                            <td>{{ number_format($item->quantity, 2) }}</td>
                                            <td>{{ $item->unit }}</td>
                                            <td>{{ number_format($item->unit_price, 0, ',', '.') }} VND</td>
                                            <td><strong>{{ number_format($itemTotal, 0, ',', '.') }} VND</strong></td>
                                            <td>
                                                <span class="badge {{ $priorityClass }}">
                                                    {{ ucfirst($item->priority) }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($item->is_essential)
                                                    <span class="badge bg-warning text-dark">
                                                        <i class="fas fa-star"></i> Bắt buộc
                                                    </span>
                                                @else
                                                    <span class="badge bg-light text-dark">Tùy chọn</span>
                                                @endif
                                                @if($item->needed_by_date)
                                                    <br><small class="text-muted">
                                                        Cần: {{ $item->needed_by_date->format('d/m/Y') }}
                                                    </small>
                                                @endif
                                            </td>
                                        </tr>
                                        @if($item->specifications)
                                            <tr>
                                                <td></td>
                                                <td colspan="7">
                                                    <small class="text-muted">
                                                        <strong>Thông số kỹ thuật:</strong> {{ $item->specifications }}
                                                    </small>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i> Chưa có mục hàng hóa/dịch vụ nào được thêm.
                        </div>
                    @endif
                </div>
            </div>

            {{-- Attachments Card --}}
            @if($propose->attachments && count($propose->attachments) > 0)
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-paperclip"></i> Tài liệu đính kèm
                            <span class="badge bg-primary">{{ count($propose->attachments) }} file</span>
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($propose->attachments as $index => $attachment)
                                <div class="col-md-6 mb-2">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-file me-2"></i>
                                        <div class="flex-grow-1">
                                            <a href="{{ route('proposes.download-attachment', [$propose, $index]) }}"
                                               class="text-decoration-none" target="_blank">
                                                {{ $attachment['name'] }}
                                            </a>
                                            <br>
                                            <small class="text-muted">
                                                {{ number_format($attachment['size'] / 1024, 1) }} KB
                                            </small>
                                        </div>
                                        <a href="{{ route('proposes.download-attachment', [$propose, $index]) }}"
                                           class="btn btn-sm btn-outline-primary ms-2">
                                            <i class="fas fa-download"></i>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>

        {{-- Sidebar --}}
        <div class="col-md-4">
            {{-- Action Buttons Card --}}
            <div class="card mb-3">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-cogs"></i> Hành động
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        @if($propose->canBeEdited())
                            <a href="{{ route('proposes.edit', $propose) }}" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Chỉnh sửa
                            </a>
                        @endif

                        @if($propose->status === 'draft')
                            <form action="{{ route('proposes.submit', $propose) }}" method="POST"
                                  onsubmit="return confirm('Bạn có chắc chắn muốn gửi đề xuất này?')">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-paper-plane"></i> Gửi đề xuất
                                </button>
                            </form>
                        @endif

                        @if(in_array($propose->status, ['submitted', 'under_review']) && auth()->user()->can('review_proposes'))
                            <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#reviewModal">
                                <i class="fas fa-eye"></i> Xem xét
                            </button>
                        @endif

                        @if($propose->status === 'pending_approval' && auth()->user()->can('approve_proposes'))
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#approveModal">
                                <i class="fas fa-check"></i> Phê duyệt
                            </button>
                        @endif

                        @if(in_array($propose->status, ['draft', 'submitted', 'under_review']))
                            <form action="{{ route('proposes.cancel', $propose) }}" method="POST"
                                  onsubmit="return confirm('Bạn có chắc chắn muốn hủy đề xuất này?')">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-outline-secondary">
                                    <i class="fas fa-times"></i> Hủy đề xuất
                                </button>
                            </form>
                        @endif

                        @if($propose->canBeEdited())
                            <form action="{{ route('proposes.destroy', $propose) }}" method="POST"
                                  onsubmit="return confirm('CẢNH BÁO: Bạn có chắc chắn muốn xóa đề xuất này? Hành động này không thể hoàn tác!')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger">
                                    <i class="fas fa-trash"></i> Xóa đề xuất
                                </button>
                            </form>
                        @endif

                        <a href="{{ route('proposes.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Quay lại danh sách
                        </a>
                    </div>
                </div>
            </div>

            {{-- Status Information Card --}}
            <div class="card mb-3">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-info-circle"></i> Thông tin trạng thái
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <strong>Trạng thái hiện tại:</strong><br>
                        <span class="badge {{ $statusBadgeClass }}">
                            {{ $propose->getStatusText() }}
                        </span>
                    </div>

                    @if($propose->reviewed_by)
                        <div class="mb-2">
                            <strong>Người xem xét:</strong><br>
                            {{ $propose->reviewedBy->name ?? 'N/A' }}
                        </div>
                        @if($propose->reviewed_at)
                            <div class="mb-2">
                                <strong>Thời gian xem xét:</strong><br>
                                {{ $propose->reviewed_at->format('d/m/Y H:i') }}
                            </div>
                        @endif
                        @if($propose->review_comments)
                            <div class="mb-2">
                                <strong>Nhận xét:</strong><br>
                                <small>{{ $propose->review_comments }}</small>
                            </div>
                        @endif
                    @endif

                    @if($propose->approved_by)
                        <div class="mb-2">
                            <strong>Người phê duyệt:</strong><br>
                            {{ $propose->approvedBy->name ?? 'N/A' }}
                        </div>
                        @if($propose->approved_at)
                            <div class="mb-2">
                                <strong>Thời gian phê duyệt:</strong><br>
                                {{ $propose->approved_at->format('d/m/Y H:i') }}
                            </div>
                        @endif
                        @if($propose->approved_amount)
                            <div class="mb-2">
                                <strong>Số tiền được phê duyệt:</strong><br>
                                <span class="text-success font-weight-bold">
                                    {{ number_format($propose->approved_amount, 0, ',', '.') }} VND
                                </span>
                            </div>
                        @endif
                        @if($propose->approval_comments)
                            <div class="mb-2">
                                <strong>Ghi chú phê duyệt:</strong><br>
                                <small>{{ $propose->approval_comments }}</small>
                            </div>
                        @endif
                    @endif

                    <div class="mb-2">
                        <strong>Cập nhật lần cuối:</strong><br>
                        {{ $propose->updated_at->format('d/m/Y H:i') }}
                    </div>
                </div>
            </div>

            {{-- Financial Summary Card --}}
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-calculator"></i> Tóm tắt tài chính
                    </h6>
                </div>
                <div class="card-body">
                    @php
                        $subtotal = $propose->items->sum(function($item) {
                            return $item->quantity * $item->unit_price;
                        });
                        $vat = $subtotal * 0.1;
                        $total = $subtotal + $vat;
                    @endphp

                    <div class="d-flex justify-content-between mb-2">
                        <span>Tạm tính:</span>
                        <span>{{ number_format($subtotal, 0, ',', '.') }} VND</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>VAT (10%):</span>
                        <span>{{ number_format($vat, 0, ',', '.') }} VND</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <strong>Tổng cộng:</strong>
                        <strong class="text-success">{{ number_format($total, 0, ',', '.') }} VND</strong>
                    </div>

                    @if($propose->approved_amount && $propose->approved_amount != $total)
                        <hr>
                        <div class="d-flex justify-content-between">
                            <strong>Được phê duyệt:</strong>
                            <strong class="text-primary">{{ number_format($propose->approved_amount, 0, ',', '.') }} VND</strong>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Review Modal --}}
@if(auth()->user()->can('review_proposes'))
<div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('proposes.review', $propose) }}" method="POST">
            @csrf
            @method('PATCH')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reviewModalLabel">Xem xét đề xuất</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="action" class="form-label">Hành động <span class="text-danger">*</span></label>
                        <select name="action" id="action" class="form-select" required>
                            <option value="">Chọn hành động</option>
                            <option value="approve">Chuyển đến phê duyệt</option>
                            <option value="request_changes">Yêu cầu chỉnh sửa</option>
                            <option value="reject">Từ chối</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="comments" class="form-label">Nhận xét</label>
                        <textarea name="comments" id="comments" class="form-control" rows="4"
                                  placeholder="Nhập nhận xét của bạn..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Xác nhận</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endif

{{-- Approve Modal --}}
@if(auth()->user()->can('approve_proposes'))
<div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('proposes.approve', $propose) }}" method="POST">
            @csrf
            @method('PATCH')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="approveModalLabel">Phê duyệt đề xuất</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="approve_action" class="form-label">Hành động <span class="text-danger">*</span></label>
                        <select name="action" id="approve_action" class="form-select" required>
                            <option value="">Chọn hành động</option>
                            <option value="approve">Phê duyệt toàn bộ</option>
                            <option value="partial_approve">Phê duyệt một phần</option>
                            <option value="reject">Từ chối</option>
                        </select>
                    </div>
                    <div class="mb-3" id="approved_amount_field" style="display: none;">
                        <label for="approved_amount" class="form-label">Số tiền được phê duyệt (VND)</label>
                        <input type="number" name="approved_amount" id="approved_amount" class="form-control"
                               step="1000" min="0" max="{{ $propose->total_amount }}"
                               value="{{ $propose->total_amount }}">
                    </div>
                    <div class="mb-3">
                        <label for="approval_comments" class="form-label">Ghi chú</label>
                        <textarea name="comments" id="approval_comments" class="form-control" rows="4"
                                  placeholder="Nhập ghi chú phê duyệt..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-success">Xác nhận</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endif

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Show/hide approved amount field based on action
    $('#approve_action').on('change', function() {
        if ($(this).val() === 'partial_approve') {
            $('#approved_amount_field').show();
            $('#approved_amount').prop('required', true);
        } else {
            $('#approved_amount_field').hide();
            $('#approved_amount').prop('required', false);
            if ($(this).val() === 'approve') {
                $('#approved_amount').val({{ $propose->total_amount }});
            }
        }
    });

    // Auto-dismiss alerts after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);

    // Confirmation for actions
    $('form[onsubmit*="confirm"]').on('submit', function(e) {
        const form = this;
        e.preventDefault();

        const confirmMessage = form.getAttribute('onsubmit').match(/'([^']*)'/)[1];

        if (confirm(confirmMessage)) {
            form.onsubmit = null;
            form.submit();
        }
    });
});
</script>
@endpush

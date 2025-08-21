@extends('layouts.app')

@section('title', 'Chi tiết báo cáo')

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h2 class="mb-2">{{ $reportManager->title }}</h2>
                    <div class="d-flex align-items-center flex-wrap gap-2">
                        <span class="badge bg-{{ $reportManager->status_color }} fs-6">
                            {{ $reportManager->status_label }}
                        </span>
                        <span class="badge bg-{{ $reportManager->priority_color }} fs-6">
                            @switch($reportManager->priority)
                                @case('low') Ưu tiên thấp @break
                                @case('medium') Ưu tiên trung bình @break
                                @case('high') Ưu tiên cao @break
                                @case('urgent') Khẩn cấp @break
                            @endswitch
                        </span>
                        <span class="badge bg-info fs-6">{{ $reportManager->report_type_label }}</span>

                        @if($reportManager->isOverdue())
                        <span class="badge bg-warning fs-6">
                            <i class="fas fa-exclamation-triangle"></i> Quá hạn
                        </span>
                        @endif
                    </div>
                </div>

                <div class="btn-group">
                    <a href="{{ route('reportManagers.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Quay lại danh sách
                    </a>

                    @if($reportManager->reporter_id == auth()->id() && $reportManager->canBeEdited())
                    <a href="{{ route('reportManagers.edit', $reportManager) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Chỉnh sửa
                    </a>
                    @endif

                    @if($reportManager->reporter_id == auth()->id() && $reportManager->status == 'draft')
                    <button type="button" class="btn btn-outline-danger" onclick="deleteReport()">
                        <i class="fas fa-trash"></i> Xóa
                    </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Report Information Card -->
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle text-primary me-2"></i>
                        Thông tin báo cáo
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-lg-6">
                            <div class="info-item">
                                <label class="fw-bold text-muted">Phòng ban:</label>
                                <span class="ms-2">
                                    <i class="fas fa-building text-primary me-1"></i>
                                    {{ $reportManager->department->name ?? 'N/A' }}
                                </span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="info-item">
                                <label class="fw-bold text-muted">Người gửi:</label>
                                <span class="ms-2">
                                    <i class="fas fa-user text-success me-1"></i>
                                    {{ $reportManager->reporter->name ?? 'N/A' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-lg-6">
                            <div class="info-item">
                                <label class="fw-bold text-muted">Người nhận:</label>
                                <span class="ms-2">
                                    <i class="fas fa-user-tie text-info me-1"></i>
                                    {{ $reportManager->recipient->name ?? 'N/A' }}
                                </span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="info-item">
                                <label class="fw-bold text-muted">Ngày tạo:</label>
                                <span class="ms-2">
                                    <i class="fas fa-calendar text-warning me-1"></i>
                                    {{ $reportManager->created_at->format('d/m/Y H:i') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    @if($reportManager->submitted_at)
                    <div class="row mb-3">
                        <div class="col-lg-6">
                            <div class="info-item">
                                <label class="fw-bold text-muted">Ngày gửi:</label>
                                <span class="ms-2">
                                    <i class="fas fa-paper-plane text-primary me-1"></i>
                                    {{ $reportManager->submitted_at->format('d/m/Y H:i') }}
                                </span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="info-item">
                                <label class="fw-bold text-muted">Thời gian:</label>
                                <span class="ms-2 text-muted">
                                    {{ $reportManager->time_since_submitted }}
                                </span>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($reportManager->reviewed_at)
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="info-item">
                                <label class="fw-bold text-muted">Ngày xem:</label>
                                <span class="ms-2">
                                    <i class="fas fa-eye text-success me-1"></i>
                                    {{ $reportManager->reviewed_at->format('d/m/Y H:i') }}
                                </span>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Period Information -->
            @if($reportManager->report_period_start || $reportManager->report_period_end)
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-calendar-alt text-info me-2"></i>
                        Kỳ báo cáo
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @if($reportManager->report_period_start)
                        <div class="col-md-6">
                            <div class="d-flex align-items-center p-3 bg-light rounded">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-play-circle fa-2x text-success"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-0">Bắt đầu</h6>
                                    <p class="mb-0 text-muted">{{ $reportManager->report_period_start->format('d/m/Y') }}</p>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if($reportManager->report_period_end)
                        <div class="col-md-6">
                            <div class="d-flex align-items-center p-3 bg-light rounded">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-stop-circle fa-2x text-danger"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-0">Kết thúc</h6>
                                    <p class="mb-0 text-muted">{{ $reportManager->report_period_end->format('d/m/Y') }}</p>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>

                    @if($reportManager->report_period_start && $reportManager->report_period_end)
                    <div class="mt-3 text-center">
                        <span class="badge bg-secondary fs-6">
                            Thời gian: {{ $reportManager->report_period_start->diffInDays($reportManager->report_period_end) + 1 }} ngày
                        </span>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Report Content -->
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-file-alt text-primary me-2"></i>
                        Nội dung báo cáo
                    </h5>
                </div>
                <div class="card-body">
                    <div class="report-content p-4 bg-light rounded border-start border-primary border-4">
                        {!! nl2br(e($reportManager->content)) !!}
                    </div>
                </div>
            </div>

            <!-- Attachments -->
            @if($reportManager->attachments && count($reportManager->attachments) > 0)
            <div class="card mb-4">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-paperclip text-success me-2"></i>
                        File đính kèm
                    </h5>
                    <span class="badge bg-success">{{ count($reportManager->attachments) }} file(s)</span>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @foreach($reportManager->attachments as $index => $attachment)
                        <div class="list-group-item d-flex justify-content-between align-items-center"
                             id="attachment-{{ $index }}">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    @php
                                        $extension = pathinfo($attachment['name'], PATHINFO_EXTENSION);
                                        $iconClass = match(strtolower($extension)) {
                                            'pdf' => 'fas fa-file-pdf text-danger',
                                            'doc', 'docx' => 'fas fa-file-word text-primary',
                                            'xls', 'xlsx' => 'fas fa-file-excel text-success',
                                            'jpg', 'jpeg', 'png', 'gif' => 'fas fa-file-image text-info',
                                            default => 'fas fa-file text-secondary'
                                        };
                                    @endphp
                                    <i class="{{ $iconClass }} fa-2x"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">{{ $attachment['name'] }}</h6>
                                    <small class="text-muted">
                                        <i class="fas fa-hdd me-1"></i>
                                        {{ round($attachment['size'] / 1024 / 1024, 2) }} MB
                                        <span class="mx-2">•</span>
                                        <i class="fas fa-file-code me-1"></i>
                                        {{ strtoupper($extension) }}
                                    </small>
                                </div>
                            </div>
                            <div class="btn-group">
                                <a href="{{ route('reportManagers.downloadAttachment', [$reportManager, $index]) }}"
                                   class="btn btn-sm btn-outline-primary" title="Tải về">
                                    <i class="fas fa-download"></i> Tải về
                                </a>

                                @if($reportManager->reporter_id == auth()->id() && $reportManager->canBeEdited())
                                <button type="button" class="btn btn-sm btn-outline-danger"
                                        onclick="removeAttachment({{ $index }})" title="Xóa file">
                                    <i class="fas fa-trash"></i>
                                </button>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Feedback Section -->
            @if($reportManager->feedback)
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-comments text-info me-2"></i>
                        Phản hồi từ cấp trên
                    </h5>
                </div>
                <div class="card-body">
                    <div class="feedback-container">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <div class="avatar-circle bg-info text-white d-flex align-items-center justify-content-center">
                                    <i class="fas fa-user"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="feedback-header mb-2">
                                    <h6 class="mb-0">{{ $reportManager->recipient->name }}</h6>
                                    <small class="text-muted">
                                        <i class="fas fa-clock me-1"></i>
                                        {{ $reportManager->reviewed_at->format('d/m/Y H:i') }}
                                    </small>
                                </div>
                                <div class="feedback-content p-3 bg-light rounded border-start border-info border-3">
                                    {{ $reportManager->feedback }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Quick Actions -->
            @if($reportManager->reporter_id == auth()->id() && $reportManager->canBeSubmitted())
            <div class="card mb-4 border-primary">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-rocket me-2"></i>
                        Hành động nhanh
                    </h6>
                </div>
                <div class="card-body text-center">
                    <i class="fas fa-paper-plane fa-3x text-primary mb-3"></i>
                    <p class="text-muted mb-3">Báo cáo này đang ở trạng thái nháp. Gửi báo cáo để cấp trên xem xét.</p>
                    <form method="POST" action="{{ route('reportManagers.update', $reportManager) }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="title" value="{{ $reportManager->title }}">
                        <input type="hidden" name="content" value="{{ $reportManager->content }}">
                        <input type="hidden" name="report_type" value="{{ $reportManager->report_type }}">
                        <input type="hidden" name="recipient_id" value="{{ $reportManager->recipient_id }}">
                        <input type="hidden" name="priority" value="{{ $reportManager->priority }}">
                        <button type="submit" name="submit" class="btn btn-primary btn-lg w-100">
                            <i class="fas fa-paper-plane me-2"></i>
                            Gửi báo cáo ngay
                        </button>
                    </form>
                </div>
            </div>
            @endif

            <!-- Director Actions -->
            @if(auth()->user()->hasRole('Giám đốc') && auth()->id() == $reportManager->recipient_id && in_array($reportManager->status, ['submitted', 'reviewed']))
            <div class="card mb-4 border-warning">
                <div class="card-header bg-warning text-dark">
                    <h6 class="mb-0">
                        <i class="fas fa-gavel me-2"></i>
                        Quyết định của bạn
                    </h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('reportManagers.approve', $reportManager) }}"
                          id="approve-form" class="mb-3">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Phản hồi (tùy chọn)</label>
                            <textarea name="feedback" class="form-control" rows="3"
                                      placeholder="Nhập phản hồi cho báo cáo này..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-success w-100 mb-2">
                            <i class="fas fa-check me-2"></i>
                            Phê duyệt báo cáo
                        </button>
                    </form>

                    <button type="button" class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#rejectModal">
                        <i class="fas fa-times me-2"></i>
                        Từ chối báo cáo
                    </button>
                </div>
            </div>
            @endif

            <!-- Status Timeline -->
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h6 class="mb-0">
                        <i class="fas fa-history text-secondary me-2"></i>
                        Lịch sử trạng thái
                    </h6>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <!-- Created -->
                        <div class="timeline-item">
                            <div class="timeline-marker bg-secondary"></div>
                            <div class="timeline-content">
                                <h6 class="timeline-title">Tạo báo cáo</h6>
                                <p class="timeline-text text-muted">
                                    {{ $reportManager->created_at->format('d/m/Y H:i') }}
                                </p>
                            </div>
                        </div>

                        <!-- Submitted -->
                        @if($reportManager->submitted_at)
                        <div class="timeline-item">
                            <div class="timeline-marker bg-primary"></div>
                            <div class="timeline-content">
                                <h6 class="timeline-title">Gửi báo cáo</h6>
                                <p class="timeline-text text-muted">
                                    {{ $reportManager->submitted_at->format('d/m/Y H:i') }}
                                </p>
                            </div>
                        </div>
                        @endif

                        <!-- Reviewed -->
                        @if($reportManager->reviewed_at)
                        <div class="timeline-item">
                            <div class="timeline-marker bg-info"></div>
                            <div class="timeline-content">
                                <h6 class="timeline-title">Đã xem</h6>
                                <p class="timeline-text text-muted">
                                    {{ $reportManager->reviewed_at->format('d/m/Y H:i') }}
                                </p>
                            </div>
                        </div>
                        @endif

                        <!-- Final Status -->
                        @if(in_array($reportManager->status, ['approved', 'rejected']))
                        <div class="timeline-item">
                            <div class="timeline-marker bg-{{ $reportManager->status == 'approved' ? 'success' : 'danger' }}"></div>
                            <div class="timeline-content">
                                <h6 class="timeline-title">
                                    {{ $reportManager->status == 'approved' ? 'Đã phê duyệt' : 'Bị từ chối' }}
                                </h6>
                                <p class="timeline-text text-muted">
                                    {{ $reportManager->reviewed_at->format('d/m/Y H:i') }}
                                </p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Report Statistics -->
            <div class="card">
                <div class="card-header bg-light">
                    <h6 class="mb-0">
                        <i class="fas fa-chart-bar text-info me-2"></i>
                        Thông tin thêm
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Số từ trong báo cáo:</span>
                        <span class="fw-bold">{{ str_word_count($reportManager->content) }}</span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Số ký tự:</span>
                        <span class="fw-bold">{{ strlen($reportManager->content) }}</span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">File đính kèm:</span>
                        <span class="fw-bold">{{ $reportManager->attachments ? count($reportManager->attachments) : 0 }}</span>
                    </div>

                    @if($reportManager->isOverdue())
                    <div class="alert alert-warning py-2">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <small>Báo cáo này đã quá hạn xử lý</small>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" action="{{ route('reportManagers.reject', $reportManager) }}">
                @csrf
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-times me-2"></i>
                        Từ chối báo cáo
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Cảnh báo:</strong> Bạn có chắc chắn muốn từ chối báo cáo "<strong>{{ $reportManager->title }}</strong>" không?
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Lý do từ chối <span class="text-danger">*</span>
                        </label>
                        <textarea name="feedback" class="form-control" rows="5" required
                                  placeholder="Vui lòng nhập lý do từ chối báo cáo. Điều này sẽ giúp người gửi hiểu và cải thiện báo cáo..."></textarea>
                        <div class="form-text">Lý do từ chối sẽ được gửi cho người tạo báo cáo.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-arrow-left me-2"></i>
                        Hủy bỏ
                    </button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-times me-2"></i>
                        Xác nhận từ chối
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="fas fa-trash me-2"></i>
                    Xóa báo cáo
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Cảnh báo:</strong> Hành động này không thể hoàn tác!
                </div>
                <p>Bạn có chắc chắn muốn xóa báo cáo "<strong>{{ $reportManager->title }}</strong>" không?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy bỏ</button>
                <form method="POST" action="{{ route('reportManagers.destroy', $reportManager) }}" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-2"></i>
                        Xác nhận xóa
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.info-item {
    margin-bottom: 0.5rem;
}

.report-content {
    line-height: 1.8;
    font-size: 1.1rem;
}

.avatar-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
}

.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline-item {
    position: relative;
    padding-bottom: 20px;
}

.timeline-item:not(:last-child)::before {
    content: '';
    position: absolute;
    left: -22px;
    top: 30px;
    width: 2px;
    height: calc(100% - 10px);
    background-color: #e9ecef;
}

.timeline-marker {
    position: absolute;
    left: -30px;
    top: 8px;
    width: 16px;
    height: 16px;
    border-radius: 50%;
    border: 2px solid #fff;
    box-shadow: 0 0 0 2px #e9ecef;
}

.timeline-content {
    padding-left: 10px;
}

.timeline-title {
    font-size: 0.9rem;
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.timeline-text {
    font-size: 0.8rem;
    margin-bottom: 0;
}

.feedback-container {
    max-height: 300px;
    overflow-y: auto;
}

.feedback-content {
    white-space: pre-wrap;
    word-wrap: break-word;
}
</style>
@endpush

@push('scripts')
<script>
function removeAttachment(index) {
    if (!confirm('Bạn có chắc muốn xóa file đính kèm này?')) {
        return;
    }

    fetch(`{{ route('reportManagers.removeAttachment', [$reportManager, '']) }}/${index}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById(`attachment-${index}`).remove();
            // Show success message
            showAlert('success', 'File đã được xóa thành công!');
        } else {
            showAlert('error', data.error || 'Có lỗi xảy ra khi xóa file.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('error', 'Có lỗi xảy ra khi xóa file.');
    });
}

function deleteReport() {
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}

// Auto-submit approve form with confirmation
document.getElementById('approve-form')?.addEventListener('submit', function(e) {
    if (!confirm('Bạn có chắc chắn muốn phê duyệt báo cáo này?')) {
        e.preventDefault();
    }
});

function showAlert(type, message) {
    const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
    const alertHtml = `
        <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
            <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;

    // Insert at the top of the container
    document.querySelector('.container-fluid').insertAdjacentHTML('afterbegin', alertHtml);

    // Auto dismiss after 5 seconds
    setTimeout(() => {
        const alert = document.querySelector('.alert');
        if (alert) {
            alert.remove();
        }
    }, 5000);
}
</script>

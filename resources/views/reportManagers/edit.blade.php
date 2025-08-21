@extends('layouts.app')

@section('title', 'Chỉnh sửa báo cáo')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title mb-0">Chỉnh sửa báo cáo</h4>
                            <small class="text-muted">Cập nhật thông tin báo cáo</small>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('reportManagers.show', $reportManager) }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left"></i> Quay lại
                            </a>
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('reportManagers.update', $reportManager) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row">
                            <!-- Left Column -->
                            <div class="col-lg-8">
                                <!-- Basic Information -->
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h6 class="mb-0">Thông tin cơ bản</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="form-label">Tiêu đề báo cáo <span class="text-danger">*</span></label>
                                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                                   value="{{ old('title', $reportManager->title) }}" required>
                                            @error('title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Nội dung báo cáo <span class="text-danger">*</span></label>
                                            <textarea name="content" rows="10"
                                                      class="form-control @error('content') is-invalid @enderror"
                                                      placeholder="Nhập nội dung chi tiết báo cáo..." required>{{ old('content', $reportManager->content) }}</textarea>
                                            @error('content')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Period Information -->
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h6 class="mb-0">Kỳ báo cáo</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="form-label">Từ ngày</label>
                                                <input type="date" name="report_period_start"
                                                       class="form-control @error('report_period_start') is-invalid @enderror"
                                                       value="{{ old('report_period_start', $reportManager->report_period_start?->format('Y-m-d')) }}">
                                                @error('report_period_start')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Đến ngày</label>
                                                <input type="date" name="report_period_end"
                                                       class="form-control @error('report_period_end') is-invalid @enderror"
                                                       value="{{ old('report_period_end', $reportManager->report_period_end?->format('Y-m-d')) }}">
                                                @error('report_period_end')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Existing Attachments -->
                                @if($reportManager->attachments && count($reportManager->attachments) > 0)
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h6 class="mb-0">File đính kèm hiện tại</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="list-group">
                                            @foreach($reportManager->attachments as $index => $attachment)
                                            <div class="list-group-item d-flex justify-content-between align-items-center" id="attachment-{{ $index }}">
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-file me-3 text-primary"></i>
                                                    <div>
                                                        <h6 class="mb-0">{{ $attachment['name'] }}</h6>
                                                        <small class="text-muted">
                                                            {{ round($attachment['size'] / 1024 / 1024, 2) }} MB
                                                        </small>
                                                    </div>
                                                </div>
                                                <div>
                                                    <a href="{{ route('reportManagers.downloadAttachment', [$reportManager, $index]) }}"
                                                       class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-outline-danger ms-1"
                                                            onclick="removeAttachment({{ $index }})">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                @endif

                                <!-- New Attachments -->
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h6 class="mb-0">Thêm file đính kèm mới</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <input type="file" name="attachments[]" multiple
                                                   class="form-control @error('attachments.*') is-invalid @enderror"
                                                   accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png">
                                            @error('attachments.*')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text">
                                                Chọn file đính kèm mới (PDF, Word, Excel, hình ảnh). Tối đa 10MB mỗi file.
                                            </div>
                                        </div>

                                        <div id="new-attachment-preview" class="mt-3"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="col-lg-4">
                                <!-- Report Settings -->
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h6 class="mb-0">Cấu hình báo cáo</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="form-label">Loại báo cáo <span class="text-danger">*</span></label>
                                            <select name="report_type" class="form-select @error('report_type') is-invalid @enderror" required>
                                                <option value="">-- Chọn loại báo cáo --</option>
                                                <option value="monthly" {{ old('report_type', $reportManager->report_type) == 'monthly' ? 'selected' : '' }}>Báo cáo tháng</option>
                                                <option value="quarterly" {{ old('report_type', $reportManager->report_type) == 'quarterly' ? 'selected' : '' }}>Báo cáo quý</option>
                                                <option value="yearly" {{ old('report_type', $reportManager->report_type) == 'yearly' ? 'selected' : '' }}>Báo cáo năm</option>
                                                <option value="project_completion" {{ old('report_type', $reportManager->report_type) == 'project_completion' ? 'selected' : '' }}>Báo cáo hoàn thành dự án</option>
                                                <option value="urgent" {{ old('report_type', $reportManager->report_type) == 'urgent' ? 'selected' : '' }}>Báo cáo khẩn cấp</option>
                                                <option value="other" {{ old('report_type', $reportManager->report_type) == 'other' ? 'selected' : '' }}>Báo cáo khác</option>
                                            </select>
                                            @error('report_type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Mức độ ưu tiên <span class="text-danger">*</span></label>
                                            <select name="priority" class="form-select @error('priority') is-invalid @enderror" required>
                                                <option value="">-- Chọn mức độ --</option>
                                                <option value="low" {{ old('priority', $reportManager->priority) == 'low' ? 'selected' : '' }}>Thấp</option>
                                                <option value="medium" {{ old('priority', $reportManager->priority) == 'medium' ? 'selected' : '' }}>Trung bình</option>
                                                <option value="high" {{ old('priority', $reportManager->priority) == 'high' ? 'selected' : '' }}>Cao</option>
                                                <option value="urgent" {{ old('priority', $reportManager->priority) == 'urgent' ? 'selected' : '' }}>Khẩn cấp</option>
                                            </select>
                                            @error('priority')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Người nhận báo cáo <span class="text-danger">*</span></label>
                                            <select name="recipient_id" class="form-select @error('recipient_id') is-invalid @enderror" required>
                                                <option value="">-- Chọn người nhận --</option>
                                                @foreach($directors as $director)
                                                <option value="{{ $director->id }}"
                                                        {{ old('recipient_id', $reportManager->recipient_id) == $director->id ? 'selected' : '' }}>
                                                    {{ $director->name }} - {{ $director->email }}
                                                </option>
                                                @endforeach
                                            </select>
                                            @error('recipient_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Current Status -->
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h6 class="mb-0">Trạng thái hiện tại</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="text-center mb-3">
                                            <span class="badge bg-{{ $reportManager->status_color }} fs-6">
                                                {{ $reportManager->status_label }}
                                            </span>
                                        </div>

                                        <div class="small text-muted">
                                            <div class="mb-2">
                                                <i class="fas fa-calendar me-2"></i>
                                                Tạo: {{ $reportManager->created_at->format('d/m/Y H:i') }}
                                            </div>

                                            @if($reportManager->submitted_at)
                                            <div class="mb-2">
                                                <i class="fas fa-paper-plane me-2"></i>
                                                Gửi: {{ $reportManager->submitted_at->format('d/m/Y H:i') }}
                                            </div>
                                            @endif

                                            <div class="mb-2">
                                                <i class="fas fa-edit me-2"></i>
                                                Sửa: {{ $reportManager->updated_at->format('d/m/Y H:i') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Department Info -->
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h6 class="mb-0">Thông tin</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="flex-shrink-0">
                                                <i class="fas fa-building fa-2x text-primary"></i>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-0">{{ $reportManager->department->name ?? 'N/A' }}</h6>
                                                <small class="text-muted">Phòng ban</small>
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <i class="fas fa-user fa-2x text-success"></i>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-0">{{ auth()->user()->name }}</h6>
                                                <small class="text-muted">Người tạo</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="row">
                            <div class="col">
                                <div class="form-text">
                                    <i class="fas fa-info-circle"></i>
                                    Lưu ý: Chỉ có thể chỉnh sửa báo cáo khi còn ở trạng thái bản nháp.
                                </div>
                            </div>
                            <div class="col-auto">
                                <button type="submit" name="save" class="btn btn-outline-primary me-2">
                                    <i class="fas fa-save"></i> Lưu thay đổi
                                </button>
                                <button type="submit" name="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane"></i> Lưu & Gửi báo cáo
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // New file preview
    const fileInput = document.querySelector('input[name="attachments[]"]');
    const previewContainer = document.getElementById('new-attachment-preview');

    fileInput.addEventListener('change', function() {
        previewContainer.innerHTML = '';

        if (this.files.length > 0) {
            const fileList = document.createElement('div');
            fileList.className = 'list-group list-group-flush';

            Array.from(this.files).forEach((file, index) => {
                const fileItem = document.createElement('div');
                fileItem.className = 'list-group-item d-flex justify-content-between align-items-center';

                const fileInfo = document.createElement('div');
                fileInfo.innerHTML = `
                    <i class="fas fa-file-plus me-2 text-success"></i>
                    <span>${file.name}</span>
                    <small class="text-muted ms-2">(${(file.size / 1024 / 1024).toFixed(2)} MB)</small>
                `;

                fileItem.appendChild(fileInfo);
                fileList.appendChild(fileItem);
            });

            previewContainer.appendChild(fileList);
        }
    });
});

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
        } else {
            alert(data.error || 'Có lỗi xảy ra khi xóa file.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Có lỗi xảy ra khi xóa file.');
    });
}
</script>
@endpush

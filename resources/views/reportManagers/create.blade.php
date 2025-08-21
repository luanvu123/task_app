@extends('layouts.app')

@section('title', 'Tạo báo cáo mới')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title mb-0">Tạo báo cáo mới</h4>
                            <small class="text-muted">Tạo báo cáo gửi lên cấp trên</small>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('reportManagers.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left"></i> Quay lại
                            </a>
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('reportManagers.store') }}" enctype="multipart/form-data">
                    @csrf
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
                                                   value="{{ old('title') }}" required>
                                            @error('title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Nội dung báo cáo <span class="text-danger">*</span></label>
                                            <textarea name="content" rows="10"
                                                      class="form-control @error('content') is-invalid @enderror"
                                                      placeholder="Nhập nội dung chi tiết báo cáo..." required>{{ old('content') }}</textarea>
                                            @error('content')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text">Mô tả chi tiết về kết quả công việc, tình hình thực hiện, khó khăn và đề xuất.</div>
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
                                                       value="{{ old('report_period_start') }}">
                                                @error('report_period_start')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Đến ngày</label>
                                                <input type="date" name="report_period_end"
                                                       class="form-control @error('report_period_end') is-invalid @enderror"
                                                       value="{{ old('report_period_end') }}">
                                                @error('report_period_end')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Attachments -->
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h6 class="mb-0">File đính kèm</h6>
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
                                                Chọn file đính kèm (PDF, Word, Excel, hình ảnh). Tối đa 10MB mỗi file.
                                            </div>
                                        </div>

                                        <div id="attachment-preview" class="mt-3"></div>
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
                                                <option value="monthly" {{ old('report_type') == 'monthly' ? 'selected' : '' }}>Báo cáo tháng</option>
                                                <option value="quarterly" {{ old('report_type') == 'quarterly' ? 'selected' : '' }}>Báo cáo quý</option>
                                                <option value="yearly" {{ old('report_type') == 'yearly' ? 'selected' : '' }}>Báo cáo năm</option>
                                                <option value="project_completion" {{ old('report_type') == 'project_completion' ? 'selected' : '' }}>Báo cáo hoàn thành dự án</option>
                                                <option value="urgent" {{ old('report_type') == 'urgent' ? 'selected' : '' }}>Báo cáo khẩn cấp</option>
                                                <option value="other" {{ old('report_type') == 'other' ? 'selected' : '' }}>Báo cáo khác</option>
                                            </select>
                                            @error('report_type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Mức độ ưu tiên <span class="text-danger">*</span></label>
                                            <select name="priority" class="form-select @error('priority') is-invalid @enderror" required>
                                                <option value="">-- Chọn mức độ --</option>
                                                <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Thấp</option>
                                                <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>Trung bình</option>
                                                <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>Cao</option>
                                                <option value="urgent" {{ old('priority') == 'urgent' ? 'selected' : '' }}>Khẩn cấp</option>
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
                                                <option value="{{ $director->id }}" {{ old('recipient_id') == $director->id ? 'selected' : '' }}>
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

                                <!-- Department Info -->
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h6 class="mb-0">Thông tin phòng ban</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <i class="fas fa-building fa-2x text-primary"></i>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-0">{{ auth()->user()->department->name ?? 'N/A' }}</h6>
                                                <small class="text-muted">Phòng ban của bạn</small>
                                            </div>
                                        </div>

                                        <hr>

                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <i class="fas fa-user fa-2x text-success"></i>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-0">{{ auth()->user()->name }}</h6>
                                                <small class="text-muted">Người tạo báo cáo</small>
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
                                    Sau khi tạo, bạn có thể lưu nháp hoặc gửi trực tiếp báo cáo.
                                </div>
                            </div>
                            <div class="col-auto">
                                <button type="submit" name="save" class="btn btn-outline-primary me-2">
                                    <i class="fas fa-save"></i> Lưu nháp
                                </button>
                                <button type="submit" name="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane"></i> Gửi báo cáo
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
    // File preview
    const fileInput = document.querySelector('input[name="attachments[]"]');
    const previewContainer = document.getElementById('attachment-preview');

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
                    <i class="fas fa-file me-2"></i>
                    <span>${file.name}</span>
                    <small class="text-muted ms-2">(${(file.size / 1024 / 1024).toFixed(2)} MB)</small>
                `;

                fileItem.appendChild(fileInfo);
                fileList.appendChild(fileItem);
            });

            previewContainer.appendChild(fileList);
        }
    });

    // Auto-set period dates based on report type
    const reportTypeSelect = document.querySelector('select[name="report_type"]');
    const periodStartInput = document.querySelector('input[name="report_period_start"]');
    const periodEndInput = document.querySelector('input[name="report_period_end"]');

    reportTypeSelect.addEventListener('change', function() {
        const now = new Date();
        let startDate, endDate;

        switch(this.value) {
            case 'monthly':
                startDate = new Date(now.getFullYear(), now.getMonth(), 1);
                endDate = new Date(now.getFullYear(), now.getMonth() + 1, 0);
                break;
            case 'quarterly':
                const quarter = Math.floor(now.getMonth() / 3);
                startDate = new Date(now.getFullYear(), quarter * 3, 1);
                endDate = new Date(now.getFullYear(), quarter * 3 + 3, 0);
                break;
            case 'yearly':
                startDate = new Date(now.getFullYear(), 0, 1);
                endDate = new Date(now.getFullYear(), 11, 31);
                break;
            default:
                return;
        }

        periodStartInput.value = startDate.toISOString().split('T')[0];
        periodEndInput.value = endDate.toISOString().split('T')[0];
    });
});
</script>
@endpush

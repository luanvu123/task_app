@extends('layouts.app')

@section('title', 'Chỉnh Sửa Công Việc')

@section('content')
   @php
        use App\Models\Task;
    @endphp
<div class="container-fluid px-4">
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<style>
    .form-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 15px;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .form-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 100%;
        height: 200%;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Ccircle cx='30' cy='30' r='4'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        opacity: 0.3;
    }

    .form-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 25px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        background: white;
    }

    .form-card:hover {
        box-shadow: 0 8px 30px rgba(0,0,0,0.12);
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 0.5rem;
        text-transform: uppercase;
        font-size: 0.875rem;
        letter-spacing: 0.5px;
    }

    .form-control, .form-select {
        border: 2px solid #e9ecef;
        border-radius: 8px;
        padding: 12px 16px;
        font-size: 14px;
        transition: all 0.3s ease;
        background-color: #fafbfc;
    }

    .form-control:focus, .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        background-color: white;
    }

    .btn-custom {
        padding: 12px 30px;
        border-radius: 8px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
        border: none;
    }

    .btn-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.2);
    }

    .btn-primary-custom {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .btn-success-custom {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        color: white;
    }

    .btn-secondary-custom {
        background: linear-gradient(135deg, #bdc3c7 0%, #95a5a6 100%);
        color: white;
    }

    .required-field::after {
        content: ' *';
        color: #e74c3c;
        font-weight: bold;
    }

    .file-upload-area {
        border: 2px dashed #dee2e6;
        border-radius: 12px;
        padding: 40px 20px;
        text-align: center;
        transition: all 0.3s ease;
        background: #fafbfc;
        cursor: pointer;
        position: relative;
    }

    .file-upload-area:hover, .file-upload-area.dragover {
        border-color: #667eea;
        background: #f8f9ff;
    }

    .file-upload-area.dragover {
        border-style: solid;
        background: #e8ecff;
    }

    .uploaded-file {
        background: white;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 12px 16px;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        transition: all 0.3s ease;
    }

    .uploaded-file:hover {
        border-color: #667eea;
        background: #f8f9ff;
    }

    .file-icon {
        width: 32px;
        height: 32px;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 12px;
        font-size: 14px;
        color: white;
    }

    .remove-file {
        background: #e74c3c;
        color: white;
        border: none;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .remove-file:hover {
        background: #c0392b;
        transform: scale(1.1);
    }

    .priority-badge {
        padding: 8px 16px;
        border-radius: 20px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: 12px;
    }

    .section-title {
        position: relative;
        padding-bottom: 10px;
        margin-bottom: 20px;
        font-weight: 700;
        color: #2c3e50;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 50px;
        height: 3px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 2px;
    }

    /* Quill Editor Customization */
    .ql-toolbar {
        border: 2px solid #e9ecef !important;
        border-bottom: 1px solid #e9ecef !important;
        border-radius: 8px 8px 0 0 !important;
        background: #fafbfc;
    }

    .ql-container {
        border: 2px solid #e9ecef !important;
        border-top: none !important;
        border-radius: 0 0 8px 8px !important;
        font-size: 14px;
        min-height: 200px;
    }

    .ql-editor {
        min-height: 200px;
        line-height: 1.6;
    }

    .ql-editor.ql-blank::before {
        color: #adb5bd;
        font-style: italic;
    }

    .ql-toolbar.ql-snow .ql-picker-label:hover,
    .ql-toolbar.ql-snow .ql-picker-item:hover {
        color: #667eea;
    }

    .ql-snow .ql-fill,
    .ql-snow .ql-stroke.ql-fill {
        fill: #667eea;
    }

    .loading-spinner {
        display: none;
        width: 20px;
        height: 20px;
        border: 2px solid #f3f3f3;
        border-top: 2px solid #667eea;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin-right: 10px;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .form-progress {
        height: 4px;
        background: #e9ecef;
        border-radius: 2px;
        overflow: hidden;
        margin-bottom: 20px;
    }

    .progress-bar {
        height: 100%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 2px;
        transition: width 0.3s ease;
    }

    @media (max-width: 768px) {
        .form-header {
            border-radius: 10px;
        }

        .btn-custom {
            width: 100%;
            margin-bottom: 10px;
        }

        .file-upload-area {
            padding: 30px 15px;
        }
    }
</style>
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="form-header p-4">
                <div class="row align-items-center position-relative">
                    <div class="col-lg-8">
                        <div class="d-flex align-items-center mb-3">
                            <a href="{{ route('tasks.show', $task) }}" class="btn btn-outline-light me-3">
                                <i class="icofont-arrow-left"></i> Quay lại
                            </a>
                            <h1 class="h3 mb-0 fw-bold">Chỉnh sửa công việc</h1>
                        </div>
                        <p class="mb-0 opacity-75">
                            <i class="icofont-building me-2"></i>{{ $task->project->department->name ?? '' }}
                            • <i class="icofont-cube me-2"></i>{{ $task->project->name }}
                        </p>
                    </div>
                    <div class="col-lg-4 text-lg-end">
                        <div class="d-flex justify-content-lg-end justify-content-start gap-2 mt-3 mt-lg-0">
                            <span class="priority-badge
                                @if($task->priority === 'urgent') bg-dark text-white
                                @elseif($task->priority === 'high') bg-danger text-white
                                @elseif($task->priority === 'medium') bg-warning text-dark
                                @else bg-secondary text-white @endif">
                                {{ Task::getPriorities()[$task->priority] }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Progress Bar -->
    <div class="form-progress">
        <div class="progress-bar" style="width: 0%"></div>
    </div>

    <form id="taskEditForm" method="POST" action="{{ route('tasks.update', $task) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <!-- Main Form -->
            <div class="col-lg-8">
                <div class="form-card mb-4">
                    <div class="card-body p-4">
                        <h4 class="section-title">Thông tin cơ bản</h4>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name" class="form-label required-field">Tên công việc</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                           id="name" name="name" value="{{ old('name', $task->name) }}"
                                           placeholder="Nhập tên công việc..." required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="project_id" class="form-label required-field">Dự án</label>
                                    <select class="form-select @error('project_id') is-invalid @enderror"
                                            id="project_id" name="project_id" required>
                                        <option value="">Chọn dự án...</option>
                                        @foreach($projects as $project)
                                            <option value="{{ $project->id }}"
                                                {{ old('project_id', $task->project_id) == $project->id ? 'selected' : '' }}>
                                                {{ $project->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('project_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="user_id" class="form-label required-field">Người thực hiện</label>
                                    <select class="form-select @error('user_id') is-invalid @enderror"
                                            id="user_id" name="user_id" required>
                                        <option value="">Chọn người thực hiện...</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}"
                                                {{ old('user_id', $task->user_id) == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }} ({{ $user->position ?? 'Nhân viên' }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('user_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="start_date" class="form-label required-field">Ngày bắt đầu</label>
                                    <input type="date" class="form-control @error('start_date') is-invalid @enderror"
                                           id="start_date" name="start_date"
                                           value="{{ old('start_date', $task->start_date->format('Y-m-d')) }}" required>
                                    @error('start_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="end_date" class="form-label required-field">Ngày kết thúc</label>
                                    <input type="date" class="form-control @error('end_date') is-invalid @enderror"
                                           id="end_date" name="end_date"
                                           value="{{ old('end_date', $task->end_date->format('Y-m-d')) }}" required>
                                    @error('end_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="priority" class="form-label required-field">Độ ưu tiên</label>
                                    <select class="form-select @error('priority') is-invalid @enderror"
                                            id="priority" name="priority" required>
                                        @foreach(Task::getPriorities() as $key => $priority)
                                            <option value="{{ $key }}"
                                                {{ old('priority', $task->priority) === $key ? 'selected' : '' }}>
                                                {{ $priority }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('priority')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status" class="form-label required-field">Trạng thái</label>
                                    <select class="form-select @error('status') is-invalid @enderror"
                                            id="status" name="status" required>
                                        @foreach(Task::getStatuses() as $key => $status)
                                            <option value="{{ $key }}"
                                                {{ old('status', $task->status) === $key ? 'selected' : '' }}>
                                                {{ $status }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="form-card mb-4">
                    <div class="card-body p-4">
                        <h4 class="section-title">Mô tả công việc</h4>
                        <div class="form-group">
                            <label for="description" class="form-label">Mô tả chi tiết</label>
                            <div id="description-editor" style="height: 300px;">
                                {!! old('description', $task->description) !!}
                            </div>
                            <textarea name="description" id="description" style="display:none;"></textarea>
                            @error('description')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- File Upload -->
                <div class="form-card mb-4">
                    <div class="card-body p-4">
                        <h4 class="section-title">Tài liệu đính kèm</h4>

                        <!-- Current Files -->
                        @if($task->image_and_document && count($task->image_and_document) > 0)
                            <div class="mb-4">
                                <h6 class="fw-bold mb-3">Tài liệu hiện tại:</h6>
                                <div id="current-files">
                                    @foreach($task->image_and_document as $index => $file)
                                        <div class="uploaded-file" data-file-index="{{ $index }}">
                                            <div class="file-icon
                                                @if(str_contains($file['type'], 'image')) bg-success
                                                @elseif(str_contains($file['type'], 'pdf')) bg-danger
                                                @elseif(str_contains($file['type'], 'word')) bg-primary
                                                @else bg-secondary @endif">
                                                @if(str_contains($file['type'], 'image'))
                                                    <i class="icofont-image"></i>
                                                @elseif(str_contains($file['type'], 'pdf'))
                                                    <i class="icofont-file-pdf"></i>
                                                @elseif(str_contains($file['type'], 'word'))
                                                    <i class="icofont-file-word"></i>
                                                @else
                                                    <i class="icofont-file-document"></i>
                                                @endif
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1 fw-semibold">{{ $file['name'] }}</h6>
                                                <small class="text-muted">{{ round($file['size'] / 1024, 2) }} KB</small>
                                            </div>
                                            <a href="{{ Storage::url($file['path']) }}" target="_blank"
                                               class="btn btn-sm btn-outline-primary me-2">
                                                <i class="icofont-eye"></i>
                                            </a>
                                            <button type="button" class="remove-file" onclick="removeCurrentFile({{ $index }})">
                                                <i class="icofont-close"></i>
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- New File Upload -->
                        <div class="form-group">
                            <label class="form-label">Tải lên tài liệu mới (tùy chọn)</label>
                            <div class="file-upload-area" id="fileUploadArea">
                                <input type="file" id="fileInput" name="image_and_document[]"
                                       multiple accept=".jpg,.jpeg,.png,.pdf,.doc,.docx" style="display: none;">
                                <div id="uploadContent">
                                    <i class="icofont-cloud-upload display-4 text-muted mb-3"></i>
                                    <h5 class="fw-bold mb-2">Kéo thả tệp vào đây hoặc nhấp để chọn</h5>
                                    <p class="text-muted mb-0">Hỗ trợ: JPG, PNG, PDF, DOC, DOCX (Tối đa 5MB mỗi tệp)</p>
                                </div>
                            </div>
                            <div id="newFilesList" class="mt-3"></div>
                            @error('image_and_document')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Current Assignee -->
                <div class="form-card mb-4">
                    <div class="card-body p-4 text-center">
                        <h5 class="section-title">Người thực hiện hiện tại</h5>

                        @if($task->assignee->image)
                            <img src="{{ $task->assignee->image_url }}" alt="" class="avatar-large rounded-circle mb-3" style="width: 100px; height: 100px;">
                        @else
                            <div class="avatar-large rounded-circle bg-primary d-flex align-items-center justify-content-center mb-3 mx-auto">
                                <span class="text-white h4 mb-0 fw-bold">{{ substr($task->assignee->name, 0, 2) }}</span>
                            </div>
                        @endif

                        <h5 class="fw-bold mb-2">{{ $task->assignee->name }}</h5>
                        <p class="text-muted mb-3">{{ $task->assignee->position ?? 'Nhân viên' }}</p>
                        <p class="text-muted small mb-0">
                            <i class="icofont-email me-1"></i>{{ $task->assignee->email }}
                        </p>
                    </div>
                </div>

                <!-- Actions -->
                <div class="form-card">
                    <div class="card-body p-4">
                        <h5 class="section-title">Hành động</h5>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success-custom btn-custom">
                                <div class="loading-spinner" id="saveSpinner"></div>
                                <i class="icofont-save"></i> Lưu thay đổi
                            </button>

                            <button type="button" class="btn btn-primary-custom btn-custom" onclick="previewTask()">
                                <i class="icofont-eye"></i> Xem trước
                            </button>

                            <a href="{{ route('tasks.show', $task) }}" class="btn btn-secondary-custom btn-custom">
                                <i class="icofont-close"></i> Hủy bỏ
                            </a>
                        </div>

                        <hr class="my-4">

                        <div class="small text-muted">
                            <p class="mb-2">
                                <i class="icofont-calendar me-1"></i>
                                <strong>Tạo:</strong> {{ $task->created_at->format('d/m/Y H:i') }}
                            </p>
                            <p class="mb-0">
                                <i class="icofont-edit me-1"></i>
                                <strong>Cập nhật:</strong> {{ $task->updated_at->format('d/m/Y H:i') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Preview Modal -->
<div class="modal fade" id="previewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Xem trước công việc</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="previewContent">
                <!-- Preview content will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary" onclick="submitForm()">Lưu thay đổi</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script>
let quill;
let newFiles = [];
let removedFiles = [];

document.addEventListener('DOMContentLoaded', function() {
    // Initialize Quill editor
    quill = new Quill('#description-editor', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'color': [] }, { 'background': [] }],
                [{ 'font': [] }],
                [{ 'align': [] }],
                ['blockquote', 'code-block'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'indent': '-1'}, { 'indent': '+1' }],
                ['link', 'image'],
                ['clean']
            ]
        },
        placeholder: 'Nhập mô tả chi tiết công việc...'
    });

    // File upload handling
    setupFileUpload();

    // Form validation
    setupFormValidation();

    // Auto-save draft functionality
    setupAutoSave();
});

function setupFileUpload() {
    const fileUploadArea = document.getElementById('fileUploadArea');
    const fileInput = document.getElementById('fileInput');

    // Click to select files
    fileUploadArea.addEventListener('click', () => fileInput.click());

    // Drag and drop
    fileUploadArea.addEventListener('dragover', handleDragOver);
    fileUploadArea.addEventListener('dragleave', handleDragLeave);
    fileUploadArea.addEventListener('drop', handleFileDrop);

    // File input change
    fileInput.addEventListener('change', handleFileSelect);
}

function handleDragOver(e) {
    e.preventDefault();
    document.getElementById('fileUploadArea').classList.add('dragover');
}

function handleDragLeave(e) {
    e.preventDefault();
    document.getElementById('fileUploadArea').classList.remove('dragover');
}

function handleFileDrop(e) {
    e.preventDefault();
    document.getElementById('fileUploadArea').classList.remove('dragover');
    const files = e.dataTransfer.files;
    handleFiles(files);
}

function handleFileSelect(e) {
    const files = e.target.files;
    handleFiles(files);
}

function handleFiles(files) {
    for (let file of files) {
        if (validateFile(file)) {
            newFiles.push(file);
            displayNewFile(file);
        }
    }
    updateProgressBar();
}

function validateFile(file) {
    const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'application/pdf',
                          'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
    const maxSize = 5 * 1024 * 1024; // 5MB

    if (!allowedTypes.includes(file.type)) {
        alert('Loại tệp không được hỗ trợ: ' + file.name);
        return false;
    }

    if (file.size > maxSize) {
        alert('Tệp quá lớn (>5MB): ' + file.name);
        return false;
    }

    return true;
}

function displayNewFile(file) {
    const filesList = document.getElementById('newFilesList');
    const fileDiv = document.createElement('div');
    fileDiv.className = 'uploaded-file';

    let iconClass = 'bg-secondary';
    let icon = 'icofont-file-document';

    if (file.type.includes('image')) {
        iconClass = 'bg-success';
        icon = 'icofont-image';
    } else if (file.type.includes('pdf')) {
        iconClass = 'bg-danger';
        icon = 'icofont-file-pdf';
    } else if (file.type.includes('word')) {
        iconClass = 'bg-primary';
        icon = 'icofont-file-word';
    }

    fileDiv.innerHTML = `
        <div class="file-icon ${iconClass}">
            <i class="${icon}"></i>
        </div>
        <div class="flex-grow-1">
            <h6 class="mb-1 fw-semibold">${file.name}</h6>
            <small class="text-muted">${Math.round(file.size / 1024)} KB</small>
        </div>
        <button type="button" class="remove-file" onclick="removeNewFile(this, '${file.name}')">
            <i class="icofont-close"></i>
        </button>
    `;

    filesList.appendChild(fileDiv);
}

function removeNewFile(button, fileName) {
    newFiles = newFiles.filter(file => file.name !== fileName);
    button.closest('.uploaded-file').remove();
    updateProgressBar();
}

function removeCurrentFile(index) {
    if (confirm('Bạn có chắc chắn muốn xóa tệp này?')) {
        removedFiles.push(index);
        document.querySelector(`[data-file-index="${index}"]`).style.display = 'none';
        updateProgressBar();
    }
}

function setupFormValidation() {
    const form = document.getElementById('taskEditForm');
    const inputs = form.querySelectorAll('input[required], select[required]');

    inputs.forEach(input => {
        input.addEventListener('blur', validateField);
        input.addEventListener('input', updateProgressBar);
    });
}

function validateField(e) {
    const field = e.target;
    if (field.value.trim() === '') {
        field.classList.add('is-invalid');
    } else {
        field.classList.remove('is-invalid');
        field.classList.add('is-valid');
    }
}

function updateProgressBar() {
    const form = document.getElementById('taskEditForm');
    const requiredFields = form.querySelectorAll('input[required], select[required]');
    let completedFields = 0;

    requiredFields.forEach(field => {
        if (field.value.trim() !== '') {
            completedFields++;
        }
    });

    // Add description to progress if not empty
    if (quill.getText().trim().length > 0) {
        completedFields++;
    }

    const totalFields = requiredFields.length + 1; // +1 for description
    const progress = (completedFields / totalFields) * 100;

    document.querySelector('.progress-bar').style.width = progress + '%';
}

function setupAutoSave() {
    let autoSaveTimer;

    function triggerAutoSave() {
        clearTimeout(autoSaveTimer);
        autoSaveTimer = setTimeout(() => {
            saveDraft();
        }, 30000); // Auto-save every 30 seconds
    }

    // Listen for changes
    document.getElementById('taskEditForm').addEventListener('input', triggerAutoSave);
    quill.on('text-change', triggerAutoSave);
}

function saveDraft() {
    const formData = new FormData(document.getElementById('taskEditForm'));
    formData.append('description', quill.root.innerHTML);
    formData.append('_draft', 'true');

    fetch("{{ route('tasks.update', $task) }}", {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Bản nháp đã được lưu tự động', 'success');
        }
    })
    .catch(error => {
        console.log('Auto-save failed:', error);
    });
}

function previewTask() {
    const formData = {
        name: document.getElementById('name').value,
        project_id: document.getElementById('project_id').value,
        user_id: document.getElementById('user_id').value,
        start_date: document.getElementById('start_date').value,
        end_date: document.getElementById('end_date').value,
        priority: document.getElementById('priority').value,
        status: document.getElementById('status').value,
        description: quill.root.innerHTML
    };

    // Generate preview content
    let previewHTML = `
        <div class="task-preview">
            <h4>${formData.name || 'Tên công việc'}</h4>
            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Ngày bắt đầu:</strong> ${formData.start_date || 'Chưa chọn'}
                </div>
                <div class="col-md-6">
                    <strong>Ngày kết thúc:</strong> ${formData.end_date || 'Chưa chọn'}
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Độ ưu tiên:</strong> ${getPriorityText(formData.priority)}
                </div>
                <div class="col-md-6">
                    <strong>Trạng thái:</strong> ${getStatusText(formData.status)}
                </div>
            </div>
            <div class="mb-3">
                <strong>Mô tả:</strong>
                <div class="mt-2 p-3 bg-light border rounded">
                    ${formData.description || '<em>Không có mô tả</em>'}
                </div>
            </div>
        </div>
    `;

    document.getElementById('previewContent').innerHTML = previewHTML;

    const modal = new bootstrap.Modal(document.getElementById('previewModal'));
    modal.show();
}

function getPriorityText(priority) {
    const priorities = {
        'low': 'Thấp',
        'medium': 'Trung bình',
        'high': 'Cao',
        'urgent': 'Khẩn cấp'
    };
    return priorities[priority] || 'Chưa chọn';
}

function getStatusText(status) {
    const statuses = {
        'in_progress': 'Đang thực hiện',
        'needs_review': 'Cần xem xét',
        'completed': 'Hoàn thành'
    };
    return statuses[status] || 'Chưa chọn';
}

function submitForm() {
    document.getElementById('taskEditForm').submit();
}

// Form submission
document.getElementById('taskEditForm').addEventListener('submit', function(e) {
    e.preventDefault();

    // Set description content
    document.getElementById('description').value = quill.root.innerHTML;

    // Show loading
    const spinner = document.getElementById('saveSpinner');
    spinner.style.display = 'inline-block';

    // Create FormData with files
    const formData = new FormData(this);

    // Add new files
    newFiles.forEach(file => {
        formData.append('image_and_document[]', file);
    });

    // Add removed files info
    if (removedFiles.length > 0) {
        formData.append('removed_files', JSON.stringify(removedFiles));
    }

    fetch(this.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        spinner.style.display = 'none';

        if (data.success) {
            showNotification('Cập nhật công việc thành công!', 'success');
            setTimeout(() => {
                window.location.href = "{{ route('tasks.show', $task) }}";
            }, 1500);
        } else {
            showNotification('Có lỗi xảy ra: ' + data.message, 'error');
        }
    })
    .catch(error => {
        spinner.style.display = 'none';
        console.error('Error:', error);
        showNotification('Có lỗi xảy ra khi cập nhật công việc', 'error');
    });
});

function showNotification(message, type) {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show position-fixed`;
    notification.style.top = '20px';
    notification.style.right = '20px';
    notification.style.zIndex = '9999';
    notification.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;

    document.body.appendChild(notification);

    // Auto remove after 5 seconds
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 5000);
}

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Ctrl/Cmd + S to save
    if ((e.ctrlKey || e.metaKey) && e.key === 's') {
        e.preventDefault();
        document.getElementById('taskEditForm').dispatchEvent(new Event('submit'));
    }

    // Ctrl/Cmd + P to preview
    if ((e.ctrlKey || e.metaKey) && e.key === 'p') {
        e.preventDefault();
        previewTask();
    }

    // Escape to cancel
    if (e.key === 'Escape') {
        if (confirm('Bạn có chắc chắn muốn hủy? Các thay đổi chưa lưu sẽ bị mất.')) {
            window.location.href = "{{ route('tasks.show', $task) }}";
        }
    }
});

// Warn before leaving page with unsaved changes
let hasUnsavedChanges = false;

document.getElementById('taskEditForm').addEventListener('input', function() {
    hasUnsavedChanges = true;
});

quill.on('text-change', function() {
    hasUnsavedChanges = true;
});

window.addEventListener('beforeunload', function(e) {
    if (hasUnsavedChanges) {
        e.preventDefault();
        e.returnValue = 'Bạn có thay đổi chưa được lưu. Bạn có chắc chắn muốn rời khỏi trang?';
    }
});

// Reset unsaved changes flag on successful submit
document.getElementById('taskEditForm').addEventListener('submit', function() {
    hasUnsavedChanges = false;
});

// Initialize tooltips
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
});
</script>
@endpush

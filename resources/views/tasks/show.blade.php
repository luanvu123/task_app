@extends('layouts.app')

@section('title', 'Chi Tiết Công Việc')



@section('content')
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <style>
        .task-detail-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 15px;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .task-detail-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 200%;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Ccircle cx='30' cy='30' r='4'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            opacity: 0.3;
        }

        .info-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 25px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            background: white;
        }

        .info-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        }

        .priority-badge {
            padding: 0px 16px;
            border-radius: 20px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-badge {
            padding: 0px 20px;
            border-radius: 25px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .description-content {
            background: #fafbfc;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 20px;
            min-height: 200px;
            line-height: 1.6;
        }

        .attachment-item {
            background: white;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 15px;
            transition: all 0.3s ease;
            text-decoration: none;
            color: inherit;
        }

        .attachment-item:hover {
            border-color: #007bff;
            background: #f8f9fa;
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            color: inherit;
            text-decoration: none;
        }

        .file-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            color: white;
        }

        .btn-action {
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }

        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
        }

        .timeline-item {
            border-left: 3px solid #e9ecef;
            padding-left: 20px;
            margin-bottom: 15px;
            position: relative;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: -8px;
            top: 5px;
            width: 12px;
            height: 12px;
            background: #007bff;
            border-radius: 50%;
            border: 3px solid white;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .section-title {
            position: relative;
            padding-bottom: 10px;
            margin-bottom: 20px;
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

        .avatar-large {
            width: 60px;
            height: 60px;
            border: 4px solid white;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        @media (max-width: 768px) {
            .task-detail-header {
                border-radius: 10px;
            }

            .info-card {
                margin-bottom: 15px;
            }
        }
    </style>
    @php
        use App\Models\Task;
    @endphp
    <div class="container-fluid px-4">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="task-detail-header p-4">
                    <div class="row align-items-center position-relative">
                        <div class="col-lg-8">
                            <div class="d-flex align-items-center mb-3">
                                <a href="{{ route('tasks.index') }}" class="btn btn-outline-light me-3">
                                    <i class="icofont-arrow-left"></i> Quay lại
                                </a>
                                <h1 class="h3 mb-0 fw-bold">{{ $task->name }}</h1>
                            </div>
                            <p class="mb-0 opacity-75">
                                <i class="icofont-building me-2"></i>{{ $task->project->department->name ?? '' }}
                                • <i class="icofont-cube me-2"></i>{{ $task->project->name }}
                            </p>
                        </div>
                        <div class="col-lg-4 text-lg-end">
                            <div class="d-flex justify-content-lg-end justify-content-start gap-2 mt-3 mt-lg-0">
                                @if(auth()->user()->isDepartmentHead() || $task->user_id === auth()->id())
                                    <a href="{{ route('tasks.edit', $task) }}" class="btn btn-warning btn-action">
                                        <i class="icofont-edit"></i> Chỉnh sửa
                                    </a>
                                @endif
                                @if(auth()->user()->isDepartmentHead())
                                    <button class="btn btn-danger btn-action" onclick="deleteTask({{ $task->id }})">
                                        <i class="icofont-trash"></i> Xóa
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <!-- Task Information -->
                <div class="card info-card mb-4">
                    <div class="card-body p-4">
                        <h4 class="section-title mb-3">Thông tin công việc</h4>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="text-muted small fw-bold text-uppercase">Ngày bắt đầu</label>
                                    <div class="d-flex align-items-center mt-1">
                                        <i class="icofont-calendar text-primary me-2"></i>
                                        <span class="fw-semibold">{{ $task->start_date->format('d/m/Y') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="text-muted small fw-bold text-uppercase">Ngày kết thúc</label>
                                    <div class="d-flex align-items-center mt-1">
                                        <i class="icofont-calendar text-danger me-2"></i>
                                        <span class="fw-semibold {{ $task->isOverdue() ? 'text-danger' : '' }}">
                                            {{ $task->end_date->format('d/m/Y') }}
                                            @if($task->isOverdue())
                                                <i class="icofont-warning text-danger ms-1" title="Quá hạn"></i>
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="text-muted small fw-bold text-uppercase">Độ ưu tiên</label>
                                    <div class="mt-1">
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
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="text-muted small fw-bold text-uppercase">Trạng thái</label>
                                    <div class="mt-1">
                                        <span class="status-badge
                                            @if($task->status === 'completed') bg-success text-white
                                            @elseif($task->status === 'needs_review') bg-info text-white
                                            @else bg-primary text-white @endif">
                                            {{ Task::getStatuses()[$task->status] }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if($task->user_id === auth()->id() || auth()->user()->isDepartmentHead())
                            <div class="mt-3">
                                <label class="text-muted small fw-bold text-uppercase">Cập nhật trạng thái</label>
                                <div class="mt-2">
                                    <select class="form-select" onchange="updateTaskStatus({{ $task->id }}, this.value)">
                                        <option value="in_progress" {{ $task->status === 'in_progress' ? 'selected' : '' }}>
                                            Đang thực hiện
                                        </option>
                                        <option value="needs_review" {{ $task->status === 'needs_review' ? 'selected' : '' }}>
                                            Cần xem xét
                                        </option>
                                        <option value="completed" {{ $task->status === 'completed' ? 'selected' : '' }}>
                                            Hoàn thành
                                        </option>
                                    </select>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Description -->
                <div class="card info-card mb-4">
                    <div class="card-body p-4">
                        <h4 class="section-title mb-3">Mô tả công việc</h4>
                        <div class="description-content">
                            @if($task->description)
                                {!! nl2br(e($task->description)) !!}
                            @else
                                <p class="text-muted fst-italic">Không có mô tả</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Attachments -->
                @if($task->image_and_document && count($task->image_and_document) > 0)
                    <div class="card info-card mb-4">
                        <div class="card-body p-4">
                            <h4 class="section-title mb-3">
                                Tài liệu đính kèm
                                <span class="badge bg-primary ms-2">{{ count($task->image_and_document) }}</span>
                            </h4>
                            <div class="row">
                                @foreach($task->image_and_document as $file)
                                    <div class="col-md-6 mb-3">
                                        <a href="{{ Storage::url($file['path']) }}" target="_blank" class="attachment-item d-block">
                                            <div class="d-flex align-items-center">
                                                <div class="file-icon me-3
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
                                                <i class="icofont-download ms-2 text-primary"></i>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Assignee Information -->
                <div class="card info-card mb-4">
                    <div class="card-body p-4 text-center">
                        <h5 class="section-title">Người thực hiện</h5>

                        @if($task->assignee->image)
                                            <img src="{{ $task->assignee->image_url }}" alt="" class="" style="width: 100px;
                            height: 100px;">
                        @else
                            <div
                                class="avatar-large rounded-circle bg-primary d-flex align-items-center justify-content-center mb-3 mx-auto">
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

                <!-- Project Information -->
                <div class="card info-card mb-4">
                    <div class="card-body p-4">
                        <h5 class="section-title">Dự án</h5>
                        <div class="d-flex align-items-center">
                            <div class="bg-primary rounded p-3 me-3">
                                <i class="icofont-cube text-white h5 mb-0"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">{{ $task->project->name }}</h6>
                                <small class="text-muted">{{ $task->project->department->name ?? '' }}</small>
                            </div>
                        </div>

                        @if($task->project->description)
                            <div class="mt-3 pt-3 border-top">
                                <p class="small text-muted mb-0">{{ Str::limit($task->project->description, 100) }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Timeline -->
                <div class="card info-card">
                    <div class="card-body p-4">
                        <h5 class="section-title">Lịch sử</h5>
                        <div class="timeline">
                            <div class="timeline-item">
                                <small class="text-muted">{{ $task->created_at->format('d/m/Y H:i') }}</small>
                                <p class="mb-0 fw-semibold">Task được tạo</p>
                            </div>
                            @if($task->updated_at != $task->created_at)
                                <div class="timeline-item">
                                    <small class="text-muted">{{ $task->updated_at->format('d/m/Y H:i') }}</small>
                                    <p class="mb-0 fw-semibold">Cập nhật gần nhất</p>
                                </div>
                            @endif
                            @if($task->status === 'completed')
                                <div class="timeline-item">
                                    <small class="text-muted">{{ $task->updated_at->format('d/m/Y H:i') }}</small>
                                    <p class="mb-0 fw-semibold text-success">
                                        <i class="icofont-check-circled me-1"></i>Hoàn thành
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function updateTaskStatus(taskId, status) {
            if (confirm('Bạn có chắc chắn muốn cập nhật trạng thái này?')) {
                fetch(`/tasks/${taskId}/status`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ status: status })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        } else {
                            alert('Có lỗi xảy ra: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Có lỗi xảy ra khi cập nhật trạng thái');
                    });
            }
        }

        function deleteTask(taskId) {
            if (confirm('Bạn có chắc chắn muốn xóa công việc này? Hành động này không thể hoàn tác.')) {
                fetch(`/tasks/${taskId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            window.location.href = '{{ route("tasks.index") }}';
                        } else {
                            alert('Có lỗi xảy ra: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Có lỗi xảy ra khi xóa task');
                    });
            }
        }
    </script>
@endpush

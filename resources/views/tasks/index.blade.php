@extends('layouts.app')

@section('content')
    @php
        use App\Models\Task;
    @endphp

    <!-- Add CSRF token meta tag -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="body d-flex py-lg-3 py-md-2">
        <div class="container-xxl">
            <div class="row align-items-center">
                <div class="border-0 mb-4">
                    <div
                        class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                        <h3 class="fw-bold mb-0">Quản Lý Công Việc</h3>
                        <div class="col-auto d-flex w-sm-100">
                            <button type="button" class="btn btn-dark btn-set-task w-sm-100" data-bs-toggle="modal"
                                data-bs-target="#createTask"><i class="icofont-plus-circle me-2 fs-6"></i>Tạo Công Việc
                                Mới</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row clearfix g-3">
                <div class="col-lg-12 col-md-12 flex-column">
                    <div class="row g-3 row-deck">
                        <!-- Task Statistics -->
                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6">
                            <div class="card">
                                <div class="card-header py-3">
                                    <h6 class="mb-0 fw-bold">Thống Kê Công Việc</h6>
                                </div>
                                <div class="card-body mem-list">
                                    <div class="progress-count mb-4">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <h6 class="mb-0 fw-bold d-flex align-items-center">Đang Thực Hiện</h6>
                                            <span class="small text-muted"
                                                id="inProgressStats">{{ $taskStats['in_progress'] }}/{{ $taskStats['total'] }}</span>
                                        </div>
                                        <div class="progress" style="height: 10px;">
                                            <div class="progress-bar light-success-bg" role="progressbar" id="inProgressBar"
                                                style="width: {{ $taskStats['total'] > 0 ? ($taskStats['in_progress'] / $taskStats['total']) * 100 : 0 }}%">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="progress-count mb-4">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <h6 class="mb-0 fw-bold d-flex align-items-center">Cần Xem Xét</h6>
                                            <span class="small text-muted"
                                                id="needsReviewStats">{{ $taskStats['needs_review'] }}/{{ $taskStats['total'] }}</span>
                                        </div>
                                        <div class="progress" style="height: 10px;">
                                            <div class="progress-bar light-info-bg" role="progressbar" id="needsReviewBar"
                                                style="width: {{ $taskStats['total'] > 0 ? ($taskStats['needs_review'] / $taskStats['total']) * 100 : 0 }}%">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="progress-count mb-4">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <h6 class="mb-0 fw-bold d-flex align-items-center">Hoàn Thành</h6>
                                            <span class="small text-muted"
                                                id="completedStats">{{ $taskStats['completed'] }}/{{ $taskStats['total'] }}</span>
                                        </div>
                                        <div class="progress" style="height: 10px;">
                                            <div class="progress-bar bg-lightgreen" role="progressbar" id="completedBar"
                                                style="width: {{ $taskStats['total'] > 0 ? ($taskStats['completed'] / $taskStats['total']) * 100 : 0 }}%">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="progress-count mb-3">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <h6 class="mb-0 fw-bold d-flex align-items-center text-danger">Quá Hạn</h6>
                                            <span class="small text-muted"
                                                id="overdueStats">{{ $taskStats['overdue'] }}</span>
                                        </div>
                                        <div class="progress" style="height: 10px;">
                                            <div class="progress-bar bg-danger" role="progressbar" id="overdueBar"
                                                style="width: {{ $taskStats['total'] > 0 ? ($taskStats['overdue'] / $taskStats['total']) * 100 : 0 }}%">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Recent Tasks -->
                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6">
                            <div class="card">
                                <div class="card-header py-3">
                                    <h6 class="mb-0 fw-bold">Công Việc Gần Đây</h6>
                                </div>
                                <div class="card-body mem-list">
                                    @forelse($recentTasks as $task)
                                        <div class="timeline-item border-bottom ms-2">
                                            <div class="d-flex">
                                                <span
                                                    class="avatar d-flex justify-content-center align-items-center rounded-circle light-success-bg">
                                                    {{ substr($task->assignee->name, 0, 2) }}
                                                </span>
                                                <div class="flex-fill ms-3">
                                                    <div class="mb-1"><strong>{{ $task->name }}</strong></div>
                                                    <span class="d-flex text-muted small">{{ $task->assignee->name }} •
                                                        {{ $task->created_at->diffForHumans() }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <p class="text-muted text-center">Chưa có công việc nào</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <!-- Team Members -->
                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12">
                            <div class="card">
                                <div class="card-header py-3">
                                    <h6 class="mb-0 fw-bold">Thành Viên Được Giao Việc</h6>
                                </div>
                                <div class="card-body">
                                    <div class="flex-grow-1 mem-list">
                                        @foreach($users->take(5) as $user)
                                            <div class="py-2 d-flex align-items-center border-bottom">
                                                <div class="d-flex ms-2 align-items-center flex-fill">
                                                    @if($user->image)
                                                        <img src="{{ $user->image_url }}"
                                                            class="avatar lg rounded-circle img-thumbnail" alt="avatar">
                                                    @else
                                                        <div
                                                            class="avatar lg rounded-circle bg-secondary d-flex align-items-center justify-content-center">
                                                            <span class="text-white fw-bold">{{ substr($user->name, 0, 2) }}</span>
                                                        </div>
                                                    @endif
                                                    <div class="d-flex flex-column ps-2">
                                                        <h6 class="fw-bold mb-0">{{ $user->name }}</h6>
                                                        <span
                                                            class="small text-muted">{{ $user->position ?? 'Nhân viên' }}</span>
                                                    </div>
                                                </div>
                                                <span class="badge bg-primary">{{ $user->tasks()->count() }} việc</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Task Board -->
                    <div class="row taskboard g-3 py-xxl-4">
                        <!-- In Progress Tasks -->
                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 mt-4">
                            <h6 class="fw-bold py-3 mb-0">Đang Thực Hiện (<span
                                    id="inProgressHeaderCount">{{ $tasks['in_progress']->count() ?? 0 }}</span>)</h6>
                            <div class="progress_task task-column" data-status="in_progress"
                                style="min-height: 400px; border: 2px dashed transparent; border-radius: 8px; padding: 10px;">
                                @forelse($tasks['in_progress'] ?? [] as $task)
                                    <div class="task-card draggable-task" data-task-id="{{ $task->id }}"
                                        data-current-status="{{ $task->status }}" data-assignee-id="{{ $task->user_id }}"
                                        data-project-id="{{ $task->project_id }}" style="cursor: move; margin-bottom: 15px;">
                                        <div class="card border-0 shadow-sm">
                                            <div class="card-body p-3">
                                                <div class="task-info d-flex align-items-center justify-content-between mb-2">
                                                    <h6
                                                        class="light-success-bg py-1 px-2 rounded-1 d-inline-block fw-bold small-14 mb-0 department-badge">
                                                        {{ $task->project->department->name ?? '' }}
                                                    </h6>
                                                    <div
                                                        class="task-priority d-flex flex-column align-items-center justify-content-center">
                                                        <div class="avatar-list avatar-list-stacked m-0">
                                                            @if($task->assignee->image)
                                                                <img class="avatar rounded-circle small-avt"
                                                                    src="{{ $task->assignee->image_url }}" alt="">
                                                            @else
                                                                <div
                                                                    class="avatar rounded-circle small-avt bg-secondary d-flex align-items-center justify-content-center">
                                                                    <span
                                                                        class="text-white small fw-bold">{{ substr($task->assignee->name, 0, 2) }}</span>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <span
                                                            class="badge {{ $task->getPriorityBadgeColor() }} text-end mt-2 priority-badge">
                                                            {{ strtoupper(Task::getPriorities()[$task->priority]) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <h6 class="fw-bold mb-1 task-title">{{ $task->name }}</h6>
                                                <p class="mb-2 small text-muted">{{ Str::limit($task->description, 100) }}</p>
                                                <div class="tikit-info d-flex justify-content-between align-items-center">
                                                    <div class="d-flex align-items-center">
                                                        <i class="icofont-calendar me-1"></i>
                                                        <span class="small">{{ $task->end_date->format('d/m') }}</span>
                                                        @if($task->image_and_document)
                                                            <i class="icofont-paper-clip ms-2 me-1"></i>
                                                            <span class="small">{{ count($task->image_and_document) }}</span>
                                                        @endif
                                                    </div>
                                                    <div
                                                        class="small text-truncate light-success-bg py-1 px-2 rounded-1 fw-bold">
                                                        {{ Str::limit($task->project->name, 15) }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-muted text-center py-4 empty-state">
                                        <i class="icofont-tasks-alt display-4 mb-3"></i>
                                        <p>Không có công việc nào</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <!-- Needs Review Tasks -->
                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 mt-4">
                            <h6 class="fw-bold py-3 mb-0">Cần Xem Xét (<span
                                    id="needsReviewHeaderCount">{{ $tasks['needs_review']->count() ?? 0 }}</span>)</h6>
                            <div class="review_task task-column" data-status="needs_review"
                                style="min-height: 400px; border: 2px dashed transparent; border-radius: 8px; padding: 10px;">
                                @forelse($tasks['needs_review'] ?? [] as $task)
                                    <div class="task-card draggable-task" data-task-id="{{ $task->id }}"
                                        data-current-status="{{ $task->status }}" data-assignee-id="{{ $task->user_id }}"
                                        data-project-id="{{ $task->project_id }}" style="cursor: move; margin-bottom: 15px;">
                                        <div class="card border-0 shadow-sm">
                                            <div class="card-body p-3">
                                                <div class="task-info d-flex align-items-center justify-content-between mb-2">
                                                    <h6
                                                        class="light-info-bg py-1 px-2 rounded-1 d-inline-block fw-bold small-14 mb-0 department-badge">
                                                        {{ $task->project->department->name ?? '' }}
                                                    </h6>
                                                    <div
                                                        class="task-priority d-flex flex-column align-items-center justify-content-center">
                                                        <div class="avatar-list avatar-list-stacked m-0">
                                                            @if($task->assignee->image)
                                                                <img class="avatar rounded-circle small-avt"
                                                                    src="{{ $task->assignee->image_url }}" alt="">
                                                            @else
                                                                <div
                                                                    class="avatar rounded-circle small-avt bg-secondary d-flex align-items-center justify-content-center">
                                                                    <span
                                                                        class="text-white small fw-bold">{{ substr($task->assignee->name, 0, 2) }}</span>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <span
                                                            class="badge {{ $task->getPriorityBadgeColor() }} text-end mt-2 priority-badge">
                                                            {{ strtoupper(Task::getPriorities()[$task->priority]) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <h6 class="fw-bold mb-1 task-title">{{ $task->name }}</h6>
                                                <p class="mb-2 small text-muted">{{ Str::limit($task->description, 100) }}</p>
                                                <div class="tikit-info d-flex justify-content-between align-items-center">
                                                    <div class="d-flex align-items-center">
                                                        <i class="icofont-calendar me-1"></i>
                                                        <span class="small">{{ $task->end_date->format('d/m') }}</span>
                                                        @if($task->image_and_document)
                                                            <i class="icofont-paper-clip ms-2 me-1"></i>
                                                            <span class="small">{{ count($task->image_and_document) }}</span>
                                                        @endif
                                                    </div>
                                                    <div
                                                        class="small text-truncate light-success-bg py-1 px-2 rounded-1 fw-bold">
                                                        {{ Str::limit($task->project->name, 15) }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-muted text-center py-4 empty-state">
                                        <i class="icofont-eye-alt display-4 mb-3"></i>
                                        <p>Không có công việc nào</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <!-- Completed Tasks -->
                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 mt-4">
                            <h6 class="fw-bold py-3 mb-0">Hoàn Thành (<span
                                    id="completedHeaderCount">{{ $tasks['completed']->count() ?? 0 }}</span>)</h6>
                            <div class="completed_task task-column" data-status="completed"
                                style="min-height: 400px; border: 2px dashed transparent; border-radius: 8px; padding: 10px;">
                                @forelse($tasks['completed'] ?? [] as $task)
                                    <div class="task-card completed-task" data-task-id="{{ $task->id }}"
                                        data-current-status="{{ $task->status }}" data-assignee-id="{{ $task->user_id }}"
                                        data-project-id="{{ $task->project_id }}" style="margin-bottom: 15px; opacity: 0.8;">
                                        <div class="card border-0 shadow-sm bg-light">
                                            <div class="card-body p-3">
                                                <div class="task-info d-flex align-items-center justify-content-between mb-2">
                                                    <h6
                                                        class="light-secondary-bg py-1 px-2 rounded-1 d-inline-block fw-bold small-14 mb-0 department-badge">
                                                        {{ $task->project->department->name ?? '' }}
                                                    </h6>
                                                    <div
                                                        class="task-priority d-flex flex-column align-items-center justify-content-center">
                                                        <div class="avatar-list avatar-list-stacked m-0">
                                                            @if($task->assignee->image)
                                                                <img class="avatar rounded-circle small-avt"
                                                                    src="{{ $task->assignee->image_url }}" alt="">
                                                            @else
                                                                <div
                                                                    class="avatar rounded-circle small-avt bg-secondary d-flex align-items-center justify-content-center">
                                                                    <span
                                                                        class="text-white small fw-bold">{{ substr($task->assignee->name, 0, 2) }}</span>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <span class="badge bg-success text-end mt-2 priority-badge">HOÀN
                                                            THÀNH</span>
                                                    </div>
                                                </div>
                                                <h6 class="fw-bold mb-1 text-decoration-line-through task-title">
                                                    {{ $task->name }}</h6>
                                                <p class="mb-2 small text-muted">{{ Str::limit($task->description, 100) }}</p>
                                                <div class="tikit-info d-flex justify-content-between align-items-center">
                                                    <div class="d-flex align-items-center">
                                                        <i class="icofont-calendar me-1"></i>
                                                        <span class="small">{{ $task->end_date->format('d/m') }}</span>
                                                        @if($task->image_and_document)
                                                            <i class="icofont-paper-clip ms-2 me-1"></i>
                                                            <span class="small">{{ count($task->image_and_document) }}</span>
                                                        @endif
                                                    </div>
                                                    <div
                                                        class="small text-truncate light-success-bg py-1 px-2 rounded-1 fw-bold">
                                                        {{ Str::limit($task->project->name, 15) }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-muted text-center py-4 empty-state">
                                        <i class="icofont-check-circled display-4 mb-3"></i>
                                        <p>Không có công việc nào</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tạo Task (giữ nguyên) -->
    <div class="modal fade" id="createTask" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tạo Công Việc Mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="createTaskForm" method="POST" action="{{ route('tasks.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Tên Công Việc <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Chọn Dự Án <span class="text-danger">*</span></label>
                            <select class="form-select" id="createProjectSelect" name="project_id" required>
                                <option value="">-- Chọn dự án --</option>
                                @foreach($projects as $project)
                                    <option value="{{ $project->id }}">{{ $project->name }}
                                        ({{ $project->department->name ?? '' }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Giao Cho <span class="text-danger">*</span></label>
                            <select class="form-select" id="createUserSelect" name="user_id" required>
                                <option value="">-- Chọn người thực hiện --</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}"
                                        data-project-ids="{{ $user->projects->pluck('id')->implode(',') }}">
                                        {{ $user->name }} ({{ $user->position ?? 'Nhân viên' }})
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted">
                                <i class="icofont-info-circle"></i>
                                Hiển thị tất cả nhân viên trong phòng ban. Chọn dự án để lọc theo thành viên dự án.
                            </small>
                        </div>

                        <div class="mb-3">
                            <label for="taskFiles" class="form-label">Tài Liệu & Hình Ảnh</label>
                            <input class="form-control" type="file" id="taskFiles" name="image_and_document[]" multiple>
                            <small class="text-muted">Hỗ trợ: JPG, PNG, PDF, DOC, DOCX (tối đa 5MB mỗi file)</small>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Ngày Bắt Đầu <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="start_date" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Ngày Kết Thúc <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="end_date" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Độ Ưu Tiên <span class="text-danger">*</span></label>
                            <select class="form-select" name="priority" required>
                                <option value="low">Thấp</option>
                                <option value="medium" selected>Trung Bình</option>
                                <option value="high">Cao</option>
                                <option value="urgent">Khẩn Cấp</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Mô Tả</label>
                            <textarea class="form-control" name="description" rows="3"
                                placeholder="Mô tả chi tiết về công việc..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-primary">Tạo Công Việc</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div id="loadingOverlay"
        style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999; justify-content: center; align-items: center;">
        <div class="spinner-border text-light" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <!-- Alert Container -->
    <div id="alertContainer" style="position: fixed; top: 20px; right: 20px; z-index: 1050; width: 350px;"></div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>
    <script>
        $(document).ready(function () {
            // Store original options for user select
            const createUserOptions = $('#createUserSelect').html();
            const currentUserId = {{ Auth::id() }};
            const isDepartmentHead = {{ Auth::user()->isDepartmentHead() ? 'true' : 'false' }};

            // Function to show alerts
            function showAlert(type, title, message, duration = 4000) {
                const alertId = 'alert_' + Date.now();
                const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
                const icon = type === 'success' ? 'check-circle' : 'exclamation-triangle';

                const alertHtml = `
                <div class="alert ${alertClass} alert-dismissible fade show" id="${alertId}" style="margin-bottom: 10px;">
                    <i class="fas fa-${icon} me-2"></i>
                    <strong>${title}</strong> ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `;

                $('#alertContainer').append(alertHtml);

                if (duration > 0) {
                    setTimeout(() => {
                        $(`#${alertId}`).fadeOut(300, function () {
                            $(this).remove();
                        });
                    }, duration);
                }
            }

            // Function to filter users based on project selection
            function filterUsersByProject(projectSelectId, userSelectId, originalOptions) {
                const projectId = $(projectSelectId).val();
                const $userSelect = $(userSelectId);

                if (!projectId) {
                    $userSelect.html(originalOptions);
                    return;
                }

                let filteredOptions = '<option value="">-- Chọn người thực hiện --</option>';
                const $tempDiv = $('<div>').html(originalOptions);

                $tempDiv.find('option').each(function () {
                    const $option = $(this);
                    const projectIds = $option.data('project-ids');

                    if (!$option.val()) {
                        return true;
                    }

                    if (!projectIds) {
                        return true;
                    }

                    const userProjectIds = projectIds.toString().split(',');
                    if (userProjectIds.includes(projectId)) {
                        filteredOptions += $option[0].outerHTML;
                    }
                });

                $userSelect.html(filteredOptions);

                if ($userSelect.find('option').length <= 1) {
                    $userSelect.append('<option value="" disabled>-- Không có thành viên trong dự án này --</option>');
                }
            }

            // Handle project selection for create modal
            $('#createProjectSelect').change(function () {
                filterUsersByProject('#createProjectSelect', '#createUserSelect', createUserOptions);
            });

            // Reset form when modal is closed
            $('#createTask').on('hidden.bs.modal', function () {
                $('#createTaskForm')[0].reset();
                $('#createUserSelect').html(createUserOptions);
            });

            // Function to update column counts and statistics
            function updateColumnCounts() {
                const inProgressCount = $('.progress_task .task-card').length;
                const needsReviewCount = $('.review_task .task-card').length;
                const completedCount = $('.completed_task .task-card').length;
                const totalCount = inProgressCount + needsReviewCount + completedCount;

                // Update header counts
                $('#inProgressHeaderCount').text(inProgressCount);
                $('#needsReviewHeaderCount').text(needsReviewCount);
                $('#completedHeaderCount').text(completedCount);

                // Update statistics section
                $('#inProgressStats').text(`${inProgressCount}/${totalCount}`);
                $('#needsReviewStats').text(`${needsReviewCount}/${totalCount}`);
                $('#completedStats').text(`${completedCount}/${totalCount}`);

                // Update progress bars
                const inProgressPercent = totalCount > 0 ? (inProgressCount / totalCount) * 100 : 0;
                const needsReviewPercent = totalCount > 0 ? (needsReviewCount / totalCount) * 100 : 0;
                const completedPercent = totalCount > 0 ? (completedCount / totalCount) * 100 : 0;

                $('#inProgressBar').css('width', `${inProgressPercent}%`);
                $('#needsReviewBar').css('width', `${needsReviewPercent}%`);
                $('#completedBar').css('width', `${completedPercent}%`);
            }

            // Function to update task card styling based on status
            function updateTaskCardStyling(taskElement, status) {
                const $taskCard = $(taskElement);
                const $card = $taskCard.find('.card');
                const $title = $taskCard.find('.task-title');
                const $departmentBadge = $taskCard.find('.department-badge');
                const $priorityBadge = $taskCard.find('.priority-badge');

                // Reset all styling classes
                $taskCard.removeClass('completed-task').css({ 'opacity': '', 'cursor': '' });
                $card.removeClass('bg-light');
                $title.removeClass('text-decoration-line-through');
                $departmentBadge.removeClass('light-success-bg light-info-bg light-secondary-bg');

                // Apply styling based on new status
                switch (status) {
                    case 'in_progress':
                        $departmentBadge.addClass('light-success-bg');
                        $taskCard.css('cursor', 'move');
                        break;
                    case 'needs_review':
                        $departmentBadge.addClass('light-info-bg');
                        $taskCard.css('cursor', 'move');
                        break;
                    case 'completed':
                        $departmentBadge.addClass('light-secondary-bg');
                        $taskCard.addClass('completed-task').css({ 'opacity': '0.8', 'cursor': 'default' });
                        $card.addClass('bg-light');
                        $title.addClass('text-decoration-line-through');
                        $priorityBadge.removeClass().addClass('badge bg-success text-end mt-2 priority-badge').text('HOÀN THÀNH');
                        break;
                }
            }

            // Function to check if user can move task to completed status
            function canMarkAsCompleted(taskElement) {
                const taskAssigneeId = parseInt(taskElement.getAttribute('data-assignee-id'));
                return isDepartmentHead || taskAssigneeId === currentUserId;
            }

            // Initialize Sortable for drag and drop
            const taskColumns = document.querySelectorAll('.task-column');

            taskColumns.forEach(column => {
                new Sortable(column, {
                    group: 'tasks',
                    animation: 150,
                    ghostClass: 'sortable-ghost',
                    chosenClass: 'sortable-chosen',
                    dragClass: 'sortable-drag',

                    // Only allow dragging of non-completed tasks
                    filter: '.completed-task, .empty-state',
                    preventOnFilter: true,

                    onStart: function (evt) {
                        // Add visual feedback when dragging starts
                        taskColumns.forEach(col => {
                            if (col !== evt.from) {
                                col.style.border = '2px dashed #007bff';
                                col.style.backgroundColor = 'rgba(0, 123, 255, 0.05)';
                            }
                        });

                        // Add dragging effect to the item
                        evt.item.style.opacity = '0.6';
                        evt.item.style.transform = 'rotate(3deg)';
                        evt.item.style.zIndex = '1000';
                    },

                    onEnd: function (evt) {
                        // Remove visual feedback
                        taskColumns.forEach(col => {
                            col.style.border = '2px dashed transparent';
                            col.style.backgroundColor = '';
                        });

                        // Reset item styling
                        evt.item.style.opacity = '';
                        evt.item.style.transform = '';
                        evt.item.style.zIndex = '';

                        // Only process if item was moved to a different column
                        if (evt.from !== evt.to) {
                            const taskId = evt.item.getAttribute('data-task-id');
                            const newStatus = evt.to.getAttribute('data-status');
                            const oldStatus = evt.item.getAttribute('data-current-status');

                            console.log(`Attempting to move task ${taskId} from ${oldStatus} to ${newStatus}`);

                            // Check permission for completed status
                            if (newStatus === 'completed' && !canMarkAsCompleted(evt.item)) {
                                // Move back to original position
                                if (evt.oldIndex >= evt.from.children.length) {
                                    evt.from.appendChild(evt.item);
                                } else {
                                    evt.from.insertBefore(evt.item, evt.from.children[evt.oldIndex] || null);
                                }

                                showAlert('error', 'Không thể di chuyển!', 'Chỉ người được giao việc hoặc trưởng phòng mới có thể đánh dấu hoàn thành.');
                                return;
                            }

                            // Store original position for potential rollback
                            const originalParent = evt.from;
                            const originalIndex = evt.oldIndex;

                            // Update task status
                            updateTaskStatus(taskId, newStatus, oldStatus, evt.item, originalParent, originalIndex);
                        }
                    },

                    onMove: function (evt) {
                        // Prevent moving completed tasks
                        const draggedTask = evt.dragged;
                        const currentStatus = draggedTask.getAttribute('data-current-status');

                        if (currentStatus === 'completed') {
                            return false;
                        }

                        // Prevent dropping into empty states
                        if (evt.related.classList.contains('empty-state')) {
                            return false;
                        }

                        return true;
                    }
                });
            });

            // Function to update task status via AJAX
            function updateTaskStatus(taskId, newStatus, oldStatus, taskElement, originalParent, originalIndex) {
                // Show loading
                $('#loadingOverlay').show();

                $.ajax({
                    url: `/tasks/${taskId}/status`,
                    type: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    data: JSON.stringify({
                        status: newStatus
                    }),
                    success: function (response) {
                        console.log('Success response:', response);

                        // Update the task element's data attribute
                        taskElement.setAttribute('data-current-status', newStatus);

                        // Update visual styling based on new status
                        updateTaskCardStyling(taskElement, newStatus);

                        // Update column counts and statistics
                        updateColumnCounts();

                        // Show success message
                        showAlert('success', 'Thành công!', response.message || 'Cập nhật trạng thái thành công!');
                    },
                    error: function (xhr) {
                        console.error('Error updating task status:', xhr);

                        // CRITICAL: Move task back to original position
                        try {
                            if (originalIndex >= originalParent.children.length) {
                                originalParent.appendChild(taskElement);
                            } else {
                                const referenceNode = originalParent.children[originalIndex];
                                originalParent.insertBefore(taskElement, referenceNode);
                            }
                        } catch (rollbackError) {
                            console.error('Error during rollback:', rollbackError);
                            // If rollback fails, reload the page
                            location.reload();
                            return;
                        }

                        let errorMessage = 'Có lỗi xảy ra khi cập nhật trạng thái.';

                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        } else if (xhr.status === 403) {
                            errorMessage = 'Bạn không có quyền cập nhật trạng thái task này.';
                        } else if (xhr.status === 422) {
                            errorMessage = 'Dữ liệu không hợp lệ.';
                        } else if (xhr.status === 500) {
                            errorMessage = 'Lỗi server. Vui lòng thử lại sau.';
                        } else if (xhr.status === 0) {
                            errorMessage = 'Mất kết nối mạng. Vui lòng kiểm tra kết nối.';
                        }

                        showAlert('error', 'Lỗi!', errorMessage);
                    },
                    complete: function () {
                        $('#loadingOverlay').hide();
                    }
                });
            }

            // Create task form submission
            $('#createTaskForm').submit(function (e) {
                e.preventDefault();

                const formData = new FormData(this);

                // Validate required fields
                const requiredFields = ['name', 'project_id', 'user_id', 'start_date', 'end_date'];
                let isValid = true;
                let errorMessages = [];

                requiredFields.forEach(function (field) {
                    const value = formData.get(field);
                    if (!value || value.trim() === '') {
                        isValid = false;
                        const fieldLabels = {
                            'name': 'Tên công việc',
                            'project_id': 'Dự án',
                            'user_id': 'Người thực hiện',
                            'start_date': 'Ngày bắt đầu',
                            'end_date': 'Ngày kết thúc'
                        };
                        errorMessages.push(`${fieldLabels[field]} là bắt buộc`);
                    }
                });

                // Validate dates
                const startDate = new Date(formData.get('start_date'));
                const endDate = new Date(formData.get('end_date'));
                if (startDate && endDate && endDate <= startDate) {
                    isValid = false;
                    errorMessages.push('Ngày kết thúc phải sau ngày bắt đầu');
                }

                if (!isValid) {
                    showAlert('error', 'Lỗi validation!', errorMessages.join('<br>'));
                    return;
                }

                // Show loading
                const submitBtn = $(this).find('button[type="submit"]');
                const originalText = submitBtn.text();
                submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Đang tạo...');

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        $('#createTask').modal('hide');
                        $('#createTaskForm')[0].reset();
                        $('#createUserSelect').html(createUserOptions);

                        showAlert('success', 'Thành công!', response.message || 'Tạo công việc thành công!');

                        // Reload page after delay to show new task
                        setTimeout(() => {
                            location.reload();
                        }, 1500);
                    },
                    error: function (xhr) {
                        console.error('Error creating task:', xhr);

                        let errorMessage = 'Có lỗi xảy ra khi tạo công việc.';

                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            const errors = xhr.responseJSON.errors;
                            errorMessage = 'Có lỗi xảy ra:<br>';
                            Object.keys(errors).forEach(key => {
                                errorMessage += `• ${errors[key][0]}<br>`;
                            });
                        } else if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        } else if (xhr.status === 500) {
                            errorMessage = 'Lỗi server. Vui lòng thử lại sau.';
                        } else if (xhr.status === 403) {
                            errorMessage = 'Bạn không có quyền thực hiện hành động này.';
                        }

                        showAlert('error', 'Lỗi tạo task!', errorMessage, 6000);
                    },
                    complete: function () {
                        submitBtn.prop('disabled', false).html(originalText);
                    }
                });
            });

            // Initialize drag and drop with improved error handling
            console.log('Initializing drag and drop functionality...');
        });

        // CSS for enhanced drag and drop visual feedback
        const style = document.createElement('style');
        style.textContent = `
        .sortable-ghost {
            opacity: 0.4;
            transform: rotate(5deg);
            background-color: rgba(0, 123, 255, 0.1);
        }

        .sortable-chosen {
            transform: scale(1.02);
            z-index: 1000;
            box-shadow: 0 8px 25px rgba(0,0,0,0.3) !important;
        }

        .sortable-drag {
            transform: rotate(5deg);
            opacity: 0.8;
        }

        .task-column:hover {
            background-color: rgba(0, 123, 255, 0.02) !important;
            transition: background-color 0.2s ease;
        }

        .task-column.drag-over {
            border: 2px dashed #007bff !important;
            background-color: rgba(0, 123, 255, 0.08) !important;
            transform: scale(1.01);
            transition: all 0.2s ease;
        }

        .draggable-task:hover:not(.completed-task) {
            transform: translateY(-2px);
            transition: transform 0.2s ease;
            box-shadow: 0 4px 15px rgba(0,0,0,0.15) !important;
        }

        .completed-task {
            pointer-events: none !important;
            cursor: default !important;
        }

        .completed-task:hover {
            transform: none !important;
        }

        .task-card {
            transition: all 0.2s ease;
        }

        .task-card.dragging {
            opacity: 0.6 !important;
            transform: rotate(3deg) scale(1.05) !important;
            z-index: 1000 !important;
            box-shadow: 0 8px 25px rgba(0,0,0,0.3) !important;
        }

        /* Loading states */
        .task-updating {
            pointer-events: none;
            opacity: 0.7;
        }

        .task-updating::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255,255,255,0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
        }

        /* Alert animations */
        .alert {
            animation: slideInRight 0.3s ease;
        }

        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        /* Responsive improvements */
        @media (max-width: 768px) {
            .task-column {
                margin-bottom: 20px;
            }

            .sortable-chosen {
                transform: scale(1.01);
            }

            #alertContainer {
                width: 280px !important;
                right: 10px !important;
            }
        }

        /* Enhanced visual feedback */
        .empty-state {
            pointer-events: none;
            user-select: none;
        }

        .task-card:not(.completed-task) {
            cursor: grab;
        }

        .task-card:not(.completed-task):active {
            cursor: grabbing;
        }

        /* Department badge styling */
        .light-success-bg {
            background-color: #d4edda !important;
            color: #155724 !important;
            border: 1px solid #c3e6cb;
        }

        .light-info-bg {
            background-color: #cce7ff !important;
            color: #004085 !important;
            border: 1px solid #abd7eb;
        }

        .light-secondary-bg {
            background-color: #e2e3e5 !important;
            color: #383d41 !important;
            border: 1px solid #ced4da;
        }

        .bg-lightgreen {
            background-color: #28a745 !important;
        }
    `;
        document.head.appendChild(style);

        // Debug logging for troubleshooting
        console.log('Task management interface initialized');
        console.log('Current user ID:', {{ Auth::id() }});
        console.log('Is department head:', {{ Auth::user()->isDepartmentHead() ? 'true' : 'false' }});
        console.log('Available task columns:', document.querySelectorAll('.task-column').length);
    </script>

@endsection

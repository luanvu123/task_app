@extends('layouts.app')

@section('content')

@php
    use App\Models\Task;
@endphp
    <div class="body d-flex py-lg-3 py-md-2">
        <div class="container-xxl">
            <div class="row align-items-center">
                <div class="border-0 mb-4">
                    <div
                        class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                        <h3 class="fw-bold mb-0">Quản Lý Công Việc</h3>
                        <div class="col-auto d-flex w-sm-100">
                            <button type="button" class="btn btn-dark btn-set-task w-sm-100" data-bs-toggle="modal"
                                data-bs-target="#createTask"><i class="icofont-plus-circle me-2 fs-6"></i>Tạo Công Việc Mới</button>
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
                                            <span class="small text-muted">{{ $taskStats['in_progress'] }}/{{ $taskStats['total'] }}</span>
                                        </div>
                                        <div class="progress" style="height: 10px;">
                                            <div class="progress-bar light-success-bg" role="progressbar"
                                                style="width: {{ $taskStats['total'] > 0 ? ($taskStats['in_progress'] / $taskStats['total']) * 100 : 0 }}%"></div>
                                        </div>
                                    </div>
                                    <div class="progress-count mb-4">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <h6 class="mb-0 fw-bold d-flex align-items-center">Cần Xem Xét</h6>
                                            <span class="small text-muted">{{ $taskStats['needs_review'] }}/{{ $taskStats['total'] }}</span>
                                        </div>
                                        <div class="progress" style="height: 10px;">
                                            <div class="progress-bar light-info-bg" role="progressbar"
                                                style="width: {{ $taskStats['total'] > 0 ? ($taskStats['needs_review'] / $taskStats['total']) * 100 : 0 }}%"></div>
                                        </div>
                                    </div>
                                    <div class="progress-count mb-4">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <h6 class="mb-0 fw-bold d-flex align-items-center">Hoàn Thành</h6>
                                            <span class="small text-muted">{{ $taskStats['completed'] }}/{{ $taskStats['total'] }}</span>
                                        </div>
                                        <div class="progress" style="height: 10px;">
                                            <div class="progress-bar bg-lightgreen" role="progressbar"
                                                style="width: {{ $taskStats['total'] > 0 ? ($taskStats['completed'] / $taskStats['total']) * 100 : 0 }}%"></div>
                                        </div>
                                    </div>
                                    <div class="progress-count mb-3">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <h6 class="mb-0 fw-bold d-flex align-items-center text-danger">Quá Hạn</h6>
                                            <span class="small text-muted">{{ $taskStats['overdue'] }}</span>
                                        </div>
                                        <div class="progress" style="height: 10px;">
                                            <div class="progress-bar bg-danger" role="progressbar"
                                                style="width: {{ $taskStats['total'] > 0 ? ($taskStats['overdue'] / $taskStats['total']) * 100 : 0 }}%"></div>
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
                                                <span class="avatar d-flex justify-content-center align-items-center rounded-circle light-success-bg">
                                                    {{ substr($task->assignee->name, 0, 2) }}
                                                </span>
                                                <div class="flex-fill ms-3">
                                                    <div class="mb-1"><strong>{{ $task->name }}</strong></div>
                                                    <span class="d-flex text-muted small">{{ $task->assignee->name }} • {{ $task->created_at->diffForHumans() }}</span>
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
                                                        <img src="{{ $user->image_url }}" class="avatar lg rounded-circle img-thumbnail" alt="avatar">
                                                    @else
                                                        <div class="avatar lg rounded-circle bg-secondary d-flex align-items-center justify-content-center">
                                                            <span class="text-white fw-bold">{{ substr($user->name, 0, 2) }}</span>
                                                        </div>
                                                    @endif
                                                    <div class="d-flex flex-column ps-2">
                                                        <h6 class="fw-bold mb-0">{{ $user->name }}</h6>
                                                        <span class="small text-muted">{{ $user->position ?? 'Nhân viên' }}</span>
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
                            <h6 class="fw-bold py-3 mb-0">Đang Thực Hiện ({{ $tasks['in_progress']->count() ?? 0 }})</h6>
                            <div class="progress_task">
                                <div class="dd" data-plugin="nestable">
                                    <ol class="dd-list">
                                        @forelse($tasks['in_progress'] ?? [] as $task)
                                            <li class="dd-item" data-id="{{ $task->id }}">
                                                <div class="dd-handle">
                                                    <div class="task-info d-flex align-items-center justify-content-between">
                                                        <h6 class="light-success-bg py-1 px-2 rounded-1 d-inline-block fw-bold small-14 mb-0">
                                                            {{ $task->project->department->name ?? '' }}
                                                        </h6>
                                                        <div class="task-priority d-flex flex-column align-items-center justify-content-center">
                                                            <div class="avatar-list avatar-list-stacked m-0">
                                                                @if($task->assignee->image)
                                                                    <img class="avatar rounded-circle small-avt" src="{{ $task->assignee->image_url }}" alt="">
                                                                @else
                                                                    <div class="avatar rounded-circle small-avt bg-secondary d-flex align-items-center justify-content-center">
                                                                        <span class="text-white small fw-bold">{{ substr($task->assignee->name, 0, 2) }}</span>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <span class="badge {{ $task->getPriorityBadgeColor() }} text-end mt-2">
                                                                {{ strtoupper(Task::getPriorities()[$task->priority]) }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <h6 class="fw-bold mt-2 mb-1">{{ $task->name }}</h6>
                                                    <p class="py-2 mb-0 small">{{ Str::limit($task->description, 100) }}</p>
                                                    <div class="tikit-info row g-3 align-items-center">
                                                        <div class="col-sm">
                                                            <ul class="d-flex list-unstyled align-items-center flex-wrap">
                                                                <li class="me-2">
                                                                    <div class="d-flex align-items-center">
                                                                        <i class="icofont-calendar"></i>
                                                                        <span class="ms-1">{{ $task->end_date->format('d/m') }}</span>
                                                                    </div>
                                                                </li>
                                                                @if($task->image_and_document)
                                                                    <li class="me-2">
                                                                        <div class="d-flex align-items-center">
                                                                            <i class="icofont-paper-clip"></i>
                                                                            <span class="ms-1">{{ count($task->image_and_document) }}</span>
                                                                        </div>
                                                                    </li>
                                                                @endif
                                                            </ul>
                                                        </div>
                                                          <div class="col-sm text-end">
                                                            <div class="small text-truncate light-success-bg py-1 px-2 rounded-1 d-inline-block fw-bold small">
                                                                {{ $task->project->name }}
                                                            </div>
                                                        </div>
                                                        <div class="col-sm text-end">
                                                            <div class="dropdown">
                                                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                                    Hành động
                                                                </button>
                                                                <ul class="dropdown-menu">
                                                                    <li><a class="dropdown-item edit-task" href="#" data-id="{{ $task->id }}">Chỉnh sửa</a></li>
                                                                    <li><a class="dropdown-item delete-task" href="#" data-id="{{ $task->id }}">Xóa</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        @empty
                                            <li class="text-muted text-center py-4">Không có công việc nào</li>
                                        @endforelse
                                    </ol>
                                </div>
                            </div>
                        </div>

                        <!-- Needs Review Tasks -->
                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 mt-4">
                            <h6 class="fw-bold py-3 mb-0">Cần Xem Xét ({{ $tasks['needs_review']->count() ?? 0 }})</h6>
                            <div class="review_task">
                                <div class="dd" data-plugin="nestable">
                                    <ol class="dd-list">
                                        @forelse($tasks['needs_review'] ?? [] as $task)
                                            <li class="dd-item" data-id="{{ $task->id }}">
                                                <div class="dd-handle">
                                                    <div class="task-info d-flex align-items-center justify-content-between">
                                                        <h6 class="light-info-bg py-1 px-2 rounded-1 d-inline-block fw-bold small-14 mb-0">
                                                            {{ $task->project->department->name ?? '' }}
                                                        </h6>
                                                        <div class="task-priority d-flex flex-column align-items-center justify-content-center">
                                                            <div class="avatar-list avatar-list-stacked m-0">
                                                                @if($task->assignee->image)
                                                                    <img class="avatar rounded-circle small-avt" src="{{ $task->assignee->image_url }}" alt="">
                                                                @else
                                                                    <div class="avatar rounded-circle small-avt bg-secondary d-flex align-items-center justify-content-center">
                                                                        <span class="text-white small fw-bold">{{ substr($task->assignee->name, 0, 2) }}</span>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <span class="badge {{ $task->getPriorityBadgeColor() }} text-end mt-2">
                                                                {{ strtoupper(Task::getPriorities()[$task->priority]) }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <h6 class="fw-bold mt-2 mb-1">{{ $task->name }}</h6>
                                                    <p class="py-2 mb-0 small">{{ Str::limit($task->description, 100) }}</p>
                                                    <div class="tikit-info row g-3 align-items-center">
                                                        <div class="col-sm">
                                                            <ul class="d-flex list-unstyled align-items-center flex-wrap">
                                                                <li class="me-2">
                                                                    <div class="d-flex align-items-center">
                                                                        <i class="icofont-calendar"></i>
                                                                        <span class="ms-1">{{ $task->end_date->format('d/m') }}</span>
                                                                    </div>
                                                                </li>
                                                                @if($task->image_and_document)
                                                                    <li class="me-2">
                                                                        <div class="d-flex align-items-center">
                                                                            <i class="icofont-paper-clip"></i>
                                                                            <span class="ms-1">{{ count($task->image_and_document) }}</span>
                                                                        </div>
                                                                    </li>
                                                                @endif
                                                            </ul>
                                                        </div>
                                                          <div class="col-sm text-end">
                                                            <div class="small text-truncate light-success-bg py-1 px-2 rounded-1 d-inline-block fw-bold small">
                                                                {{ $task->project->name }}
                                                            </div>
                                                        </div>
                                                        <div class="col-sm text-end">
                                                            <div class="dropdown">
                                                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                                    Hành động
                                                                </button>
                                                                <ul class="dropdown-menu">
                                                                    <li><a class="dropdown-item edit-task" href="#" data-id="{{ $task->id }}">Chỉnh sửa</a></li>
                                                                    <li><a class="dropdown-item delete-task" href="#" data-id="{{ $task->id }}">Xóa</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        @empty
                                            <li class="text-muted text-center py-4">Không có công việc nào</li>
                                        @endforelse
                                    </ol>
                                </div>
                            </div>
                        </div>

                        <!-- Completed Tasks -->
                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 mt-4">
                            <h6 class="fw-bold py-3 mb-0">Hoàn Thành ({{ $tasks['completed']->count() ?? 0 }})</h6>
                            <div class="completed_task">
                                <div class="dd" data-plugin="nestable">
                                    <ol class="dd-list">
                                        @forelse($tasks['completed'] ?? [] as $task)
                                            <li class="dd-item" data-id="{{ $task->id }}">
                                                <div class="dd-handle">
                                                    <div class="task-info d-flex align-items-center justify-content-between">
                                                        <h6 class="light-secondary-bg py-1 px-2 rounded-1 d-inline-block fw-bold small-14 mb-0">
                                                            {{ $task->project->department->name ?? '' }}
                                                        </h6>
                                                        <div class="task-priority d-flex flex-column align-items-center justify-content-center">
                                                            <div class="avatar-list avatar-list-stacked m-0">
                                                                @if($task->assignee->image)
                                                                    <img class="avatar rounded-circle small-avt" src="{{ $task->assignee->image_url }}" alt="">
                                                                @else
                                                                    <div class="avatar rounded-circle small-avt bg-secondary d-flex align-items-center justify-content-center">
                                                                        <span class="text-white small fw-bold">{{ substr($task->assignee->name, 0, 2) }}</span>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <span class="badge bg-success text-end mt-2">HOÀN THÀNH</span>
                                                        </div>
                                                    </div>
                                                    <h6 class="fw-bold mt-2 mb-1">{{ $task->name }}</h6>
                                                    <p class="py-2 mb-0 small">{{ Str::limit($task->description, 100) }}</p>
                                                    <div class="tikit-info row g-3 align-items-center">
                                                        <div class="col-sm">
                                                            <ul class="d-flex list-unstyled align-items-center flex-wrap">
                                                                <li class="me-2">
                                                                    <div class="d-flex align-items-center">
                                                                        <i class="icofont-calendar"></i>
                                                                        <span class="ms-1">{{ $task->end_date->format('d/m') }}</span>
                                                                    </div>
                                                                </li>
                                                                @if($task->image_and_document)
                                                                    <li class="me-2">
                                                                        <div class="d-flex align-items-center">
                                                                            <i class="icofont-paper-clip"></i>
                                                                            <span class="ms-1">{{ count($task->image_and_document) }}</span>
                                                                        </div>
                                                                    </li>
                                                                @endif
                                                            </ul>
                                                        </div>
                                                        <div class="col-sm text-end">
                                                            <div class="small text-truncate light-success-bg py-1 px-2 rounded-1 d-inline-block fw-bold small">
                                                                {{ $task->project->name }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        @empty
                                            <li class="text-muted text-center py-4">Không có công việc nào</li>
                                        @endforelse
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tạo Task -->
    <div class="modal fade" id="createTask" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tạo Công Việc Mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="createTaskForm" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Tên Công Việc <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Chọn Dự Án <span class="text-danger">*</span></label>
                            <select class="form-select" name="project_id" id="projectSelect" required>
                                <option value="">-- Chọn dự án --</option>
                                @foreach($projects as $project)
                                    <option value="{{ $project->id }}">{{ $project->name }} ({{ $project->department->name ?? '' }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Giao Cho <span class="text-danger">*</span></label>
                            <select class="form-select" name="user_id" id="userSelect" required>
                                <option value="">-- Chọn người thực hiện --</option>
                            </select>
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
                            <textarea class="form-control" name="description" rows="3" placeholder="Mô tả chi tiết về công việc..."></textarea>
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

    <!-- Modal Chỉnh Sửa Task -->
    <div class="modal fade" id="editTask" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Chỉnh Sửa Công Việc</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editTaskForm" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="editTaskId" name="task_id">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Tên Công Việc <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="editTaskName" name="name" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Chọn Dự Án <span class="text-danger">*</span></label>
                            <select class="form-select" id="editProjectSelect" name="project_id" required>
                                <option value="">-- Chọn dự án --</option>
                                @foreach($projects as $project)
                                    <option value="{{ $project->id }}">{{ $project->name }} ({{ $project->department->name ?? '' }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Giao Cho <span class="text-danger">*</span></label>
                            <select class="form-select" id="editUserSelect" name="user_id" required>
                                <option value="">-- Chọn người thực hiện --</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Trạng Thái <span class="text-danger">*</span></label>
                            <select class="form-select" id="editTaskStatus" name="status" required>
                                <option value="in_progress">Đang Thực Hiện</option>
                                <option value="needs_review">Cần Xem Xét</option>
                                <option value="completed">Hoàn Thành</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tài Liệu & Hình Ảnh</label>
                            <input class="form-control" type="file" name="image_and_document[]" multiple>
                            <small class="text-muted">Hỗ trợ: JPG, PNG, PDF, DOC, DOCX (tối đa 5MB mỗi file)</small>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Ngày Bắt Đầu <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="editStartDate" name="start_date" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Ngày Kết Thúc <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="editEndDate" name="end_date" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Độ Ưu Tiên <span class="text-danger">*</span></label>
                            <select class="form-select" id="editTaskPriority" name="priority" required>
                                <option value="low">Thấp</option>
                                <option value="medium">Trung Bình</option>
                                <option value="high">Cao</option>
                                <option value="urgent">Khẩn Cấp</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Mô Tả</label>
                            <textarea class="form-control" id="editTaskDescription" name="description" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-primary">Cập Nhật</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Xóa Task -->
    <div class="modal fade" id="deleteTask" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold text-danger">Xóa Công Việc</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <i class="icofont-ui-delete text-danger display-2 mb-3"></i>
                    <h6>Bạn có chắc chắn muốn xóa công việc này?</h6>
                    <p class="text-muted">Hành động này không thể hoàn tác!</p>
                    <input type="hidden" id="deleteTaskId">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">Xóa</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Load project members when project is selected
            $('#projectSelect, #editProjectSelect').change(function() {
                const projectId = $(this).val();
                const userSelect = $(this).attr('id') === 'projectSelect' ? '#userSelect' : '#editUserSelect';

                $(userSelect).html('<option value="">-- Đang tải... --</option>');

                if (projectId) {
                    $.get(`/projects/${projectId}/members`)
                        .done(function(members) {
                            let options = '<option value="">-- Chọn người thực hiện --</option>';
                            members.forEach(function(member) {
                                options += `<option value="${member.id}">${member.name} (${member.position || 'Nhân viên'})</option>`;
                            });
                            $(userSelect).html(options);
                        })
                        .fail(function() {
                            $(userSelect).html('<option value="">-- Lỗi khi tải dữ liệu --</option>');
                        });
                } else {
                    $(userSelect).html('<option value="">-- Chọn người thực hiện --</option>');
                }
            });

            // Create task form
            $('#createTaskForm').submit(function(e) {
                e.preventDefault();

                const formData = new FormData(this);

                $.ajax({
                    url: '{{ route("tasks.store") }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('#createTask').modal('hide');
                        $('#createTaskForm')[0].reset();

                        Swal.fire({
                            icon: 'success',
                            title: 'Thành công!',
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function(xhr) {
                        const errors = xhr.responseJSON.errors;
                        let errorMessage = 'Có lỗi xảy ra:\n';

                        Object.keys(errors).forEach(key => {
                            errorMessage += `${errors[key][0]}\n`;
                        });

                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi!',
                            text: errorMessage
                        });
                    }
                });
            });

            // Edit task
            $(document).on('click', '.edit-task', function(e) {
                e.preventDefault();
                const taskId = $(this).data('id');

                $.get(`/tasks/${taskId}`)
                    .done(function(task) {
                        $('#editTaskId').val(task.id);
                        $('#editTaskName').val(task.name);
                        $('#editProjectSelect').val(task.project_id).trigger('change');
                        $('#editTaskStatus').val(task.status);
                        $('#editStartDate').val(task.start_date);
                        $('#editEndDate').val(task.end_date);
                        $('#editTaskPriority').val(task.priority);
                        $('#editTaskDescription').val(task.description);

                        // Load project members and select assigned user
                        setTimeout(() => {
                            $('#editUserSelect').val(task.user_id);
                        }, 500);

                        $('#editTask').modal('show');
                    })
                    .fail(function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi!',
                            text: 'Không thể tải thông tin công việc'
                        });
                    });
            });

            // Update task form
            $('#editTaskForm').submit(function(e) {
                e.preventDefault();

                const taskId = $('#editTaskId').val();
                const formData = new FormData(this);

                $.ajax({
                    url: `/tasks/${taskId}`,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('#editTask').modal('hide');

                        Swal.fire({
                            icon: 'success',
                            title: 'Thành công!',
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function(xhr) {
                        const errors = xhr.responseJSON.errors;
                        let errorMessage = 'Có lỗi xảy ra:\n';

                        Object.keys(errors).forEach(key => {
                            errorMessage += `${errors[key][0]}\n`;
                        });

                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi!',
                            text: errorMessage
                        });
                    }
                });
            });

            // Delete task
            $(document).on('click', '.delete-task', function(e) {
                e.preventDefault();
                const taskId = $(this).data('id');
                $('#deleteTaskId').val(taskId);
                $('#deleteTask').modal('show');
            });

            $('#confirmDelete').click(function() {
                const taskId = $('#deleteTaskId').val();

                $.ajax({
                    url: `/tasks/${taskId}`,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('#deleteTask').modal('hide');

                        Swal.fire({
                            icon: 'success',
                            title: 'Thành công!',
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi!',
                            text: 'Không thể xóa công việc'
                        });
                    }
                });
            });
        });
    </script>

@endsection

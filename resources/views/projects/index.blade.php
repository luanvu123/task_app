@extends('layouts.app')

@section('content')
<div class="body d-flex py-lg-3 py-md-2">
    <div class="container-xxl">
        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row align-items-center">
            <div class="border-0 mb-4">
                <div class="card-header p-0 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                    <h3 class="fw-bold py-3 mb-0">Dự án</h3>
                    <div class="d-flex py-2 project-tab flex-wrap w-sm-100">
                        <button type="button" class="btn btn-dark w-sm-100" data-bs-toggle="modal"
                            data-bs-target="#createproject">
                            <i class="icofont-plus-circle me-2 fs-6"></i>Tạo dự án
                        </button>
                        <ul class="nav nav-tabs tab-body-header rounded ms-3 prtab-set w-sm-100" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#All-list" role="tab">Tất cả</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#Planning-list" role="tab">Lên kế hoạch</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#InProgress-list" role="tab">Đang thực hiện</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#Completed-list" role="tab">Hoàn thành</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row align-items-center">
            <div class="col-lg-12 col-md-12 flex-column">
                <div class="tab-content mt-4">
                    <!-- All Projects Tab -->
                    <div class="tab-pane fade show active" id="All-list">
                        <div class="row g-3 gy-5 py-3 row-deck">
                            @foreach($projects as $project)
                                @include('projects.partials.project-card', ['project' => $project])
                            @endforeach
                        </div>
                    </div>

                    <!-- Planning Projects Tab -->
                    <div class="tab-pane fade" id="Planning-list">
                        <div class="row g-3 gy-5 py-3 row-deck">
                            @foreach($projects->where('status', 'planning') as $project)
                                @include('projects.partials.project-card', ['project' => $project])
                            @endforeach
                        </div>
                    </div>

                    <!-- In Progress Projects Tab -->
                    <div class="tab-pane fade" id="InProgress-list">
                        <div class="row g-3 gy-5 py-3 row-deck">
                            @foreach($projects->where('status', 'in_progress') as $project)
                                @include('projects.partials.project-card', ['project' => $project])
                            @endforeach
                        </div>
                    </div>

                    <!-- Completed Projects Tab -->
                    <div class="tab-pane fade" id="Completed-list">
                        <div class="row g-3 gy-5 py-3 row-deck">
                            @foreach($projects->where('status', 'completed') as $project)
                                @include('projects.partials.project-card', ['project' => $project])
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create Project Modal -->
<div class="modal fade" id="createproject" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <form action="{{ route('projects.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tạo dự án mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                    <div class="mb-3">
                        <label for="project_name" class="form-label">Tên dự án</label>
                        <input type="text" class="form-control" id="project_name" name="name"
                               placeholder="Nhập tên dự án" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Phòng ban</label>
                        <select class="form-select" name="department_id" required>
                            <option value="">Chọn phòng ban</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Quản lý dự án</label>
                        <select class="form-select" name="manager_id" required>
                            <option value="">Chọn quản lý</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="project_images" class="form-label">Hình ảnh & Tài liệu</label>
                        <input class="form-control" type="file" name="images[]" multiple
                               accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx">
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col">
                            <label class="form-label">Ngày bắt đầu</label>
                            <input type="date" class="form-control" name="start_date" required>
                        </div>
                        <div class="col">
                            <label class="form-label">Ngày kết thúc</label>
                            <input type="date" class="form-control" name="end_date" required>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-sm-12">
                            <label class="form-label">Thông báo gửi đến</label>
                            <select class="form-select" name="notification_sent" required>
                                @foreach(App\Models\Project::getNotificationTypes() as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-12">
                            <label class="form-label">Thành viên tham gia</label>
                            <select class="form-select" multiple name="member_ids[]">
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-sm">
                            <label class="form-label">Ngân sách (VNĐ)</label>
                            <input type="number" class="form-control" name="budget" min="0" step="1000">
                        </div>
                        <div class="col-sm">
                            <label class="form-label">Độ ưu tiên</label>
                            <select class="form-select" name="priority" required>
                                @foreach(App\Models\Project::getPriorities() as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Mô tả (tùy chọn)</label>
                        <textarea class="form-control" name="description" rows="3"
                                  placeholder="Thêm mô tả chi tiết về dự án"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Tạo dự án</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Project Modal -->
<div class="modal fade" id="editproject" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <form id="edit-project-form" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Chỉnh sửa dự án</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                    <input type="hidden" id="edit_project_id" name="project_id">

                    <div class="mb-3">
                        <label class="form-label">Tên dự án</label>
                        <input type="text" class="form-control" id="edit_project_name" name="name" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Phòng ban</label>
                        <select class="form-select" id="edit_department_id" name="department_id" required>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Quản lý dự án</label>
                        <select class="form-select" id="edit_manager_id" name="manager_id" required>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Hình ảnh & Tài liệu mới</label>
                        <input class="form-control" type="file" name="images[]" multiple
                               accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx">
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col">
                            <label class="form-label">Ngày bắt đầu</label>
                            <input type="date" class="form-control" id="edit_start_date" name="start_date" required>
                        </div>
                        <div class="col">
                            <label class="form-label">Ngày kết thúc</label>
                            <input type="date" class="form-control" id="edit_end_date" name="end_date" required>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-sm-12">
                            <label class="form-label">Trạng thái</label>
                            <select class="form-select" id="edit_status" name="status" required>
                                @foreach(App\Models\Project::getStatuses() as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-12">
                            <label class="form-label">Thông báo gửi đến</label>
                            <select class="form-select" id="edit_notification_sent" name="notification_sent" required>
                                @foreach(App\Models\Project::getNotificationTypes() as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-12">
                            <label class="form-label">Thành viên tham gia</label>
                            <select class="form-select" id="edit_member_ids" multiple name="member_ids[]">
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-sm">
                            <label class="form-label">Ngân sách (VNĐ)</label>
                            <input type="number" class="form-control" id="edit_budget" name="budget" min="0" step="1000">
                        </div>
                        <div class="col-sm">
                            <label class="form-label">Độ ưu tiên</label>
                            <select class="form-select" id="edit_priority" name="priority" required>
                                @foreach(App\Models\Project::getPriorities() as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Mô tả</label>
                        <textarea class="form-control" id="edit_description" name="description" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Project Modal -->
<div class="modal fade" id="deleteproject" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable">
        <div class="modal-content">
            <form id="delete-project-form" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Xóa dự án vĩnh viễn?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body justify-content-center flex-column d-flex">
                    <i class="icofont-ui-delete text-danger display-2 text-center mt-2"></i>
                    <p class="mt-4 fs-5 text-center">Bạn chỉ có thể xóa dự án này vĩnh viễn</p>
                    <p class="text-center">Tên dự án: <strong id="delete_project_name"></strong></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-danger">Xóa</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Edit Project Modal
    document.querySelectorAll('[data-bs-target="#editproject"]').forEach(button => {
        button.addEventListener('click', function() {
            const projectId = this.getAttribute('data-project-id');
            const projectName = this.getAttribute('data-project-name');
            const departmentId = this.getAttribute('data-department-id');
            const managerId = this.getAttribute('data-manager-id');
            const startDate = this.getAttribute('data-start-date');
            const endDate = this.getAttribute('data-end-date');
            const budget = this.getAttribute('data-budget');
            const priority = this.getAttribute('data-priority');
            const status = this.getAttribute('data-status');
            const notificationSent = this.getAttribute('data-notification-sent');
            const description = this.getAttribute('data-description');
            const memberIds = JSON.parse(this.getAttribute('data-member-ids') || '[]');

            // Set form action
            document.getElementById('edit-project-form').action = `/projects/${projectId}`;

            // Fill form fields
            document.getElementById('edit_project_id').value = projectId;
            document.getElementById('edit_project_name').value = projectName;
            document.getElementById('edit_department_id').value = departmentId;
            document.getElementById('edit_manager_id').value = managerId;
            document.getElementById('edit_start_date').value = startDate;
            document.getElementById('edit_end_date').value = endDate;
            document.getElementById('edit_budget').value = budget;
            document.getElementById('edit_priority').value = priority;
            document.getElementById('edit_status').value = status;
            document.getElementById('edit_notification_sent').value = notificationSent;
            document.getElementById('edit_description').value = description;

            // Set selected members
            const memberSelect = document.getElementById('edit_member_ids');
            Array.from(memberSelect.options).forEach(option => {
                option.selected = memberIds.includes(parseInt(option.value));
            });
        });
    });

    // Delete Project Modal
    document.querySelectorAll('[data-bs-target="#deleteproject"]').forEach(button => {
        button.addEventListener('click', function() {
            const projectId = this.getAttribute('data-project-id');
            const projectName = this.getAttribute('data-project-name');

            // Set form action
            document.getElementById('delete-project-form').action = `/projects/${projectId}`;

            // Set project name in modal
            document.getElementById('delete_project_name').textContent = projectName;
        });
    });
});
</script>
@endsection




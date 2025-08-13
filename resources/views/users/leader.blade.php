@extends('layouts.app')

@section('title', 'Danh Sách Trưởng Phòng')

@section('content')
    <div class="body d-flex py-lg-3 py-md-2">
        <div class="container-xxl">
            <div class="row align-items-center">
                <div class="border-0 mb-4">
                    <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                        <h3 class="fw-bold mb-0">Danh Sách Trưởng Phòng</h3>
                        <div class="d-flex py-2 project-tab flex-wrap w-sm-100">
                            <button type="button" class="btn btn-outline-primary me-2 mb-2" data-bs-toggle="modal" data-bs-target="#exportModal">
                                <i class="icofont-file-excel"></i> Xuất Excel
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row clearfix g-3">
                <div class="col-sm-12">
                    <div class="card mb-3">
                        <div class="card-body">
                            <table id="leaderTable" class="table table-hover align-middle mb-0" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Trưởng Phòng</th>
                                        <th>Phòng Ban</th>
                                        <th>Dự Án Gần Nhất</th>
                                        <th>Tổng Công Việc</th>
                                        <th>Email</th>
                                        <th>Ngày Phân Công</th>
                                        <th>Nhân Viên Quản Lý</th>
                                        <th>Trạng Thái</th>
                                        <th>Thao Tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($leaders as $leader)
                                        <tr>
                                            <td>
                                                <img class="avatar rounded-circle"
                                                     src="{{ $leader->image ? asset('storage/' . $leader->image) : asset('assets/images/xs/avatar3.jpg') }}"
                                                     alt="{{ $leader->name }}"
                                                     onerror="this.src='{{ asset('assets/images/xs/avatar3.jpg') }}'"
                                                     style="width: 40px; height: 40px; object-fit: cover;">
                                                <span class="fw-bold ms-1">{{ $leader->name }}</span>
                                            </td>
                                            <td>
                                                @if($leader->managedDepartment)
                                                    <span class="badge bg-info">{{ $leader->managedDepartment->name }}</span>
                                                @else
                                                    <span class="text-muted">Chưa có phòng ban</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($leader->latest_project)
                                                    <a href="#" class="text-primary">{{ $leader->latest_project->name }}</a>
                                                    <small class="d-block text-muted">
                                                        {{ $leader->latest_project->created_at ? $leader->latest_project->created_at->format('d/m/Y') : '' }}
                                                    </small>
                                                @else
                                                    <span class="text-muted">Chưa có dự án</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-secondary">{{ $leader->task_count ?? 0 }} Công việc</span>
                                            </td>
                                            <td>
                                                <a href="mailto:{{ $leader->email }}">{{ $leader->email }}</a>
                                            </td>
                                            <td>
                                                {{ $leader->created_at ? $leader->created_at->format('d/m/Y') : '' }}
                                            </td>
                                            <td>
                                                @if($leader->managedDepartment && ($leader->staff_count ?? 0) > 0)
                                                    <div class="avatar-list avatar-list-stacked px-3">
                                                        @foreach($leader->managedDepartment->employees->take(4) as $employee)
                                                            <img class="avatar rounded-circle sm"
                                                                 src="{{ $employee->image ? asset('storage/' . $employee->image) : asset('assets/images/xs/avatar3.jpg') }}"
                                                                 alt="{{ $employee->name }}"
                                                                 title="{{ $employee->name }}"
                                                                 onerror="this.src='{{ asset('assets/images/xs/avatar3.jpg') }}'"
                                                                 style="width: 30px; height: 30px; object-fit: cover; margin-left: -5px;">
                                                        @endforeach

                                                        @if(($leader->staff_count ?? 0) > 4)
                                                            <span class="avatar rounded-circle text-center sm bg-primary text-white"
                                                                  style="width: 30px; height: 30px; line-height: 30px; font-size: 12px;">
                                                                +{{ $leader->staff_count - 4 }}
                                                            </span>
                                                        @endif

                                                        <span class="avatar rounded-circle text-center pointer sm border"
                                                              data-bs-toggle="modal" data-bs-target="#staffModal"
                                                              data-leader-id="{{ $leader->id }}"
                                                              data-leader-name="{{ $leader->name }}"
                                                              title="Xem tất cả nhân viên"
                                                              style="width: 30px; height: 30px; line-height: 28px; cursor: pointer;">
                                                            <i class="icofont-eye"></i>
                                                        </span>
                                                    </div>
                                                @else
                                                    <span class="text-muted">Chưa có nhân viên</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $leader->status === 'active' ? 'success' : 'warning' }}">
                                                    {{ $leader->status === 'active' ? 'Hoạt động' : 'Không hoạt động' }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-outline-secondary btn-sm"
                                                            data-bs-toggle="modal" data-bs-target="#staffModal"
                                                            data-leader-id="{{ $leader->id }}"
                                                            data-leader-name="{{ $leader->name }}"
                                                            title="Xem nhân viên">
                                                        <i class="icofont-users text-primary"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-outline-secondary btn-sm"
                                                            onclick="editLeader({{ $leader->id }})" title="Chỉnh sửa">
                                                        <i class="icofont-edit text-success"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-outline-secondary btn-sm deleterow"
                                                            onclick="deleteLeader({{ $leader->id }})" title="Xóa">
                                                        <i class="icofont-ui-delete text-danger"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center py-4">
                                                <div class="d-flex flex-column align-items-center">
                                                    <i class="icofont-users-alt-2 fs-1 text-muted mb-3"></i>
                                                    <h5 class="text-muted">Chưa có trưởng phòng nào</h5>
                                                    <p class="text-muted">Vui lòng thêm trưởng phòng để quản lý các phòng ban</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal hiển thị nhân viên của phòng ban -->
    <div class="modal fade" id="staffModal" tabindex="-1" aria-labelledby="staffModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="staffModalLabel">
                        <i class="icofont-users me-2"></i>Nhân Viên Phòng Ban
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h6 class="mb-1">Trưởng phòng: <span id="leaderName" class="text-primary"></span></h6>
                            <p class="text-muted mb-0">Danh sách nhân viên thuộc phòng ban</p>
                        </div>
                        <div>
                            <span class="badge bg-info" id="staffCount">0 nhân viên</span>
                        </div>
                    </div>

                    <div id="staffList" class="members_list">
                        <!-- Loading state -->
                        <div class="text-center py-4">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Đang tải...</span>
                            </div>
                        </div>
                    </div>

                    <!-- Thông tin dự án gần nhất -->
                    <div class="mt-4">
                        <h6 class="fw-bold mb-3">
                            <i class="icofont-tasks me-2"></i>Dự Án Gần Nhất
                        </h6>
                        <div id="latestProject" class="card bg-light">
                            <!-- Loading state -->
                            <div class="card-body text-center py-4">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Đang tải...</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary" id="manageStaffBtn">
                        <i class="icofont-ui-settings me-1"></i>Quản Lý Nhân Viên
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Global variables
    let leaderTable;

    $(document).ready(function() {
        // Kiểm tra các dependency
        if (typeof $ === 'undefined') {
            console.error('jQuery chưa được load!');
            showErrorMessage('Lỗi: jQuery chưa được tải. Vui lòng kiểm tra kết nối mạng.');
            return;
        }

        if (typeof $.fn.DataTable === 'undefined') {
            console.error('DataTables chưa được load!');
            showErrorMessage('Lỗi: DataTables chưa được tải. Vui lòng kiểm tra kết nối mạng.');
            return;
        }

        // Khởi tạo DataTable với error handling
        try {
            initializeDataTable();
            initializeModalEvents();
            console.log('Trang được khởi tạo thành công');
        } catch (error) {
            console.error('Lỗi khởi tạo:', error);
            showErrorMessage('Có lỗi xảy ra khi khởi tạo trang: ' + error.message);
        }
    });

    function initializeDataTable() {
        leaderTable = $('#leaderTable').DataTable({
            "processing": true,
            "language": {
                "processing": "Đang xử lý...",
                "search": "Tìm kiếm:",
                "lengthMenu": "Hiển thị _MENU_ mục",
                "info": "Hiển thị _START_ đến _END_ trong tổng số _TOTAL_ mục",
                "infoEmpty": "Hiển thị 0 đến 0 trong tổng số 0 mục",
                "infoFiltered": "(lọc từ _MAX_ mục)",
                "infoPostFix": "",
                "loadingRecords": "Đang tải...",
                "zeroRecords": "Không tìm thấy dữ liệu",
                "emptyTable": "Không có dữ liệu",
                "paginate": {
                    "first": "Đầu",
                    "previous": "Trước",
                    "next": "Tiếp",
                    "last": "Cuối"
                }
            },
            "order": [[0, "asc"]],
            "columnDefs": [
                { "orderable": false, "targets": [6, 8] }
            ],
            "pageLength": 10,
            "responsive": true,
            "error": function(xhr, error, code) {
                console.error('DataTable error:', error, code);
                showErrorMessage('Lỗi DataTable: ' + error);
            }
        });

        console.log('DataTable đã được khởi tạo thành công');
    }

    function initializeModalEvents() {
        // Xử lý khi mở modal nhân viên
        $('#staffModal').on('show.bs.modal', function(event) {
            try {
                const button = $(event.relatedTarget);
                const leaderId = button.data('leader-id');
                const leaderName = button.data('leader-name');

                if (!leaderId) {
                    throw new Error('Không tìm thấy ID trưởng phòng');
                }

                if (!leaderName) {
                    throw new Error('Không tìm thấy tên trưởng phòng');
                }

                $('#leaderName').text(leaderName);
                $('#manageStaffBtn').data('leader-id', leaderId);

                // Reset modal content
                resetModalContent();

                // Load dữ liệu
                loadStaffAndProject(leaderId);

            } catch (error) {
                console.error('Lỗi mở modal:', error);
                showModalError('Có lỗi xảy ra khi mở modal: ' + error.message);
            }
        });

        // Reset modal khi đóng
        $('#staffModal').on('hidden.bs.modal', function() {
            resetModalContent();
        });
    }

    function resetModalContent() {
        $('#leaderName').text('');
        $('#staffCount').text('0 nhân viên');
        $('#staffList').html(`
            <div class="text-center py-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Đang tải...</span>
                </div>
            </div>
        `);
        $('#latestProject').html(`
            <div class="card-body text-center py-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Đang tải...</span>
                </div>
            </div>
        `);
    }

    function loadStaffAndProject(leaderId) {
        if (!leaderId) {
            console.error('Leader ID không được cung cấp');
            showModalError('Lỗi: Không tìm thấy ID trưởng phòng');
            return;
        }

        // Kiểm tra CSRF token
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        if (!csrfToken) {
            console.error('CSRF token không tìm thấy');
            showModalError('Lỗi bảo mật: Không tìm thấy CSRF token');
            return;
        }

        // Gọi API
        $.ajax({
            url: `/users/leaders/${leaderId}/staff-and-project`,
            method: 'GET',
            dataType: 'json',
            timeout: 15000, // 15 seconds
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            beforeSend: function() {
                console.log(`Đang gửi request để load dữ liệu cho leader ID: ${leaderId}`);
            },
            success: function(response) {
                try {
                    console.log('Nhận được response:', response);

                    if (!response) {
                        throw new Error('Response rỗng');
                    }

                    if (!response.success) {
                        throw new Error(response.message || 'API trả về lỗi');
                    }

                    // Cập nhật số lượng nhân viên
                    const staffCount = response.staff_count || 0;
                    $('#staffCount').text(`${staffCount} nhân viên`);

                    // Hiển thị danh sách nhân viên
                    displayStaffList(response.staff || []);

                    // Hiển thị dự án gần nhất
                    displayLatestProject(response.latest_project);

                    console.log('Dữ liệu đã được hiển thị thành công');

                } catch (error) {
                    console.error('Lỗi xử lý response:', error);
                    showModalError('Lỗi xử lý dữ liệu: ' + error.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', {
                    xhr: xhr,
                    status: status,
                    error: error,
                    responseText: xhr.responseText
                });

                let errorMessage = 'Không thể tải dữ liệu';

                if (xhr.status === 404) {
                    errorMessage = 'Không tìm thấy thông tin trưởng phòng';
                } else if (xhr.status === 500) {
                    errorMessage = 'Lỗi server khi tải dữ liệu';
                } else if (xhr.status === 0) {
                    errorMessage = 'Không thể kết nối đến server';
                } else if (status === 'timeout') {
                    errorMessage = 'Quá thời gian chờ phản hồi';
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }

                showModalError(errorMessage);
            }
        });
    }

    function displayStaffList(staffList) {
        let staffHtml = '';

        if (staffList && staffList.length > 0) {
            staffHtml = '<ul class="list-unstyled list-group list-group-flush mb-0">';

            staffList.forEach(function(staff) {
                // Escape HTML để tránh XSS
                const staffName = $('<div>').text(staff.name || 'Không có tên').html();
                const staffEmail = $('<div>').text(staff.email || 'Không có email').html();
                const staffPosition = $('<div>').text(staff.position || 'Chưa có chức vụ').html();
                const staffStatusText = $('<div>').text(staff.status_text || 'Không xác định').html();
                const taskCount = parseInt(staff.task_count) || 0;

                // Xác định class cho trạng thái
                const statusClass = staff.status === 'active' ? 'success' : 'warning';

                staffHtml += `
                <li class="list-group-item py-3 d-flex align-items-center">
                    <div class="me-3">
                        <img class="avatar lg rounded-circle"
                             src="${staff.image_url || '{{ asset('assets/images/xs/avatar3.jpg') }}'}"
                             alt="${staffName}"
                             onerror="this.src='{{ asset('assets/images/xs/avatar3.jpg') }}'"
                             style="width: 50px; height: 50px; object-fit: cover;">
                    </div>
                    <div class="flex-fill">
                        <h6 class="mb-1 fw-bold">${staffName}</h6>
                        <span class="text-muted">${staffEmail}</span>
                        <br>
                        <small class="text-info">${staffPosition}</small>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-${statusClass}">
                            ${staffStatusText}
                        </span>
                        <br>
                        <small class="text-muted">
                            ${taskCount} công việc
                        </small>
                    </div>
                </li>`;
            });

            staffHtml += '</ul>';
        } else {
            staffHtml = `
            <div class="text-center py-4">
                <i class="icofont-users-alt-2 fs-1 text-muted mb-3"></i>
                <p class="text-muted">Phòng ban chưa có nhân viên</p>
            </div>`;
        }

        $('#staffList').html(staffHtml);
    }

    function displayLatestProject(project) {
        let projectHtml = '';

        if (project && project !== null) {
            const statusClasses = {
                'planning': 'info',
                'in_progress': 'primary',
                'on_hold': 'warning',
                'completed': 'success',
                'cancelled': 'danger'
            };

            // Escape HTML
            const projectName = $('<div>').text(project.name || 'Không có tên').html();
            const projectDesc = $('<div>').text(project.description || 'Không có mô tả').html();
            const statusText = $('<div>').text(project.status_text || 'Không xác định').html();

            const statusClass = statusClasses[project.status] || 'secondary';
            const completionPercentage = parseInt(project.completion_percentage) || 0;

            projectHtml = `
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <h6 class="card-title mb-0">${projectName}</h6>
                    <span class="badge bg-${statusClass}">${statusText}</span>
                </div>
                <p class="card-text text-muted">${projectDesc}</p>
                <div class="row g-2">
                    <div class="col-md-6">
                        <small class="text-muted">Ngày bắt đầu:</small>
                        <br>
                        <strong>${project.start_date_formatted || 'Chưa xác định'}</strong>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted">Ngày kết thúc:</small>
                        <br>
                        <strong>${project.end_date_formatted || 'Chưa xác định'}</strong>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted">Ngân sách:</small>
                        <br>
                        <strong class="text-success">${project.formatted_budget || '0 VNĐ'}</strong>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted">Tiến độ:</small>
                        <br>
                        <div class="progress" style="height: 20px;">
                            <div class="progress-bar bg-${statusClass}"
                                 role="progressbar"
                                 style="width: ${completionPercentage}%"
                                 aria-valuenow="${completionPercentage}"
                                 aria-valuemin="0"
                                 aria-valuemax="100">
                                ${completionPercentage}%
                            </div>
                        </div>
                    </div>
                </div>
            </div>`;
        } else {
            projectHtml = `
            <div class="card-body text-center py-4">
                <i class="icofont-tasks fs-1 text-muted mb-3"></i>
                <p class="text-muted">Phòng ban chưa có dự án nào</p>
            </div>`;
        }

        $('#latestProject').html(projectHtml);
    }

    function showModalError(message) {
        const errorHtml = `
        <div class="alert alert-danger" role="alert">
            <i class="icofont-warning me-2"></i>
            ${message}
        </div>`;

        $('#staffList').html(errorHtml);
        $('#latestProject').html(`
        <div class="card-body">
            <div class="alert alert-danger" role="alert">
                <i class="icofont-warning me-2"></i>
                Không thể tải thông tin dự án
            </div>
        </div>`);
    }

    function showErrorMessage(message) {
        // Hiển thị thông báo lỗi trên trang
        const alertHtml = `
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="icofont-warning me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>`;

        $('.container-xxl').prepend(alertHtml);
    }

    // Các hàm tiện ích
    function editLeader(leaderId) {
        if (!leaderId) {
            alert('Lỗi: Không tìm thấy ID trưởng phòng');
            return;
        }

        window.location.href = `/users/${leaderId}/edit`;
    }

    function deleteLeader(leaderId) {
        if (!leaderId) {
            alert('Lỗi: Không tìm thấy ID trưởng phòng');
            return;
        }

        if (!confirm('Bạn có chắc chắn muốn xóa trưởng phòng này không?')) {
            return;
        }

        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        if (!csrfToken) {
            alert('Lỗi bảo mật: Không tìm thấy CSRF token');
            return;
        }

        $.ajax({
            url: `/users/${leaderId}`,
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            beforeSend: function() {
                // Disable button để tránh click nhiều lần
                $(`.deleterow[onclick*="${leaderId}"]`).prop('disabled', true);
            },
            success: function(response) {
                alert('Đã xóa trưởng phòng thành công!');
                location.reload();
            },
            error: function(xhr, status, error) {
                console.error('Delete error:', {xhr, status, error});

                let errorMessage = 'Có lỗi xảy ra khi xóa trưởng phòng!';

                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                } else if (xhr.status === 403) {
                    errorMessage = 'Bạn không có quyền xóa trưởng phòng này!';
                } else if (xhr.status === 404) {
                    errorMessage = 'Không tìm thấy trưởng phòng cần xóa!';
                }

                alert(errorMessage);
            },
            complete: function() {
                // Re-enable button
                $(`.deleterow[onclick*="${leaderId}"]`).prop('disabled', false);
            }
        });
    }

    // Export functions to global scope
    window.editLeader = editLeader;
    window.deleteLeader = deleteLeader;
    window.loadStaffAndProject = loadStaffAndProject;
</script>
@endpush

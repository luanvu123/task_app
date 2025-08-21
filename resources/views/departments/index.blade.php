@extends('layouts.app')

@section('content')
<div class="body d-flex py-lg-3 py-md-2">
    <div class="container-xxl">
        <div class="row align-items-center">
            <div class="border-0 mb-4">
                <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                    <h3 class="fw-bold mb-0">Quản Lý Phòng Ban</h3>
                    <div class="col-auto d-flex w-sm-100">
                        <button type="button" class="btn btn-dark btn-set-task w-sm-100" data-bs-toggle="modal"
                            data-bs-target="#depadd"><i class="icofont-plus-circle me-2 fs-6"></i>Thêm Phòng Ban</button>
                    </div>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
            </div>
        @endif

        <div class="row clearfix g-3">
            <div class="col-sm-12">
                <div class="card mb-3">
                    <div class="card-body">
                        <table id="myProjectTable" class="table table-hover align-middle mb-0" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Trưởng Phòng</th>
                                    <th>Tên Phòng Ban</th>
                                    <th>Số Nhân Viên</th>
                                    <th>Trạng Thái</th>
                                    <th>Thao Tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($departments as $department)
                                <tr>
                                    <td>
                                        <span class="fw-bold">{{ $loop->iteration }}</span>
                                    </td>
                                    <td>
                                        @if($department->departmentHead)
                                            <img class="avatar rounded-circle" src="{{ asset('assets/images/xs/avatar1.jpg') }}" alt="">
                                            <span class="fw-bold ms-1">{{ $department->departmentHead->name }}</span>
                                        @else
                                            <span class="text-muted">Chưa có trưởng phòng</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $department->name }}
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $department->employee_count }} nhân viên</span>
                                    </td>
                                    <td>
                                        <span class="badge {{ $department->status == 'active' ? 'bg-success' : 'bg-secondary' }}">
                                            {{ $department->status == 'active' ? 'Hoạt động' : 'Tạm dừng' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Thao tác">
                                            <button type="button" class="btn btn-outline-secondary"
                                                data-bs-toggle="modal" data-bs-target="#depedit"
                                                onclick="editDepartment({{ $department->id }}, '{{ $department->name }}', '{{ $department->department_head_id }}', '{{ $department->status }}')"
                                                title="Chỉnh sửa">
                                                <i class="icofont-edit text-success"></i>
                                            </button>
                                            <form method="POST" action="{{ route('departments.destroy', $department->id) }}" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-secondary"
                                                    onclick="return confirm('Bạn có chắc chắn muốn xóa phòng ban này không?')"
                                                    title="Xóa">
                                                    <i class="icofont-ui-delete text-danger"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Department Modal -->
<div class="modal fade" id="depadd" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable">
        <div class="modal-content">
            <form method="POST" action="{{ route('departments.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="depaddLabel">Thêm Phòng Ban Mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="department_name" class="form-label">Tên Phòng Ban <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="department_name" name="name"
                               placeholder="Nhập tên phòng ban" required>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-sm-6">
                            <label for="department_head" class="form-label">Trưởng Phòng</label>
                            <select class="form-select" id="department_head" name="department_head_id">
                                <option value="">Chọn trưởng phòng</option>
                                @foreach(App\Models\User::all() as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label for="status" class="form-label">Trạng Thái <span class="text-danger">*</span></label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="active">Hoạt động</option>
                                <option value="inactive">Tạm dừng</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="icofont-plus-circle me-1"></i>Thêm Mới
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Department Modal -->
<div class="modal fade" id="depedit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable">
        <div class="modal-content">
            <form method="POST" id="editForm">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="depeditLabel">Chỉnh Sửa Phòng Ban</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_department_name" class="form-label">Tên Phòng Ban <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_department_name" name="name"
                               placeholder="Nhập tên phòng ban" required>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-sm-6">
                            <label for="edit_department_head" class="form-label">Trưởng Phòng</label>
                            <select class="form-select" id="edit_department_head" name="department_head_id">
                                <option value="">Chọn trưởng phòng</option>
                                @foreach(App\Models\User::all() as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label for="edit_status" class="form-label">Trạng Thái <span class="text-danger">*</span></label>
                            <select class="form-select" id="edit_status" name="status" required>
                                <option value="active">Hoạt động</option>
                                <option value="inactive">Tạm dừng</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-success">
                        <i class="icofont-save me-1"></i>Lưu Thay Đổi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function editDepartment(id, name, departmentHeadId, status) {
    document.getElementById('editForm').action = `/departments/${id}`;
    document.getElementById('edit_department_name').value = name;
    document.getElementById('edit_department_head').value = departmentHeadId || '';
    document.getElementById('edit_status').value = status;
}
</script>

@endsection

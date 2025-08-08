@extends('layouts.app')

@section('content')
<div class="body d-flex py-lg-3 py-md-2">
    <div class="container-xxl">
        <div class="row align-items-center">
            <div class="border-0 mb-4">
                <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                    <h3 class="fw-bold mb-0">Departments</h3>
                    <div class="col-auto d-flex w-sm-100">
                        <button type="button" class="btn btn-dark btn-set-task w-sm-100" data-bs-toggle="modal"
                            data-bs-target="#depadd"><i class="icofont-plus-circle me-2 fs-6"></i>Add
                            Departments</button>
                    </div>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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
                                    <th>Department Head</th>
                                    <th>Department Name</th>
                                    <th>Employee UnderWork</th>
                                    <th>Status</th>
                                    <th>Actions</th>
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
                                            <span class="text-muted">No head assigned</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $department->name }}
                                    </td>
                                    <td>
                                        {{ $department->employee_count }}
                                    </td>
                                    <td>
                                        <span class="badge {{ $department->status == 'active' ? 'bg-success' : 'bg-secondary' }}">
                                            {{ ucfirst($department->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Basic outlined example">
                                            <button type="button" class="btn btn-outline-secondary"
                                                data-bs-toggle="modal" data-bs-target="#depedit"
                                                onclick="editDepartment({{ $department->id }}, '{{ $department->name }}', '{{ $department->department_head_id }}', '{{ $department->status }}')">
                                                <i class="icofont-edit text-success"></i>
                                            </button>
                                            <form method="POST" action="{{ route('departments.destroy', $department->id) }}" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-secondary"
                                                    onclick="return confirm('Are you sure you want to delete this department?')">
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
                    <h5 class="modal-title fw-bold" id="depaddLabel">Department Add</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="department_name" class="form-label">Department Name</label>
                        <input type="text" class="form-control" id="department_name" name="name" required>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-sm-6">
                            <label for="department_head" class="form-label">Department Head</label>
                            <select class="form-select" id="department_head" name="department_head_id">
                                <option value="">Select Head</option>
                                @foreach(App\Models\User::all() as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add</button>
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
                    <h5 class="modal-title fw-bold" id="depeditLabel">Department Edit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_department_name" class="form-label">Department Name</label>
                        <input type="text" class="form-control" id="edit_department_name" name="name" required>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-sm-6">
                            <label for="edit_department_head" class="form-label">Department Head</label>
                            <select class="form-select" id="edit_department_head" name="department_head_id">
                                <option value="">Select Head</option>
                                @foreach(App\Models\User::all() as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label for="edit_status" class="form-label">Status</label>
                            <select class="form-select" id="edit_status" name="status" required>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
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

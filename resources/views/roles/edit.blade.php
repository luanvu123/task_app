@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Chỉnh Sửa Vai Trò</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary btn-sm mb-2" href="{{ route('roles.index') }}"><i class="fa fa-arrow-left"></i> Quay Lại</a>
        </div>
    </div>
</div>

@if (count($errors) > 0)
    <div class="alert alert-danger">
        <strong>Oops!</strong> Có một số vấn đề với dữ liệu nhập vào.<br><br>
        <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('roles.update', $role->id) }}">
    @csrf
    @method('PUT')

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group mb-4">
                <strong>Tên Vai Trò:</strong>
                <input type="text" name="name" placeholder="Nhập tên vai trò" class="form-control" value="{{ $role->name }}">
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <strong>Phân Quyền:</strong>
                    <div>
                        <button type="button" class="btn btn-sm btn-success" id="checkAll">Chọn Tất Cả</button>
                        <button type="button" class="btn btn-sm btn-warning" id="uncheckAll">Bỏ Chọn Tất Cả</button>
                    </div>
                </div>

                <!-- Permission Table -->
                <div class="table-responsive">
                    <table class="table table-bordered permission-table">
                        <thead class="table-primary">
                            <tr>
                                <th style="width: 200px;" class="text-center">CHỨC NĂNG</th>
                                <th class="text-center" style="width: 120px;">XEM</th>
                                <th class="text-center" style="width: 120px;">TẠO</th>
                                <th class="text-center" style="width: 120px;">SỬA</th>
                                <th class="text-center" style="width: 120px;">XÓA</th>
                                <th class="text-center">HÀNH ĐỘNG KHÁC</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Role Permissions -->
                            <tr>
                                <td class="fw-bold bg-light">Vai Trò</td>
                                <td class="text-center">
                                    @php $perm = $permission->where('name', 'role-list')->first(); @endphp
                                    @if($perm)
                                    <input type="checkbox" name="permission[{{$perm->id}}]" value="{{$perm->id}}"
                                           class="form-check-input permission-checkbox"
                                           {{ in_array($perm->id, $rolePermissions) ? 'checked' : ''}}>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @php $perm = $permission->where('name', 'role-create')->first(); @endphp
                                    @if($perm)
                                    <input type="checkbox" name="permission[{{$perm->id}}]" value="{{$perm->id}}"
                                           class="form-check-input permission-checkbox"
                                           {{ in_array($perm->id, $rolePermissions) ? 'checked' : ''}}>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @php $perm = $permission->where('name', 'role-edit')->first(); @endphp
                                    @if($perm)
                                    <input type="checkbox" name="permission[{{$perm->id}}]" value="{{$perm->id}}"
                                           class="form-check-input permission-checkbox"
                                           {{ in_array($perm->id, $rolePermissions) ? 'checked' : ''}}>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @php $perm = $permission->where('name', 'role-delete')->first(); @endphp
                                    @if($perm)
                                    <input type="checkbox" name="permission[{{$perm->id}}]" value="{{$perm->id}}"
                                           class="form-check-input permission-checkbox"
                                           {{ in_array($perm->id, $rolePermissions) ? 'checked' : ''}}>
                                    @endif
                                </td>
                                <td class="text-center text-muted">-</td>
                            </tr>

                            <!-- User Permissions -->
                            <tr>
                                <td class="fw-bold bg-light">Người Dùng</td>
                                <td class="text-center">
                                    @php $perm = $permission->where('name', 'user-list')->first(); @endphp
                                    @if($perm)
                                    <input type="checkbox" name="permission[{{$perm->id}}]" value="{{$perm->id}}"
                                           class="form-check-input permission-checkbox"
                                           {{ in_array($perm->id, $rolePermissions) ? 'checked' : ''}}>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @php $perm = $permission->where('name', 'user-create')->first(); @endphp
                                    @if($perm)
                                    <input type="checkbox" name="permission[{{$perm->id}}]" value="{{$perm->id}}"
                                           class="form-check-input permission-checkbox"
                                           {{ in_array($perm->id, $rolePermissions) ? 'checked' : ''}}>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @php $perm = $permission->where('name', 'user-edit')->first(); @endphp
                                    @if($perm)
                                    <input type="checkbox" name="permission[{{$perm->id}}]" value="{{$perm->id}}"
                                           class="form-check-input permission-checkbox"
                                           {{ in_array($perm->id, $rolePermissions) ? 'checked' : ''}}>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @php $perm = $permission->where('name', 'user-delete')->first(); @endphp
                                    @if($perm)
                                    <input type="checkbox" name="permission[{{$perm->id}}]" value="{{$perm->id}}"
                                           class="form-check-input permission-checkbox"
                                           {{ in_array($perm->id, $rolePermissions) ? 'checked' : ''}}>
                                    @endif
                                </td>
                                <td class="text-center text-muted">-</td>
                            </tr>

                            <!-- Project Permissions -->
                            <tr>
                                <td class="fw-bold bg-light">Dự Án</td>
                                <td class="text-center">
                                    @php $perm = $permission->where('name', 'project-list')->first(); @endphp
                                    @if($perm)
                                    <input type="checkbox" name="permission[{{$perm->id}}]" value="{{$perm->id}}"
                                           class="form-check-input permission-checkbox"
                                           {{ in_array($perm->id, $rolePermissions) ? 'checked' : ''}}>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @php $perm = $permission->where('name', 'project-create')->first(); @endphp
                                    @if($perm)
                                    <input type="checkbox" name="permission[{{$perm->id}}]" value="{{$perm->id}}"
                                           class="form-check-input permission-checkbox"
                                           {{ in_array($perm->id, $rolePermissions) ? 'checked' : ''}}>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @php $perm = $permission->where('name', 'project-edit')->first(); @endphp
                                    @if($perm)
                                    <input type="checkbox" name="permission[{{$perm->id}}]" value="{{$perm->id}}"
                                           class="form-check-input permission-checkbox"
                                           {{ in_array($perm->id, $rolePermissions) ? 'checked' : ''}}>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @php $perm = $permission->where('name', 'project-delete')->first(); @endphp
                                    @if($perm)
                                    <input type="checkbox" name="permission[{{$perm->id}}]" value="{{$perm->id}}"
                                           class="form-check-input permission-checkbox"
                                           {{ in_array($perm->id, $rolePermissions) ? 'checked' : ''}}>
                                    @endif
                                </td>
                                <td class="text-center text-muted">-</td>
                            </tr>

                            <!-- Task Permissions -->
                            <tr>
                                <td class="fw-bold bg-light">Nhiệm Vụ</td>
                                <td class="text-center">
                                    @php $perm = $permission->where('name', 'task-list')->first(); @endphp
                                    @if($perm)
                                    <input type="checkbox" name="permission[{{$perm->id}}]" value="{{$perm->id}}"
                                           class="form-check-input permission-checkbox"
                                           {{ in_array($perm->id, $rolePermissions) ? 'checked' : ''}}>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @php $perm = $permission->where('name', 'task-create')->first(); @endphp
                                    @if($perm)
                                    <input type="checkbox" name="permission[{{$perm->id}}]" value="{{$perm->id}}"
                                           class="form-check-input permission-checkbox"
                                           {{ in_array($perm->id, $rolePermissions) ? 'checked' : ''}}>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @php $perm = $permission->where('name', 'task-edit')->first(); @endphp
                                    @if($perm)
                                    <input type="checkbox" name="permission[{{$perm->id}}]" value="{{$perm->id}}"
                                           class="form-check-input permission-checkbox"
                                           {{ in_array($perm->id, $rolePermissions) ? 'checked' : ''}}>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @php $perm = $permission->where('name', 'task-delete')->first(); @endphp
                                    @if($perm)
                                    <input type="checkbox" name="permission[{{$perm->id}}]" value="{{$perm->id}}"
                                           class="form-check-input permission-checkbox"
                                           {{ in_array($perm->id, $rolePermissions) ? 'checked' : ''}}>
                                    @endif
                                </td>
                                <td class="text-center text-muted">-</td>
                            </tr>

                            <!-- Timesheet Permissions -->
                            <tr>
                                <td class="fw-bold bg-light">Chấm Công</td>
                                <td class="text-center">
                                    @php $perm = $permission->where('name', 'timesheet-list')->first(); @endphp
                                    @if($perm)
                                    <input type="checkbox" name="permission[{{$perm->id}}]" value="{{$perm->id}}"
                                           class="form-check-input permission-checkbox"
                                           {{ in_array($perm->id, $rolePermissions) ? 'checked' : ''}}>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @php $perm = $permission->where('name', 'timesheet-create')->first(); @endphp
                                    @if($perm)
                                    <input type="checkbox" name="permission[{{$perm->id}}]" value="{{$perm->id}}"
                                           class="form-check-input permission-checkbox"
                                           {{ in_array($perm->id, $rolePermissions) ? 'checked' : ''}}>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @php $perm = $permission->where('name', 'timesheet-edit')->first(); @endphp
                                    @if($perm)
                                    <input type="checkbox" name="permission[{{$perm->id}}]" value="{{$perm->id}}"
                                           class="form-check-input permission-checkbox"
                                           {{ in_array($perm->id, $rolePermissions) ? 'checked' : ''}}>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @php $perm = $permission->where('name', 'timesheet-delete')->first(); @endphp
                                    @if($perm)
                                    <input type="checkbox" name="permission[{{$perm->id}}]" value="{{$perm->id}}"
                                           class="form-check-input permission-checkbox"
                                           {{ in_array($perm->id, $rolePermissions) ? 'checked' : ''}}>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        @php $perm = $permission->where('name', 'timesheet-submit')->first(); @endphp
                                        @if($perm)
                                        <div class="form-check form-check-inline">
                                            <input type="checkbox" name="permission[{{$perm->id}}]" value="{{$perm->id}}"
                                                   class="form-check-input permission-checkbox" id="submit{{$perm->id}}"
                                                   {{ in_array($perm->id, $rolePermissions) ? 'checked' : ''}}>
                                            <label class="form-check-label small" for="submit{{$perm->id}}">Gửi</label>
                                        </div>
                                        @endif

                                        @php $perm = $permission->where('name', 'timesheet-approve')->first(); @endphp
                                        @if($perm)
                                        <div class="form-check form-check-inline">
                                            <input type="checkbox" name="permission[{{$perm->id}}]" value="{{$perm->id}}"
                                                   class="form-check-input permission-checkbox" id="approve{{$perm->id}}"
                                                   {{ in_array($perm->id, $rolePermissions) ? 'checked' : ''}}>
                                            <label class="form-check-label small" for="approve{{$perm->id}}">Duyệt</label>
                                        </div>
                                        @endif

                                        @php $perm = $permission->where('name', 'timesheet-reject')->first(); @endphp
                                        @if($perm)
                                        <div class="form-check form-check-inline">
                                            <input type="checkbox" name="permission[{{$perm->id}}]" value="{{$perm->id}}"
                                                   class="form-check-input permission-checkbox" id="reject{{$perm->id}}"
                                                   {{ in_array($perm->id, $rolePermissions) ? 'checked' : ''}}>
                                            <label class="form-check-label small" for="reject{{$perm->id}}">Từ Chối</label>
                                        </div>
                                        @endif
                                    </div>
                                </td>
                            </tr>

                            <!-- Salary Slip Permissions -->
                            <tr>
                                <td class="fw-bold bg-light">Phiếu Lương</td>
                                <td class="text-center">
                                    @php $perm = $permission->where('name', 'salaryslip-list')->first(); @endphp
                                    @if($perm)
                                    <input type="checkbox" name="permission[{{$perm->id}}]" value="{{$perm->id}}"
                                           class="form-check-input permission-checkbox"
                                           {{ in_array($perm->id, $rolePermissions) ? 'checked' : ''}}>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @php $perm = $permission->where('name', 'salaryslip-create')->first(); @endphp
                                    @if($perm)
                                    <input type="checkbox" name="permission[{{$perm->id}}]" value="{{$perm->id}}"
                                           class="form-check-input permission-checkbox"
                                           {{ in_array($perm->id, $rolePermissions) ? 'checked' : ''}}>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @php $perm = $permission->where('name', 'salaryslip-edit')->first(); @endphp
                                    @if($perm)
                                    <input type="checkbox" name="permission[{{$perm->id}}]" value="{{$perm->id}}"
                                           class="form-check-input permission-checkbox"
                                           {{ in_array($perm->id, $rolePermissions) ? 'checked' : ''}}>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @php $perm = $permission->where('name', 'salaryslip-delete')->first(); @endphp
                                    @if($perm)
                                    <input type="checkbox" name="permission[{{$perm->id}}]" value="{{$perm->id}}"
                                           class="form-check-input permission-checkbox"
                                           {{ in_array($perm->id, $rolePermissions) ? 'checked' : ''}}>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        @php $perm = $permission->where('name', 'salaryslip-print')->first(); @endphp
                                        @if($perm)
                                        <div class="form-check form-check-inline">
                                            <input type="checkbox" name="permission[{{$perm->id}}]" value="{{$perm->id}}"
                                                   class="form-check-input permission-checkbox" id="print{{$perm->id}}"
                                                   {{ in_array($perm->id, $rolePermissions) ? 'checked' : ''}}>
                                            <label class="form-check-label small" for="print{{$perm->id}}">In</label>
                                        </div>
                                        @endif

                                        @php $perm = $permission->where('name', 'salaryslip-status')->first(); @endphp
                                        @if($perm)
                                        <div class="form-check form-check-inline">
                                            <input type="checkbox" name="permission[{{$perm->id}}]" value="{{$perm->id}}"
                                                   class="form-check-input permission-checkbox" id="status{{$perm->id}}"
                                                   {{ in_array($perm->id, $rolePermissions) ? 'checked' : ''}}>
                                            <label class="form-check-label small" for="status{{$perm->id}}">Cập Nhật</label>
                                        </div>
                                        @endif
                                    </div>
                                </td>
                            </tr>

                            <!-- Department Permissions -->
                            <tr>
                                <td class="fw-bold bg-light">Phòng Ban</td>
                                <td class="text-center">
                                    @php $perm = $permission->where('name', 'department-list')->first(); @endphp
                                    @if($perm)
                                    <input type="checkbox" name="permission[{{$perm->id}}]" value="{{$perm->id}}"
                                           class="form-check-input permission-checkbox"
                                           {{ in_array($perm->id, $rolePermissions) ? 'checked' : ''}}>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @php $perm = $permission->where('name', 'department-create')->first(); @endphp
                                    @if($perm)
                                    <input type="checkbox" name="permission[{{$perm->id}}]" value="{{$perm->id}}"
                                           class="form-check-input permission-checkbox"
                                           {{ in_array($perm->id, $rolePermissions) ? 'checked' : ''}}>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @php $perm = $permission->where('name', 'department-edit')->first(); @endphp
                                    @if($perm)
                                    <input type="checkbox" name="permission[{{$perm->id}}]" value="{{$perm->id}}"
                                           class="form-check-input permission-checkbox"
                                           {{ in_array($perm->id, $rolePermissions) ? 'checked' : ''}}>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @php $perm = $permission->where('name', 'department-delete')->first(); @endphp
                                    @if($perm)
                                    <input type="checkbox" name="permission[{{$perm->id}}]" value="{{$perm->id}}"
                                           class="form-check-input permission-checkbox"
                                           {{ in_array($perm->id, $rolePermissions) ? 'checked' : ''}}>
                                    @endif
                                </td>
                                <td class="text-center text-muted">-</td>
                            </tr>

                            <!-- Notification Permissions -->
                            <tr>
                                <td class="fw-bold bg-light">Thông Báo</td>
                                <td class="text-center">
                                    @php $perm = $permission->where('name', 'notification-list')->first(); @endphp
                                    @if($perm)
                                    <input type="checkbox" name="permission[{{$perm->id}}]" value="{{$perm->id}}"
                                           class="form-check-input permission-checkbox"
                                           {{ in_array($perm->id, $rolePermissions) ? 'checked' : ''}}>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @php $perm = $permission->where('name', 'notification-create')->first(); @endphp
                                    @if($perm)
                                    <input type="checkbox" name="permission[{{$perm->id}}]" value="{{$perm->id}}"
                                           class="form-check-input permission-checkbox"
                                           {{ in_array($perm->id, $rolePermissions) ? 'checked' : ''}}>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @php $perm = $permission->where('name', 'notification-edit')->first(); @endphp
                                    @if($perm)
                                    <input type="checkbox" name="permission[{{$perm->id}}]" value="{{$perm->id}}"
                                           class="form-check-input permission-checkbox"
                                           {{ in_array($perm->id, $rolePermissions) ? 'checked' : ''}}>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @php $perm = $permission->where('name', 'notification-delete')->first(); @endphp
                                    @if($perm)
                                    <input type="checkbox" name="permission[{{$perm->id}}]" value="{{$perm->id}}"
                                           class="form-check-input permission-checkbox"
                                           {{ in_array($perm->id, $rolePermissions) ? 'checked' : ''}}>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @php $perm = $permission->where('name', 'notification-mark-read')->first(); @endphp
                                    @if($perm)
                                    <div class="form-check d-inline-block">
                                        <input type="checkbox" name="permission[{{$perm->id}}]" value="{{$perm->id}}"
                                               class="form-check-input permission-checkbox" id="markread{{$perm->id}}"
                                               {{ in_array($perm->id, $rolePermissions) ? 'checked' : ''}}>
                                        <label class="form-check-label small" for="markread{{$perm->id}}">Đánh Dấu Đã Đọc</label>
                                    </div>
                                    @endif
                                </td>
                            </tr>
<!-- Vendor Permissions - THÊM ĐOẠN NÀY VÀO SAU Message Permissions -->
<tr>
    <td class="fw-bold bg-light">Nhà Cung Cấp</td>
    <td class="text-center">
        @php $perm = $permission->where('name', 'vendor-list')->first(); @endphp
        @if($perm)
        <input type="checkbox" name="permission[{{$perm->id}}]" value="{{$perm->id}}"
               class="form-check-input permission-checkbox"
               {{ in_array($perm->id, $rolePermissions) ? 'checked' : ''}}>
        @endif
    </td>
    <td class="text-center">
        @php $perm = $permission->where('name', 'vendor-create')->first(); @endphp
        @if($perm)
        <input type="checkbox" name="permission[{{$perm->id}}]" value="{{$perm->id}}"
               class="form-check-input permission-checkbox"
               {{ in_array($perm->id, $rolePermissions) ? 'checked' : ''}}>
        @endif
    </td>
    <td class="text-center">
        @php $perm = $permission->where('name', 'vendor-edit')->first(); @endphp
        @if($perm)
        <input type="checkbox" name="permission[{{$perm->id}}]" value="{{$perm->id}}"
               class="form-check-input permission-checkbox"
               {{ in_array($perm->id, $rolePermissions) ? 'checked' : ''}}>
        @endif
    </td>
    <td class="text-center">
        @php $perm = $permission->where('name', 'vendor-delete')->first(); @endphp
        @if($perm)
        <input type="checkbox" name="permission[{{$perm->id}}]" value="{{$perm->id}}"
               class="form-check-input permission-checkbox"
               {{ in_array($perm->id, $rolePermissions) ? 'checked' : ''}}>
        @endif
    </td>
    <td class="text-center text-muted">-</td>
</tr>

<!-- Item Category Permissions -->
<tr>
    <td class="fw-bold bg-light">Danh Mục Sản Phẩm</td>
    <td class="text-center">
        @php $perm = $permission->where('name', 'item-category-list')->first(); @endphp
        @if($perm)
        <input type="checkbox" name="permission[{{$perm->id}}]" value="{{$perm->id}}"
               class="form-check-input permission-checkbox"
               {{ in_array($perm->id, $rolePermissions) ? 'checked' : ''}}>
        @endif
    </td>
    <td class="text-center">
        @php $perm = $permission->where('name', 'item-category-create')->first(); @endphp
        @if($perm)
        <input type="checkbox" name="permission[{{$perm->id}}]" value="{{$perm->id}}"
               class="form-check-input permission-checkbox"
               {{ in_array($perm->id, $rolePermissions) ? 'checked' : ''}}>
        @endif
    </td>
    <td class="text-center">
        @php $perm = $permission->where('name', 'item-category-edit')->first(); @endphp
        @if($perm)
        <input type="checkbox" name="permission[{{$perm->id}}]" value="{{$perm->id}}"
               class="form-check-input permission-checkbox"
               {{ in_array($perm->id, $rolePermissions) ? 'checked' : ''}}>
        @endif
    </td>
    <td class="text-center">
        @php $perm = $permission->where('name', 'item-category-delete')->first(); @endphp
        @if($perm)
        <input type="checkbox" name="permission[{{$perm->id}}]" value="{{$perm->id}}"
               class="form-check-input permission-checkbox"
               {{ in_array($perm->id, $rolePermissions) ? 'checked' : ''}}>
        @endif
    </td>
    <td class="text-center">
        @php $perm = $permission->where('name', 'item-category-toggle-active')->first(); @endphp
        @if($perm)
        <div class="form-check d-inline-block">
            <input type="checkbox" name="permission[{{$perm->id}}]" value="{{$perm->id}}"
                   class="form-check-input permission-checkbox" id="toggle{{$perm->id}}"
                   {{ in_array($perm->id, $rolePermissions) ? 'checked' : ''}}>
            <label class="form-check-label small" for="toggle{{$perm->id}}">Bật/Tắt</label>
        </div>
        @endif
    </td>
</tr>

<!-- Propose Permissions -->
<tr>
    <td class="fw-bold bg-light">Đề Xuất</td>
    <td class="text-center">
        @php $perm = $permission->where('name', 'propose-list')->first(); @endphp
        @if($perm)
        <input type="checkbox" name="permission[{{$perm->id}}]" value="{{$perm->id}}"
               class="form-check-input permission-checkbox"
               {{ in_array($perm->id, $rolePermissions) ? 'checked' : ''}}>
        @endif
    </td>
    <td class="text-center">
        @php $perm = $permission->where('name', 'propose-create')->first(); @endphp
        @if($perm)
        <input type="checkbox" name="permission[{{$perm->id}}]" value="{{$perm->id}}"
               class="form-check-input permission-checkbox"
               {{ in_array($perm->id, $rolePermissions) ? 'checked' : ''}}>
        @endif
    </td>
    <td class="text-center">
        @php $perm = $permission->where('name', 'propose-edit')->first(); @endphp
        @if($perm)
        <input type="checkbox" name="permission[{{$perm->id}}]" value="{{$perm->id}}"
               class="form-check-input permission-checkbox"
               {{ in_array($perm->id, $rolePermissions) ? 'checked' : ''}}>
        @endif
    </td>
    <td class="text-center">
        @php $perm = $permission->where('name', 'propose-delete')->first(); @endphp
        @if($perm)
        <input type="checkbox" name="permission[{{$perm->id}}]" value="{{$perm->id}}"
               class="form-check-input permission-checkbox"
               {{ in_array($perm->id, $rolePermissions) ? 'checked' : ''}}>
        @endif
    </td>
    <td class="text-center">
        <div class="d-flex flex-wrap justify-content-center gap-1">
            @php $perm = $permission->where('name', 'propose-submit')->first(); @endphp
            @if($perm)
            <div class="form-check form-check-inline">
                <input type="checkbox" name="permission[{{$perm->id}}]" value="{{$perm->id}}"
                       class="form-check-input permission-checkbox" id="submit{{$perm->id}}"
                       {{ in_array($perm->id, $rolePermissions) ? 'checked' : ''}}>
                <label class="form-check-label small" for="submit{{$perm->id}}">Gửi</label>
            </div>
            @endif

            @php $perm = $permission->where('name', 'propose-review')->first(); @endphp
            @if($perm)
            <div class="form-check form-check-inline">
                <input type="checkbox" name="permission[{{$perm->id}}]" value="{{$perm->id}}"
                       class="form-check-input permission-checkbox" id="review{{$perm->id}}"
                       {{ in_array($perm->id, $rolePermissions) ? 'checked' : ''}}>
                <label class="form-check-label small" for="review{{$perm->id}}">Xem Xét</label>
            </div>
            @endif

            @php $perm = $permission->where('name', 'propose-approve')->first(); @endphp
            @if($perm)
            <div class="form-check form-check-inline">
                <input type="checkbox" name="permission[{{$perm->id}}]" value="{{$perm->id}}"
                       class="form-check-input permission-checkbox" id="approve{{$perm->id}}"
                       {{ in_array($perm->id, $rolePermissions) ? 'checked' : ''}}>
                <label class="form-check-label small" for="approve{{$perm->id}}">Phê Duyệt</label>
            </div>
            @endif

            @php $perm = $permission->where('name', 'propose-cancel')->first(); @endphp
            @if($perm)
            <div class="form-check form-check-inline">
                <input type="checkbox" name="permission[{{$perm->id}}]" value="{{$perm->id}}"
                       class="form-check-input permission-checkbox" id="cancel{{$perm->id}}"
                       {{ in_array($perm->id, $rolePermissions) ? 'checked' : ''}}>
                <label class="form-check-label small" for="cancel{{$perm->id}}">Hủy</label>
            </div>
            @endif

            @php $perm = $permission->where('name', 'propose-statistics')->first(); @endphp
            @if($perm)
            <div class="form-check form-check-inline">
                <input type="checkbox" name="permission[{{$perm->id}}]" value="{{$perm->id}}"
                       class="form-check-input permission-checkbox" id="statistics{{$perm->id}}"
                       {{ in_array($perm->id, $rolePermissions) ? 'checked' : ''}}>
                <label class="form-check-label small" for="statistics{{$perm->id}}">Thống Kê</label>
            </div>
            @endif

            @php $perm = $permission->where('name', 'propose-export')->first(); @endphp
            @if($perm)
            <div class="form-check form-check-inline">
                <input type="checkbox" name="permission[{{$perm->id}}]" value="{{$perm->id}}"
                       class="form-check-input permission-checkbox" id="export{{$perm->id}}"
                       {{ in_array($perm->id, $rolePermissions) ? 'checked' : ''}}>
                <label class="form-check-label small" for="export{{$perm->id}}">Xuất</label>
            </div>
            @endif

            @php $perm = $permission->where('name', 'propose-download-attachment')->first(); @endphp
            @if($perm)
            <div class="form-check form-check-inline">
                <input type="checkbox" name="permission[{{$perm->id}}]" value="{{$perm->id}}"
                       class="form-check-input permission-checkbox" id="download{{$perm->id}}"
                       {{ in_array($perm->id, $rolePermissions) ? 'checked' : ''}}>
                <label class="form-check-label small" for="download{{$perm->id}}">Tải Xuống</label>
            </div>
            @endif
        </div>
    </td>
</tr>
                            <!-- Message Permissions -->
                            <tr>
                                <td class="fw-bold bg-light">Tin Nhắn</td>
                                <td class="text-center">
                                    @php $perm = $permission->where('name', 'message-list')->first(); @endphp
                                    @if($perm)
                                    <input type="checkbox" name="permission[{{$perm->id}}]" value="{{$perm->id}}"
                                           class="form-check-input permission-checkbox"
                                           {{ in_array($perm->id, $rolePermissions) ? 'checked' : ''}}>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @php $perm = $permission->where('name', 'message-create')->first(); @endphp
                                    @if($perm)
                                    <input type="checkbox" name="permission[{{$perm->id}}]" value="{{$perm->id}}"
                                           class="form-check-input permission-checkbox"
                                           {{ in_array($perm->id, $rolePermissions) ? 'checked' : ''}}>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @php $perm = $permission->where('name', 'message-edit')->first(); @endphp
                                    @if($perm)
                                    <input type="checkbox" name="permission[{{$perm->id}}]" value="{{$perm->id}}"
                                           class="form-check-input permission-checkbox"
                                           {{ in_array($perm->id, $rolePermissions) ? 'checked' : ''}}>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @php $perm = $permission->where('name', 'message-delete')->first(); @endphp
                                    @if($perm)
                                    <input type="checkbox" name="permission[{{$perm->id}}]" value="{{$perm->id}}"
                                           class="form-check-input permission-checkbox"
                                           {{ in_array($perm->id, $rolePermissions) ? 'checked' : ''}}>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        @php $perm = $permission->where('name', 'message-group-create')->first(); @endphp
                                        @if($perm)
                                        <div class="form-check form-check-inline">
                                            <input type="checkbox" name="permission[{{$perm->id}}]" value="{{$perm->id}}"
                                                   class="form-check-input permission-checkbox" id="groupcreate{{$perm->id}}"
                                                   {{ in_array($perm->id, $rolePermissions) ? 'checked' : ''}}>
                                            <label class="form-check-label small" for="groupcreate{{$perm->id}}">Tạo Nhóm</label>
                                        </div>
                                        @endif

                                        @php $perm = $permission->where('name', 'message-group-manage')->first(); @endphp
                                        @if($perm)
                                        <div class="form-check form-check-inline">
                                            <input type="checkbox" name="permission[{{$perm->id}}]" value="{{$perm->id}}"
                                                   class="form-check-input permission-checkbox" id="groupmanage{{$perm->id}}"
                                                   {{ in_array($perm->id, $rolePermissions) ? 'checked' : ''}}>
                                            <label class="form-check-label small" for="groupmanage{{$perm->id}}">Quản Lý Nhóm</label>
                                        </div>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-4">
            <button type="submit" class="btn btn-primary btn-sm mb-3 px-4">
                <i class="fa-solid fa-floppy-disk"></i> Lưu Thay Đổi
            </button>
        </div>
    </div>
</form>

<style>
.permission-table {
    font-size: 0.9rem;
}

.permission-table th {
    background-color: #e3f2fd;
    font-weight: 600;
    text-align: center;
    vertical-align: middle;
    border: 1px solid #dee2e6;
}

.permission-table td {
    vertical-align: middle;
    border: 1px solid #dee2e6;
}

.permission-table tbody tr:nth-child(even) {
    background-color: #f8f9fa;
}

.permission-table tbody tr:hover {
    background-color: #e8f4f8;
}

.permission-checkbox {
    width: 18px;
    height: 18px;
    cursor: pointer;
}

.permission-checkbox:checked {
    background-color: #007bff;
    border-color: #007bff;
}

.form-check-label {
    cursor: pointer;
    margin-left: 5px;
}

.bg-light {
    background-color: #f1f3f4 !important;
}

.gap-2 {
    gap: 0.5rem;
}

@media (max-width: 768px) {
    .permission-table {
        font-size: 0.8rem;
    }

    .form-check-label {
        font-size: 0.75rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Chọn tất cả checkbox
    document.getElementById('checkAll').addEventListener('click', function() {
        const checkboxes = document.querySelectorAll('.permission-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = true;
        });
    });

    // Bỏ chọn tất cả checkbox
    document.getElementById('uncheckAll').addEventListener('click', function() {
        const checkboxes = document.querySelectorAll('.permission-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = false;
        });
    });

    // Thêm hiệu ứng hover cho các hàng
    const tableRows = document.querySelectorAll('.permission-table tbody tr');
    tableRows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.backgroundColor = '#e8f4f8';
        });

        row.addEventListener('mouseleave', function() {
            // Khôi phục màu nền ban đầu
            const isEven = Array.from(this.parentNode.children).indexOf(this) % 2 === 1;
            this.style.backgroundColor = isEven ? '#f8f9fa' : '';
        });
    });
});
</script>

<p class="text-center text-primary mt-3"><small>Hệ thống quản lý phân quyền</small></p>
@endsection

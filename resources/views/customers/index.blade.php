@extends('layouts.app')

@section('title', 'Quản lý Khách hàng')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0">
                            <i class="fas fa-users me-2"></i>
                            Danh sách Khách hàng
                        </h3>
                        <a href="{{ route('customers.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i>
                            Thêm khách hàng
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Search and Filter Form -->
                    <form method="GET" action="{{ route('customers.index') }}" class="mb-4">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <input type="text"
                                       name="search"
                                       class="form-control"
                                       placeholder="Tìm kiếm theo tên, mã, email, SĐT..."
                                       value="{{ request('search') }}">
                            </div>
                            <div class="col-md-2">
                                <select name="status" class="form-select">
                                    <option value="">Tất cả trạng thái</option>
                                    @foreach(App\Models\Customer::getStatuses() as $key => $label)
                                        <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="type" class="form-select">
                                    <option value="">Tất cả loại</option>
                                    @foreach(App\Models\Customer::getTypes() as $key => $label)
                                        <option value="{{ $key }}" {{ request('type') == $key ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="sort_by" class="form-select">
                                    <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Ngày tạo</option>
                                    <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>Tên</option>
                                    <option value="code" {{ request('sort_by') == 'code' ? 'selected' : '' }}>Mã KH</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <div class="btn-group w-100" role="group">
                                    <button type="submit" class="btn btn-outline-primary">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <a href="{{ route('customers.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-times"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- Bulk Actions -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="bulk-actions" style="display: none;">
                                <form method="POST" action="{{ route('customers.bulk-action') }}" class="d-inline-flex align-items-center">
                                    @csrf
                                    <input type="hidden" name="selected_ids" id="selected_ids">
                                    <span class="me-2">Với <span id="selected_count">0</span> mục đã chọn:</span>
                                    <select name="action" class="form-select form-select-sm me-2" style="width: auto;">
                                        <option value="">Chọn hành động</option>
                                        <option value="activate">Kích hoạt</option>
                                        <option value="deactivate">Vô hiệu hóa</option>
                                        <option value="delete">Xóa</option>
                                    </select>
                                    <button type="submit" class="btn btn-sm btn-secondary" onclick="return confirm('Bạn có chắc chắn?')">
                                        Thực hiện
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-6 text-end">
                            <small class="text-muted">
                                Hiển thị {{ $customers->firstItem() ?? 0 }} đến {{ $customers->lastItem() ?? 0 }}
                                trong tổng số {{ $customers->total() }} khách hàng
                            </small>
                        </div>
                    </div>

                    <!-- Customers Table -->
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th width="40">
                                        <input type="checkbox" id="select_all">
                                    </th>
                                    <th>Mã KH</th>
                                    <th>Tên khách hàng</th>
                                    <th>Loại</th>
                                    <th>Liên hệ</th>
                                    <th>Trạng thái</th>
                                    <th>Dự án</th>
                                    <th>Ngày tạo</th>
                                    <th width="120">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($customers as $customer)
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="customer_ids[]" value="{{ $customer->id }}" class="customer-checkbox">
                                        </td>
                                        <td>
                                            <code>{{ $customer->code }}</code>
                                        </td>
                                        <td>
                                            <div>
                                                <strong>{{ $customer->name }}</strong>
                                                @if($customer->contact_person)
                                                    <br>
                                                    <small class="text-muted">
                                                        <i class="fas fa-user-tie me-1"></i>
                                                        {{ $customer->contact_person }}
                                                    </small>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            @if($customer->type == 'company')
                                                <span class="badge bg-primary">
                                                    <i class="fas fa-building me-1"></i>Công ty
                                                </span>
                                            @else
                                                <span class="badge bg-info">
                                                    <i class="fas fa-user me-1"></i>Cá nhân
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($customer->email)
                                                <div>
                                                    <i class="fas fa-envelope text-muted me-1"></i>
                                                    <small>{{ $customer->email }}</small>
                                                </div>
                                            @endif
                                            @if($customer->phone)
                                                <div>
                                                    <i class="fas fa-phone text-muted me-1"></i>
                                                    <small>{{ $customer->phone }}</small>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            @switch($customer->status)
                                                @case('active')
                                                    <span class="badge bg-success">Đang hoạt động</span>
                                                    @break
                                                @case('inactive')
                                                    <span class="badge bg-secondary">Không hoạt động</span>
                                                    @break
                                                @case('potential')
                                                    <span class="badge bg-warning">Tiềm năng</span>
                                                    @break
                                            @endswitch
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <span class="badge bg-primary me-1">{{ $customer->projects_count }}</span>
                                                @if($customer->active_projects_count > 0)
                                                    <span class="badge bg-success">{{ $customer->active_projects_count }} đang thực hiện</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <small>{{ $customer->created_at->format('d/m/Y H:i') }}</small>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="{{ route('customers.show', $customer) }}"
                                                   class="btn btn-outline-info"
                                                   title="Xem chi tiết">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('customers.edit', $customer) }}"
                                                   class="btn btn-outline-primary"
                                                   title="Chỉnh sửa">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form method="POST"
                                                      action="{{ route('customers.destroy', $customer) }}"
                                                      class="d-inline"
                                                      onsubmit="return confirm('Bạn có chắc chắn muốn xóa khách hàng này?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="btn btn-outline-danger"
                                                            title="Xóa"
                                                            @if($customer->projects_count > 0) disabled @endif>
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="fas fa-users fa-3x mb-3"></i>
                                                <p>Không có khách hàng nào được tìm thấy</p>
                                                @if(!request()->hasAny(['search', 'status', 'type']))
                                                    <a href="{{ route('customers.create') }}" class="btn btn-primary">
                                                        <i class="fas fa-plus me-1"></i>
                                                        Thêm khách hàng đầu tiên
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($customers->hasPages())
                        <div class="d-flex justify-content-center">
                            {{ $customers->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Select all functionality
    $('#select_all').change(function() {
        $('.customer-checkbox').prop('checked', this.checked);
        updateBulkActions();
    });

    // Individual checkbox change
    $('.customer-checkbox').change(function() {
        updateBulkActions();
    });

    function updateBulkActions() {
        const checkedBoxes = $('.customer-checkbox:checked');
        const count = checkedBoxes.length;

        if (count > 0) {
            $('.bulk-actions').show();
            $('#selected_count').text(count);

            // Update selected IDs
            const ids = checkedBoxes.map(function() {
                return this.value;
            }).get();
            $('#selected_ids').val(JSON.stringify(ids));
        } else {
            $('.bulk-actions').hide();
        }
    }

    // Auto-submit form when sort changes
    $('select[name="sort_by"]').change(function() {
        $(this).closest('form').submit();
    });
});
</script>
@endpush
@endsection

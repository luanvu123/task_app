@extends('layouts.app')

@section('title', 'Quản lý nhà cung cấp')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="card-title mb-0">Danh sách nhà cung cấp</h3>
                            </div>
                            <div class="col-auto">
                                <a href="{{ route('vendors.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Thêm nhà cung cấp
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <!-- Bộ lọc -->
                        <form method="GET" action="{{ route('vendors.index') }}" class="mb-3">
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="text" name="search" class="form-control" placeholder="Tìm kiếm..."
                                        value="{{ request('search') }}">
                                </div>
                                <div class="col-md-3">
                                    <select name="status" class="form-control">
                                        <option value="">Tất cả trạng thái</option>
                                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>
                                            Hoạt động
                                        </option>
                                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>
                                            Không hoạt động
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-outline-primary">
                                        <i class="fas fa-search"></i> Tìm kiếm
                                    </button>
                                </div>
                                <div class="col-md-2">
                                    <a href="{{ route('vendors.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-refresh"></i> Đặt lại
                                    </a>
                                </div>
                            </div>
                        </form>

                        <!-- Thông báo -->
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <!-- Bảng danh sách -->
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Tên nhà cung cấp</th>
                                        <th>Người liên hệ</th>
                                        <th>Email</th>
                                        <th>Điện thoại</th>
                                        <th>Trạng thái</th>
                                        <th>Đánh giá</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($vendors as $vendor)
                                        <tr>
                                            <td>{{ $loop->iteration + ($vendors->currentPage() - 1) * $vendors->perPage() }}
                                            </td>
                                            <td>
                                                <strong>{{ $vendor->name }}</strong>
                                                @if($vendor->tax_code)
                                                    <br><small class="text-muted">MST: {{ $vendor->tax_code }}</small>
                                                @endif
                                            </td>
                                            <td>{{ $vendor->contact_person ?: 'Chưa có' }}</td>
                                            <td>
                                                @if($vendor->email)
                                                    <a href="mailto:{{ $vendor->email }}">{{ $vendor->email }}</a>
                                                @else
                                                    <span class="text-muted">Chưa có</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($vendor->phone)
                                                    <a href="tel:{{ $vendor->phone }}">{{ $vendor->phone }}</a>
                                                @else
                                                    <span class="text-muted">Chưa có</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $vendor->status == 'active' ? 'success' : 'secondary' }}">
                                                    {{ $vendor->status_text }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($vendor->rating > 0)
                                                    <span class="text-warning">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            @if($i <= $vendor->rating)
                                                                <i class="fas fa-star"></i>
                                                            @else
                                                                <i class="far fa-star"></i>
                                                            @endif
                                                        @endfor
                                                    </span>
                                                    <small>({{ $vendor->rating }})</small>
                                                @else
                                                    <span class="text-muted">Chưa đánh giá</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('vendors.show', $vendor) }}"
                                                        class="btn btn-sm btn-outline-info" title="Xem chi tiết">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('vendors.edit', $vendor) }}"
                                                        class="btn btn-sm btn-outline-primary" title="Sửa">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-outline-danger" title="Xóa"
                                                        onclick="deleteVendor({{ $vendor->id }})">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center text-muted">
                                                Không có nhà cung cấp nào
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Phân trang -->
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                Hiển thị {{ $vendors->firstItem() ?? 0 }} - {{ $vendors->lastItem() ?? 0 }}
                                trong tổng số {{ $vendors->total() }} kết quả
                            </div>
                            <div>
                                {{ $vendors->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Form xóa ẩn -->
    <form id="delete-form" action="" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    <script>
        function deleteVendor(id) {
            if (confirm('Bạn có chắc chắn muốn xóa nhà cung cấp này?')) {
                document.getElementById('delete-form').action = '/vendors/' + id;
                document.getElementById('delete-form').submit();
            }
        }
    </script>
@endsection

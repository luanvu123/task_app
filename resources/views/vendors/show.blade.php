@extends('layouts.app')

@section('title', 'Chi tiết nhà cung cấp')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="card-title mb-0">Chi tiết nhà cung cấp</h3>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('vendors.edit', $vendor) }}" class="btn btn-primary me-2">
                                <i class="fas fa-edit"></i> Sửa
                            </a>
                            <a href="{{ route('vendors.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Quay lại
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Thông báo -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-8">
                            <!-- Thông tin cơ bản -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-info-circle"></i> Thông tin cơ bản
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <strong>Tên nhà cung cấp:</strong>
                                        </div>
                                        <div class="col-sm-9">
                                            <h4 class="text-primary mb-0">{{ $vendor->name }}</h4>
                                        </div>
                                    </div>
                                    <hr>

                                    @if($vendor->contact_person)
                                    <div class="row mb-2">
                                        <div class="col-sm-3">
                                            <strong>Người liên hệ:</strong>
                                        </div>
                                        <div class="col-sm-9">
                                            {{ $vendor->contact_person }}
                                        </div>
                                    </div>
                                    @endif

                                    @if($vendor->email)
                                    <div class="row mb-2">
                                        <div class="col-sm-3">
                                            <strong>Email:</strong>
                                        </div>
                                        <div class="col-sm-9">
                                            <a href="mailto:{{ $vendor->email }}">{{ $vendor->email }}</a>
                                        </div>
                                    </div>
                                    @endif

                                    @if($vendor->phone)
                                    <div class="row mb-2">
                                        <div class="col-sm-3">
                                            <strong>Điện thoại:</strong>
                                        </div>
                                        <div class="col-sm-9">
                                            <a href="tel:{{ $vendor->phone }}">{{ $vendor->phone }}</a>
                                        </div>
                                    </div>
                                    @endif

                                    @if($vendor->address)
                                    <div class="row mb-2">
                                        <div class="col-sm-3">
                                            <strong>Địa chỉ:</strong>
                                        </div>
                                        <div class="col-sm-9">
                                            {{ $vendor->address }}
                                        </div>
                                    </div>
                                    @endif

                                    @if($vendor->tax_code)
                                    <div class="row mb-2">
                                        <div class="col-sm-3">
                                            <strong>Mã số thuế:</strong>
                                        </div>
                                        <div class="col-sm-9">
                                            <code>{{ $vendor->tax_code }}</code>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Chuyên môn -->
                            @if($vendor->specialties)
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-tools"></i> Chuyên môn
                                    </h5>
                                </div>
                                <div class="card-body">
                                    @foreach($vendor->specialties as $specialty)
                                        <span class="badge bg-info me-2 mb-2">{{ $specialty }}</span>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>

                        <div class="col-md-4">
                            <!-- Trạng thái và đánh giá -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-chart-line"></i> Trạng thái & Đánh giá
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="text-center mb-3">
                                        <span class="badge bg-{{ $vendor->status == 'active' ? 'success' : 'secondary' }} fs-6">
                                            {{ $vendor->status_text }}
                                        </span>
                                    </div>

                                    <div class="text-center">
                                        <h6>Đánh giá</h6>
                                        @if($vendor->rating > 0)
                                            <div class="text-warning fs-4 mb-2">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= $vendor->rating)
                                                        <i class="fas fa-star"></i>
                                                    @elseif($i - 0.5 <= $vendor->rating)
                                                        <i class="fas fa-star-half-alt"></i>
                                                    @else
                                                        <i class="far fa-star"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                            <div class="h4 text-warning">{{ $vendor->rating }}/5</div>
                                        @else
                                            <div class="text-muted">
                                                <i class="fas fa-star-o"></i><br>
                                                Chưa có đánh giá
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Thông tin khác -->
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-clock"></i> Thông tin khác
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <small class="text-muted">Ngày tạo:</small><br>
                                        <strong>{{ $vendor->created_at->format('d/m/Y H:i') }}</strong>
                                    </div>

                                    @if($vendor->updated_at != $vendor->created_at)
                                    <div class="mb-3">
                                        <small class="text-muted">Cập nhật lần cuối:</small><br>
                                        <strong>{{ $vendor->updated_at->format('d/m/Y H:i') }}</strong>
                                    </div>
                                    @endif

                                    <div class="d-grid gap-2">
                                        <button type="button" class="btn btn-outline-danger btn-sm"
                                                onclick="deleteVendor({{ $vendor->id }})">
                                            <i class="fas fa-trash"></i> Xóa nhà cung cấp
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Form xóa ẩn -->
<form id="delete-form" action="{{ route('vendors.destroy', $vendor) }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
<script>
function deleteVendor(id) {
    if (confirm('Bạn có chắc chắn muốn xóa nhà cung cấp "{{ $vendor->name }}"?\nHành động này không thể hoàn tác!')) {
        document.getElementById('delete-form').submit();
    }
}
</script>
@endsection

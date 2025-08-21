@extends('layouts.app')

@section('title', 'Chỉnh sửa Khách hàng: ' . $customer->name)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0">
                            <i class="fas fa-user-edit me-2"></i>
                            Chỉnh sửa Khách hàng: {{ $customer->name }}
                        </h3>
                        <div class="btn-group">
                            <a href="{{ route('customers.show', $customer) }}" class="btn btn-info">
                                <i class="fas fa-eye me-1"></i>
                                Xem chi tiết
                            </a>
                            <a href="{{ route('customers.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i>
                                Quay lại
                            </a>
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('customers.update', $customer) }}">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row">
                            <!-- Basic Information -->
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Thông tin cơ bản</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="name" class="form-label">
                                                        Tên khách hàng <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="text"
                                                           class="form-control @error('name') is-invalid @enderror"
                                                           id="name"
                                                           name="name"
                                                           value="{{ old('name', $customer->name) }}"
                                                           required>
                                                    @error('name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="code" class="form-label">
                                                        Mã khách hàng <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="text"
                                                           class="form-control @error('code') is-invalid @enderror"
                                                           id="code"
                                                           name="code"
                                                           value="{{ old('code', $customer->code) }}"
                                                           required>
                                                    @error('code')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="type" class="form-label">
                                                        Loại khách hàng <span class="text-danger">*</span>
                                                    </label>
                                                    <select class="form-select @error('type') is-invalid @enderror"
                                                            id="type"
                                                            name="type"
                                                            required>
                                                        <option value="">Chọn loại khách hàng</option>
                                                        @foreach(App\Models\Customer::getTypes() as $key => $label)
                                                            <option value="{{ $key }}" {{ old('type', $customer->type) == $key ? 'selected' : '' }}>
                                                                {{ $label }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('type')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="status" class="form-label">
                                                        Trạng thái <span class="text-danger">*</span>
                                                    </label>
                                                    <select class="form-select @error('status') is-invalid @enderror"
                                                            id="status"
                                                            name="status"
                                                            required>
                                                        @foreach(App\Models\Customer::getStatuses() as $key => $label)
                                                            <option value="{{ $key }}" {{ old('status', $customer->status) == $key ? 'selected' : '' }}>
                                                                {{ $label }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('status')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="tax_code" class="form-label">Mã số thuế</label>
                                            <input type="text"
                                                   class="form-control @error('tax_code') is-invalid @enderror"
                                                   id="tax_code"
                                                   name="tax_code"
                                                   value="{{ old('tax_code', $customer->tax_code) }}">
                                            @error('tax_code')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="address" class="form-label">Địa chỉ</label>
                                            <textarea class="form-control @error('address') is-invalid @enderror"
                                                      id="address"
                                                      name="address"
                                                      rows="3">{{ old('address', $customer->address) }}</textarea>
                                            @error('address')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="description" class="form-label">Mô tả</label>
                                            <textarea class="form-control @error('description') is-invalid @enderror"
                                                      id="description"
                                                      name="description"
                                                      rows="3">{{ old('description', $customer->description) }}</textarea>
                                            @error('description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Contact Information -->
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Thông tin liên hệ</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email"
                                                   class="form-control @error('email') is-invalid @enderror"
                                                   id="email"
                                                   name="email"
                                                   value="{{ old('email', $customer->email) }}">
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="phone" class="form-label">Số điện thoại</label>
                                            <input type="tel"
                                                   class="form-control @error('phone') is-invalid @enderror"
                                                   id="phone"
                                                   name="phone"
                                                   value="{{ old('phone', $customer->phone) }}">
                                            @error('phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="contact_person" class="form-label">Người liên hệ</label>
                                            <input type="text"
                                                   class="form-control @error('contact_person') is-invalid @enderror"
                                                   id="contact_person"
                                                   name="contact_person"
                                                   value="{{ old('contact_person', $customer->contact_person) }}">
                                            @error('contact_person')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="contact_position" class="form-label">Chức vụ</label>
                                            <input type="text"
                                                   class="form-control @error('contact_position') is-invalid @enderror"
                                                   id="contact_position"
                                                   name="contact_position"
                                                   value="{{ old('contact_position', $customer->contact_position) }}">
                                            @error('contact_position')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Additional Information -->
                                <div class="card mt-3">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Thông tin bổ sung</h5>
                                    </div>
                                    <div class="card-body">
                                        <div id="additional-info-container">
                                            <div class="mb-2">
                                                <small class="text-muted">
                                                    Thêm các thông tin bổ sung dưới dạng key-value
                                                </small>
                                            </div>

                                            @if($customer->additional_info && count($customer->additional_info) > 0)
                                                @foreach($customer->additional_info as $key => $value)
                                                    <div class="additional-info-item mb-2">
                                                        <div class="row">
                                                            <div class="col-5">
                                                                <input type="text"
                                                                       class="form-control form-control-sm"
                                                                       placeholder="Tên trường"
                                                                       name="additional_info_keys[]"
                                                                       value="{{ $key }}">
                                                            </div>
                                                            <div class="col-6">
                                                                <input type="text"
                                                                       class="form-control form-control-sm"
                                                                       placeholder="Giá trị"
                                                                       name="additional_info_values[]"
                                                                       value="{{ $value }}">
                                                            </div>
                                                            <div class="col-1">
                                                                <button type="button"
                                                                        class="btn btn-sm btn-outline-danger remove-info-item">
                                                                    <i class="fas fa-minus"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="additional-info-item mb-2">
                                                    <div class="row">
                                                        <div class="col-5">
                                                            <input type="text"
                                                                   class="form-control form-control-sm"
                                                                   placeholder="Tên trường"
                                                                   name="additional_info_keys[]">
                                                        </div>
                                                        <div class="col-6">
                                                            <input type="text"
                                                                   class="form-control form-control-sm"
                                                                   placeholder="Giá trị"
                                                                   name="additional_info_values[]">
                                                        </div>
                                                        <div class="col-1">
                                                            <button type="button"
                                                                    class="btn btn-sm btn-outline-danger remove-info-item">
                                                                <i class="fas fa-minus"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <button type="button"
                                                class="btn btn-sm btn-outline-primary"
                                                id="add-info-item">
                                            <i class="fas fa-plus me-1"></i>
                                            Thêm trường
                                        </button>
                                    </div>
                                </div>

                                <!-- Customer Statistics -->
                                @if($customer->projects->count() > 0)
                                    <div class="card mt-3">
                                        <div class="card-header">
                                            <h5 class="card-title mb-0">
                                                <i class="fas fa-chart-bar me-2"></i>
                                                Thống kê dự án
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row text-center">
                                                <div class="col-6">
                                                    <div class="border-end">
                                                        <h4 class="text-primary mb-0">{{ $customer->projects->count() }}</h4>
                                                        <small class="text-muted">Tổng dự án</small>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <h4 class="text-success mb-0">{{ $customer->activeProjects->count() }}</h4>
                                                    <small class="text-muted">Đang thực hiện</small>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="text-center">
                                                <strong>Tổng ngân sách:</strong>
                                                <div class="text-warning">
                                                    {{ number_format($customer->projects->sum('budget'), 0, ',', '.') }} VNĐ
                                                </div>
                                            </div>

                                            @if($customer->status != 'active' && $customer->activeProjects->count() > 0)
                                                <div class="alert alert-warning mt-3 mb-0" role="alert">
                                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                                    <small>
                                                        Khách hàng có {{ $customer->activeProjects->count() }} dự án đang hoạt động.
                                                        Cần xem xét trạng thái khách hàng.
                                                    </small>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="d-flex justify-content-between">
                            <div>
                                <a href="{{ route('customers.show', $customer) }}" class="btn btn-secondary">
                                    <i class="fas fa-times me-1"></i>
                                    Hủy bỏ
                                </a>
                                @if($customer->projects->count() == 0)
                                    <button type="button"
                                            class="btn btn-danger ms-2"
                                            onclick="deleteCustomer()"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteModal">
                                        <i class="fas fa-trash me-1"></i>
                                        Xóa khách hàng
                                    </button>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>
                                Cập nhật thông tin
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Xác nhận xóa khách hàng
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn xóa khách hàng <strong>{{ $customer->name }}</strong>?</p>
                <p class="text-muted">Hành động này không thể hoàn tác!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>
                    Hủy bỏ
                </button>
                <form method="POST" action="{{ route('customers.destroy', $customer) }}" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-1"></i>
                        Xóa khách hàng
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Add new additional info item
    $('#add-info-item').click(function() {
        const newItem = `
            <div class="additional-info-item mb-2">
                <div class="row">
                    <div class="col-5">
                        <input type="text"
                               class="form-control form-control-sm"
                               placeholder="Tên trường"
                               name="additional_info_keys[]">
                    </div>
                    <div class="col-6">
                        <input type="text"
                               class="form-control form-control-sm"
                               placeholder="Giá trị"
                               name="additional_info_values[]">
                    </div>
                    <div class="col-1">
                        <button type="button"
                                class="btn btn-sm btn-outline-danger remove-info-item">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
        $('#additional-info-container').append(newItem);
    });

    // Remove additional info item
    $(document).on('click', '.remove-info-item', function() {
        if ($('.additional-info-item').length > 1) {
            $(this).closest('.additional-info-item').remove();
        } else {
            // Clear the inputs instead of removing the last item
            $(this).closest('.additional-info-item').find('input').val('');
        }
    });

    // Form validation
    $('form').on('submit', function(e) {
        let isValid = true;

        // Check required fields
        $(this).find('[required]').each(function() {
            if (!$(this).val().trim()) {
                isValid = false;
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
            }
        });

        // Check for duplicate customer code
        const code = $('#code').val();
        if (code) {
            // You can add AJAX validation here if needed
        }

        if (!isValid) {
            e.preventDefault();
            alert('Vui lòng điền đầy đủ các trường bắt buộc!');
        }
    });

    // Status change warning
    $('#status').change(function() {
        const newStatus = $(this).val();
        const activeProjects = {{ $customer->activeProjects->count() }};

        if (newStatus !== 'active' && activeProjects > 0) {
            alert('Cảnh báo: Khách hàng này có ' + activeProjects + ' dự án đang hoạt động. Hãy cân nhắc kỹ trước khi thay đổi trạng thái.');
        }
    });
});
</script>
@endpush
@endsection

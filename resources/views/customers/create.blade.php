@extends('layouts.app')

@section('title', 'Thêm Khách hàng mới')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0">
                            <i class="fas fa-user-plus me-2"></i>
                            Thêm Khách hàng mới
                        </h3>
                        <a href="{{ route('customers.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i>
                            Quay lại
                        </a>
                    </div>
                </div>

                <form method="POST" action="{{ route('customers.store') }}">
                    @csrf
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
                                                           value="{{ old('name') }}"
                                                           required>
                                                    @error('name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="code" class="form-label">
                                                        Mã khách hàng
                                                        <small class="text-muted">(Để trống để tự động tạo)</small>
                                                    </label>
                                                    <input type="text"
                                                           class="form-control @error('code') is-invalid @enderror"
                                                           id="code"
                                                           name="code"
                                                           value="{{ old('code') }}"
                                                           placeholder="VD: CUS2025001">
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
                                                            <option value="{{ $key }}" {{ old('type') == $key ? 'selected' : '' }}>
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
                                                            <option value="{{ $key }}" {{ old('status', 'active') == $key ? 'selected' : '' }}>
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
                                                   value="{{ old('tax_code') }}">
                                            @error('tax_code')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="address" class="form-label">Địa chỉ</label>
                                            <textarea class="form-control @error('address') is-invalid @enderror"
                                                      id="address"
                                                      name="address"
                                                      rows="3">{{ old('address') }}</textarea>
                                            @error('address')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="description" class="form-label">Mô tả</label>
                                            <textarea class="form-control @error('description') is-invalid @enderror"
                                                      id="description"
                                                      name="description"
                                                      rows="3">{{ old('description') }}</textarea>
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
                                                   value="{{ old('email') }}">
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
                                                   value="{{ old('phone') }}">
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
                                                   value="{{ old('contact_person') }}">
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
                                                   value="{{ old('contact_position') }}">
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
                                        </div>
                                        <button type="button"
                                                class="btn btn-sm btn-outline-primary"
                                                id="add-info-item">
                                            <i class="fas fa-plus me-1"></i>
                                            Thêm trường
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('customers.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i>
                                Hủy bỏ
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>
                                Lưu khách hàng
                            </button>
                        </div>
                    </div>
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
        $(this).closest('.additional-info-item').remove();
    });

    // Auto-generate customer code based on name
    $('#name').on('input', function() {
        if (!$('#code').val()) {
            const name = $(this).val();
            const words = name.split(' ');
            let code = 'CUS' + new Date().getFullYear();

            if (words.length > 0) {
                const initials = words.map(word => word.charAt(0).toUpperCase()).join('');
                code += initials.substring(0, 3);
            }

            // Add random number
            code += Math.floor(Math.random() * 1000).toString().padStart(3, '0');

            $('#code').val(code);
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

        if (!isValid) {
            e.preventDefault();
            alert('Vui lòng điền đầy đủ các trường bắt buộc!');
        }
    });
});
</script>
@endpush
@endsection

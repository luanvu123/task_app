@extends('layouts.app')

@section('title', 'Sửa nhà cung cấp')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="card-title mb-0">Sửa thông tin nhà cung cấp</h3>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('vendors.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Quay lại
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ route('vendors.update', $vendor) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Tên nhà cung cấp <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                           id="name" name="name" value="{{ old('name', $vendor->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="contact_person" class="form-label">Người liên hệ</label>
                                    <input type="text" class="form-control @error('contact_person') is-invalid @enderror"
                                           id="contact_person" name="contact_person" value="{{ old('contact_person', $vendor->contact_person) }}">
                                    @error('contact_person')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                           id="email" name="email" value="{{ old('email', $vendor->email) }}">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Số điện thoại</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                           id="phone" name="phone" value="{{ old('phone', $vendor->phone) }}">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Địa chỉ</label>
                            <textarea class="form-control @error('address') is-invalid @enderror"
                                      id="address" name="address" rows="3">{{ old('address', $vendor->address) }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="tax_code" class="form-label">Mã số thuế</label>
                                    <input type="text" class="form-control @error('tax_code') is-invalid @enderror"
                                           id="tax_code" name="tax_code" value="{{ old('tax_code', $vendor->tax_code) }}">
                                    @error('tax_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Trạng thái <span class="text-danger">*</span></label>
                                    <select class="form-control @error('status') is-invalid @enderror"
                                            id="status" name="status" required>
                                        <option value="">Chọn trạng thái</option>
                                        <option value="active" {{ old('status', $vendor->status) == 'active' ? 'selected' : '' }}>
                                            Hoạt động
                                        </option>
                                        <option value="inactive" {{ old('status', $vendor->status) == 'inactive' ? 'selected' : '' }}>
                                            Không hoạt động
                                        </option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="rating" class="form-label">Đánh giá (0-5)</label>
                                    <input type="number" class="form-control @error('rating') is-invalid @enderror"
                                           id="rating" name="rating" min="0" max="5" step="0.1"
                                           value="{{ old('rating', $vendor->rating) }}">
                                    @error('rating')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Chuyên môn</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="specialties[]"
                                               value="Công nghệ thông tin" id="specialty_it"
                                               {{ in_array('Công nghệ thông tin', old('specialties', $vendor->specialties ?? [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="specialty_it">
                                            Công nghệ thông tin
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="specialties[]"
                                               value="Xây dựng" id="specialty_construction"
                                               {{ in_array('Xây dựng', old('specialties', $vendor->specialties ?? [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="specialty_construction">
                                            Xây dựng
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="specialties[]"
                                               value="Vận tải" id="specialty_transport"
                                               {{ in_array('Vận tải', old('specialties', $vendor->specialties ?? [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="specialty_transport">
                                            Vận tải
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="specialties[]"
                                               value="Thiết bị văn phòng" id="specialty_office"
                                               {{ in_array('Thiết bị văn phòng', old('specialties', $vendor->specialties ?? [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="specialty_office">
                                            Thiết bị văn phòng
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="specialties[]"
                                               value="Dịch vụ tư vấn" id="specialty_consulting"
                                               {{ in_array('Dịch vụ tư vấn', old('specialties', $vendor->specialties ?? [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="specialty_consulting">
                                            Dịch vụ tư vấn
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="specialties[]"
                                               value="Khác" id="specialty_other"
                                               {{ in_array('Khác', old('specialties', $vendor->specialties ?? [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="specialty_other">
                                            Khác
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-end">
                            <a href="{{ route('vendors.show', $vendor) }}" class="btn btn-info me-2">
                                <i class="fas fa-eye"></i> Xem chi tiết
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Cập nhật
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

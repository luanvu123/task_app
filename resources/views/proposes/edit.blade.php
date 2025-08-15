@extends('layouts.app')

@section('title', 'Chỉnh sửa đề xuất')

@section('content')
<div class="container-fluid">
    {{-- Display Error Messages --}}
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <h5><i class="fas fa-exclamation-circle"></i> Có lỗi xảy ra khi cập nhật đề xuất:</h5>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    {{-- Display Success Message --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    {{-- Display General Error Message --}}
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    {{-- Propose Info Card --}}
    <div class="card mb-3">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="fas fa-info-circle"></i> Thông tin đề xuất
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
               <div class="col-md-3">
    <strong>Mã đề xuất:</strong><br>
    <span class="badge bg-primary">{{ $propose->propose_code }}</span>
</div>
<div class="col-md-3">
    <strong>Trạng thái:</strong><br>
    <span class="badge {{ $propose->status === 'draft' ? 'bg-secondary' : 'bg-info' }}">
        {{ $propose->getStatusText() }}
    </span>
</div>

                <div class="col-md-3">
                    <strong>Ngày tạo:</strong><br>
                    {{ $propose->created_at->format('d/m/Y H:i') }}
                </div>
                <div class="col-md-3">
                    <strong>Người tạo:</strong><br>
                    {{ $propose->proposedBy->name ?? 'N/A' }}
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('proposes.update', $propose) }}" method="POST" enctype="multipart/form-data" id="propose-edit-form">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Chỉnh sửa thông tin đề xuất</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="project_id">Dự án <span class="text-danger">*</span></label>
                                    <select name="project_id" id="project_id" class="form-control @error('project_id') is-invalid @enderror" required>
                                        <option value="">Chọn dự án</option>
                                        @forelse($projects as $project)
                                            <option value="{{ $project->id }}"
                                                {{ (old('project_id') ?? $propose->project_id) == $project->id ? 'selected' : '' }}>
                                                {{ $project->name }}
                                            </option>
                                        @empty
                                            <option value="" disabled>Không có dự án nào</option>
                                        @endforelse
                                    </select>
                                    @error('project_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="department_id">Bộ phận <span class="text-danger">*</span></label>
                                    <select name="department_id" id="department_id" class="form-control @error('department_id') is-invalid @enderror" required>
                                        <option value="">Chọn bộ phận</option>
                                        @forelse($departments as $department)
                                            <option value="{{ $department->id }}"
                                                {{ (old('department_id') ?? $propose->department_id) == $department->id ? 'selected' : '' }}>
                                                {{ $department->name }}
                                            </option>
                                        @empty
                                            <option value="" disabled>Không có bộ phận nào</option>
                                        @endforelse
                                    </select>
                                    @error('department_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="title">Tiêu đề <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="title"
                                   class="form-control @error('title') is-invalid @enderror"
                                   value="{{ old('title') ?? $propose->title }}"
                                   placeholder="Nhập tiêu đề đề xuất"
                                   maxlength="255"
                                   required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Tối đa 255 ký tự</small>
                        </div>
<div class="form-group">
    <label for="status">Duyệt đề xuất</label>
    <select name="status" id="status" class="form-control">
        <option value="draft" {{ $propose->status == 'draft' ? 'selected' : '' }}>Bản nháp</option>
        <option value="submitted" {{ $propose->status == 'submitted' ? 'selected' : '' }}>Đã gửi</option>
        <option value="under_review" {{ $propose->status == 'under_review' ? 'selected' : '' }}>Đang xem xét</option>
        <option value="pending_approval" {{ $propose->status == 'pending_approval' ? 'selected' : '' }}>Chờ phê duyệt</option>
        <option value="approved" {{ $propose->status == 'approved' ? 'selected' : '' }}>Đã phê duyệt</option>
        <option value="partially_approved" {{ $propose->status == 'partially_approved' ? 'selected' : '' }}>Phê duyệt một phần</option>
        <option value="rejected" {{ $propose->status == 'rejected' ? 'selected' : '' }}>Từ chối</option>
        <option value="cancelled" {{ $propose->status == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
        <option value="completed" {{ $propose->status == 'completed' ? 'selected' : '' }}>Hoàn thành</option>
    </select>
</div>
                        <div class="form-group">
                            <label for="description">Mô tả <span class="text-danger">*</span></label>
                            <textarea name="description" id="description" rows="3"
                                      class="form-control @error('description') is-invalid @enderror"
                                      placeholder="Mô tả chi tiết về đề xuất"
                                      required>{{ old('description') ?? $propose->description }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="justification">Lý do đề xuất <span class="text-danger">*</span></label>
                            <textarea name="justification" id="justification" rows="3"
                                      class="form-control @error('justification') is-invalid @enderror"
                                      placeholder="Giải thích lý do tại sao cần đề xuất này"
                                      required>{{ old('justification') ?? $propose->justification }}</textarea>
                            @error('justification')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="expected_benefit">Lợi ích kỳ vọng</label>
                            <textarea name="expected_benefit" id="expected_benefit" rows="3"
                                      class="form-control @error('expected_benefit') is-invalid @enderror"
                                      placeholder="Mô tả lợi ích dự kiến sẽ đạt được">{{ old('expected_benefit') ?? $propose->expected_benefit }}</textarea>
                            @error('expected_benefit')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="propose_type">Loại đề xuất <span class="text-danger">*</span></label>
                                    <select name="propose_type" id="propose_type" class="form-control @error('propose_type') is-invalid @enderror" required>
                                        <option value="">Chọn loại</option>
                                        <option value="equipment" {{ (old('propose_type') ?? $propose->propose_type) == 'equipment' ? 'selected' : '' }}>Thiết bị</option>
                                        <option value="supplies" {{ (old('propose_type') ?? $propose->propose_type) == 'supplies' ? 'selected' : '' }}>Vật tư</option>
                                        <option value="services" {{ (old('propose_type') ?? $propose->propose_type) == 'services' ? 'selected' : '' }}>Dịch vụ</option>
                                        <option value="software" {{ (old('propose_type') ?? $propose->propose_type) == 'software' ? 'selected' : '' }}>Phần mềm</option>
                                        <option value="training" {{ (old('propose_type') ?? $propose->propose_type) == 'training' ? 'selected' : '' }}>Đào tạo</option>
                                        <option value="travel" {{ (old('propose_type') ?? $propose->propose_type) == 'travel' ? 'selected' : '' }}>Đi lại</option>
                                        <option value="other" {{ (old('propose_type') ?? $propose->propose_type) == 'other' ? 'selected' : '' }}>Khác</option>
                                    </select>
                                    @error('propose_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="priority">Độ ưu tiên <span class="text-danger">*</span></label>
                                    <select name="priority" id="priority" class="form-control @error('priority') is-invalid @enderror" required>
                                        <option value="">Chọn độ ưu tiên</option>
                                        <option value="low" {{ (old('priority') ?? $propose->priority) == 'low' ? 'selected' : '' }}>Thấp</option>
                                        <option value="medium" {{ (old('priority') ?? $propose->priority) == 'medium' ? 'selected' : '' }}>Trung bình</option>
                                        <option value="high" {{ (old('priority') ?? $propose->priority) == 'high' ? 'selected' : '' }}>Cao</option>
                                        <option value="urgent" {{ (old('priority') ?? $propose->priority) == 'urgent' ? 'selected' : '' }}>Khẩn cấp</option>
                                    </select>
                                    @error('priority')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="budget_source">Nguồn ngân sách <span class="text-danger">*</span></label>
                                    <select name="budget_source" id="budget_source" class="form-control @error('budget_source') is-invalid @enderror" required>
                                        <option value="">Chọn nguồn</option>
                                        <option value="project_budget" {{ (old('budget_source') ?? $propose->budget_source) == 'project_budget' ? 'selected' : '' }}>Ngân sách dự án</option>
                                        <option value="department_budget" {{ (old('budget_source') ?? $propose->budget_source) == 'department_budget' ? 'selected' : '' }}>Ngân sách bộ phận</option>
                                        <option value="additional_budget" {{ (old('budget_source') ?? $propose->budget_source) == 'additional_budget' ? 'selected' : '' }}>Ngân sách bổ sung</option>
                                        <option value="external_funding" {{ (old('budget_source') ?? $propose->budget_source) == 'external_funding' ? 'selected' : '' }}>Nguồn bên ngoài</option>
                                    </select>
                                    @error('budget_source')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="needed_by_date">Cần trước ngày</label>
                                    <input type="date" name="needed_by_date" id="needed_by_date"
                                           class="form-control @error('needed_by_date') is-invalid @enderror"
                                           value="{{ old('needed_by_date') ?? ($propose->needed_by_date ? $propose->needed_by_date->format('Y-m-d') : '') }}"
                                           min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                                    @error('needed_by_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="expected_delivery_date">Dự kiến giao hàng</label>
                                    <input type="date" name="expected_delivery_date" id="expected_delivery_date"
                                           class="form-control @error('expected_delivery_date') is-invalid @enderror"
                                           value="{{ old('expected_delivery_date') ?? ($propose->expected_delivery_date ? $propose->expected_delivery_date->format('Y-m-d') : '') }}"
                                           min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                                    @error('expected_delivery_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Ngày dự kiến nhận được hàng</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="vendor_id">Nhà cung cấp đề xuất</label>
                                    <select name="vendor_id" id="vendor_id" class="form-control @error('vendor_id') is-invalid @enderror">
                                        <option value="">Chọn nhà cung cấp</option>
                                        @forelse($vendors as $vendor)
                                            <option value="{{ $vendor->id }}"
                                                {{ (old('vendor_id') ?? $propose->vendor_id) == $vendor->id ? 'selected' : '' }}>
                                                {{ $vendor->name }}
                                            </option>
                                        @empty
                                            <option value="" disabled>Không có nhà cung cấp nào</option>
                                        @endforelse
                                    </select>
                                    @error('vendor_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="is_urgent" id="is_urgent" class="custom-control-input"
                                       value="1" {{ (old('is_urgent') ?? $propose->is_urgent) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="is_urgent">
                                    Đánh dấu là cấp thiết
                                </label>
                            </div>
                        </div>

                        {{-- Current Attachments --}}
                        @if($propose->attachments && count($propose->attachments) > 0)
                            <div class="form-group">
                                <label>Tài liệu đã đính kèm</label>
                                <div class="card">
                                    <div class="card-body">
                                        @foreach($propose->attachments as $index => $attachment)
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <div>
                                                    <i class="fas fa-file"></i>
                                                    <a href="{{ route('proposes.download-attachment', [$propose, $index]) }}" target="_blank">
                                                        {{ $attachment['name'] }}
                                                    </a>
                                                    <small class="text-muted">({{ number_format($attachment['size'] / 1024, 1) }} KB)</small>
                                                </div>
                                                <button type="button" class="btn btn-sm btn-outline-danger remove-attachment" data-index="{{ $index }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- New Attachments --}}
                        <div class="form-group">
                            <label for="attachments">Thêm tài liệu đính kèm</label>
                            <input type="file" name="attachments[]" id="attachments"
                                   class="form-control-file @error('attachments.*') is-invalid @enderror"
                                   multiple
                                   accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png,.gif">
                            <small class="form-text text-muted">
                                Tối đa 10MB mỗi file. Định dạng cho phép: PDF, DOC, DOCX, XLS, XLSX, JPG, PNG, GIF
                            </small>
                            @error('attachments.*')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Items Section -->
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Danh sách hàng hóa/dịch vụ <span class="text-danger">*</span></h3>
                        <button type="button" id="add-item" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Thêm mục
                        </button>
                    </div>
                    <div class="card-body">
                        <div id="items-container">
                            {{-- Items will be loaded here from existing data or old input --}}
                        </div>
                        @error('items')
                            <div class="alert alert-danger mt-2">
                                <i class="fas fa-exclamation-triangle"></i> {{ $message }}
                            </div>
                        @enderror
                        <div class="row mt-3">
                            <div class="col-md-12 text-right">
                                <h5>Tổng cộng (bao gồm 10% VAT): <span id="total-amount">0</span> VND</h5>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Instructions -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Hướng dẫn</h3>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <h6><i class="fas fa-info-circle"></i> Lưu ý quan trọng:</h6>
                            <ul class="mb-0">
                                <li>Nhập đầy đủ thông tin để cập nhật đề xuất</li>
                                <li><strong>Phải có ít nhất một mục hàng hóa/dịch vụ</strong></li>
                                <li>Có thể thêm/xóa/sửa các mục hàng hóa/dịch vụ</li>
                                <li>Kiểm tra kỹ thông tin trước khi lưu</li>
                                @if($propose->status !== 'draft')
                                    <li class="text-warning"><strong>Lưu ý:</strong> Đề xuất này đã được gửi, việc chỉnh sửa có thể ảnh hưởng đến quy trình phê duyệt.</li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="form-group">
                    <button type="submit" class="btn btn-success" id="update-btn">
                        <i class="fas fa-save"></i> Cập nhật đề xuất
                    </button>
                    <a href="{{ route('proposes.show', $propose) }}" class="btn btn-info">
                        <i class="fas fa-eye"></i> Xem chi tiết
                    </a>
                    <a href="{{ route('proposes.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Quay lại danh sách
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Item Template for adding new items -->
<template id="item-template">
    <div class="item-row border p-3 mb-3" data-item-index="INDEX">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h6 class="mb-0">Mục hàng hóa/dịch vụ #<span class="item-number">INDEX</span></h6>
            <button type="button" class="btn btn-sm btn-danger remove-item">
                <i class="fas fa-trash"></i> Xóa
            </button>
        </div>

        <input type="hidden" name="items[INDEX][id]" class="item-id" value="">

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Tên hàng hóa/dịch vụ <span class="text-danger">*</span></label>
                    <input type="text" name="items[INDEX][name]" class="form-control item-name"
                           placeholder="Nhập tên hàng hóa/dịch vụ" required>
                    <div class="invalid-feedback item-name-error"></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Danh mục</label>
                    <select name="items[INDEX][category_id]" class="form-control item-category">
                        <option value="">Chọn danh mục</option>
                        @forelse($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @empty
                            <option value="" disabled>Không có danh mục nào</option>
                        @endforelse
                    </select>
                </div>
            </div>
        </div>


        <div class="form-group">
            <label>Mô tả</label>
            <textarea name="items[INDEX][description]" class="form-control item-description"
                      rows="2" placeholder="Mô tả chi tiết về hàng hóa/dịch vụ"></textarea>
        </div>

        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label>Số lượng <span class="text-danger">*</span></label>
                    <input type="number" name="items[INDEX][quantity]" class="form-control item-quantity"
                           step="0.01" min="0.01" placeholder="0" required>
                    <div class="invalid-feedback item-quantity-error"></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Đơn vị <span class="text-danger">*</span></label>
                    <input type="text" name="items[INDEX][unit]" class="form-control item-unit"
                           placeholder="cái, kg, lít..." maxlength="50" required>
                    <div class="invalid-feedback item-unit-error"></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Đơn giá (VND) <span class="text-danger">*</span></label>
                    <input type="number" name="items[INDEX][unit_price]" class="form-control item-price"
                           step="0.01" min="0" placeholder="0" required>
                    <div class="invalid-feedback item-price-error"></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Độ ưu tiên</label>
                    <select name="items[INDEX][priority]" class="form-control item-priority" required>
                        <option value="low">Thấp</option>
                        <option value="medium" selected>Trung bình</option>
                        <option value="high">Cao</option>
                        <option value="critical">Quan trọng</option>
                    </select>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Thương hiệu</label>
                    <input type="text" name="items[INDEX][brand]" class="form-control item-brand"
                           placeholder="Tên thương hiệu" maxlength="100">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Model</label>
                    <input type="text" name="items[INDEX][model]" class="form-control item-model"
                           placeholder="Số model" maxlength="100">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Cần trước ngày</label>
                    <input type="date" name="items[INDEX][needed_by_date]"
                           class="form-control item-needed-date"
                           min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                </div>
            </div>
        </div>

        <div class="form-group">
            <label>Thông số kỹ thuật</label>
            <textarea name="items[INDEX][specifications]" class="form-control item-specs"
                      rows="2" placeholder="Mô tả thông số kỹ thuật chi tiết"></textarea>
        </div>

        <div class="form-group">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" name="items[INDEX][is_essential]"
                       class="custom-control-input item-essential" id="essential-INDEX" value="1">
                <label class="custom-control-label" for="essential-INDEX">Bắt buộc có</label>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 text-right">
                <small class="text-muted">
                    Thành tiền: <span class="item-total">0</span> VND
                </small>
            </div>
        </div>
    </div>
</template>

@endsection
@push('scripts')
<script>
$(document).ready(function() {
    let itemIndex = 0;

    // Load existing items first
    @if(old('items'))
        // Load old input data for items if validation failed
        @foreach(old('items') as $index => $item)
            addItemWithData({{ $index }}, {!! json_encode($item) !!});
        @endforeach
    @else
        // Load existing items from the propose
        @foreach($propose->items as $index => $item)
            addItemWithData({{ $index }}, {!! json_encode([
                'id' => $item->id,
                'name' => $item->name,
                'description' => $item->description,
                'quantity' => $item->quantity,
                'unit_price' => $item->unit_price,
                'unit' => $item->unit,
                'category_id' => $item->category_id,
                'brand' => $item->brand,
                'model' => $item->model,
                'specifications' => $item->specifications,
                'priority' => $item->priority,
                'is_essential' => $item->is_essential,
                'needed_by_date' => $item->needed_by_date ? $item->needed_by_date->format('Y-m-d') : null
            ]) !!});
        @endforeach
    @endif

    // If no items loaded, add one empty item
    if ($('.item-row').length === 0) {
        addNewItem();
    }

    // Form validation before submit
    $('#propose-edit-form').on('submit', function(e) {
        let isValid = true;
        let errorMessages = [];

        // Check if there are any items
        if ($('.item-row').length === 0) {
            isValid = false;
            errorMessages.push('Phải có ít nhất một mục hàng hóa/dịch vụ.');
        }

        // Validate each item
        $('.item-row').each(function(index) {
            let itemNumber = index + 1;
            let $row = $(this);

            // Check required fields
            let name = $row.find('.item-name').val().trim();
            let quantity = $row.find('.item-quantity').val();
            let unit = $row.find('.item-unit').val().trim();
            let price = $row.find('.item-price').val();

            if (!name) {
                isValid = false;
                errorMessages.push('Mục ' + itemNumber + ': Tên hàng hóa/dịch vụ là bắt buộc.');
                $row.find('.item-name').addClass('is-invalid');
            } else {
                $row.find('.item-name').removeClass('is-invalid');
            }

            if (!quantity || parseFloat(quantity) <= 0) {
                isValid = false;
                errorMessages.push('Mục ' + itemNumber + ': Số lượng phải lớn hơn 0.');
                $row.find('.item-quantity').addClass('is-invalid');
            } else {
                $row.find('.item-quantity').removeClass('is-invalid');
            }

            if (!unit) {
                isValid = false;
                errorMessages.push('Mục ' + itemNumber + ': Đơn vị là bắt buộc.');
                $row.find('.item-unit').addClass('is-invalid');
            } else {
                $row.find('.item-unit').removeClass('is-invalid');
            }

            if (!price || parseFloat(price) < 0) {
                isValid = false;
                errorMessages.push('Mục ' + itemNumber + ': Đơn giá phải lớn hơn hoặc bằng 0.');
                $row.find('.item-price').addClass('is-invalid');
            } else {
                $row.find('.item-price').removeClass('is-invalid');
            }
        });

        if (!isValid) {
            e.preventDefault();
            let errorHtml = '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
            errorHtml += '<h5><i class="fas fa-exclamation-circle"></i> Vui lòng kiểm tra các lỗi sau:</h5>';
            errorHtml += '<ul class="mb-0">';
            errorMessages.forEach(function(msg) {
                errorHtml += '<li>' + msg + '</li>';
            });
            errorHtml += '</ul>';
            errorHtml += '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
            errorHtml += '<span aria-hidden-true">&times;</span>';
            errorHtml += '</button></div>';

            $('.container-fluid').prepend(errorHtml);
            $('html, body').animate({scrollTop: 0}, 500);
            return false;
        }

        // Show loading state
        $('#update-btn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Đang cập nhật...');
    });

    // Add item
    $('#add-item').click(function() {
        addNewItem();
    });

    // Remove item
    $(document).on('click', '.remove-item', function() {
        if ($('.item-row').length > 1) {
            $(this).closest('.item-row').remove();
            updateItemNumbers();
            updateTotal();
        } else {
            alert('Phải có ít nhất một mục hàng hóa/dịch vụ!');
        }
    });

    // Update total when quantity or price changes
    $(document).on('input', '.item-quantity, .item-price', function() {
        updateItemTotal($(this).closest('.item-row'));
        updateTotal();
    });

    // Clear invalid state when user starts typing
    $(document).on('input', '.item-name, .item-quantity, .item-unit, .item-price', function() {
        $(this).removeClass('is-invalid');
    });

    // Remove attachment functionality
    $(document).on('click', '.remove-attachment', function() {
        let index = $(this).data('index');
        if (confirm('Bạn có chắc chắn muốn xóa file này?')) {
            // Add hidden input to mark for deletion
            if (!$('#removed-attachments').length) {
                $('#propose-edit-form').append('<input type="hidden" name="removed_attachments" id="removed-attachments" value="">');
            }

            let removedList = $('#removed-attachments').val();
            removedList = removedList ? removedList + ',' + index : index;
            $('#removed-attachments').val(removedList);

            $(this).closest('.d-flex').remove();
        }
    });

    // Add validation for expected_delivery_date relationship
    $('#expected_delivery_date, #needed_by_date').on('change', function() {
        const neededDate = $('#needed_by_date').val();
        const expectedDeliveryDate = $('#expected_delivery_date').val();

        if (neededDate && expectedDeliveryDate) {
            if (new Date(expectedDeliveryDate) > new Date(neededDate)) {
                $('#expected_delivery_date').addClass('is-invalid');
                if (!$('#expected_delivery_date').next('.invalid-feedback').length) {
                    $('#expected_delivery_date').after('<div class="invalid-feedback">Ngày giao hàng phải trước ngày cần thiết</div>');
                }
            } else {
                $('#expected_delivery_date').removeClass('is-invalid');
                $('#expected_delivery_date').next('.invalid-feedback').remove();
            }
        }
    });

    function addNewItem() {
        const template = $('#item-template').html();
        const itemHtml = template.replace(/INDEX/g, itemIndex);
        $('#items-container').append(itemHtml);

        // Update checkbox ID and label for attribute
        $('#items-container').find('.item-essential').last().attr('id', 'essential-' + itemIndex);
        $('#items-container').find('label[for="essential-INDEX"]').last().attr('for', 'essential-' + itemIndex);

        itemIndex++;
        updateItemNumbers();
        updateTotal();

        // Scroll to new item
        $('html, body').animate({
            scrollTop: $('.item-row').last().offset().top - 100
        }, 500);
    }

    function addItemWithData(index, data) {
        const template = $('#item-template').html();
        const itemHtml = template.replace(/INDEX/g, index);
        const $itemRow = $(itemHtml);

        // Fill in data (either existing or old input)
        $itemRow.find('.item-id').val(data.id || '');
        $itemRow.find('.item-name').val(data.name || '');
        $itemRow.find('.item-description').val(data.description || '');
        $itemRow.find('.item-quantity').val(data.quantity || '');
        $itemRow.find('.item-unit').val(data.unit || '');
        $itemRow.find('.item-price').val(data.unit_price || '');
        $itemRow.find('.item-category').val(data.category_id || '');
        $itemRow.find('.item-brand').val(data.brand || '');
        $itemRow.find('.item-model').val(data.model || '');
        $itemRow.find('.item-specs').val(data.specifications || '');
        $itemRow.find('.item-priority').val(data.priority || 'medium');
        $itemRow.find('.item-essential').prop('checked', data.is_essential == '1' || data.is_essential === true);
        $itemRow.find('.item-needed-date').val(data.needed_by_date || '');

        // Update checkbox ID and label for attribute
        $itemRow.find('.item-essential').attr('id', 'essential-' + index);
        $itemRow.find('label[for="essential-INDEX"]').attr('for', 'essential-' + index);

        $('#items-container').append($itemRow);

        if (index >= itemIndex) {
            itemIndex = index + 1;
        }

        updateItemTotal($itemRow);
        updateItemNumbers();
        updateTotal();
    }

    function updateItemNumbers() {
        $('.item-row').each(function(index) {
            $(this).find('.item-number').text(index + 1);
            $(this).attr('data-item-index', index + 1);
        });
    }

    function updateItemTotal($itemRow) {
        const quantity = parseFloat($itemRow.find('.item-quantity').val()) || 0;
        const price = parseFloat($itemRow.find('.item-price').val()) || 0;
        const total = quantity * price;

        $itemRow.find('.item-total').text(new Intl.NumberFormat('vi-VN').format(total));
    }

    function updateTotal() {
        let total = 0;
        $('.item-row').each(function() {
            const quantity = parseFloat($(this).find('.item-quantity').val()) || 0;
            const price = parseFloat($(this).find('.item-price').val()) || 0;
            total += quantity * price;
        });

        // Add 10% VAT
        total = total * 1.1;

        $('#total-amount').text(new Intl.NumberFormat('vi-VN').format(total));
    }

    // File upload validation
    $('#attachments').on('change', function() {
        const files = this.files;
        const maxFileSize = 10 * 1024 * 1024; // 10MB
        const allowedTypes = [
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'image/jpeg',
            'image/jpg',
            'image/png',
            'image/gif'
        ];

        let isValid = true;
        let errorMessages = [];

        Array.from(files).forEach(function(file, index) {
            if (file.size > maxFileSize) {
                isValid = false;
                errorMessages.push('File "' + file.name + '" vượt quá kích thước cho phép (10MB).');
            }

            if (!allowedTypes.includes(file.type)) {
                isValid = false;
                errorMessages.push('File "' + file.name + '" không đúng định dạng cho phép.');
            }
        });

        if (!isValid) {
            $(this).val(''); // Clear the input
            alert('Lỗi tải file:\n' + errorMessages.join('\n'));
        }
    });

    // Show confirmation before leaving page with unsaved changes
    let formChanged = false;
    $('#propose-edit-form').on('input change', function() {
        formChanged = true;
    });

    $('#propose-edit-form').on('submit', function() {
        formChanged = false;
    });

    $(window).on('beforeunload', function(e) {
        if (formChanged) {
            const message = 'Bạn có thay đổi chưa được lưu. Bạn có chắc chắn muốn rời khỏi trang?';
            e.returnValue = message;
            return message;
        }
    });

    // Dynamic priority indicator
    $(document).on('change', '.item-priority', function() {
        const $row = $(this).closest('.item-row');
        const priority = $(this).val();

        $row.removeClass('border-warning border-danger border-info border-secondary');

        switch(priority) {
            case 'critical':
                $row.addClass('border-danger');
                break;
            case 'high':
                $row.addClass('border-warning');
                break;
            case 'medium':
                $row.addClass('border-info');
                break;
            default:
                $row.addClass('border-secondary');
        }
    });

    // Initialize priority colors for existing items
    $('.item-priority').trigger('change');

    // Initialize total calculation
    updateTotal();
});
</script>
@endpush

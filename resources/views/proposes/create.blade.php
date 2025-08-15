@extends('layouts.app')

@section('title', 'Tạo đề xuất mới')

@section('content')
    <div class="container-fluid">
        {{-- Display Error Messages --}}
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <h5><i class="fas fa-exclamation-circle"></i> Có lỗi xảy ra khi tạo đề xuất:</h5>
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

        <form action="{{ route('proposes.store') }}" method="POST" enctype="multipart/form-data" id="propose-form">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Thông tin đề xuất</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="project_id">Dự án <span class="text-danger">*</span></label>
                                        <select name="project_id" id="project_id"
                                            class="form-control @error('project_id') is-invalid @enderror" required>
                                            <option value="">Chọn dự án</option>
                                            @forelse($projects as $project)
                                                <option value="{{ $project->id }}" {{ old('project_id') == $project->id ? 'selected' : '' }}>
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
                                        <select name="department_id" id="department_id"
                                            class="form-control @error('department_id') is-invalid @enderror" required>
                                            <option value="">Chọn bộ phận</option>
                                            @forelse($departments as $department)
                                                <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>
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
                                    class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}"
                                    placeholder="Nhập tiêu đề đề xuất" maxlength="255" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Tối đa 255 ký tự</small>
                            </div>

                            <div class="form-group">
                                <label for="description">Mô tả <span class="text-danger">*</span></label>
                                <textarea name="description" id="description" rows="3"
                                    class="form-control @error('description') is-invalid @enderror"
                                    placeholder="Mô tả chi tiết về đề xuất" required>{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="justification">Lý do đề xuất <span class="text-danger">*</span></label>
                                <textarea name="justification" id="justification" rows="3"
                                    class="form-control @error('justification') is-invalid @enderror"
                                    placeholder="Giải thích lý do tại sao cần đề xuất này"
                                    required>{{ old('justification') }}</textarea>
                                @error('justification')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="expected_benefit">Lợi ích kỳ vọng</label>
                                <textarea name="expected_benefit" id="expected_benefit" rows="3"
                                    class="form-control @error('expected_benefit') is-invalid @enderror"
                                    placeholder="Mô tả lợi ích dự kiến sẽ đạt được">{{ old('expected_benefit') }}</textarea>
                                @error('expected_benefit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="propose_type">Loại đề xuất <span class="text-danger">*</span></label>
                                        <select name="propose_type" id="propose_type"
                                            class="form-control @error('propose_type') is-invalid @enderror" required>
                                            <option value="">Chọn loại</option>
                                            <option value="equipment" {{ old('propose_type') == 'equipment' ? 'selected' : '' }}>Thiết bị</option>
                                            <option value="supplies" {{ old('propose_type') == 'supplies' ? 'selected' : '' }}>Vật tư</option>
                                            <option value="services" {{ old('propose_type') == 'services' ? 'selected' : '' }}>Dịch vụ</option>
                                            <option value="software" {{ old('propose_type') == 'software' ? 'selected' : '' }}>Phần mềm</option>
                                            <option value="training" {{ old('propose_type') == 'training' ? 'selected' : '' }}>Đào tạo</option>
                                            <option value="travel" {{ old('propose_type') == 'travel' ? 'selected' : '' }}>Đi
                                                lại</option>
                                            <option value="other" {{ old('propose_type') == 'other' ? 'selected' : '' }}>Khác
                                            </option>
                                        </select>
                                        @error('propose_type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="priority">Độ ưu tiên <span class="text-danger">*</span></label>
                                        <select name="priority" id="priority"
                                            class="form-control @error('priority') is-invalid @enderror" required>
                                            <option value="">Chọn độ ưu tiên</option>
                                            <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Thấp</option>
                                            <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>Trung
                                                bình</option>
                                            <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>Cao
                                            </option>
                                            <option value="urgent" {{ old('priority') == 'urgent' ? 'selected' : '' }}>Khẩn
                                                cấp</option>
                                        </select>
                                        @error('priority')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="budget_source">Nguồn ngân sách <span
                                                class="text-danger">*</span></label>
                                        <select name="budget_source" id="budget_source"
                                            class="form-control @error('budget_source') is-invalid @enderror" required>
                                            <option value="">Chọn nguồn</option>
                                            <option value="project_budget" {{ old('budget_source') == 'project_budget' ? 'selected' : '' }}>Ngân sách dự án</option>
                                            <option value="department_budget" {{ old('budget_source') == 'department_budget' ? 'selected' : '' }}>Ngân sách bộ phận</option>
                                            <option value="additional_budget" {{ old('budget_source') == 'additional_budget' ? 'selected' : '' }}>Ngân sách bổ sung</option>
                                            <option value="external_funding" {{ old('budget_source') == 'external_funding' ? 'selected' : '' }}>Nguồn bên ngoài</option>
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
                                            value="{{ old('needed_by_date') }}"
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
                                            value="{{ old('expected_delivery_date') }}"
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
                                        <select name="vendor_id" id="vendor_id"
                                            class="form-control @error('vendor_id') is-invalid @enderror">
                                            <option value="">Chọn nhà cung cấp</option>
                                            @forelse($vendors as $vendor)
                                                <option value="{{ $vendor->id }}" {{ old('vendor_id') == $vendor->id ? 'selected' : '' }}>
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
                                        value="1" {{ old('is_urgent') ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="is_urgent">
                                        Đánh dấu là cấp thiết
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="attachments">Tài liệu đính kèm</label>
                                <input type="file" name="attachments[]" id="attachments"
                                    class="form-control-file @error('attachments.*') is-invalid @enderror" multiple
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
                                {{-- Items will be added here dynamically --}}
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
                                    <li>Nhập đầy đủ thông tin để tạo đề xuất</li>
                                    <li><strong>Phải có ít nhất một mục hàng hóa/dịch vụ</strong></li>
                                    <li>Đề xuất sẽ ở trạng thái nháp sau khi tạo</li>
                                    <li>Có thể chỉnh sửa và bổ sung thông tin sau khi tạo</li>
                                    <li>Kiểm tra kỹ thông tin trước khi lưu</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="form-group">
                        <button type="submit" class="btn btn-success" id="submit-btn">
                            <i class="fas fa-save"></i> Tạo đề xuất
                        </button>
                        <a href="{{ route('proposes.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Quay lại
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
                <textarea name="items[INDEX][description]" class="form-control item-description" rows="2"
                    placeholder="Mô tả chi tiết về hàng hóa/dịch vụ"></textarea>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Số lượng <span class="text-danger">*</span></label>
                        <input type="number" name="items[INDEX][quantity]" class="form-control item-quantity" step="0.01"
                            min="0.01" placeholder="0" required>
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
                        <input type="number" name="items[INDEX][unit_price]" class="form-control item-price" step="0.01"
                            min="0" placeholder="0" required>
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
                        <input type="text" name="items[INDEX][model]" class="form-control item-model" placeholder="Số model"
                            maxlength="100">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Cần trước ngày</label>
                        <input type="date" name="items[INDEX][needed_by_date]" class="form-control item-needed-date"
                            min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Thông số kỹ thuật</label>
                <textarea name="items[INDEX][specifications]" class="form-control item-specs" rows="2"
                    placeholder="Mô tả thông số kỹ thuật chi tiết"></textarea>
            </div>

            <div class="form-group">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" name="items[INDEX][is_essential]" class="custom-control-input item-essential"
                        id="essential-INDEX" value="1">
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
        $(document).ready(function () {
            let itemIndex = 0;

            // Load old input data for items if validation failed
            @if(old('items'))
                @foreach(old('items') as $index => $item)
                    addItemWithData({{ $index }}, @json($item));
                @endforeach
            @else
                // Add first item by default if no old data
                addNewItem();
            @endif

            // Form validation before submit
            $('#propose-form').on('submit', function (e) {
                let isValid = true;
                let errorMessages = [];

                // Check if there are any items
                if ($('.item-row').length === 0) {
                    isValid = false;
                    errorMessages.push('Phải có ít nhất một mục hàng hóa/dịch vụ.');
                }

                // Validate each item
                $('.item-row').each(function (index) {
                    let itemNumber = index + 1;
                    let $row = $(this);

                    // Check required fields
                    let name = $row.find('.item-name').val().trim();
                    let quantity = $row.find('.item-quantity').val();
                    let unit = $row.find('.item-unit').val().trim();
                    let price = $row.find('.item-price').val();

                    if (!name) {
                        isValid = false;
                        errorMessages.push(`Mục ${itemNumber}: Tên hàng hóa/dịch vụ là bắt buộc.`);
                        $row.find('.item-name').addClass('is-invalid');
                    } else {
                        $row.find('.item-name').removeClass('is-invalid');
                    }

                    if (!quantity || parseFloat(quantity) <= 0) {
                        isValid = false;
                        errorMessages.push(`Mục ${itemNumber}: Số lượng phải lớn hơn 0.`);
                        $row.find('.item-quantity').addClass('is-invalid');
                    } else {
                        $row.find('.item-quantity').removeClass('is-invalid');
                    }

                    if (!unit) {
                        isValid = false;
                        errorMessages.push(`Mục ${itemNumber}: Đơn vị là bắt buộc.`);
                        $row.find('.item-unit').addClass('is-invalid');
                    } else {
                        $row.find('.item-unit').removeClass('is-invalid');
                    }

                    if (!price || parseFloat(price) < 0) {
                        isValid = false;
                        errorMessages.push(`Mục ${itemNumber}: Đơn giá phải lớn hơn hoặc bằng 0.`);
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
                    errorMessages.forEach(function (msg) {
                        errorHtml += '<li>' + msg + '</li>';
                    });
                    errorHtml += '</ul>';
                    errorHtml += '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
                    errorHtml += '<span aria-hidden="true">&times;</span>';
                    errorHtml += '</button></div>';

                    $('.container-fluid').prepend(errorHtml);
                    $('html, body').animate({ scrollTop: 0 }, 500);
                    return false;
                }

                // Show loading state
                $('#submit-btn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Đang tạo...');
            });

            // Add item
            $('#add-item').click(function () {
                addNewItem();
            });

            // Remove item
            $(document).on('click', '.remove-item', function () {
                if ($('.item-row').length > 1) {
                    $(this).closest('.item-row').remove();
                    updateItemNumbers();
                    updateTotal();
                } else {
                    alert('Phải có ít nhất một mục hàng hóa/dịch vụ!');
                }
            });

            // Update total when quantity or price changes
            $(document).on('input', '.item-quantity, .item-price', function () {
                updateItemTotal($(this).closest('.item-row'));
                updateTotal();
            });

            // Clear invalid state when user starts typing
            $(document).on('input', '.item-name, .item-quantity, .item-unit, .item-price', function () {
                $(this).removeClass('is-invalid');
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

                // Fill in old data
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
                $itemRow.find('.item-essential').prop('checked', data.is_essential == '1');
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
                $('.item-row').each(function (index) {
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
                $('.item-row').each(function () {
                    const quantity = parseFloat($(this).find('.item-quantity').val()) || 0;
                    const price = parseFloat($(this).find('.item-price').val()) || 0;
                    total += quantity * price;
                });

                // Add 10% VAT
                total = total * 1.1;

                $('#total-amount').text(new Intl.NumberFormat('vi-VN').format(total));
            }

            // File upload validation
            $('#attachments').on('change', function () {
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

                Array.from(files).forEach(function (file, index) {
                    if (file.size > maxFileSize) {
                        isValid = false;
                        errorMessages.push(`File "${file.name}" vượt quá kích thước cho phép (10MB).`);
                    }

                    if (!allowedTypes.includes(file.type)) {
                        isValid = false;
                        errorMessages.push(`File "${file.name}" không đúng định dạng cho phép.`);
                    }
                });

                if (!isValid) {
                    $(this).val(''); // Clear the input
                    alert('Lỗi tải file:\n' + errorMessages.join('\n'));
                }
            });

            // Auto-save draft functionality (optional)
            let autoSaveTimer;
            function scheduleAutoSave() {
                clearTimeout(autoSaveTimer);
                autoSaveTimer = setTimeout(function () {
                    saveAsDraft();
                }, 30000); // Auto-save after 30 seconds of inactivity
            }

            function saveAsDraft() {
                // Implementation for auto-saving draft
                // This would send an AJAX request to save the current form data as draft
                console.log('Auto-saving draft...');
            }

            // Schedule auto-save on form input changes
            $('#propose-form').on('input change', 'input, select, textarea', function () {
                scheduleAutoSave();
            });

            // Prevent accidental form submission on Enter key
            $('#propose-form').on('keydown', 'input:not([type=submit])', function (e) {
                if (e.keyCode === 13) {
                    e.preventDefault();
                    return false;
                }
            });

            // Add validation for expected_delivery_date relationship
            $('#expected_delivery_date, #needed_by_date').on('change', function () {
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

            // Show confirmation before leaving page with unsaved changes
            let formChanged = false;
            $('#propose-form').on('input change', function () {
                formChanged = true;
            });

            $('#propose-form').on('submit', function () {
                formChanged = false;
            });

            $(window).on('beforeunload', function (e) {
                if (formChanged) {
                    const message = 'Bạn có thay đổi chưa được lưu. Bạn có chắc chắn muốn rời khỏi trang?';
                    e.returnValue = message;
                    return message;
                }
            });

            // Dynamic priority indicator
            $(document).on('change', '.item-priority', function () {
                const $row = $(this).closest('.item-row');
                const priority = $(this).val();

                $row.removeClass('border-warning border-danger border-info border-secondary');

                switch (priority) {
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
        });

        // Additional utility functions
        function formatCurrency(amount) {
            return new Intl.NumberFormat('vi-VN', {
                style: 'currency',
                currency: 'VND'
            }).format(amount);
        }

        function validateEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }

        function showLoadingOverlay() {
            const overlay = `
            <div id="loading-overlay" style="
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0,0,0,0.5);
                z-index: 9999;
                display: flex;
                justify-content: center;
                align-items: center;
            ">
                <div style="
                    background: white;
                    padding: 20px;
                    border-radius: 5px;
                    text-align: center;
                ">
                    <i class="fas fa-spinner fa-spin fa-2x"></i>
                    <p class="mt-2">Đang xử lý...</p>
                </div>
            </div>
        `;
            $('body').append(overlay);
        }

        function hideLoadingOverlay() {
            $('#loading-overlay').remove();
        }
    </script>
@endpush

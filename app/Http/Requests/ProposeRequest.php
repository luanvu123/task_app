<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Propose;

class ProposeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Check if user can create propose or update existing one
        if ($this->route('propose')) {
            return $this->user()->can('update', $this->route('propose'));
        }

        return $this->user()->can('create', Propose::class);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $rules = [
            // Basic propose information
            'project_id' => 'required|exists:projects,id',
            'department_id' => 'required|exists:departments,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:5000',
            'justification' => 'required|string|max:5000',
            'expected_benefit' => 'nullable|string|max:5000',

            // Propose classification
            'propose_type' => 'required|in:equipment,supplies,services,software,training,travel,other',
            'priority' => 'required|in:low,medium,high,urgent',
            'is_urgent' => 'boolean',
            'budget_source' => 'required|in:project_budget,department_budget,additional_budget,external_funding',

            // Dates
            'needed_by_date' => 'nullable|date|after:today',
            'expected_delivery_date' => 'nullable|date|after_or_equal:needed_by_date',

            // Optional vendor
            'vendor_id' => 'nullable|exists:vendors,id',

            // File attachments
            'attachments' => 'nullable|array|max:10',
            'attachments.*' => 'file|max:10240|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png,gif',
            'quotation_files' => 'nullable|array|max:5',
            'quotation_files.*' => 'file|max:10240|mimes:pdf,doc,docx,xls,xlsx',

            // Items validation
            'items' => 'required|array|min:1|max:50',
            'items.*.id' => 'nullable|exists:propose_items,id',
            'items.*.name' => 'required|string|max:255',
            'items.*.description' => 'nullable|string|max:1000',
            'items.*.specifications' => 'nullable|string|max:2000',
            'items.*.brand' => 'nullable|string|max:100',
            'items.*.model' => 'nullable|string|max:100',
            'items.*.item_code' => 'nullable|string|max:50',

            // Item classification
            'items.*.category_id' => 'nullable|exists:item_categories,id',
            'items.*.unit' => 'required|string|max:20',

            // Quantity and pricing
            'items.*.quantity' => 'required|numeric|min:0.01|max:999999.99',
            'items.*.unit_price' => 'required|numeric|min:0|max:999999999.99',
            'items.*.discount_percent' => 'nullable|numeric|min:0|max:100',
            'items.*.tax_percent' => 'nullable|numeric|min:0|max:100',

            // Item priority and requirements
            'items.*.priority' => 'required|in:low,medium,high,critical',
            'items.*.is_essential' => 'boolean',
            'items.*.needed_by_date' => 'nullable|date|after:today',
            'items.*.quality_requirements' => 'nullable|string|max:1000',
            'items.*.technical_requirements' => 'nullable|string|max:1000',
            'items.*.warranty_period' => 'nullable|string|max:100',

            // Vendor for each item
            'items.*.preferred_vendor_id' => 'nullable|exists:vendors,id',

            // Item attachments
            'items.*.attachments' => 'nullable|array|max:5',
            'items.*.attachments.*' => 'file|max:5120|mimes:pdf,jpg,jpeg,png,gif',
        ];

        // Additional rules for updating
        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            // When updating, make sure item IDs belong to this propose
            $rules['items.*.id'] = [
                'nullable',
                'exists:propose_items,id',
                function ($attribute, $value, $fail) {
                    if ($value && $this->route('propose')) {
                        $itemExists = $this->route('propose')
                            ->items()
                            ->where('id', $value)
                            ->exists();

                        if (!$itemExists) {
                            $fail('The selected item does not belong to this propose.');
                        }
                    }
                },
            ];
        }

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'project_id.required' => 'Vui lòng chọn dự án.',
            'project_id.exists' => 'Dự án được chọn không tồn tại.',
            'department_id.required' => 'Vui lòng chọn bộ phận.',
            'department_id.exists' => 'Bộ phận được chọn không tồn tại.',
            'title.required' => 'Vui lòng nhập tiêu đề đề xuất.',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự.',
            'description.required' => 'Vui lòng nhập mô tả đề xuất.',
            'description.max' => 'Mô tả không được vượt quá 5000 ký tự.',
            'justification.required' => 'Vui lòng nhập lý do đề xuất.',
            'justification.max' => 'Lý do đề xuất không được vượt quá 5000 ký tự.',
            'expected_benefit.max' => 'Lợi ích mong đợi không được vượt quá 5000 ký tự.',

            'propose_type.required' => 'Vui lòng chọn loại đề xuất.',
            'propose_type.in' => 'Loại đề xuất không hợp lệ.',
            'priority.required' => 'Vui lòng chọn độ ưu tiên.',
            'priority.in' => 'Độ ưu tiên không hợp lệ.',
            'budget_source.required' => 'Vui lòng chọn nguồn ngân sách.',
            'budget_source.in' => 'Nguồn ngân sách không hợp lệ.',

            'needed_by_date.after' => 'Ngày cần có phải sau ngày hôm nay.',
            'expected_delivery_date.after_or_equal' => 'Ngày giao hàng dự kiến phải sau hoặc bằng ngày cần có.',

            'vendor_id.exists' => 'Nhà cung cấp được chọn không tồn tại.',

            'attachments.max' => 'Chỉ được đính kèm tối đa 10 file.',
            'attachments.*.file' => 'File đính kèm không hợp lệ.',
            'attachments.*.max' => 'File đính kèm không được vượt quá 10MB.',
            'attachments.*.mimes' => 'File đính kèm phải có định dạng: pdf, doc, docx, xls, xlsx, jpg, jpeg, png, gif.',

            'items.required' => 'Phải có ít nhất một mục hàng hóa/dịch vụ.',
            'items.min' => 'Phải có ít nhất một mục hàng hóa/dịch vụ.',
            'items.max' => 'Không được vượt quá 50 mục hàng hóa/dịch vụ.',

            'items.*.name.required' => 'Vui lòng nhập tên hàng hóa/dịch vụ.',
            'items.*.name.max' => 'Tên hàng hóa/dịch vụ không được vượt quá 255 ký tự.',
            'items.*.description.max' => 'Mô tả không được vượt quá 1000 ký tự.',
            'items.*.specifications.max' => 'Thông số kỹ thuật không được vượt quá 2000 ký tự.',

            'items.*.unit.required' => 'Vui lòng nhập đơn vị tính.',
            'items.*.unit.max' => 'Đơn vị tính không được vượt quá 20 ký tự.',

            'items.*.quantity.required' => 'Vui lòng nhập số lượng.',
            'items.*.quantity.numeric' => 'Số lượng phải là số.',
            'items.*.quantity.min' => 'Số lượng phải lớn hơn 0.',
            'items.*.quantity.max' => 'Số lượng quá lớn.',

            'items.*.unit_price.required' => 'Vui lòng nhập đơn giá.',
            'items.*.unit_price.numeric' => 'Đơn giá phải là số.',
            'items.*.unit_price.min' => 'Đơn giá không được âm.',
            'items.*.unit_price.max' => 'Đơn giá quá lớn.',

            'items.*.discount_percent.numeric' => 'Phần trăm chiết khấu phải là số.',
            'items.*.discount_percent.min' => 'Phần trăm chiết khấu không được âm.',
            'items.*.discount_percent.max' => 'Phần trăm chiết khấu không được vượt quá 100%.',

            'items.*.tax_percent.numeric' => 'Phần trăm thuế phải là số.',
            'items.*.tax_percent.min' => 'Phần trăm thuế không được âm.',
            'items.*.tax_percent.max' => 'Phần trăm thuế không được vượt quá 100%.',

            'items.*.priority.required' => 'Vui lòng chọn độ ưu tiên.',
            'items.*.priority.in' => 'Độ ưu tiên không hợp lệ.',

            'items.*.needed_by_date.after' => 'Ngày cần có phải sau ngày hôm nay.',

            'items.*.preferred_vendor_id.exists' => 'Nhà cung cấp ưu tiên không tồn tại.',
            'items.*.category_id.exists' => 'Danh mục không tồn tại.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'project_id' => 'dự án',
            'department_id' => 'bộ phận',
            'title' => 'tiêu đề',
            'description' => 'mô tả',
            'justification' => 'lý do đề xuất',
            'expected_benefit' => 'lợi ích mong đợi',
            'propose_type' => 'loại đề xuất',
            'priority' => 'độ ưu tiên',
            'budget_source' => 'nguồn ngân sách',
            'needed_by_date' => 'ngày cần có',
            'expected_delivery_date' => 'ngày giao hàng dự kiến',
            'vendor_id' => 'nhà cung cấp',
            'items' => 'danh sách hàng hóa/dịch vụ',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Convert string "true"/"false" to boolean for checkboxes
        if ($this->has('is_urgent')) {
            $this->merge([
                'is_urgent' => filter_var($this->is_urgent, FILTER_VALIDATE_BOOLEAN)
            ]);
        }

        // Prepare items data
        if ($this->has('items')) {
            $items = collect($this->items)->map(function ($item) {
                // Convert boolean fields
                if (isset($item['is_essential'])) {
                    $item['is_essential'] = filter_var($item['is_essential'], FILTER_VALIDATE_BOOLEAN);
                }

                // Set default tax percent if not provided
                if (!isset($item['tax_percent']) || $item['tax_percent'] === '') {
                    $item['tax_percent'] = 10; // Default VAT 10%
                }

                // Set default discount percent if not provided
                if (!isset($item['discount_percent']) || $item['discount_percent'] === '') {
                    $item['discount_percent'] = 0;
                }

                return $item;
            })->toArray();

            $this->merge(['items' => $items]);
        }
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            // Custom validation: Check if needed_by_date is reasonable
            if ($this->needed_by_date && $this->expected_delivery_date) {
                $neededBy = \Carbon\Carbon::parse($this->needed_by_date);
                $expectedDelivery = \Carbon\Carbon::parse($this->expected_delivery_date);

                if ($expectedDelivery->gt($neededBy)) {
                    $validator->errors()->add(
                        'expected_delivery_date',
                        'Ngày giao hàng dự kiến không được sau ngày cần có.'
                    );
                }
            }

            // Custom validation: Check total amount reasonableness
            if ($this->has('items')) {
                $totalAmount = collect($this->items)->sum(function ($item) {
                    return ($item['quantity'] ?? 0) * ($item['unit_price'] ?? 0);
                });

                // Check if total amount is too large (over 10 billion VND)
                if ($totalAmount > 10000000000) {
                    $validator->errors()->add('items', 'Tổng giá trị đề xuất quá lớn (trên 10 tỷ VNĐ).');
                }
            }

            // Custom validation: Check essential items have reasonable dates
            if ($this->has('items')) {
                foreach ($this->items as $index => $item) {
                    if (($item['is_essential'] ?? false) && empty($item['needed_by_date'])) {
                        $validator->errors()->add(
                            "items.{$index}.needed_by_date",
                            'Mục bắt buộc phải có ngày cần có.'
                        );
                    }
                }
            }
        });
    }
}

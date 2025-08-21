<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $customerId = $this->route('customer') ? $this->route('customer')->id : null;

        return [
            'name' => 'required|string|max:255',
            'code' => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('customers', 'code')->ignore($customerId),
            ],
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:1000',
            'contact_person' => 'nullable|string|max:255',
            'contact_position' => 'nullable|string|max:255',
            'tax_code' => 'nullable|string|max:50',
            'type' => 'required|in:individual,company',
            'status' => 'required|in:active,inactive,potential',
            'description' => 'nullable|string|max:2000',
            'additional_info' => 'nullable|array',
            'additional_info.*' => 'nullable|string|max:500',

            // For additional info form fields
            'additional_info_keys' => 'nullable|array',
            'additional_info_keys.*' => 'nullable|string|max:100',
            'additional_info_values' => 'nullable|array',
            'additional_info_values.*' => 'nullable|string|max:500',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'name' => 'tên khách hàng',
            'code' => 'mã khách hàng',
            'email' => 'email',
            'phone' => 'số điện thoại',
            'address' => 'địa chỉ',
            'contact_person' => 'người liên hệ',
            'contact_position' => 'chức vụ',
            'tax_code' => 'mã số thuế',
            'type' => 'loại khách hàng',
            'status' => 'trạng thái',
            'description' => 'mô tả',
            'additional_info_keys.*' => 'tên trường thông tin bổ sung',
            'additional_info_values.*' => 'giá trị thông tin bổ sung',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Tên khách hàng là bắt buộc.',
            'name.max' => 'Tên khách hàng không được vượt quá 255 ký tự.',
            'code.unique' => 'Mã khách hàng này đã tồn tại.',
            'code.max' => 'Mã khách hàng không được vượt quá 50 ký tự.',
            'email.email' => 'Email không đúng định dạng.',
            'email.max' => 'Email không được vượt quá 255 ký tự.',
            'phone.max' => 'Số điện thoại không được vượt quá 20 ký tự.',
            'address.max' => 'Địa chỉ không được vượt quá 1000 ký tự.',
            'contact_person.max' => 'Tên người liên hệ không được vượt quá 255 ký tự.',
            'contact_position.max' => 'Chức vụ không được vượt quá 255 ký tự.',
            'tax_code.max' => 'Mã số thuế không được vượt quá 50 ký tự.',
            'type.required' => 'Loại khách hàng là bắt buộc.',
            'type.in' => 'Loại khách hàng không hợp lệ.',
            'status.required' => 'Trạng thái là bắt buộc.',
            'status.in' => 'Trạng thái không hợp lệ.',
            'description.max' => 'Mô tả không được vượt quá 2000 ký tự.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Clean up phone number
        if ($this->phone) {
            $phone = preg_replace('/[^0-9+]/', '', $this->phone);
            $this->merge(['phone' => $phone]);
        }

        // Process additional info
        if ($this->has('additional_info_keys') && $this->has('additional_info_values')) {
            $keys = array_filter($this->additional_info_keys ?? []);
            $values = array_filter($this->additional_info_values ?? []);

            $additionalInfo = [];
            foreach ($keys as $index => $key) {
                if (isset($values[$index]) && !empty(trim($key)) && !empty(trim($values[$index]))) {
                    $additionalInfo[trim($key)] = trim($values[$index]);
                }
            }

            $this->merge(['additional_info' => $additionalInfo]);
        }

        // Auto-generate code if not provided
        if (empty($this->code) && $this->isMethod('POST')) {
            $this->merge(['code' => $this->generateCustomerCode()]);
        }
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            // Check if customer has active projects when changing status to inactive
            if ($this->isMethod('PUT') && $this->status !== 'active') {
                $customer = $this->route('customer');
                if ($customer && $customer->activeProjects()->exists()) {
                    $validator->errors()->add('status',
                        'Không thể thay đổi trạng thái khách hàng khi còn có dự án đang hoạt động.');
                }
            }

            // Validate email uniqueness (optional business rule)
            if ($this->email) {
                $customerId = $this->route('customer') ? $this->route('customer')->id : null;
                $existingCustomer = \App\Models\Customer::where('email', $this->email)
                    ->when($customerId, function ($query) use ($customerId) {
                        $query->where('id', '!=', $customerId);
                    })
                    ->first();

                if ($existingCustomer) {
                    $validator->errors()->add('email',
                        'Email này đã được sử dụng bởi khách hàng khác: ' . $existingCustomer->name);
                }
            }
        });
    }

    /**
     * Generate customer code automatically
     */
    private function generateCustomerCode(): string
    {
        $prefix = 'CUS';
        $year = date('Y');

        $lastCustomer = \App\Models\Customer::whereYear('created_at', $year)
                           ->where('code', 'LIKE', $prefix . $year . '%')
                           ->orderBy('code', 'desc')
                           ->first();

        if ($lastCustomer) {
            $lastNumber = (int) substr($lastCustomer->code, -4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return $prefix . $year . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Get validated data with additional processing
     */
    public function validated($key = null, $default = null)
    {
        $data = parent::validated($key, $default);

        // Remove additional_info_keys and additional_info_values as they're already processed
        unset($data['additional_info_keys'], $data['additional_info_values']);

        return $data;
    }
}

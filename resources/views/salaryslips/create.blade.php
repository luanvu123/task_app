@extends('layouts.app')

@section('content')
<div class="body d-flex py-lg-3 py-md-2">
    <div class="container-xxl">
        <div class="row align-items-center">
            <div class="border-0 mb-4">
                <div class="card-header no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                    <h3 class="fw-bold mb-0 py-3 pb-2">Tạo Phiếu Lương</h3>
                    <a href="{{ route('salaryslips.index') }}" class="btn btn-outline-primary">
                        <i class="fa fa-arrow-left me-2"></i>Quay lại danh sách
                    </a>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('salaryslips.store') }}" method="POST" id="salaryslip-form">
                            @csrf

                            <!-- Thông tin cơ bản -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="user_id" class="form-label">Nhân viên <span class="text-danger">*</span></label>
                                    <select name="user_id" id="user_id" class="form-select @error('user_id') is-invalid @enderror" required>
                                        <option value="">-- Chọn nhân viên --</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }} - {{ $user->email }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('user_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="salary_date" class="form-label">Tháng lương <span class="text-danger">*</span></label>
                                    <input type="date" name="salary_date" id="salary_date"
                                           class="form-control @error('salary_date') is-invalid @enderror"
                                           value="{{ old('salary_date', date('Y-m-01')) }}" required>
                                    @error('salary_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <!-- Thu nhập -->
                                <div class="col-lg-6">
                                    <div class="card border">
                                        <div class="card-header bg-success text-white">
                                            <h5 class="mb-0">Thu nhập</h5>
                                        </div>
                                        <div class="card-body">
                                            <div id="earnings-container">
                                                <div class="earning-item mb-3">
                                                    <div class="row">
                                                        <div class="col-7">
                                                            <input type="text" name="earnings[0][description]"
                                                                   class="form-control" placeholder="Mô tả thu nhập"
                                                                   value="{{ old('earnings.0.description', 'Lương cơ bản') }}" required>
                                                        </div>
                                                        <div class="col-4">
                                                            <input type="number" name="earnings[0][amount]"
                                                                   class="form-control earning-amount" placeholder="0"
                                                                   value="{{ old('earnings.0.amount') }}" min="0" step="1000" required>
                                                        </div>
                                                        <div class="col-1">
                                                            <button type="button" class="btn btn-outline-danger btn-sm remove-earning" disabled>
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <button type="button" class="btn btn-outline-success btn-sm mb-3" id="add-earning">
                                                <i class="fa fa-plus me-1"></i>Thêm thu nhập
                                            </button>

                                            <div class="border-top pt-3">
                                                <div class="row">
                                                    <div class="col-7">
                                                        <strong>Tổng thu nhập:</strong>
                                                    </div>
                                                    <div class="col-5 text-end">
                                                        <strong id="total-earnings">0 VND</strong>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Khấu trừ -->
                                <div class="col-lg-6">
                                    <div class="card border">
                                        <div class="card-header bg-danger text-white">
                                            <h5 class="mb-0">Khấu trừ</h5>
                                        </div>
                                        <div class="card-body">
                                            <div id="deductions-container">
                                                <div class="deduction-item mb-3">
                                                    <div class="row">
                                                        <div class="col-7">
                                                            <input type="text" name="deductions[0][description]"
                                                                   class="form-control" placeholder="Mô tả khấu trừ"
                                                                   value="{{ old('deductions.0.description', 'Thuế TNCN') }}">
                                                        </div>
                                                        <div class="col-4">
                                                            <input type="number" name="deductions[0][amount]"
                                                                   class="form-control deduction-amount" placeholder="0"
                                                                   value="{{ old('deductions.0.amount') }}" min="0" step="1000">
                                                        </div>
                                                        <div class="col-1">
                                                            <button type="button" class="btn btn-outline-danger btn-sm remove-deduction" disabled>
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <button type="button" class="btn btn-outline-danger btn-sm mb-3" id="add-deduction">
                                                <i class="fa fa-plus me-1"></i>Thêm khấu trừ
                                            </button>

                                            <div class="border-top pt-3">
                                                <div class="row mb-2">
                                                    <div class="col-7">
                                                        <strong>Tổng khấu trừ:</strong>
                                                    </div>
                                                    <div class="col-5 text-end">
                                                        <strong id="total-deductions">0 VND</strong>
                                                    </div>
                                                </div>

                                                <div class="row border-top pt-2">
                                                    <div class="col-7">
                                                        <strong class="text-primary">Lương thực nhận:</strong>
                                                    </div>
                                                    <div class="col-5 text-end">
                                                        <strong class="text-primary" id="net-salary">0 VND</strong>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-12 text-end">
                                    <button type="button" class="btn btn-secondary me-2" onclick="history.back()">Hủy</button>
                                    <button type="submit" class="btn btn-primary">
                                           <i class="icofont-save"></i>Tạo Phiếu Lương
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let earningIndex = 1;
    let deductionIndex = 1;

    // Thêm thu nhập
    document.getElementById('add-earning').addEventListener('click', function() {
        const container = document.getElementById('earnings-container');
        const newEarning = document.createElement('div');
        newEarning.className = 'earning-item mb-3';
        newEarning.innerHTML = `
            <div class="row">
                <div class="col-7">
                    <input type="text" name="earnings[${earningIndex}][description]"
                           class="form-control" placeholder="Mô tả thu nhập" required>
                </div>
                <div class="col-4">
                    <input type="number" name="earnings[${earningIndex}][amount]"
                           class="form-control earning-amount" placeholder="0"
                           min="0" step="1000" required>
                </div>
                <div class="col-1">
                    <button type="button" class="btn btn-outline-danger btn-sm remove-earning">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>
            </div>
        `;
        container.appendChild(newEarning);
        earningIndex++;
        updateRemoveButtons();
        bindAmountChangeEvents();
    });

    // Thêm khấu trừ
    document.getElementById('add-deduction').addEventListener('click', function() {
        const container = document.getElementById('deductions-container');
        const newDeduction = document.createElement('div');
        newDeduction.className = 'deduction-item mb-3';
        newDeduction.innerHTML = `
            <div class="row">
                <div class="col-7">
                    <input type="text" name="deductions[${deductionIndex}][description]"
                           class="form-control" placeholder="Mô tả khấu trừ">
                </div>
                <div class="col-4">
                    <input type="number" name="deductions[${deductionIndex}][amount]"
                           class="form-control deduction-amount" placeholder="0"
                           min="0" step="1000">
                </div>
                <div class="col-1">
                    <button type="button" class="btn btn-outline-danger btn-sm remove-deduction">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>
            </div>
        `;
        container.appendChild(newDeduction);
        deductionIndex++;
        updateRemoveButtons();
        bindAmountChangeEvents();
    });

    // Xóa thu nhập/khấu trừ
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-earning')) {
            e.target.closest('.earning-item').remove();
            updateRemoveButtons();
            calculateTotals();
        }
        if (e.target.closest('.remove-deduction')) {
            e.target.closest('.deduction-item').remove();
            updateRemoveButtons();
            calculateTotals();
        }
    });

    // Cập nhật trạng thái nút xóa
    function updateRemoveButtons() {
        const earningItems = document.querySelectorAll('.earning-item');
        const deductionItems = document.querySelectorAll('.deduction-item');

        earningItems.forEach((item, index) => {
            const removeBtn = item.querySelector('.remove-earning');
            removeBtn.disabled = earningItems.length === 1;
        });

        deductionItems.forEach((item, index) => {
            const removeBtn = item.querySelector('.remove-deduction');
            removeBtn.disabled = deductionItems.length === 1;
        });
    }

    // Bind events cho input amount
    function bindAmountChangeEvents() {
        document.querySelectorAll('.earning-amount, .deduction-amount').forEach(input => {
            input.removeEventListener('input', calculateTotals);
            input.addEventListener('input', calculateTotals);
        });
    }

    // Tính tổng
    function calculateTotals() {
        let totalEarnings = 0;
        let totalDeductions = 0;

        document.querySelectorAll('.earning-amount').forEach(input => {
            totalEarnings += parseFloat(input.value) || 0;
        });

        document.querySelectorAll('.deduction-amount').forEach(input => {
            totalDeductions += parseFloat(input.value) || 0;
        });

        const netSalary = totalEarnings - totalDeductions;

        document.getElementById('total-earnings').textContent = formatCurrency(totalEarnings);
        document.getElementById('total-deductions').textContent = formatCurrency(totalDeductions);
        document.getElementById('net-salary').textContent = formatCurrency(netSalary);
    }

    // Format currency
    function formatCurrency(amount) {
        return new Intl.NumberFormat('vi-VN').format(amount) + ' VND';
    }

    // Khởi tạo
    bindAmountChangeEvents();
    calculateTotals();
    updateRemoveButtons();
});
</script>
@endsection

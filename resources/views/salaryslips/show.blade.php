@extends('layouts.app')

@section('content')
<div class="body d-flex py-lg-3 py-md-2">
    <div class="container-xxl">
        <div class="row align-items-center">
            <div class="border-0 mb-4">
                <div class="card-header no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                    <h3 class="fw-bold mb-0 py-3 pb-2">Phiếu Lương</h3>
                    <div>
                        <a href="{{ route('salaryslips.index') }}" class="btn btn-outline-primary me-2">
                            <i class="fa fa-arrow-left me-1"></i>Quay lại
                        </a>
                        @if($salaryslip->status == 'draft')
                            <a href="{{ route('salaryslips.edit', $salaryslip) }}" class="btn btn-outline-warning me-2">
                                <i class="fa fa-edit me-1"></i>Chỉnh sửa
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-12 col-md-12">
                <div class="card p-xl-5 p-lg-4 p-0">
                    <div class="card-body">
                        <!-- Header với trạng thái -->
                        <div class="mb-3 pb-3 border-bottom d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="mb-1">PHIẾU LƯƠNG</h4>
                                <strong>{{ \Carbon\Carbon::parse($salaryslip->salary_date)->format('m/Y') }}</strong>
                            </div>
                            <div>
                                @switch($salaryslip->status)
                                    @case('draft')
                                        <span class="badge bg-warning">Nháp</span>
                                        @break
                                    @case('approved')
                                        <span class="badge bg-success">Đã duyệt</span>
                                        @break
                                    @case('paid')
                                        <span class="badge bg-primary">Đã thanh toán</span>
                                        @break
                                @endswitch
                            </div>
                        </div>

                        <!-- Thông tin công ty và nhân viên -->
                        <div class="row mb-4">
                            <div class="col-sm-6">
                                <h6 class="mb-3">Từ công ty:</h6>
                                <div><strong>{{ config('app.name', 'Công ty ABC') }}</strong></div>
                                <div>123 Đường ABC, Quận 1</div>
                                <div>TP. Hồ Chí Minh, Việt Nam</div>
                                <div>Email: info@company.com</div>
                                <div>Điện thoại: +84 123 456 789</div>
                            </div>

                            <div class="col-sm-6">
                                <h6 class="mb-3">Đến nhân viên:</h6>
                                <div><strong>{{ $salaryslip->employee->name }}</strong></div>
                                <div>{{ $salaryslip->employee->job_title ?? 'Nhân viên' }}</div>
                                <div>Mã NV: {{ str_pad($salaryslip->employee->id, 5, '0', STR_PAD_LEFT) }}</div>
                                <div>Email: {{ $salaryslip->employee->email }}</div>
                                <div>Ngày tạo: {{ $salaryslip->created_at->format('d/m/Y') }}</div>
                            </div>
                        </div>

                        <!-- Bảng thu nhập và khấu trừ -->
                        <div class="row">
                            <!-- Thu nhập -->
                            <div class="col-lg-6">
                                <div class="table-responsive-sm">
                                    <table class="table table-striped">
                                        <thead class="table-success">
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th>Khoản thu nhập</th>
                                                <th class="text-end">Số tiền</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($salaryslip->earnings_array as $index => $earning)
                                            <tr>
                                                <td class="text-center">{{ $index + 1 }}</td>
                                                <td>{{ $earning['description'] }}</td>
                                                <td class="text-end">{{ number_format($earning['amount'], 0, ',', '.') }} VND</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="row">
                                    <div class="col-lg-4 col-sm-5"></div>
                                    <div class="col-lg-8 col-sm-7 ms-auto">
                                        <table class="table table-clear">
                                            <tbody>
                                                <tr>
                                                    <td><strong>Tổng thu nhập</strong></td>
                                                    <td class="text-end"><strong>{{ $salaryslip->formatted_earnings_amount }}</strong></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Khấu trừ -->
                            <div class="col-lg-6">
                                <div class="table-responsive-sm">
                                    <table class="table table-striped">
                                        <thead class="table-danger">
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th>Khoản khấu trừ</th>
                                                <th class="text-end">Số tiền</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($salaryslip->deductions_array) > 0)
                                                @foreach($salaryslip->deductions_array as $index => $deduction)
                                                    @if(!empty($deduction['description']) && $deduction['amount'] > 0)
                                                    <tr>
                                                        <td class="text-center">{{ $index + 1 }}</td>
                                                        <td>{{ $deduction['description'] }}</td>
                                                        <td class="text-end">{{ number_format($deduction['amount'], 0, ',', '.') }} VND</td>
                                                    </tr>
                                                    @endif
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="3" class="text-center text-muted">Không có khoản khấu trừ</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>

                                <div class="row">
                                    <div class="col-lg-4 col-sm-5"></div>
                                    <div class="col-lg-8 col-sm-7 ms-auto">
                                        <table class="table table-clear">
                                            <tbody>
                                                <tr>
                                                    <td><strong>Tổng khấu trừ</strong></td>
                                                    <td class="text-end"><strong>{{ $salaryslip->formatted_deductions_amount }}</strong></td>
                                                </tr>
                                                <tr class="table-primary">
                                                    <td><strong>Thu nhập - Khấu trừ</strong></td>
                                                    <td class="text-end"><strong>{{ $salaryslip->formatted_net_salary }}</strong></td>
                                                </tr>
                                                <tr class="table-success">
                                                    <td><strong>Lương thực nhận</strong></td>
                                                    <td class="text-end"><strong class="text-success fs-5">{{ $salaryslip->formatted_net_salary }}</strong></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Ghi chú -->
                        <div class="row mt-4">
                            <div class="col-lg-12">
                                <h6>Ghi chú</h6>
                                <p class="text-muted">
                                    Phiếu lương này được tạo tự động bởi hệ thống.
                                    Mọi thắc mắc vui lòng liên hệ phòng Nhân sự.
                                    <br>
                                    Người tạo: <strong>{{ $salaryslip->creator->name }}</strong>
                                </p>
                            </div>

                            <!-- Nút hành động -->
                            <div class="col-lg-12 text-end">
                                @if($salaryslip->status == 'draft')
                                    <form method="POST" action="{{ route('salaryslips.updateStatus', $salaryslip) }}" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="approved">
                                        <button type="submit" class="btn btn-success btn-lg my-1" onclick="return confirm('Bạn có chắc muốn duyệt phiếu lương này?')">
                                           <i class="icofont-verification-check"></i> Duyệt phiếu lương
                                        </button>
                                    </form>
                                @elseif($salaryslip->status == 'approved')
                                    <form method="POST" action="{{ route('salaryslips.updateStatus', $salaryslip) }}" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="paid">
                                        <button type="submit" class="btn btn-primary btn-lg my-1" onclick="return confirm('Bạn có chắc đã thanh toán lương cho nhân viên này?')">
                                            <i class="icofont-credit-card"></i> Đánh dấu đã thanh toán
                                        </button>
                                    </form>
                                @endif



                                <button type="button" class="btn btn-info btn-lg my-1" onclick="window.print()">
                                    <i class="icofont-cloud-download"></i> Tải xuống
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .btn, .card-header .btn, nav, footer {
        display: none !important;
    }
    .card {
        border: none !important;
        box-shadow: none !important;
    }
    body {
        background: white !important;
    }
}
</style>
@endsection

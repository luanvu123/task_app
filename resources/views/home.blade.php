@extends('layouts.app')

@section('title', 'Dashboard - Trang chủ')

@section('content')
    <div class="container-fluid">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                        <p class="text-muted">Chào mừng trở lại, {{ auth()->user()->name }}!</p>
                    </div>
                    <div class="text-muted">
                        <i class="fas fa-calendar-alt"></i>
                        {{ now()->format('d/m/Y') }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Thống kê tổng quan -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Tổng nhân viên
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ number_format($totalStats['total_users']) }}
                                </div>
                                <div class="text-xs text-success">
                                    <i class="fas fa-users"></i>
                                    {{ number_format($totalStats['active_users']) }} đang hoạt động
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Dự án
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ number_format($totalStats['total_projects']) }}
                                </div>
                                <div class="text-xs text-success">
                                    <i class="fas fa-chart-line"></i>
                                    {{ number_format($totalStats['active_projects']) }} đang hoạt động
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-project-diagram fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Công việc
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ number_format($totalStats['total_tasks']) }}
                                </div>
                                <div class="text-xs text-success">
                                    <i class="fas fa-check"></i>
                                    {{ number_format($totalStats['completed_tasks']) }} đã hoàn thành
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-tasks fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Quá hạn
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ number_format($totalStats['overdue_tasks']) }}
                                </div>
                                <div class="text-xs text-danger">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    Cần xử lý ngay
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clock fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Biểu đồ và thống kê -->
        <div class="row">
            <!-- Biểu đồ nhân viên theo phòng ban -->
            <div class="col-xl-6 col-lg-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Nhân viên theo phòng ban</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="departmentChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Biểu đồ trạng thái dự án -->
            <div class="col-xl-6 col-lg-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Trạng thái dự án</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="projectStatusChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Biểu đồ độ ưu tiên task -->
            <div class="col-xl-6 col-lg-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Task theo độ ưu tiên</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="taskPriorityChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Biểu đồ trạng thái task -->
            <div class="col-xl-6 col-lg-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Trạng thái công việc</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="taskStatusChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Biểu đồ lương và timesheet -->
        <div class="row">
            <div class="col-xl-8 col-lg-7">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Thống kê lương 6 tháng gần nhất</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="salaryChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-5">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Giới tính nhân viên</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="genderChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bảng hiệu suất nhân viên -->
        <div class="row">
            <div class="col-xl-8 col-lg-7">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Top 10 nhân viên hiệu suất cao</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tên nhân viên</th>
                                        <th>Tổng task</th>
                                        <th>Hoàn thành</th>
                                        <th>Tỷ lệ (%)</th>
                                        <th>Tiến độ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($performanceStats as $index => $user)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $user['name'] }}</td>
                                            <td>{{ $user['total_tasks'] }}</td>
                                            <td>{{ $user['completed_tasks'] }}</td>
                                            <td>{{ $user['completion_rate'] }}%</td>
                                            <td>
                                                <div class="progress">
                                                    <div class="progress-bar bg-success" role="progressbar"
                                                        style="width: {{ $user['completion_rate'] }}%"
                                                        aria-valuenow="{{ $user['completion_rate'] }}" aria-valuemin="0"
                                                        aria-valuemax="100">
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-5">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Timesheet 6 tháng gần nhất</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="timesheetChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Biểu đồ nhân viên theo phòng ban
            const departmentCtx = document.getElementById('departmentChart').getContext('2d');
            new Chart(departmentCtx, {
                type: 'doughnut',
                data: {
                    labels: @json(array_column($departmentStats, 'name')),
                    datasets: [{
                        data: @json(array_column($departmentStats, 'count')),
                        backgroundColor: @json(array_column($departmentStats, 'color')),
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                        }
                    }
                }
            });

            // Biểu đồ trạng thái dự án
            const projectStatusCtx = document.getElementById('projectStatusChart').getContext('2d');
            new Chart(projectStatusCtx, {
                type: 'pie',
                data: {
                    labels: @json(array_column($projectStatusStats, 'status')),
                    datasets: [{
                        data: @json(array_column($projectStatusStats, 'count')),
                        backgroundColor: @json(array_column($projectStatusStats, 'color')),
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                        }
                    }
                }
            });

            // Biểu đồ độ ưu tiên task
            const taskPriorityCtx = document.getElementById('taskPriorityChart').getContext('2d');
            new Chart(taskPriorityCtx, {
                type: 'bar',
                data: {
                    labels: @json(array_column($taskPriorityStats, 'priority')),
                    datasets: [{
                        label: 'Số lượng task',
                        data: @json(array_column($taskPriorityStats, 'count')),
                        backgroundColor: @json(array_column($taskPriorityStats, 'color')),
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Biểu đồ trạng thái task
            const taskStatusCtx = document.getElementById('taskStatusChart').getContext('2d');
            new Chart(taskStatusCtx, {
                type: 'doughnut',
                data: {
                    labels: @json(array_column($taskStatusStats, 'status')),
                    datasets: [{
                        data: @json(array_column($taskStatusStats, 'count')),
                        backgroundColor: @json(array_column($taskStatusStats, 'color')),
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                        }
                    }
                }
            });

            // Biểu đồ lương
            const salaryCtx = document.getElementById('salaryChart').getContext('2d');
            new Chart(salaryCtx, {
                type: 'line',
                data: {
                    labels: @json(array_column($salaryStats, 'month')),
                    datasets: [{
                        label: 'Tổng lương (VNĐ)',
                        data: @json(array_column($salaryStats, 'total_salary')),
                        borderColor: '#4e73df',
                        backgroundColor: 'rgba(78, 115, 223, 0.1)',
                        borderWidth: 2,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function (value) {
                                    return new Intl.NumberFormat('vi-VN').format(value) + ' VNĐ';
                                }
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    return 'Tổng lương: ' + new Intl.NumberFormat('vi-VN').format(context.parsed.y) + ' VNĐ';
                                }
                            }
                        }
                    }
                }
            });

            // Biểu đồ giới tính
            const genderCtx = document.getElementById('genderChart').getContext('2d');
            new Chart(genderCtx, {
                type: 'pie',
                data: {
                    labels: @json(array_column($genderStats, 'gender')),
                    datasets: [{
                        data: @json(array_column($genderStats, 'count')),
                        backgroundColor: @json(array_column($genderStats, 'color')),
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                        }
                    }
                }
            });

            // Biểu đồ timesheet
            const timesheetCtx = document.getElementById('timesheetChart').getContext('2d');
            new Chart(timesheetCtx, {
                type: 'bar',
                data: {
                    labels: @json(array_column($timesheetStats, 'month')),
                    datasets: [{
                        label: 'Tổng giờ làm việc',
                        data: @json(array_column($timesheetStats, 'total_hours')),
                        backgroundColor: '#1cc88a',
                        borderColor: '#1cc88a',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function (value) {
                                    return value + ' giờ';
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>

    <style>
        .border-left-primary {
            border-left: 0.25rem solid #4e73df !important;
        }

        .border-left-success {
            border-left: 0.25rem solid #1cc88a !important;
        }

        .border-left-info {
            border-left: 0.25rem solid #36b9cc !important;
        }

        .border-left-warning {
            border-left: 0.25rem solid #f6c23e !important;
        }

        .card {
            transition: all 0.3s;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        }

        .progress {
            height: 8px;
        }

        .table th {
            border-top: none;
            font-weight: 600;
            color: #5a5c69;
            background-color: #f8f9fc;
        }
    </style>

@endsection

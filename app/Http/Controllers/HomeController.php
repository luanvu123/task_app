<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Department;
use App\Models\Project;
use App\Models\Task;
use App\Models\ProjectTimesheet;
use App\Models\Salaryslip;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Lấy dữ liệu thống kê tổng quan
        $totalStats = $this->getTotalStats();

        // Thống kê nhân viên theo phòng ban
        $departmentStats = $this->getDepartmentStats();

        // Thống kê dự án theo trạng thái
        $projectStatusStats = $this->getProjectStatusStats();

        // Thống kê task theo độ ưu tiên
        $taskPriorityStats = $this->getTaskPriorityStats();

        // Thống kê task theo trạng thái
        $taskStatusStats = $this->getTaskStatusStats();

        // Thống kê nhân viên theo giới tính
        $genderStats = $this->getGenderStats();

        // Thống kê lương theo tháng (6 tháng gần nhất)
        $salaryStats = $this->getSalaryStats();

        // Thống kê timesheet theo tháng
        $timesheetStats = $this->getTimesheetStats();

        // Thống kê hiệu suất nhân viên
        $performanceStats = $this->getPerformanceStats();

        // Thống kê dự án theo phòng ban
        $projectDepartmentStats = $this->getProjectDepartmentStats();

        return view('home', compact(
            'totalStats',
            'departmentStats',
            'projectStatusStats',
            'taskPriorityStats',
            'taskStatusStats',
            'genderStats',
            'salaryStats',
            'timesheetStats',
            'performanceStats',
            'projectDepartmentStats'
        ));
    }

    /**
     * Lấy thống kê tổng quan
     */
    private function getTotalStats()
    {
        return [
            'total_users' => User::count(),
            'active_users' => User::active()->count(),
            'total_departments' => Department::count(),
            'total_projects' => Project::count(),
            'active_projects' => Project::whereIn('status', [
                Project::STATUS_PLANNING,
                Project::STATUS_IN_PROGRESS
            ])->count(),
            'total_tasks' => Task::count(),
            'completed_tasks' => Task::where('status', Task::STATUS_COMPLETED)->count(),
            'overdue_tasks' => Task::where('end_date', '<', now())
                                  ->where('status', '!=', Task::STATUS_COMPLETED)
                                  ->count(),
        ];
    }

    /**
     * Thống kê nhân viên theo phòng ban
     */
    private function getDepartmentStats()
    {
        return Department::withCount('employees')
            ->get()
            ->map(function ($dept) {
                return [
                    'name' => $dept->name,
                    'count' => $dept->employees_count,
                    'color' => $this->getRandomColor()
                ];
            })
            ->toArray();
    }

    /**
     * Thống kê dự án theo trạng thái
     */
    private function getProjectStatusStats()
    {
        $statuses = Project::getStatuses();
        $data = [];

        foreach ($statuses as $key => $label) {
            $count = Project::where('status', $key)->count();
            $data[] = [
                'status' => $label,
                'count' => $count,
                'color' => $this->getStatusColor($key)
            ];
        }

        return $data;
    }

    /**
     * Thống kê task theo độ ưu tiên
     */
    private function getTaskPriorityStats()
    {
        $priorities = [
            'low' => ['label' => 'Thấp', 'color' => '#10B981'],
            'medium' => ['label' => 'Trung bình', 'color' => '#F59E0B'],
            'high' => ['label' => 'Cao', 'color' => '#EF4444'],
            'urgent' => ['label' => 'Khẩn cấp', 'color' => '#DC2626']
        ];

        $data = [];
        foreach ($priorities as $key => $config) {
            $count = Task::where('priority', $key)->count();
            $data[] = [
                'priority' => $config['label'],
                'count' => $count,
                'color' => $config['color']
            ];
        }

        return $data;
    }

    /**
     * Thống kê task theo trạng thái
     */
    private function getTaskStatusStats()
    {
        $statuses = [
            'in_progress' => ['label' => 'Đang thực hiện', 'color' => '#3B82F6'],
            'needs_review' => ['label' => 'Cần xem xét', 'color' => '#F59E0B'],
            'completed' => ['label' => 'Hoàn thành', 'color' => '#10B981']
        ];

        $data = [];
        foreach ($statuses as $key => $config) {
            $count = Task::where('status', $key)->count();
            $data[] = [
                'status' => $config['label'],
                'count' => $count,
                'color' => $config['color']
            ];
        }

        return $data;
    }

    /**
     * Thống kê nhân viên theo giới tính
     */
    private function getGenderStats()
    {
        return [
            [
                'gender' => 'Nam',
                'count' => User::where('gender', 'male')->count(),
                'color' => '#3B82F6'
            ],
            [
                'gender' => 'Nữ',
                'count' => User::where('gender', 'female')->count(),
                'color' => '#EC4899'
            ],
            [
                'gender' => 'Khác',
                'count' => User::where('gender', 'other')->count(),
                'color' => '#6B7280'
            ]
        ];
    }

    /**
     * Thống kê lương theo 6 tháng gần nhất
     */
    private function getSalaryStats()
    {
        $data = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthYear = $date->format('Y-m');

            $totalSalary = Salaryslip::whereYear('salary_date', $date->year)
                                   ->whereMonth('salary_date', $date->month)
                                   ->sum('net_salary');

            $data[] = [
                'month' => $date->format('m/Y'),
                'total_salary' => $totalSalary,
                'formatted_salary' => number_format($totalSalary, 0, ',', '.') . ' VNĐ'
            ];
        }

        return $data;
    }

    /**
     * Thống kê timesheet theo 6 tháng gần nhất
     */
    private function getTimesheetStats()
    {
        $data = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);

            $totalHours = ProjectTimesheet::whereYear('work_date', $date->year)
                                        ->whereMonth('work_date', $date->month)
                                        ->where('status', ProjectTimesheet::STATUS_APPROVED)
                                        ->sum('total_hours');

            $data[] = [
                'month' => $date->format('m/Y'),
                'total_hours' => round($totalHours, 2)
            ];
        }

        return $data;
    }

    /**
     * Thống kê hiệu suất top 10 nhân viên
     */
    private function getPerformanceStats()
    {
        return User::select('id', 'name')
            ->withCount([
                'tasks as total_tasks',
                'tasks as completed_tasks' => function ($query) {
                    $query->where('status', Task::STATUS_COMPLETED);
                }
            ])
            ->having('total_tasks', '>', 0)
            ->get()
            ->map(function ($user) {
                $completionRate = $user->total_tasks > 0
                    ? round(($user->completed_tasks / $user->total_tasks) * 100, 2)
                    : 0;

                return [
                    'name' => $user->name,
                    'total_tasks' => $user->total_tasks,
                    'completed_tasks' => $user->completed_tasks,
                    'completion_rate' => $completionRate
                ];
            })
            ->sortByDesc('completion_rate')
            ->take(10)
            ->values()
            ->toArray();
    }

    /**
     * Thống kê số dự án theo phòng ban
     */
    private function getProjectDepartmentStats()
    {
        return Department::withCount('projects')
            ->get()
            ->map(function ($dept) {
                return [
                    'name' => $dept->name,
                    'project_count' => $dept->projects_count,
                    'color' => $this->getRandomColor()
                ];
            })
            ->toArray();
    }

    /**
     * Lấy màu ngẫu nhiên cho biểu đồ
     */
    private function getRandomColor()
    {
        $colors = [
            '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0',
            '#9966FF', '#FF9F40', '#FF6384', '#C9CBCF',
            '#4BC0C0', '#FF6384', '#36A2EB', '#FFCE56'
        ];

        return $colors[array_rand($colors)];
    }

    /**
     * Lấy màu theo trạng thái
     */
    private function getStatusColor($status)
    {
        $colors = [
            'planning' => '#6B7280',
            'in_progress' => '#3B82F6',
            'on_hold' => '#F59E0B',
            'completed' => '#10B981',
            'cancelled' => '#EF4444'
        ];

        return $colors[$status] ?? '#6B7280';
    }
}

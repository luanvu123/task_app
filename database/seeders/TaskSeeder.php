<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = Project::all();
        $users = User::all();

        if ($projects->isEmpty() || $users->isEmpty()) {
            $this->command->info('Không có dự án hoặc người dùng nào. Vui lòng tạo trước khi chạy TaskSeeder.');
            return;
        }

        $taskNames = [
            'Thiết kế giao diện người dùng',
            'Phát triển API backend',
            'Tích hợp thanh toán',
            'Kiểm thử tính năng đăng nhập',
            'Tối ưu hóa database',
            'Viết tài liệu kỹ thuật',
            'Thiết kế mockup trang chủ',
            'Cài đặt server production',
            'Kiểm tra bảo mật hệ thống',
            'Phân tích yêu cầu khách hàng',
            'Tạo báo cáo tiến độ',
            'Sửa lỗi responsive mobile',
            'Cấu hình CI/CD pipeline',
            'Tạo component tái sử dụng',
            'Kiểm thử hiệu năng',
        ];

        $descriptions = [
            'Thiết kế giao diện thân thiện với người dùng, đảm bảo trải nghiệm tốt trên mọi thiết bị.',
            'Phát triển các API RESTful để hỗ trợ frontend và mobile app.',
            'Tích hợp các cổng thanh toán phổ biến như VNPay, Momo, ZaloPay.',
            'Kiểm thử đầy đủ các tình huống đăng nhập, bao gồm cả trường hợp lỗi.',
            'Tối ưu hóa truy vấn database để cải thiện hiệu năng hệ thống.',
            'Viết tài liệu chi tiết về cách sử dụng và triển khai hệ thống.',
            'Tạo mockup cho trang chủ với thiết kế hiện đại và thu hút.',
            'Cấu hình server production với các công cụ monitoring.',
            'Thực hiện kiểm tra bảo mật toàn diện cho hệ thống.',
            'Phân tích và làm rõ các yêu cầu từ phía khách hàng.',
            'Tạo báo cáo chi tiết về tiến độ thực hiện dự án.',
            'Sửa các lỗi hiển thị trên thiết bị mobile.',
            'Thiết lập quy trình CI/CD tự động cho dự án.',
            'Tạo các component có thể tái sử dụng cho nhiều trang.',
            'Kiểm tra và tối ưu hiệu năng của ứng dụng.',
        ];

        $priorities = ['low', 'medium', 'high', 'urgent'];
        $statuses = ['in_progress', 'needs_review', 'completed'];

        foreach ($projects as $project) {
            // Tạo 3-7 tasks cho mỗi project
            $taskCount = rand(3, 7);
            $projectMembers = $project->members;

            if ($projectMembers->isEmpty()) {
                // Nếu project không có members, sử dụng random users
                $availableUsers = $users->random(min(3, $users->count()));
            } else {
                $availableUsers = $projectMembers;
            }

            for ($i = 0; $i < $taskCount; $i++) {
                $startDate = Carbon::now()->subDays(rand(0, 30));
                $endDate = $startDate->copy()->addDays(rand(3, 21));

                Task::create([
                    'name' => $taskNames[array_rand($taskNames)],
                    'project_id' => $project->id,
                    'user_id' => $availableUsers->random()->id,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'priority' => $priorities[array_rand($priorities)],
                    'status' => $statuses[array_rand($statuses)],
                    'description' => $descriptions[array_rand($descriptions)],
                    'image_and_document' => null, // Có thể thêm sau
                ]);
            }
        }

        $this->command->info('Đã tạo thành công ' . Task::count() . ' công việc mẫu.');
    }
}

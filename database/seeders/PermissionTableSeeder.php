<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run(): void
    {
        $permissions = [
            // Role permissions - Quyền quản lý vai trò
            [
                'name' => 'role-list',
                'description' => 'Xem danh sách vai trò trong hệ thống'
            ],
            [
                'name' => 'role-create',
                'description' => 'Tạo mới vai trò và phân quyền'
            ],
            [
                'name' => 'role-edit',
                'description' => 'Chỉnh sửa thông tin vai trò và quyền hạn'
            ],
            [
                'name' => 'role-delete',
                'description' => 'Xóa vai trò khỏi hệ thống'
            ],

            // User permissions - Quyền quản lý người dùng
            [
                'name' => 'user-list',
                'description' => 'Xem danh sách người dùng trong hệ thống'
            ],
            [
                'name' => 'user-create',
                'description' => 'Tạo tài khoản người dùng mới'
            ],
            [
                'name' => 'user-edit',
                'description' => 'Chỉnh sửa thông tin người dùng'
            ],
            [
                'name' => 'user-delete',
                'description' => 'Xóa tài khoản người dùng'
            ],

            // Project permissions - Quyền quản lý dự án
            [
                'name' => 'project-list',
                'description' => 'Xem danh sách các dự án'
            ],
            [
                'name' => 'project-create',
                'description' => 'Tạo dự án mới'
            ],
            [
                'name' => 'project-edit',
                'description' => 'Chỉnh sửa thông tin dự án'
            ],
            [
                'name' => 'project-delete',
                'description' => 'Xóa dự án khỏi hệ thống'
            ],

            // Task permissions - Quyền quản lý nhiệm vụ
            [
                'name' => 'task-list',
                'description' => 'Xem danh sách nhiệm vụ'
            ],
            [
                'name' => 'task-create',
                'description' => 'Tạo nhiệm vụ mới'
            ],
            [
                'name' => 'task-edit',
                'description' => 'Chỉnh sửa thông tin nhiệm vụ'
            ],
            [
                'name' => 'task-delete',
                'description' => 'Xóa nhiệm vụ'
            ],

            // Timesheet permissions - Quyền quản lý chấm công
            [
                'name' => 'timesheet-list',
                'description' => 'Xem danh sách bảng chấm công'
            ],
            [
                'name' => 'timesheet-create',
                'description' => 'Tạo bảng chấm công mới'
            ],
            [
                'name' => 'timesheet-edit',
                'description' => 'Chỉnh sửa bảng chấm công'
            ],
            [
                'name' => 'timesheet-delete',
                'description' => 'Xóa bảng chấm công'
            ],
            [
                'name' => 'timesheet-submit',
                'description' => 'Gửi bảng chấm công để duyệt'
            ],
            [
                'name' => 'timesheet-approve',
                'description' => 'Phê duyệt bảng chấm công'
            ],
            [
                'name' => 'timesheet-reject',
                'description' => 'Từ chối bảng chấm công'
            ],

            // Salary slip permissions - Quyền quản lý bảng lương
            [
                'name' => 'salaryslip-list',
                'description' => 'Xem danh sách phiếu lương'
            ],
            [
                'name' => 'salaryslip-create',
                'description' => 'Tạo phiếu lương mới'
            ],
            [
                'name' => 'salaryslip-edit',
                'description' => 'Chỉnh sửa phiếu lương'
            ],
            [
                'name' => 'salaryslip-delete',
                'description' => 'Xóa phiếu lương'
            ],
            [
                'name' => 'salaryslip-print',
                'description' => 'In phiếu lương'
            ],
            [
                'name' => 'salaryslip-status',
                'description' => 'Cập nhật trạng thái phiếu lương'
            ],

            // Department permissions - Quyền quản lý phòng ban
            [
                'name' => 'department-list',
                'description' => 'Xem danh sách phòng ban'
            ],
            [
                'name' => 'department-create',
                'description' => 'Tạo phòng ban mới'
            ],
            [
                'name' => 'department-edit',
                'description' => 'Chỉnh sửa thông tin phòng ban'
            ],
            [
                'name' => 'department-delete',
                'description' => 'Xóa phòng ban'
            ],

            // Notification permissions - Quyền quản lý thông báo
            [
                'name' => 'notification-list',
                'description' => 'Xem danh sách thông báo'
            ],
            [
                'name' => 'notification-create',
                'description' => 'Tạo thông báo mới'
            ],
            [
                'name' => 'notification-edit',
                'description' => 'Chỉnh sửa thông báo'
            ],
            [
                'name' => 'notification-delete',
                'description' => 'Xóa thông báo'
            ],
            [
                'name' => 'notification-mark-read',
                'description' => 'Đánh dấu thông báo đã đọc'
            ],

            // Message permissions - Quyền quản lý tin nhắn
            [
                'name' => 'message-list',
                'description' => 'Xem danh sách tin nhắn'
            ],
            [
                'name' => 'message-create',
                'description' => 'Gửi tin nhắn mới'
            ],
            [
                'name' => 'message-edit',
                'description' => 'Chỉnh sửa tin nhắn'
            ],
            [
                'name' => 'message-delete',
                'description' => 'Xóa tin nhắn'
            ],
            [
                'name' => 'message-group-create',
                'description' => 'Tạo nhóm chat mới'
            ],
            [
                'name' => 'message-group-manage',
                'description' => 'Quản lý thành viên nhóm chat'
            ],

            // Report permissions - Quyền báo cáo
            [
                'name' => 'report-view',
                'description' => 'Xem các báo cáo hệ thống'
            ],
            [
                'name' => 'report-export',
                'description' => 'Xuất báo cáo ra file'
            ],
  [
                'name' => 'vendor-list',
                'description' => 'Xem danh sách nhà cung cấp'
            ],
            [
                'name' => 'vendor-create',
                'description' => 'Tạo nhà cung cấp mới'
            ],
            [
                'name' => 'vendor-edit',
                'description' => 'Chỉnh sửa thông tin nhà cung cấp'
            ],
            [
                'name' => 'vendor-delete',
                'description' => 'Xóa nhà cung cấp'
            ],

            // Item Category permissions - Quyền quản lý danh mục sản phẩm
            [
                'name' => 'item-category-list',
                'description' => 'Xem danh sách danh mục sản phẩm'
            ],
            [
                'name' => 'item-category-create',
                'description' => 'Tạo danh mục sản phẩm mới'
            ],
            [
                'name' => 'item-category-edit',
                'description' => 'Chỉnh sửa danh mục sản phẩm'
            ],
            [
                'name' => 'item-category-delete',
                'description' => 'Xóa danh mục sản phẩm'
            ],
            [
                'name' => 'item-category-toggle-active',
                'description' => 'Bật/tắt trạng thái hoạt động danh mục sản phẩm'
            ],

            // Propose permissions - Quyền quản lý đề xuất
            [
                'name' => 'propose-list',
                'description' => 'Xem danh sách đề xuất'
            ],
            [
                'name' => 'propose-create',
                'description' => 'Tạo đề xuất mới'
            ],
            [
                'name' => 'propose-edit',
                'description' => 'Chỉnh sửa đề xuất'
            ],
            [
                'name' => 'propose-delete',
                'description' => 'Xóa đề xuất'
            ],
            [
                'name' => 'propose-submit',
                'description' => 'Gửi đề xuất để xem xét'
            ],
            [
                'name' => 'propose-review',
                'description' => 'Xem xét và đánh giá đề xuất'
            ],
            [
                'name' => 'propose-approve',
                'description' => 'Phê duyệt/từ chối đề xuất'
            ],
            [
                'name' => 'propose-cancel',
                'description' => 'Hủy đề xuất'
            ],
            [
                'name' => 'propose-statistics',
                'description' => 'Xem thống kê đề xuất'
            ],
            [
                'name' => 'propose-export',
                'description' => 'Xuất dữ liệu đề xuất'
            ],
            [
                'name' => 'propose-download-attachment',
                'description' => 'Tải xuống tệp đính kèm đề xuất'
            ],
            // System permissions - Quyền hệ thống
            [
                'name' => 'system-settings',
                'description' => 'Cấu hình cài đặt hệ thống'
            ],
            [
                'name' => 'backup-restore',
                'description' => 'Sao lưu và khôi phục dữ liệu'
            ]
        ];

        foreach ($permissions as $permissionData) {
            Permission::firstOrCreate(
                ['name' => $permissionData['name'], 'guard_name' => 'web'],
                ['description' => $permissionData['description']]
            );
        }
    }
}

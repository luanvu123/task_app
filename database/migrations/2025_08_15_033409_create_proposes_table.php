<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * BẢNG PROPOSES - Đề xuất mua sắm/chi phí cho dự án
     * Liên kết với bảng Projects để quản lý đề xuất hàng hóa/dịch vụ
     */
    public function up(): void
    {
        Schema::create('proposes', function (Blueprint $table) {
            $table->id();

            // Liên kết với Project
            $table->unsignedBigInteger('project_id');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');

            // Thông tin người đề xuất
            $table->unsignedBigInteger('proposed_by'); // Người đề xuất
            $table->foreign('proposed_by')->references('id')->on('users');

            $table->unsignedBigInteger('department_id'); // Bộ phận đề xuất
            $table->foreign('department_id')->references('id')->on('departments');

            // Thông tin đề xuất
            $table->string('propose_code')->unique(); // Mã đề xuất (tự động gen)
            $table->string('title'); // Tiêu đề đề xuất
            $table->text('description'); // Mô tả lý do đề xuất
            $table->text('justification'); // Lý do cần thiết
            $table->text('expected_benefit')->nullable(); // Lợi ích mong đợi

            // Thông tin tài chính
            $table->decimal('total_amount', 15, 2)->default(0); // Tổng giá trị đề xuất
            $table->decimal('approved_amount', 15, 2)->default(0); // Số tiền được duyệt
            $table->string('currency', 3)->default('VND'); // Đơn vị tiền tệ
            $table->enum('budget_source', [
                'project_budget', // Từ ng예算 dự án
                'department_budget', // Từ ngân sách bộ phận
                'additional_budget', // Ngân sách bổ sung
                'external_funding' // Nguồn tài trợ ngoài
            ])->default('project_budget');

            // Phân loại đề xuất
            $table->enum('propose_type', [
                'equipment', // Thiết bị
                'supplies', // Vật tư
                'services', // Dịch vụ
                'software', // Phần mềm
                'training', // Đào tạo
                'travel', // Công tác phí
                'other' // Khác
            ]);

            // Độ ưu tiên và tính cấp thiết
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            $table->boolean('is_urgent')->default(false); // Cấp thiết
            $table->date('needed_by_date')->nullable(); // Cần có trước ngày

            // Quy trình phê duyệt
            $table->enum('status', [
                'draft', // Bản nháp
                'submitted', // Đã gửi
                'under_review', // Đang xem xét
                'pending_approval', // Chờ phê duyệt
                'approved', // Đã phê duyệt
                'partially_approved', // Phê duyệt một phần
                'rejected', // Từ chối
                'cancelled', // Hủy bỏ
                'completed' // Hoàn thành
            ])->default('draft');

            // Thông tin phê duyệt
            $table->unsignedBigInteger('reviewed_by')->nullable(); // Người xem xét
            $table->foreign('reviewed_by')->references('id')->on('users');
            $table->timestamp('reviewed_at')->nullable();
            $table->text('review_comments')->nullable(); // Nhận xét khi xem xét

            $table->unsignedBigInteger('approved_by')->nullable(); // Người phê duyệt
            $table->foreign('approved_by')->references('id')->on('users');
            $table->timestamp('approved_at')->nullable();
            $table->text('approval_comments')->nullable(); // Nhận xét khi phê duyệt

            // Nhà cung cấp và báo giá
            $table->unsignedBigInteger('vendor_id')->nullable(); // Nhà cung cấp được chọn
            $table->foreign('vendor_id')->references('id')->on('vendors');
            $table->json('quotations')->nullable(); // Danh sách báo giá từ các nhà cung cấp

            // Thông tin giao hàng và thanh toán
            $table->date('expected_delivery_date')->nullable(); // Ngày giao hàng dự kiến
            $table->date('actual_delivery_date')->nullable(); // Ngày giao hàng thực tế
            $table->enum('payment_method', [
                'cash', 'transfer', 'check', 'credit_card', 'installment'
            ])->nullable();
            $table->enum('payment_status', [
                'pending', 'partial', 'completed', 'overdue'
            ])->default('pending');

            // File đính kèm
            $table->json('attachments')->nullable(); // Hóa đơn, chứng từ, hình ảnh
            $table->json('quotation_files')->nullable(); // File báo giá
            $table->json('approval_documents')->nullable(); // Chứng từ phê duyệt

            // Theo dõi thực hiện
            $table->text('implementation_notes')->nullable(); // Ghi chú thực hiện
            $table->integer('completion_percentage')->default(0); // % hoàn thành
            $table->date('completion_date')->nullable(); // Ngày hoàn thành

            // Đánh giá sau khi hoàn thành
            $table->integer('satisfaction_rating')->nullable(); // Đánh giá sự hài lòng 1-5
            $table->text('feedback')->nullable(); // Phản hồi
            $table->boolean('would_recommend_vendor')->nullable(); // Có giới thiệu vendor không

            // Metadata
            $table->timestamps();
            $table->softDeletes(); // Soft delete

            // Indexes
            $table->index(['project_id', 'status']);
            $table->index(['proposed_by', 'created_at']);
            $table->index(['department_id', 'propose_type']);
            $table->index(['priority', 'needed_by_date']);
            $table->index(['status', 'total_amount']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proposes');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('report_managers', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Tiêu đề báo cáo
            $table->text('content'); // Nội dung báo cáo
            $table->enum('report_type', [
                'monthly',
                'quarterly',
                'yearly',
                'project_completion',
                'urgent',
                'other'
            ])->default('monthly'); // Loại báo cáo

            $table->unsignedBigInteger('department_id'); // Phòng ban gửi báo cáo
            $table->unsignedBigInteger('reporter_id'); // Người gửi báo cáo (trưởng phòng)
            $table->unsignedBigInteger('recipient_id'); // Người nhận báo cáo (giám đốc)

            $table->enum('status', [
                'draft',     // Bản nháp
                'submitted', // Đã gửi
                'reviewed',  // Đã xem
                'approved',  // Đã phê duyệt
                'rejected'   // Từ chối
            ])->default('draft');

            $table->enum('priority', [
                'low',
                'medium',
                'high',
                'urgent'
            ])->default('medium'); // Mức độ ưu tiên

            $table->date('report_period_start')->nullable(); // Bắt đầu kỳ báo cáo
            $table->date('report_period_end')->nullable(); // Kết thúc kỳ báo cáo
            $table->timestamp('submitted_at')->nullable(); // Thời gian gửi
            $table->timestamp('reviewed_at')->nullable(); // Thời gian xem
            $table->text('feedback')->nullable(); // Phản hồi từ giám đốc
            $table->json('attachments')->nullable(); // File đính kèm (JSON array)

            $table->timestamps();

            // Foreign key constraints
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
            $table->foreign('reporter_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('recipient_id')->references('id')->on('users')->onDelete('cascade');

            // Indexes
            $table->index(['department_id', 'status']);
            $table->index(['reporter_id', 'created_at']);
            $table->index(['recipient_id', 'status']);
            $table->index('report_type');
            $table->index('priority');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_managers');
    }
};

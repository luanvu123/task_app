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
        Schema::create('salaryslips', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('created_by'); // Người tạo (Auth->id)
            $table->unsignedBigInteger('user_id'); // Nhân viên nhận lương
            $table->longText('earnings'); // Chi tiết các khoản thu nhập
            $table->decimal('earnings_amount', 15, 2); // Tổng thu nhập
            $table->longText('deductions'); // Chi tiết các khoản khấu trừ
            $table->decimal('deductions_amount', 15, 2); // Tổng khấu trừ
            $table->decimal('net_salary', 15, 2); // Lương thực nhận
            $table->date('salary_date'); // Tháng lương
            $table->string('status')->default('draft'); // Trạng thái: draft, approved, paid
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // Indexes
            $table->index(['user_id', 'salary_date']);
            $table->index('created_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salaryslips');
    }
};

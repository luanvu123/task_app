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
        // Tạo bảng customers
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Tên khách hàng
            $table->string('code')->unique(); // Mã khách hàng (unique)
            $table->string('email')->nullable(); // Email liên hệ
            $table->string('phone')->nullable(); // Số điện thoại
            $table->text('address')->nullable(); // Địa chỉ
            $table->string('contact_person')->nullable(); // Người liên hệ chính
            $table->string('contact_position')->nullable(); // Chức vụ người liên hệ
            $table->string('tax_code')->nullable(); // Mã số thuế
            $table->enum('type', ['individual', 'company'])->default('company'); // Loại khách hàng
            $table->enum('status', ['active', 'inactive', 'potential'])->default('active'); // Trạng thái
            $table->text('description')->nullable(); // Mô tả thêm
            $table->json('additional_info')->nullable(); // Thông tin bổ sung (JSON)
            $table->timestamps();

            // Indexes
            $table->index('code');
            $table->index('status');
            $table->index('type');
        });

        // Thêm cột customer_id vào bảng projects
        Schema::table('projects', function (Blueprint $table) {
            $table->foreignId('customer_id')
                  ->nullable()
                  ->after('id')
                  ->constrained('customers')
                  ->onDelete('set null'); // Khi xóa customer, project vẫn giữ lại nhưng customer_id = null

            // Index cho customer_id
            $table->index('customer_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Xóa foreign key và cột customer_id từ projects
        Schema::table('projects', function (Blueprint $table) {
            $table->dropForeign(['customer_id']);
            $table->dropColumn('customer_id');
        });

        // Xóa bảng customers
        Schema::dropIfExists('customers');
    }
};

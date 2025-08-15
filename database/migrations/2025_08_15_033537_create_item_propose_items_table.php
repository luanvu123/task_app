<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * BẢNG PROPOSE_ITEMS - Chi tiết danh sách hàng hóa/dịch vụ trong đề xuất
     */
    public function up(): void
    {
        Schema::create('propose_items', function (Blueprint $table) {
            $table->id();

            // Liên kết với Propose
            $table->unsignedBigInteger('propose_id');
            $table->foreign('propose_id')->references('id')->on('proposes')->onDelete('cascade');

            // Thông tin sản phẩm/dịch vụ
            $table->string('item_code')->nullable(); // Mã hàng hóa (nếu có)
            $table->string('name'); // Tên hàng hóa/dịch vụ
            $table->text('description')->nullable(); // Mô tả chi tiết
            $table->text('specifications')->nullable(); // Thông số kỹ thuật
            $table->string('brand')->nullable(); // Thương hiệu
            $table->string('model')->nullable(); // Model/phiên bản

            // Phân loại
            $table->unsignedBigInteger('category_id')->nullable(); // Danh mục sản phẩm
            $table->foreign('category_id')->references('id')->on('item_categories');
            $table->string('unit'); // Đơn vị tính (cái, kg, m2, giờ...)

            // Số lượng và giá
            $table->decimal('quantity', 10, 2); // Số lượng
            $table->decimal('unit_price', 12, 2); // Đơn giá
            $table->decimal('total_price', 15, 2); // Thành tiền
            $table->decimal('discount_percent', 5, 2)->default(0); // % chiết khấu
            $table->decimal('discount_amount', 12, 2)->default(0); // Số tiền chiết khấu
            $table->decimal('tax_percent', 5, 2)->default(10); // % thuế VAT
            $table->decimal('tax_amount', 12, 2)->default(0); // Tiền thuế
            $table->decimal('final_amount', 15, 2); // Tổng cuối cùng (sau thuế, chiết khấu)

            // Trạng thái phê duyệt từng item
            $table->enum('approval_status', [
                'pending', // Chờ duyệt
                'approved', // Đã duyệt
                'rejected', // Từ chối
                'modified' // Điều chỉnh (số lượng/giá)
            ])->default('pending');

            $table->decimal('approved_quantity', 10, 2)->nullable(); // Số lượng được duyệt
            $table->decimal('approved_unit_price', 12, 2)->nullable(); // Đơn giá được duyệt
            $table->text('rejection_reason')->nullable(); // Lý do từ chối

            // Thông tin nhà cung cấp cho từng item
            $table->unsignedBigInteger('preferred_vendor_id')->nullable();
            $table->foreign('preferred_vendor_id')->references('id')->on('vendors');
            $table->json('vendor_quotes')->nullable(); // Báo giá từ các vendor khác nhau

            // Thời gian và ưu tiên
            $table->date('needed_by_date')->nullable(); // Cần có trước ngày
            $table->enum('priority', ['low', 'medium', 'high', 'critical'])->default('medium');
            $table->boolean('is_essential')->default(false); // Bắt buộc phải có

            // Thông tin kỹ thuật và chất lượng
            $table->text('quality_requirements')->nullable(); // Yêu cầu chất lượng
            $table->text('technical_requirements')->nullable(); // Yêu cầu kỹ thuật
            $table->json('certifications_required')->nullable(); // Chứng chỉ cần có
            $table->string('warranty_period')->nullable(); // Thời gian bảo hành

            // Theo dõi thực hiện
            $table->enum('procurement_status', [
                'not_started', // Chưa bắt đầu
                'quotation_requested', // Đã yêu cầu báo giá
                'quotation_received', // Đã nhận báo giá
                'vendor_selected', // Đã chọn nhà cung cấp
                'order_placed', // Đã đặt hàng
                'in_transit', // Đang giao hàng
                'delivered', // Đã giao
                'completed', // Hoàn thành
                'cancelled' // Hủy bỏ
            ])->default('not_started');

            // Thông tin giao hàng
            $table->date('expected_delivery_date')->nullable();
            $table->date('actual_delivery_date')->nullable();
            $table->decimal('delivered_quantity', 10, 2)->nullable(); // Số lượng đã giao
            $table->text('delivery_notes')->nullable(); // Ghi chú giao hàng

            // File đính kèm cho từng item
            $table->json('attachments')->nullable(); // Hình ảnh, catalog, datasheet
            $table->json('quotation_files')->nullable(); // File báo giá

            // Đánh giá sau khi nhận hàng
            $table->integer('quality_rating')->nullable(); // Đánh giá chất lượng 1-5
            $table->integer('delivery_rating')->nullable(); // Đánh giá giao hàng 1-5
            $table->text('feedback')->nullable(); // Phản hồi về sản phẩm

            // Thông tin bảo trì và hỗ trợ
            $table->date('warranty_start_date')->nullable();
            $table->date('warranty_end_date')->nullable();
            $table->text('maintenance_notes')->nullable();

            $table->timestamps();

            // Indexes
            $table->index(['propose_id', 'approval_status']);
            $table->index(['category_id', 'name']);
            $table->index(['procurement_status', 'expected_delivery_date']);
            $table->index(['preferred_vendor_id', 'final_amount']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('propose_items');
    }
};

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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // 'task', 'message', 'system', etc.
            $table->unsignedBigInteger('user_id'); // người nhận thông báo
            $table->unsignedBigInteger('from_user_id')->nullable(); // người gửi thông báo
            $table->string('title'); // tiêu đề thông báo
            $table->text('message'); // nội dung thông báo
            $table->json('data')->nullable(); // dữ liệu bổ sung (task_id, conversation_id, etc.)
            $table->string('url')->nullable(); // link để click vào thông báo
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('from_user_id')->references('id')->on('users')->onDelete('set null');

            $table->index(['user_id', 'is_read']);
            $table->index(['user_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};

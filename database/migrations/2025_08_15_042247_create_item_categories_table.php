<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    { Schema::create('item_categories', function (Blueprint $table) {
    $table->id();
    $table->string('name'); // Tên danh mục
    $table->string('code')->unique(); // Mã danh mục
    $table->text('description')->nullable();
    $table->unsignedBigInteger('parent_id')->nullable(); // Danh mục cha
    $table->foreign('parent_id')->references('id')->on('item_categories');
    $table->boolean('is_active')->default(true);
    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_categories');
    }
};

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
        Schema::create('project_timesheets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->date('work_date');
            $table->time('monday')->nullable()->default('00:00:00');
            $table->time('tuesday')->nullable()->default('00:00:00');
            $table->time('wednesday')->nullable()->default('00:00:00');
            $table->time('thursday')->nullable()->default('00:00:00');
            $table->time('friday')->nullable()->default('00:00:00');
            $table->time('saturday')->nullable()->default('00:00:00');
            $table->time('sunday')->nullable()->default('00:00:00');
            $table->decimal('total_hours', 5, 2)->default(0);
            $table->enum('status', ['draft', 'submitted', 'approved', 'rejected'])->default('draft');
            $table->text('notes')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->timestamps();

            // Indexes
            $table->index(['project_id', 'user_id', 'work_date']);
            $table->index('work_date');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_timesheets');
    }
};

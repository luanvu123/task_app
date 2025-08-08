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
        Schema::table('users', function (Blueprint $table) {
            $table->string('nationality', 100)->nullable()->after('status');
            $table->string('religion', 100)->nullable()->after('nationality');
            $table->enum('marital_status', ['single', 'married', 'divorced', 'widowed'])->nullable()->after('religion');
            $table->string('passport_no', 20)->nullable()->after('marital_status');
            $table->string('emergency_contact', 20)->nullable()->after('passport_no');
            $table->string('bank_name', 100)->nullable()->after('emergency_contact');
            $table->string('account_no', 30)->nullable()->after('bank_name');
            $table->string('ifsc_code', 11)->nullable()->after('account_no');
            $table->string('pan_no', 10)->nullable()->after('ifsc_code');
            $table->string('upi_id', 100)->nullable()->after('pan_no');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'nationality',
                'religion',
                'marital_status',
                'passport_no',
                'emergency_contact',
                'bank_name',
                'account_no',
                'ifsc_code',
                'pan_no',
                'upi_id'
            ]);
        });
    }
};

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
        Schema::table('generate_test', function (Blueprint $table) {
            $table->integer('standard')->nullable()->after('test_code');
            $table->integer('medium')->nullable()->after('test_code');
            $table->integer('subject')->nullable()->after('test_code');
            $table->boolean('status')->default(0)->after('test_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('generate_test', function (Blueprint $table) {
            $table->dropColumn(['standard','medium','subject', 'status']);
        });
    }
};

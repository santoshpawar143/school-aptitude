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
        Schema::table('result', function (Blueprint $table) {
            $table->json('selected_ans')->nullable()->after('marks_obtained');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('result', function (Blueprint $table) {
            $table->dropColumn(['selected_ans']);
        });
    }
};

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
        Schema::create('teacher_subject', function (Blueprint $table) {
            $table->id(); // auto-incrementing primary key
            $table->unsignedBigInteger('teacher_id'); // foreign key reference
            $table->unsignedBigInteger('school_id'); // foreign key reference
            $table->json('board_array');
            $table->json('medium_array');
            $table->json('standard_array');
            $table->json('subject_array');
            $table->boolean('is_deleted')->default(false); // flag indicating deleted status
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher_subject');
    }
};

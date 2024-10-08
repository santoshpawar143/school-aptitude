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
    //     Schema::table('users', function (Blueprint $table) {
    //         // Add the role_id column
    //         // Ensure the role column is of type unsignedBigInteger
    //         $table->unsignedBigInteger('school_id')->change();

    //         // Add foreign key constraint
    //         $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
    //     });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::table('users', function (Blueprint $table) {
        //     // Drop the foreign key constraint
        //     $table->dropForeign(['school_id']);

        //     // Drop the role_id column
        //     $table->dropColumn('school_id');
        // });
    }
};

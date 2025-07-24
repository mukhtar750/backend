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
        Schema::table('resources', function (Blueprint $table) {
            $table->unsignedBigInteger('mentor_id')->nullable()->after('bdsp_id');
            $table->unsignedBigInteger('mentee_id')->nullable()->after('mentor_id');
            $table->foreign('mentor_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('mentee_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('resources', function (Blueprint $table) {
            $table->dropForeign(['mentor_id']);
            $table->dropForeign(['mentee_id']);
            $table->dropColumn(['mentor_id', 'mentee_id']);
        });
    }
};

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
        Schema::table('pairings', function (Blueprint $table) {
            // Drop the existing unique constraint
            $table->dropUnique(['user_one_id', 'user_two_id', 'pairing_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pairings', function (Blueprint $table) {
            // Restore the unique constraint if we need to rollback
            $table->unique(['user_one_id', 'user_two_id', 'pairing_type']);
        });
    }
};

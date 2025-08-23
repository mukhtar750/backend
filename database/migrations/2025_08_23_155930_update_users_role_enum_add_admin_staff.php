<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, we need to drop the existing enum constraint
        // This is necessary because MySQL/PostgreSQL don't allow direct enum modifications
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('entrepreneur', 'investor', 'bdsp', 'admin', 'staff') DEFAULT 'entrepreneur'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to the original enum values
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('entrepreneur', 'investor', 'bdsp') DEFAULT 'entrepreneur'");
    }
};

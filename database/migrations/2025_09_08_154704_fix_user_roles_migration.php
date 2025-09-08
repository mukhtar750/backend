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
        // First, check if the role column exists
        if (!Schema::hasColumn('users', 'role')) {
            // If role column doesn't exist, create it with all possible values
            Schema::table('users', function (Blueprint $table) {
                $table->enum('role', ['entrepreneur', 'investor', 'bdsp', 'admin', 'staff'])
                      ->default('entrepreneur');
            });
        }
        
        // Now safely update the enum values if needed
        // First, get the current column definition
        $column = DB::select(
            "SELECT COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS 
             WHERE TABLE_SCHEMA = ? 
             AND TABLE_NAME = 'users' 
             AND COLUMN_NAME = 'role'",
             [config('database.connections.mysql.database')]
        );

        if (!empty($column)) {
            $columnType = $column[0]->COLUMN_TYPE;
            
            // Check if the column needs to be updated
            if (strpos($columnType, "'admin'") === false || strpos($columnType, "'staff'") === false) {
                // Temporarily allow any value in the role column
                DB::statement("ALTER TABLE users MODIFY COLUMN role VARCHAR(20) DEFAULT 'entrepreneur'");
                
                // Now update to the new enum
                DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('entrepreneur', 'investor', 'bdsp', 'admin', 'staff') DEFAULT 'entrepreneur'");
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // We'll keep the column but revert to the original enum values
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('entrepreneur', 'investor', 'bdsp') DEFAULT 'entrepreneur'");
    }
};

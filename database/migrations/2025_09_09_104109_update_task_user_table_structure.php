<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Check if the table exists
        if (Schema::hasTable('task_user')) {
            Schema::table('task_user', function (Blueprint $table) {
                // Add status column if it doesn't exist
                if (!Schema::hasColumn('task_user', 'status')) {
                    $table->string('status')->default('pending')->after('user_id');
                }
                
                // Add completed_at column if it doesn't exist
                if (!Schema::hasColumn('task_user', 'completed_at')) {
                    $table->timestamp('completed_at')->nullable()->after('status');
                }
                
                // Add timestamps if they don't exist
                if (!Schema::hasColumn('task_user', 'created_at')) {
                    $table->timestamps();
                }
            });
            
            // Add composite unique index if it doesn't exist
            Schema::table('task_user', function (Blueprint $table) {
                if (!Schema::hasIndex('task_user', ['task_id', 'user_id'])) {
                    $table->unique(['task_id', 'user_id']);
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This is a safe down migration that won't drop columns
        // to prevent data loss in production
        Schema::table('task_user', function (Blueprint $table) {
            // Don't drop columns in production to prevent data loss
            if (!app()->environment('production')) {
                $table->dropUnique(['task_id', 'user_id']);
                
                if (Schema::hasColumn('task_user', 'status')) {
                    $table->dropColumn('status');
                }
                
                if (Schema::hasColumn('task_user', 'completed_at')) {
                    $table->dropColumn('completed_at');
                }
                
                if (Schema::hasColumn('task_user', 'created_at')) {
                    $table->dropTimestamps();
                }
            }
        });
    }
};

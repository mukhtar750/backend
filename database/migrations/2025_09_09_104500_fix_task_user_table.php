<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Only proceed if the table exists
        if (!Schema::hasTable('task_user')) {
            return;
        }

        // Add status column if it doesn't exist
        if (!Schema::hasColumn('task_user', 'status')) {
            Schema::table('task_user', function (Blueprint $table) {
                $table->string('status')->default('pending')->after('user_id');
            });
        }

        // Add completed_at column if it doesn't exist
        if (!Schema::hasColumn('task_user', 'completed_at')) {
            Schema::table('task_user', function (Blueprint $table) {
                $table->timestamp('completed_at')->nullable()->after('status');
            });
        }

        // Add timestamps if they don't exist
        if (!Schema::hasColumn('task_user', 'created_at')) {
            Schema::table('task_user', function (Blueprint $table) {
                $table->timestamps();
            });
        }

        // Add unique index if it doesn't exist
        $indexes = collect(DB::select("SHOW INDEX FROM task_user"))->pluck('Key_name');
        if (!$indexes->contains('task_user_task_id_user_id_unique')) {
            Schema::table('task_user', function (Blueprint $table) {
                $table->unique(['task_id', 'user_id'], 'task_user_task_id_user_id_unique');
            });
        }
    }

    public function down(): void
    {
        // Safe down migration - only drop in non-production
        if (!app()->environment('production')) {
            Schema::table('task_user', function (Blueprint $table) {
                $table->dropUnique('task_user_task_id_user_id_unique');
                
                if (Schema::hasColumn('task_user', 'status')) {
                    $table->dropColumn('status');
                }
                
                if (Schema::hasColumn('task_user', 'completed_at')) {
                    $table->dropColumn('completed_at');
                }
                
                if (Schema::hasColumn('task_user', 'created_at')) {
                    $table->dropColumn(['created_at', 'updated_at']);
                }
            });
        }
    }
};

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
        Schema::table('startups', function (Blueprint $table) {
            if (!Schema::hasColumn('startups', 'anonymous_teaser')) {
                $table->boolean('anonymous_teaser')->default(true)->after('status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('startups', function (Blueprint $table) {
            if (Schema::hasColumn('startups', 'anonymous_teaser')) {
                $table->dropColumn('anonymous_teaser');
            }
        });
    }
};

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
        Schema::table('users', function (Blueprint $table) {
            // Add missing entrepreneur fields
            if (!Schema::hasColumn('users', 'business_name')) {
                $table->string('business_name')->nullable()->after('bdsp_linkedin');
            }
            if (!Schema::hasColumn('users', 'sector')) {
                $table->string('sector')->nullable()->after('business_name');
            }
            if (!Schema::hasColumn('users', 'cac_number')) {
                $table->string('cac_number')->nullable()->after('sector');
            }
            if (!Schema::hasColumn('users', 'funding_stage')) {
                $table->string('funding_stage')->nullable()->after('cac_number');
            }
            if (!Schema::hasColumn('users', 'website')) {
                $table->string('website')->nullable()->after('funding_stage');
            }
            if (!Schema::hasColumn('users', 'entrepreneur_phone')) {
                $table->string('entrepreneur_phone')->nullable()->after('website');
            }
            if (!Schema::hasColumn('users', 'entrepreneur_linkedin')) {
                $table->string('entrepreneur_linkedin')->nullable()->after('entrepreneur_phone');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'business_name',
                'sector', 
                'cac_number',
                'funding_stage',
                'website',
                'entrepreneur_phone',
                'entrepreneur_linkedin'
            ]);
        });
    }
};

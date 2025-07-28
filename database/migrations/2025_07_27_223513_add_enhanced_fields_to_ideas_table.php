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
        Schema::table('ideas', function (Blueprint $table) {
            // Enhanced submission fields
            $table->text('problem_statement')->nullable()->after('description');
            $table->text('proposed_solution')->nullable()->after('problem_statement');
            $table->string('sector')->nullable()->after('proposed_solution');
            $table->text('target_beneficiaries')->nullable()->after('sector');
            $table->enum('urgency_level', ['low', 'medium', 'high'])->default('medium')->after('target_beneficiaries');
            $table->json('related_sdgs')->nullable()->after('urgency_level');
            $table->string('tags')->nullable()->after('related_sdgs');
            
            // Enhanced status management
            $table->enum('status', ['open', 'pitched', 'approved', 'under_review', 'selected_for_incubation', 'in_development', 'piloted', 'archived', 'rejected'])->default('open')->change();
            
            // Interest tracking
            $table->unsignedInteger('interest_count')->default(0)->after('downvotes');
            
            // Admin tracking
            $table->json('assigned_stakeholders')->nullable()->after('interest_count');
            $table->text('admin_notes')->nullable()->after('assigned_stakeholders');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ideas', function (Blueprint $table) {
            $table->dropColumn([
                'problem_statement',
                'proposed_solution', 
                'sector',
                'target_beneficiaries',
                'urgency_level',
                'related_sdgs',
                'tags',
                'interest_count',
                'assigned_stakeholders',
                'admin_notes'
            ]);
            
            // Revert status enum
            $table->enum('status', ['open', 'pitched', 'approved'])->default('open')->change();
        });
    }
};

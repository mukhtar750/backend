<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\TrainingModule;
use App\Policies\TrainingModulePolicy;

class TestPolicyAccess extends Command
{
    protected $signature = 'test:policy-access {email}';
    protected $description = 'Test policy access for a specific user';

    public function handle()
    {
        $email = $this->argument('email');
        
        $this->info("=== TESTING POLICY ACCESS FOR: {$email} ===");
        
        // Find user
        $user = User::where('email', $email)->first();
        if (!$user) {
            $this->error("User not found: {$email}");
            return 1;
        }
        
        $this->line("User ID: {$user->id}");
        $this->line("User Name: {$user->name}");
        $this->line("User Role: {$user->role}");
        $this->line("User Status: {$user->status}");
        $this->line("User Approved: " . ($user->is_approved ? 'Yes' : 'No'));
        $this->newLine();
        
        // Find user's modules
        $modules = TrainingModule::where('bdsp_id', $user->id)->get();
        $this->line("User has {$modules->count()} modules:");
        
        foreach ($modules as $module) {
            $this->line("  - Module ID: {$module->id}");
            $this->line("    Title: {$module->title}");
            $this->line("    BDSP ID: {$module->bdsp_id}");
            $this->line("    Status: {$module->status}");
            $this->newLine();
            
            // Test policy
            $policy = new TrainingModulePolicy();
            
            $canView = $policy->view($user, $module);
            $canUpdate = $policy->update($user, $module);
            $canDelete = $policy->delete($user, $module);
            
            $this->line("Policy Results:");
            $this->line("  Can View: " . ($canView ? '✓ Yes' : '✗ No'));
            $this->line("  Can Update: " . ($canUpdate ? '✓ Yes' : '✗ No'));
            $this->line("  Can Delete: " . ($canDelete ? '✓ Yes' : '✗ No'));
            $this->newLine();
        }
        
        return 0;
    }
}

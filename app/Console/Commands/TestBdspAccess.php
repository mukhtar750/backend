<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class TestBdspAccess extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:bdsp-access {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test BDSP access for specific user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        
        $this->info("=== TESTING BDSP ACCESS FOR: {$email} ===");
        $this->newLine();

        // 1. Find the user
        $user = User::where('email', $email)->first();
        if (!$user) {
            $this->error("✗ User not found: {$email}");
            return 1;
        }

        $this->line("✓ User found: {$user->name}");
        $this->line("  ID: {$user->id}");
        $this->line("  Role: {$user->role}");
        $this->line("  Approved: " . ($user->is_approved ? 'Yes' : 'No'));
        $this->line("  Status: {$user->status}");
        $this->newLine();

        // 2. Test authentication
        Auth::login($user);
        if (Auth::check()) {
            $this->line("✓ Authentication successful");
            $this->line("  Logged in as: " . Auth::user()->name);
        } else {
            $this->error("✗ Authentication failed");
            return 1;
        }
        $this->newLine();

        // 3. Check if user has BDSP role
        if ($user->role !== 'bdsp') {
            $this->error("✗ User role is '{$user->role}', expected 'bdsp'");
            return 1;
        }
        $this->line("✓ User has correct BDSP role");
        $this->newLine();

        // 4. Check approval status
        if (!$user->is_approved) {
            $this->warn("⚠ User is not approved - this might cause 403 errors");
        } else {
            $this->line("✓ User is approved");
        }
        $this->newLine();

        // 5. Check user's modules
        $moduleCount = DB::table('training_modules')
            ->where('bdsp_id', $user->id)
            ->count();
        
        $this->line("User has {$moduleCount} training modules");
        
        if ($moduleCount > 0) {
            $modules = DB::table('training_modules')
                ->where('bdsp_id', $user->id)
                ->select('id', 'title', 'status')
                ->get();
            
            foreach ($modules as $module) {
                $this->line("  - {$module->title} (Status: {$module->status})");
            }
        } else {
            $this->warn("⚠ User has no modules - they need at least one to test access");
        }
        $this->newLine();

        // 6. Test basic database queries
        $this->line("Testing database queries:");
        
        try {
            $totalUsers = DB::table('users')->count();
            $this->line("  ✓ Total users: {$totalUsers}");
            
            $totalBdsps = DB::table('users')->where('role', 'bdsp')->count();
            $this->line("  ✓ Total BDSPs: {$totalBdsps}");
            
            $totalModules = DB::table('training_modules')->count();
            $this->line("  ✓ Total modules: {$totalModules}");
            
        } catch (\Exception $e) {
            $this->error("✗ Database query failed: " . $e->getMessage());
            return 1;
        }
        $this->newLine();

        // 7. Test middleware registration
        $this->line("Checking middleware:");
        
        $routeMiddleware = app('router')->getMiddleware();
        if (isset($routeMiddleware['role'])) {
            $this->line("  ✓ Role middleware registered");
        } else {
            $this->error("  ✗ Role middleware NOT registered");
        }
        $this->newLine();

        // 8. Summary
        $this->info("=== SUMMARY ===");
        $this->line("User: {$user->name} ({$user->email})");
        $this->line("Role: {$user->role}");
        $this->line("Approved: " . ($user->is_approved ? 'Yes' : 'No'));
        $this->line("Modules: {$moduleCount}");
        $this->line("Authentication: " . (Auth::check() ? 'Success' : 'Failed'));
        
        if ($user->role === 'bdsp' && $user->is_approved && Auth::check()) {
            $this->line("✓ All basic checks passed - user should be able to access BDSP features");
        } else {
            $this->error("✗ Some checks failed - this might be causing 403 errors");
        }
        
        return 0;
    }
}

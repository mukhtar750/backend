<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\TrainingModule;
use App\Policies\TrainingModulePolicy;

class DeepDiagnose403 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'diagnose:deep-403 {email?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deep diagnose 403 error for specific BDSP user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        
        $this->info('=== DEEP 403 ERROR DIAGNOSIS ===');
        $this->newLine();

        // 1. Test with specific BDSP user
        if ($email) {
            $this->info("1. TESTING SPECIFIC BDSP USER: {$email}");
            
            $user = User::where('email', $email)->first();
            if (!$user) {
                $this->error("   ✗ User not found: {$email}");
                return 1;
            }
            
            $this->line("   User ID: {$user->id}");
            $this->line("   Name: {$user->name}");
            $this->line("   Role: {$user->role}");
            $this->line("   Approved: " . ($user->is_approved ? 'Yes' : 'No'));
            $this->line("   Status: {$user->status}");
            $this->newLine();
            
            // Test authentication
            Auth::login($user);
            $this->line("   ✓ Authenticated as: {$user->name}");
            $this->newLine();
            
            // Test policy access
            $this->testPolicyAccess($user);
            
        } else {
            $this->info('1. TESTING ALL BDSP USERS:');
            $bdsps = User::where('role', 'bdsp')->get();
            
            foreach ($bdsps as $bdsp) {
                $this->line("   Testing: {$bdsp->name} ({$bdsp->email})");
                $this->testPolicyAccess($bdsp);
                $this->newLine();
            }
        }

        // 2. Check route registration
        $this->info('2. ROUTE REGISTRATION CHECK:');
        $bdspRoutes = Route::getRoutes()->getRoutes();
        $bdspTrainingRoutes = collect($bdspRoutes)->filter(function ($route) {
            return str_contains($route->uri, 'bdsp/training-modules');
        });
        
        $this->line("   Found " . $bdspTrainingRoutes->count() . " BDSP training routes:");
        foreach ($bdspTrainingRoutes as $route) {
            $this->line("     - {$route->methods[0]} {$route->uri} -> {$route->getName()}");
        }
        $this->newLine();

        // 3. Check middleware stack
        $this->info('3. MIDDLEWARE STACK CHECK:');
        $middlewareGroups = app('router')->getMiddlewareGroups();
        $routeMiddleware = app('router')->getMiddleware();
        
        if (isset($routeMiddleware['role'])) {
            $this->line("   ✓ Role middleware registered: " . $routeMiddleware['role']);
        } else {
            $this->error("   ✗ Role middleware NOT registered");
        }
        $this->newLine();

        // 4. Database integrity check
        $this->info('4. DATABASE INTEGRITY CHECK:');
        
        // Check for any modules with invalid BDSP IDs
        $invalidModules = DB::table('training_modules as tm')
            ->leftJoin('users as u', 'tm.bdsp_id', '=', 'u.id')
            ->whereNull('u.id')
            ->orWhere('u.role', '!=', 'bdsp')
            ->get();
            
        if ($invalidModules->isNotEmpty()) {
            $this->error("   ✗ Found " . $invalidModules->count() . " invalid modules:");
            foreach ($invalidModules as $module) {
                $this->line("     - {$module->title} (BDSP ID: {$module->bdsp_id})");
            }
        } else {
            $this->line("   ✓ All modules have valid BDSP owners");
        }
        $this->newLine();

        // 5. Session check
        $this->info('5. SESSION CHECK:');
        $this->line("   Session Driver: " . config('session.driver'));
        $this->line("   Session Lifetime: " . config('session.lifetime') . " minutes");
        
        if (Auth::check()) {
            $this->line("   ✓ User is authenticated: " . Auth::user()->name);
        } else {
            $this->error("   ✗ No user authenticated");
        }
        $this->newLine();

        // 6. Test actual route access
        $this->info('6. ROUTE ACCESS TEST:');
        try {
            $response = app()->handle(\Illuminate\Http\Request::create('/bdsp/training-modules', 'GET'));
            $this->line("   Route response code: " . $response->getStatusCode());
            
            if ($response->getStatusCode() === 403) {
                $this->error("   ✗ Route returns 403 - Authorization issue");
            } elseif ($response->getStatusCode() === 200) {
                $this->line("   ✓ Route accessible");
            } else {
                $this->warn("   ⚠ Route returns: " . $response->getStatusCode());
            }
        } catch (\Exception $e) {
            $this->error("   ✗ Route test failed: " . $e->getMessage());
        }
        $this->newLine();

        // 7. Check recent Laravel logs
        $this->info('7. RECENT LARAVEL LOGS:');
        $logFile = storage_path('logs/laravel.log');
        if (file_exists($logFile)) {
            $recentLogs = file_get_contents($logFile);
            $lines = explode("\n", $recentLogs);
            $recentLines = array_slice($lines, -20); // Last 20 lines
            
            $this->line("   Recent log entries:");
            foreach ($recentLines as $line) {
                if (str_contains($line, '403') || str_contains($line, 'Policy') || str_contains($line, 'bdsp')) {
                    $this->line("     " . trim($line));
                }
            }
        } else {
            $this->error("   ✗ Laravel log file not found");
        }
        $this->newLine();

        $this->info('=== DEEP DIAGNOSIS COMPLETE ===');
        return 0;
    }

    private function testPolicyAccess($user)
    {
        $this->line("   Testing policy access for: {$user->name}");
        
        // Get user's modules
        $userModules = TrainingModule::where('bdsp_id', $user->id)->get();
        $this->line("   User has {$userModules->count()} modules");
        
        if ($userModules->isNotEmpty()) {
            $module = $userModules->first();
            $policy = new TrainingModulePolicy();
            
            // Test view permission
            $canView = $policy->view($user, $module);
            $this->line("   Can view own module: " . ($canView ? '✓ Yes' : '✗ No'));
            
            // Test create permission
            $canCreate = $policy->create($user);
            $this->line("   Can create modules: " . ($canCreate ? '✓ Yes' : '✗ No'));
            
            // Test update permission
            $canUpdate = $policy->update($user, $module);
            $this->line("   Can update own module: " . ($canUpdate ? '✓ Yes' : '✗ No'));
        } else {
            $this->line("   ⚠ User has no modules to test");
        }
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Diagnose403Error extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'diagnose:403-error';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Diagnose 403 error issues for BDSP training modules';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('=== PRODUCTION 403 ERROR DIAGNOSTIC ===');
        $this->newLine();

        // 1. Basic Environment Check
        $this->info('1. ENVIRONMENT CHECK:');
        $this->line('   PHP Version: ' . PHP_VERSION);
        $this->line('   Laravel Version: ' . app()->version());
        $this->line('   Environment: ' . (env('APP_ENV') ?: 'Not set'));
        $this->line('   Debug Mode: ' . (env('APP_DEBUG') ? 'ON' : 'OFF'));
        $this->newLine();

        // 2. Database Connection Test
        $this->info('2. DATABASE CONNECTION:');
        try {
            DB::connection()->getPdo();
            $this->line('   ✓ Database connection successful');
            
            $userCount = DB::table('users')->count();
            $this->line("   ✓ Total users: {$userCount}");
            
        } catch (\Exception $e) {
            $this->error('   ✗ Database connection failed: ' . $e->getMessage());
            $this->line('   → Check your .env file database settings');
            $this->newLine();
            return 1;
        }

        // 3. BDSP User Analysis
        $this->info('3. BDSP USER ANALYSIS:');
        try {
            $bdsps = DB::table('users')
                ->where('role', 'bdsp')
                ->select('id', 'name', 'email', 'role', 'is_approved', 'status')
                ->get();
            
            if ($bdsps->isEmpty()) {
                $this->error('   ✗ NO BDSP USERS FOUND!');
                $this->line('   → This is likely the main issue');
                $this->line('   → Check if users have correct role assignment');
                $this->newLine();
            } else {
                $this->line("   ✓ Found " . $bdsps->count() . " BDSP users:");
                foreach ($bdsps as $bdsp) {
                    $status = $bdsp->is_approved ? 'Approved' : 'Not Approved';
                    $this->line("     - {$bdsp->name} ({$bdsp->email}) - {$status}");
                }
                $this->newLine();
            }
            
            // Check for case sensitivity issues
            $caseInsensitiveBdsps = DB::table('users')
                ->whereRaw('LOWER(role) = ?', ['bdsp'])
                ->get();
            
            if ($caseInsensitiveBdsps->count() != $bdsps->count()) {
                $this->warn('   ⚠ Case sensitivity issue detected!');
                $this->line('   → Some users may have \'BDSP\' instead of \'bdsp\'');
                $this->line("   → Found " . $caseInsensitiveBdsps->count() . " users with case-insensitive match");
                $this->newLine();
            }
            
        } catch (\Exception $e) {
            $this->error('   ✗ Error analyzing BDSP users: ' . $e->getMessage());
            $this->newLine();
        }

        // 4. Training Modules Check
        $this->info('4. TRAINING MODULES CHECK:');
        try {
            $moduleCount = DB::table('training_modules')->count();
            $this->line("   ✓ Total training modules: {$moduleCount}");
            
            if ($moduleCount > 0) {
                $modules = DB::table('training_modules as tm')
                    ->leftJoin('users as u', 'tm.bdsp_id', '=', 'u.id')
                    ->select('tm.id', 'tm.title', 'tm.bdsp_id', 'u.name as bdsp_name', 'u.role as bdsp_role')
                    ->limit(5)
                    ->get();
                
                $this->line('   Sample modules:');
                foreach ($modules as $module) {
                    $owner = $module->bdsp_name ?: 'Unknown';
                    $role = $module->bdsp_role ?: 'No role';
                    $this->line("     - {$module->title} (Owner: {$owner}, Role: {$role})");
                }
            }
            
        } catch (\Exception $e) {
            $this->error('   ✗ Error checking training modules: ' . $e->getMessage());
        }
        $this->newLine();

        // 5. Session and Authentication Check
        $this->info('5. SESSION & AUTHENTICATION:');
        $this->line('   Session Driver: ' . env('SESSION_DRIVER', 'file'));
        $this->line('   Session Lifetime: ' . env('SESSION_LIFETIME', '120') . ' minutes');

        // Check session storage
        $sessionPath = storage_path('framework/sessions');
        if (is_dir($sessionPath)) {
            if (is_writable($sessionPath)) {
                $this->line('   ✓ Session storage is writable');
            } else {
                $this->error('   ✗ Session storage is NOT writable');
                $this->line('   → This could cause authentication issues');
            }
        } else {
            $this->error('   ✗ Session directory doesn\'t exist');
        }

        // Check for active sessions
        $sessionFiles = glob($sessionPath . '/*');
        $this->line('   Active session files: ' . count($sessionFiles));
        $this->newLine();

        // 6. File Permissions Check
        $this->info('6. CRITICAL FILE PERMISSIONS:');
        $criticalPaths = [
            storage_path() => 'Storage directory',
            base_path('bootstrap/cache') => 'Cache directory',
            public_path() => 'Public directory',
            base_path('.env') => 'Environment file'
        ];

        foreach ($criticalPaths as $path => $description) {
            if (file_exists($path)) {
                $perms = fileperms($path);
                $isWritable = is_writable($path);
                $status = $isWritable ? '✓' : '✗';
                $this->line("   {$status} {$description}: " . substr(sprintf('%o', $perms), -4));
                
                if (!$isWritable) {
                    $this->line('      → Needs write permissions');
                }
            } else {
                $this->error("   ✗ {$description}: Not found");
            }
        }
        $this->newLine();

        // 7. Route and Middleware Check
        $this->info('7. ROUTE & MIDDLEWARE CHECK:');

        // Check if routes are cached
        $routeCache = base_path('bootstrap/cache/routes.php');
        if (file_exists($routeCache)) {
            $this->line('   ✓ Routes are cached');
        } else {
            $this->warn('   ⚠ Routes are not cached');
        }

        // Check middleware registration
        $kernelFile = app_path('Http/Kernel.php');
        if (file_exists($kernelFile)) {
            $kernelContent = file_get_contents($kernelFile);
            
            if (strpos($kernelContent, "'role'") !== false) {
                $this->line('   ✓ Role middleware is registered');
            } else {
                $this->error('   ✗ Role middleware is NOT registered');
            }
            
            if (strpos($kernelContent, 'RoleMiddleware') !== false) {
                $this->line('   ✓ RoleMiddleware class is referenced');
            } else {
                $this->error('   ✗ RoleMiddleware class is NOT referenced');
            }
        } else {
            $this->error('   ✗ Kernel.php not found');
        }
        $this->newLine();

        // 8. Policy Registration Check
        $this->info('8. POLICY REGISTRATION:');
        $authProvider = app_path('Providers/AuthServiceProvider.php');
        if (file_exists($authProvider)) {
            $providerContent = file_get_contents($authProvider);
            
            if (strpos($providerContent, 'TrainingModulePolicy') !== false) {
                $this->line('   ✓ TrainingModulePolicy is registered');
            } else {
                $this->error('   ✗ TrainingModulePolicy is NOT registered');
            }
        } else {
            $this->error('   ✗ AuthServiceProvider.php not found');
        }
        $this->newLine();

        // 9. Specific BDSP Test
        $this->info('9. BDSP SPECIFIC TEST:');
        if (!empty($bdsps) && $bdsps->isNotEmpty()) {
            $testBdsp = $bdsps->first();
            $this->line("   Testing with BDSP: {$testBdsp->name} (ID: {$testBdsp->id})");
            
            // Check if this BDSP has any modules
            $moduleCount = DB::table('training_modules')
                ->where('bdsp_id', $testBdsp->id)
                ->count();
            
            $this->line("   Modules owned by this BDSP: {$moduleCount}");
            
            if ($moduleCount == 0) {
                $this->warn('   ⚠ This BDSP has no modules - they need modules to test access');
            }
            
            // Check approval status
            if (!$testBdsp->is_approved) {
                $this->warn('   ⚠ This BDSP is not approved - this could cause 403 errors');
            }
        } else {
            $this->line('   No BDSP users to test with');
        }
        $this->newLine();

        // 10. Recommendations
        $this->info('10. RECOMMENDATIONS:');
        $this->line('   → Check the Laravel logs: tail -f storage/logs/laravel.log');
        $this->line('   → Clear all caches: php artisan optimize:clear');
        $this->line('   → Check Apache/Nginx error logs in cPanel');
        $this->line('   → Verify .htaccess file exists in public/ directory');
        $this->line('   → Ensure all file permissions are correct (755 for dirs, 644 for files)');
        $this->line('   → Test with a fresh BDSP user session');
        $this->newLine();

        $this->info('=== DIAGNOSTIC COMPLETE ===');
        $this->line('Please share the output above along with your error logs.');

        return 0;
    }
}

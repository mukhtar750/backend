<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class FixMiddlewareRegistration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:middleware-registration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix middleware registration issues';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('=== FIXING MIDDLEWARE REGISTRATION ===');
        $this->newLine();

        // 1. Clear all caches
        $this->info('1. CLEARING ALL CACHES:');
        try {
            Artisan::call('optimize:clear');
            $this->line('   ✓ All caches cleared');
        } catch (\Exception $e) {
            $this->error('   ✗ Error clearing caches: ' . $e->getMessage());
        }
        $this->newLine();

        // 2. Clear route cache
        $this->info('2. CLEARING ROUTE CACHE:');
        try {
            Artisan::call('route:clear');
            $this->line('   ✓ Route cache cleared');
        } catch (\Exception $e) {
            $this->error('   ✗ Error clearing route cache: ' . $e->getMessage());
        }
        $this->newLine();

        // 3. Clear config cache
        $this->info('3. CLEARING CONFIG CACHE:');
        try {
            Artisan::call('config:clear');
            $this->line('   ✓ Config cache cleared');
        } catch (\Exception $e) {
            $this->error('   ✗ Error clearing config cache: ' . $e->getMessage());
        }
        $this->newLine();

        // 4. Clear application cache
        $this->info('4. CLEARING APPLICATION CACHE:');
        try {
            Artisan::call('cache:clear');
            $this->line('   ✓ Application cache cleared');
        } catch (\Exception $e) {
            $this->error('   ✗ Error clearing application cache: ' . $e->getMessage());
        }
        $this->newLine();

        // 5. Check middleware registration
        $this->info('5. CHECKING MIDDLEWARE REGISTRATION:');
        $routeMiddleware = app('router')->getMiddleware();
        
        if (isset($routeMiddleware['role'])) {
            $this->line('   ✓ Role middleware is registered: ' . $routeMiddleware['role']);
        } else {
            $this->error('   ✗ Role middleware is NOT registered');
            $this->line('   → This is the cause of 403 errors');
        }
        
        if (isset($routeMiddleware['auth'])) {
            $this->line('   ✓ Auth middleware is registered: ' . $routeMiddleware['auth']);
        } else {
            $this->error('   ✗ Auth middleware is NOT registered');
        }
        $this->newLine();

        // 6. Test route registration
        $this->info('6. TESTING ROUTE REGISTRATION:');
        try {
            $routes = app('router')->getRoutes();
            $bdspRoutes = collect($routes)->filter(function ($route) {
                return str_contains($route->uri, 'bdsp/training-modules');
            });
            
            $this->line("   ✓ Found {$bdspRoutes->count()} BDSP training routes");
            
            // Check if routes have middleware
            foreach ($bdspRoutes as $route) {
                $middleware = $route->middleware();
                if (in_array('role:bdsp', $middleware)) {
                    $this->line("   ✓ Route {$route->uri} has role:bdsp middleware");
                } else {
                    $this->warn("   ⚠ Route {$route->uri} missing role:bdsp middleware");
                }
            }
        } catch (\Exception $e) {
            $this->error('   ✗ Error checking routes: ' . $e->getMessage());
        }
        $this->newLine();

        // 7. Rebuild caches for production
        $this->info('7. REBUILDING CACHES FOR PRODUCTION:');
        try {
            Artisan::call('route:cache');
            $this->line('   ✓ Routes cached for production');
        } catch (\Exception $e) {
            $this->warn('   ⚠ Could not cache routes: ' . $e->getMessage());
        }
        
        try {
            Artisan::call('config:cache');
            $this->line('   ✓ Config cached for production');
        } catch (\Exception $e) {
            $this->warn('   ⚠ Could not cache config: ' . $e->getMessage());
        }
        $this->newLine();

        $this->info('=== MIDDLEWARE FIX COMPLETE ===');
        $this->line('Please test BDSP access now.');
        
        return 0;
    }
}

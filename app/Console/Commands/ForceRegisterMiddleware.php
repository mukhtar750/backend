<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Middleware\Authenticate;

class ForceRegisterMiddleware extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'force:register-middleware';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Force register middleware classes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('=== FORCE REGISTERING MIDDLEWARE ===');
        $this->newLine();

        // 1. Test if middleware classes can be loaded
        $this->info('1. TESTING MIDDLEWARE CLASS LOADING:');
        
        try {
            $roleMiddleware = new RoleMiddleware();
            $this->line('   ✓ RoleMiddleware class can be instantiated');
        } catch (\Exception $e) {
            $this->error('   ✗ Error loading RoleMiddleware: ' . $e->getMessage());
            return 1;
        }

        try {
            $authMiddleware = new Authenticate();
            $this->line('   ✓ Authenticate class can be instantiated');
        } catch (\Exception $e) {
            $this->error('   ✗ Error loading Authenticate: ' . $e->getMessage());
            return 1;
        }
        $this->newLine();

        // 2. Manually register middleware with router
        $this->info('2. MANUALLY REGISTERING MIDDLEWARE:');
        
        try {
            $router = app('router');
            
            // Register role middleware
            $router->aliasMiddleware('role', RoleMiddleware::class);
            $this->line('   ✓ Role middleware registered manually');
            
            // Register auth middleware
            $router->aliasMiddleware('auth', Authenticate::class);
            $this->line('   ✓ Auth middleware registered manually');
            
        } catch (\Exception $e) {
            $this->error('   ✗ Error registering middleware: ' . $e->getMessage());
            return 1;
        }
        $this->newLine();

        // 3. Verify registration
        $this->info('3. VERIFYING REGISTRATION:');
        
        $middleware = $router->getMiddleware();
        
        if (isset($middleware['role'])) {
            $this->line('   ✓ Role middleware now registered: ' . $middleware['role']);
        } else {
            $this->error('   ✗ Role middleware still NOT registered');
        }
        
        if (isset($middleware['auth'])) {
            $this->line('   ✓ Auth middleware now registered: ' . $middleware['auth']);
        } else {
            $this->error('   ✗ Auth middleware still NOT registered');
        }
        $this->newLine();

        // 4. Test route middleware
        $this->info('4. TESTING ROUTE MIDDLEWARE:');
        
        try {
            $routes = $router->getRoutes();
            $bdspRoutes = collect($routes)->filter(function ($route) {
                return str_contains($route->uri, 'bdsp/training-modules');
            });
            
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

        // 5. Clear caches
        $this->info('5. CLEARING CACHES:');
        try {
            Artisan::call('optimize:clear');
            $this->line('   ✓ All caches cleared');
        } catch (\Exception $e) {
            $this->error('   ✗ Error clearing caches: ' . $e->getMessage());
        }
        $this->newLine();

        $this->info('=== FORCE REGISTRATION COMPLETE ===');
        $this->line('Please test BDSP access now.');
        
        return 0;
    }
}

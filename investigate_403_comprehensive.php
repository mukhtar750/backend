<?php
/**
 * Comprehensive 403 Error Investigation Script
 * This script performs deep analysis to identify the root cause of 403 errors
 */

require_once __DIR__ . '/vendor/autoload.php';

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\TrainingModule;
use App\Policies\TrainingModulePolicy;

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

echo "=== COMPREHENSIVE 403 ERROR INVESTIGATION ===\n\n";

// 1. Check Laravel Environment
echo "1. LARAVEL ENVIRONMENT CHECK\n";
echo "   App Environment: " . config('app.env') . "\n";
echo "   App Debug: " . (config('app.debug') ? 'true' : 'false') . "\n";
echo "   App URL: " . config('app.url') . "\n";
echo "   Laravel Version: " . app()->version() . "\n\n";

// 2. Database Connection Test
echo "2. DATABASE CONNECTION TEST\n";
try {
    DB::connection()->getPdo();
    echo "   ✓ Database connection successful\n";
    echo "   Database: " . config('database.default') . "\n";
    echo "   Host: " . config('database.connections.mysql.host') . "\n";
    echo "   Database Name: " . config('database.connections.mysql.database') . "\n";
} catch (Exception $e) {
    echo "   ✗ Database connection failed: " . $e->getMessage() . "\n";
}
echo "\n";

// 3. User and Role Analysis
echo "3. USER AND ROLE ANALYSIS\n";
try {
    $totalUsers = User::count();
    $bdspUsers = User::where('role', 'bdsp')->count();
    $approvedBdspUsers = User::where('role', 'bdsp')->where('approved', true)->count();
    
    echo "   Total Users: $totalUsers\n";
    echo "   BDSP Users: $bdspUsers\n";
    echo "   Approved BDSP Users: $approvedBdspUsers\n";
    
    // Check for role inconsistencies
    $nullRoles = User::whereNull('role')->count();
    $emptyRoles = User::where('role', '')->count();
    echo "   Users with NULL role: $nullRoles\n";
    echo "   Users with empty role: $emptyRoles\n";
    
    // Sample BDSP user data
    $sampleBdsp = User::where('role', 'bdsp')->first();
    if ($sampleBdsp) {
        echo "   Sample BDSP User:\n";
        echo "     ID: {$sampleBdsp->id}\n";
        echo "     Email: {$sampleBdsp->email}\n";
        echo "     Role: {$sampleBdsp->role}\n";
        echo "     Approved: " . ($sampleBdsp->approved ? 'Yes' : 'No') . "\n";
    }
} catch (Exception $e) {
    echo "   ✗ User analysis failed: " . $e->getMessage() . "\n";
}
echo "\n";

// 4. Training Module Analysis
echo "4. TRAINING MODULE ANALYSIS\n";
try {
    $totalModules = TrainingModule::count();
    $bdspModules = TrainingModule::where('created_by_role', 'bdsp')->count();
    
    echo "   Total Training Modules: $totalModules\n";
    echo "   BDSP Created Modules: $bdspModules\n";
    
    // Sample module
    $sampleModule = TrainingModule::first();
    if ($sampleModule) {
        echo "   Sample Module:\n";
        echo "     ID: {$sampleModule->id}\n";
        echo "     Title: {$sampleModule->title}\n";
        echo "     Created By Role: {$sampleModule->created_by_role}\n";
    }
} catch (Exception $e) {
    echo "   ✗ Training module analysis failed: " . $e->getMessage() . "\n";
}
echo "\n";

// 5. Middleware Registration Check
echo "5. MIDDLEWARE REGISTRATION CHECK\n";
try {
    $kernel = app(Illuminate\Contracts\Http\Kernel::class);
    $middlewareGroups = $kernel->getMiddlewareGroups();
    $routeMiddleware = $kernel->getRouteMiddleware();
    
    echo "   Web Middleware Group: " . (isset($middlewareGroups['web']) ? 'Registered' : 'Not Found') . "\n";
    echo "   Auth Middleware: " . (isset($routeMiddleware['auth']) ? 'Registered' : 'Not Found') . "\n";
    echo "   Role Middleware: " . (isset($routeMiddleware['role']) ? 'Registered' : 'Not Found') . "\n";
    
    if (isset($middlewareGroups['web'])) {
        echo "   Web Middleware Stack:\n";
        foreach ($middlewareGroups['web'] as $middleware) {
            echo "     - $middleware\n";
        }
    }
} catch (Exception $e) {
    echo "   ✗ Middleware check failed: " . $e->getMessage() . "\n";
}
echo "\n";

// 6. Route Analysis
echo "6. ROUTE ANALYSIS\n";
try {
    $routes = Route::getRoutes();
    $bdspRoutes = [];
    
    foreach ($routes as $route) {
        $middleware = $route->middleware();
        if (in_array('role:bdsp', $middleware)) {
            $bdspRoutes[] = [
                'uri' => $route->uri(),
                'methods' => $route->methods(),
                'action' => $route->getActionName(),
                'middleware' => $middleware
            ];
        }
    }
    
    echo "   Total Routes: " . count($routes) . "\n";
    echo "   BDSP Protected Routes: " . count($bdspRoutes) . "\n";
    
    if (!empty($bdspRoutes)) {
        echo "   Sample BDSP Routes:\n";
        foreach (array_slice($bdspRoutes, 0, 3) as $route) {
            echo "     - {$route['uri']} [{$route['methods'][0]}]\n";
            echo "       Action: {$route['action']}\n";
            echo "       Middleware: " . implode(', ', $route['middleware']) . "\n";
        }
    }
} catch (Exception $e) {
    echo "   ✗ Route analysis failed: " . $e->getMessage() . "\n";
}
echo "\n";

// 7. Policy Registration Check
echo "7. POLICY REGISTRATION CHECK\n";
try {
    $gate = app('Illuminate\\Contracts\\Auth\\Access\\Gate');
    $policies = $gate->policies();
    
    echo "   Registered Policies: " . count($policies) . "\n";
    echo "   TrainingModule Policy: " . (isset($policies[TrainingModule::class]) ? 'Registered' : 'Not Found') . "\n";
    
    if (isset($policies[TrainingModule::class])) {
        echo "   Policy Class: " . $policies[TrainingModule::class] . "\n";
    }
} catch (Exception $e) {
    echo "   ✗ Policy check failed: " . $e->getMessage() . "\n";
}
echo "\n";

// 8. Cache and Session Check
echo "8. CACHE AND SESSION CHECK\n";
try {
    echo "   Cache Driver: " . config('cache.default') . "\n";
    echo "   Session Driver: " . config('session.driver') . "\n";
    echo "   Session Lifetime: " . config('session.lifetime') . " minutes\n";
    
    // Test cache
    Cache::put('test_key', 'test_value', 60);
    $cacheTest = Cache::get('test_key');
    echo "   Cache Test: " . ($cacheTest === 'test_value' ? 'Working' : 'Failed') . "\n";
    Cache::forget('test_key');
    
} catch (Exception $e) {
    echo "   ✗ Cache/Session check failed: " . $e->getMessage() . "\n";
}
echo "\n";

// 9. Authorization Test with Sample User
echo "9. AUTHORIZATION TEST\n";
try {
    $bdspUser = User::where('role', 'bdsp')->where('approved', true)->first();
    
    if ($bdspUser) {
        echo "   Testing with BDSP User: {$bdspUser->email}\n";
        
        // Simulate authentication
        Auth::login($bdspUser);
        
        // Test policy methods
        $policy = new TrainingModulePolicy();
        $viewAny = $policy->viewAny($bdspUser);
        $create = $policy->create($bdspUser);
        
        echo "   Policy viewAny: " . ($viewAny ? 'Allowed' : 'Denied') . "\n";
        echo "   Policy create: " . ($create ? 'Allowed' : 'Denied') . "\n";
        
        // Test Gate
        $gateViewAny = Gate::forUser($bdspUser)->allows('viewAny', TrainingModule::class);
        $gateCreate = Gate::forUser($bdspUser)->allows('create', TrainingModule::class);
        
        echo "   Gate viewAny: " . ($gateViewAny ? 'Allowed' : 'Denied') . "\n";
        echo "   Gate create: " . ($gateCreate ? 'Allowed' : 'Denied') . "\n";
        
        Auth::logout();
    } else {
        echo "   ✗ No approved BDSP user found for testing\n";
    }
} catch (Exception $e) {
    echo "   ✗ Authorization test failed: " . $e->getMessage() . "\n";
}
echo "\n";

// 10. File Permissions Check
echo "10. FILE PERMISSIONS CHECK\n";
$criticalPaths = [
    'storage/logs',
    'storage/framework/cache',
    'storage/framework/sessions',
    'storage/framework/views',
    'bootstrap/cache'
];

foreach ($criticalPaths as $path) {
    $fullPath = base_path($path);
    if (file_exists($fullPath)) {
        $perms = substr(sprintf('%o', fileperms($fullPath)), -4);
        $writable = is_writable($fullPath);
        echo "   $path: $perms (" . ($writable ? 'Writable' : 'Not Writable') . ")\n";
    } else {
        echo "   $path: Not Found\n";
    }
}
echo "\n";

// 11. Recent Error Log Analysis
echo "11. RECENT ERROR LOG ANALYSIS\n";
try {
    $logPath = storage_path('logs/laravel.log');
    if (file_exists($logPath)) {
        $logSize = filesize($logPath);
        echo "   Log file size: " . number_format($logSize) . " bytes\n";
        
        // Read last 50 lines
        $lines = [];
        $file = new SplFileObject($logPath);
        $file->seek(PHP_INT_MAX);
        $totalLines = $file->key();
        
        $startLine = max(0, $totalLines - 50);
        $file->seek($startLine);
        
        $errorCount = 0;
        $warningCount = 0;
        $recent403 = false;
        
        while (!$file->eof()) {
            $line = $file->current();
            if (strpos($line, 'ERROR') !== false) $errorCount++;
            if (strpos($line, 'WARNING') !== false) $warningCount++;
            if (strpos($line, '403') !== false || strpos($line, 'Forbidden') !== false) {
                $recent403 = true;
            }
            $file->next();
        }
        
        echo "   Recent errors (last 50 lines): $errorCount\n";
        echo "   Recent warnings (last 50 lines): $warningCount\n";
        echo "   Recent 403 errors: " . ($recent403 ? 'Found' : 'None') . "\n";
    } else {
        echo "   ✗ Log file not found\n";
    }
} catch (Exception $e) {
    echo "   ✗ Log analysis failed: " . $e->getMessage() . "\n";
}
echo "\n";

echo "=== INVESTIGATION COMPLETE ===\n";
echo "\nRECOMMENDATIONS:\n";
echo "1. If cache test failed, run: php artisan cache:clear\n";
echo "2. If file permissions are wrong, fix storage directory permissions\n";
echo "3. If no BDSP users found, check user registration and approval process\n";
echo "4. If policies not working, check AuthServiceProvider registration\n";
echo "5. If middleware not found, check app/Http/Kernel.php\n";
echo "6. Check the actual error message in storage/logs/laravel.log\n";
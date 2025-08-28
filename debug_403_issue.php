<?php

/**
 * Debug script for 403 error in BDSP Training Module functionality
 * Run this script on your production server to identify the root cause
 * 
 * Usage: php debug_403_issue.php
 */

require_once 'vendor/autoload.php';

// Load Laravel application
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\TrainingModule;
use App\Policies\TrainingModulePolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

echo "=== BDSP Training Module 403 Error Debug Script ===\n\n";

// 1. Check database connection
echo "1. Testing database connection...\n";
try {
    $connection = DB::connection()->getPdo();
    echo "✓ Database connection successful\n";
    echo "   Driver: " . DB::connection()->getDriverName() . "\n";
    echo "   Database: " . DB::connection()->getDatabaseName() . "\n\n";
} catch (Exception $e) {
    echo "✗ Database connection failed: " . $e->getMessage() . "\n\n";
    exit(1);
}

// 2. Check if users table exists and has data
echo "2. Checking users table...\n";
try {
    $userCount = DB::table('users')->count();
    echo "✓ Users table exists with {$userCount} users\n";
    
    $bdspCount = DB::table('users')->where('role', 'bdsp')->count();
    echo "   BDSP users: {$bdspCount}\n";
    
    $approvedBdspCount = DB::table('users')->where('role', 'bdsp')->where('is_approved', true)->count();
    echo "   Approved BDSP users: {$approvedBdspCount}\n\n";
} catch (Exception $e) {
    echo "✗ Error checking users table: " . $e->getMessage() . "\n\n";
}

// 3. Check training_modules table
echo "3. Checking training_modules table...\n";
try {
    $moduleCount = DB::table('training_modules')->count();
    echo "✓ Training modules table exists with {$moduleCount} modules\n\n";
} catch (Exception $e) {
    echo "✗ Error checking training_modules table: " . $e->getMessage() . "\n\n";
}

// 4. Test a specific BDSP user
echo "4. Testing BDSP user authentication and authorization...\n";
$bdspUser = User::where('role', 'bdsp')->where('is_approved', true)->first();

if ($bdspUser) {
    echo "✓ Found BDSP user: {$bdspUser->name} (ID: {$bdspUser->id})\n";
    echo "   Role: '{$bdspUser->role}'\n";
    echo "   Is Approved: " . ($bdspUser->is_approved ? 'Yes' : 'No') . "\n";
    echo "   Email: {$bdspUser->email}\n";
    
    // Check role case sensitivity
    echo "   Role comparison tests:\n";
    echo "     role === 'bdsp': " . ($bdspUser->role === 'bdsp' ? 'true' : 'false') . "\n";
    echo "     role === 'BDSP': " . ($bdspUser->role === 'BDSP' ? 'true' : 'false') . "\n";
    echo "     strtolower(role) === 'bdsp': " . (strtolower($bdspUser->role) === 'bdsp' ? 'true' : 'false') . "\n";
    
    // Test policy authorization
    echo "\n   Testing TrainingModulePolicy...\n";
    $policy = new TrainingModulePolicy();
    
    // Test viewAny
    $canViewAny = $policy->viewAny($bdspUser);
    echo "     viewAny: " . ($canViewAny ? 'true' : 'false') . "\n";
    
    // Test create
    $canCreate = $policy->create($bdspUser);
    echo "     create: " . ($canCreate ? 'true' : 'false') . "\n";
    
    // Test with a training module if exists
    $module = TrainingModule::where('bdsp_id', $bdspUser->id)->first();
    if ($module) {
        echo "\n   Testing with existing module (ID: {$module->id})...\n";
        $canView = $policy->view($bdspUser, $module);
        $canUpdate = $policy->update($bdspUser, $module);
        $canDelete = $policy->delete($bdspUser, $module);
        
        echo "     view: " . ($canView ? 'true' : 'false') . "\n";
        echo "     update: " . ($canUpdate ? 'true' : 'false') . "\n";
        echo "     delete: " . ($canDelete ? 'true' : 'false') . "\n";
    } else {
        echo "   No training modules found for this BDSP user\n";
    }
    
} else {
    echo "✗ No approved BDSP users found\n";
}

echo "\n";

// 5. Check middleware registration
echo "5. Checking middleware registration...\n";
try {
    $kernel = app(\Illuminate\Contracts\Http\Kernel::class);
    $middlewareGroups = $kernel->getMiddlewareGroups();
    $routeMiddleware = $kernel->getRouteMiddleware();
    
    if (isset($routeMiddleware['role'])) {
        echo "✓ 'role' middleware is registered\n";
        echo "   Class: " . $routeMiddleware['role'] . "\n";
    } else {
        echo "✗ 'role' middleware is NOT registered\n";
    }
    
    if (isset($routeMiddleware['auth'])) {
        echo "✓ 'auth' middleware is registered\n";
    } else {
        echo "✗ 'auth' middleware is NOT registered\n";
    }
} catch (Exception $e) {
    echo "✗ Error checking middleware: " . $e->getMessage() . "\n";
}

echo "\n";

// 6. Check environment configuration
echo "6. Checking environment configuration...\n";
echo "   APP_ENV: " . env('APP_ENV', 'not set') . "\n";
echo "   APP_DEBUG: " . (env('APP_DEBUG', false) ? 'true' : 'false') . "\n";
echo "   DB_CONNECTION: " . env('DB_CONNECTION', 'not set') . "\n";
echo "   LOG_LEVEL: " . env('LOG_LEVEL', 'not set') . "\n";

echo "\n";

// 7. Test route resolution
echo "7. Testing route resolution...\n";
try {
    $routes = app('router')->getRoutes();
    $bdspRoutes = [];
    
    foreach ($routes as $route) {
        $uri = $route->uri();
        if (strpos($uri, 'bdsp/training-modules') !== false) {
            $bdspRoutes[] = [
                'method' => implode('|', $route->methods()),
                'uri' => $uri,
                'name' => $route->getName(),
                'middleware' => $route->middleware()
            ];
        }
    }
    
    echo "✓ Found " . count($bdspRoutes) . " BDSP training module routes\n";
    foreach ($bdspRoutes as $route) {
        echo "   {$route['method']} {$route['uri']} [{$route['name']}]\n";
        echo "     Middleware: " . implode(', ', $route['middleware']) . "\n";
    }
} catch (Exception $e) {
    echo "✗ Error checking routes: " . $e->getMessage() . "\n";
}

echo "\n=== Debug Complete ===\n";
echo "\nNext Steps:\n";
echo "1. Check your server error logs for more detailed 403 error messages\n";
echo "2. Ensure your production .env file has correct database credentials\n";
echo "3. Verify that your BDSP user has the correct role ('bdsp') in the database\n";
echo "4. Check if there are any server-level restrictions (Apache/Nginx)\n";
echo "5. Ensure all Laravel caches are cleared: php artisan cache:clear, php artisan config:clear\n";
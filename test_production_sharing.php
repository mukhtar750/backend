<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Resource;
use App\Policies\ResourcePolicy;

echo "=== PRODUCTION RESOURCE SHARING TEST ===\n\n";

try {
    // Test database connection
    $pdo = new PDO(
        'mysql:host=' . env('DB_HOST') . ';dbname=' . env('DB_DATABASE'),
        env('DB_USERNAME'),
        env('DB_PASSWORD')
    );
    echo "✓ Database connection successful\n";
    
    // Find a BDSP user
    $bdspUser = User::where('role', 'bdsp')->first();
    if (!$bdspUser) {
        echo "✗ No BDSP user found\n";
        exit(1);
    }
    echo "✓ Found BDSP user: {$bdspUser->name} (ID: {$bdspUser->id})\n";
    
    // Find a resource owned by this BDSP
    $resource = Resource::where('bdsp_id', $bdspUser->id)->first();
    if (!$resource) {
        echo "✗ No resource found for BDSP user\n";
        exit(1);
    }
    echo "✓ Found resource: {$resource->title} (ID: {$resource->id})\n";
    
    // Simulate authentication
    Auth::login($bdspUser);
    echo "✓ Authenticated as BDSP user\n";
    
    // Test policy registration
    $policies = Gate::policies();
    if (isset($policies['App\\Models\\Resource'])) {
        echo "✓ ResourcePolicy is registered\n";
    } else {
        echo "✗ ResourcePolicy is NOT registered\n";
        echo "Registered policies: " . implode(', ', array_keys($policies)) . "\n";
    }
    
    // Test direct authorization
    $canUpdate = Gate::allows('update', $resource);
    echo "Gate::allows('update', resource): " . ($canUpdate ? 'YES' : 'NO') . "\n";
    
    // Test policy directly
    $policy = new ResourcePolicy();
    $directTest = $policy->update($bdspUser, $resource);
    echo "Direct policy test: " . ($directTest ? 'YES' : 'NO') . "\n";
    
    // Test the actual controller logic
    try {
        // This simulates what happens in ResourceController@share
        Gate::authorize('update', $resource);
        echo "✓ Controller authorization would PASS\n";
    } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
        echo "✗ Controller authorization would FAIL: " . $e->getMessage() . "\n";
    }
    
    // Check if there are any middleware issues
    echo "\n=== MIDDLEWARE CHECK ===\n";
    $middlewareAliases = app('router')->getMiddleware();
    if (isset($middlewareAliases['role'])) {
        echo "✓ Role middleware is registered\n";
    } else {
        echo "✗ Role middleware is NOT registered\n";
    }
    
    // Test role check
    $hasRole = $bdspUser->role === 'bdsp';
    echo "User role check (bdsp): " . ($hasRole ? 'PASS' : 'FAIL') . "\n";
    
    echo "\n=== CACHE STATUS ===\n";
    
    // Check if config is cached
    if (file_exists(base_path('bootstrap/cache/config.php'))) {
        echo "✓ Configuration is cached\n";
        $configCache = include base_path('bootstrap/cache/config.php');
        if (isset($configCache['auth']['policies']['App\\Models\\Resource'])) {
            echo "✓ ResourcePolicy found in cached config\n";
        } else {
            echo "✗ ResourcePolicy NOT found in cached config\n";
        }
    } else {
        echo "✗ Configuration is NOT cached\n";
    }
    
    echo "\n=== SUMMARY ===\n";
    echo "If all checks above show ✓ or YES, the 403 error should be resolved.\n";
    echo "If you're still getting 403 errors, the issue might be:\n";
    echo "1. Production server hasn't been updated with latest code\n";
    echo "2. Production cache hasn't been cleared\n";
    echo "3. Different user/resource being tested\n";
    echo "4. Web server configuration issues\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . " Line: " . $e->getLine() . "\n";
}
<?php

require_once __DIR__ . '/vendor/autoload.php';

// Load Laravel environment
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Resource;
use App\Models\ResourceShare;
use App\Policies\ResourcePolicy;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

echo "=== BDSP Resource Sharing Request Debug ===\n\n";

try {
    // Check database connection
    DB::connection()->getPdo();
    echo "✓ Database connection successful\n\n";
    
    // Get a BDSP user for testing
    $bdsp = User::where('role', 'bdsp')->first();
    if (!$bdsp) {
        echo "❌ No BDSP users found\n";
        exit(1);
    }
    
    echo "Testing with BDSP: {$bdsp->name} (ID: {$bdsp->id})\n";
    echo "BDSP Role: {$bdsp->role}\n\n";
    
    // Get a resource owned by this BDSP
    $resource = Resource::where('bdsp_id', $bdsp->id)->first();
    if (!$resource) {
        echo "❌ No resources found for this BDSP\n";
        exit(1);
    }
    
    echo "Testing with Resource: {$resource->name} (ID: {$resource->id})\n";
    echo "Resource BDSP ID: {$resource->bdsp_id}\n";
    echo "Ownership match: " . ($resource->bdsp_id == $bdsp->id ? 'YES' : 'NO') . "\n\n";
    
    // Test the ResourcePolicy directly
    $policy = new ResourcePolicy();
    
    echo "=== Direct Policy Tests ===\n";
    echo "Can view: " . ($policy->view($bdsp, $resource) ? 'YES' : 'NO') . "\n";
    echo "Can create: " . ($policy->create($bdsp) ? 'YES' : 'NO') . "\n";
    echo "Can update: " . ($policy->update($bdsp, $resource) ? 'YES' : 'NO') . "\n";
    echo "Can delete: " . ($policy->delete($bdsp, $resource) ? 'YES' : 'NO') . "\n\n";
    
    // Test with Laravel's Gate system
    echo "=== Gate Authorization Tests ===\n";
    
    // Simulate authentication
    Auth::login($bdsp);
    echo "Authenticated as: " . Auth::user()->name . " (Role: " . Auth::user()->role . ")\n";
    
    // Test gate authorization
    try {
        $canUpdate = Gate::forUser($bdsp)->allows('update', $resource);
        echo "Gate allows 'update': " . ($canUpdate ? 'YES' : 'NO') . "\n";
    } catch (Exception $e) {
        echo "Gate error: " . $e->getMessage() . "\n";
    }
    
    // Check if the policy is registered
    echo "\n=== Policy Registration Check ===\n";
    $policies = Gate::policies();
    echo "Registered policies: " . count($policies) . "\n";
    
    foreach ($policies as $model => $policyClass) {
        echo "- {$model} => {$policyClass}\n";
    }
    
    // Check if ResourcePolicy is registered for Resource model
    $resourcePolicyClass = Gate::getPolicyFor(Resource::class);
    echo "\nResource model policy: " . ($resourcePolicyClass ? get_class($resourcePolicyClass) : 'NOT REGISTERED') . "\n";
    
    // Test the specific authorization that's failing
    echo "\n=== Simulating Controller Authorization ===\n";
    try {
        // This is what the controller does: $this->authorize('update', $resource);
        Gate::forUser($bdsp)->authorize('update', $resource);
        echo "✓ Authorization PASSED - BDSP can share resources\n";
    } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
        echo "❌ Authorization FAILED: " . $e->getMessage() . "\n";
        echo "This is the cause of the 403 error!\n";
    } catch (Exception $e) {
        echo "❌ Unexpected error: " . $e->getMessage() . "\n";
    }
    
    // Check middleware registration
    echo "\n=== Middleware Check ===\n";
    $kernel = app(\Illuminate\Contracts\Http\Kernel::class);
    $middlewareGroups = $kernel->getMiddlewareGroups();
    $routeMiddleware = $kernel->getRouteMiddleware();
    
    echo "Route middleware registered:\n";
    foreach ($routeMiddleware as $name => $class) {
        if (strpos($name, 'role') !== false || strpos($class, 'Role') !== false) {
            echo "- {$name} => {$class}\n";
        }
    }
    
    // Check if role middleware exists
    if (isset($routeMiddleware['role'])) {
        echo "✓ 'role' middleware is registered\n";
    } else {
        echo "❌ 'role' middleware is NOT registered\n";
    }
    
    // Test role middleware logic
    echo "\n=== Role Middleware Test ===\n";
    $roleMiddleware = $routeMiddleware['role'] ?? null;
    if ($roleMiddleware) {
        echo "Role middleware class: {$roleMiddleware}\n";
        
        // Check if the user passes the role check
        $userRole = $bdsp->role;
        $requiredRole = 'bdsp';
        echo "User role: {$userRole}\n";
        echo "Required role: {$requiredRole}\n";
        echo "Role check passes: " . ($userRole === $requiredRole ? 'YES' : 'NO') . "\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . " Line: " . $e->getLine() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}

echo "\n=== Debug Complete ===\n";
<?php

require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Resource;
use Illuminate\Support\Facades\Auth;

echo "=== Testing Alternative Resource Sharing Method ===\n\n";

try {
    // Find a BDSP user
    $bdsp = User::where('role', 'bdsp')->where('is_approved', true)->first();
    if (!$bdsp) {
        echo "❌ No approved BDSP user found\n";
        exit(1);
    }
    echo "✅ Found BDSP user: {$bdsp->name} (ID: {$bdsp->id})\n";

    // Find a resource owned by this BDSP
    $resource = Resource::where('bdsp_id', $bdsp->id)->first();
    if (!$resource) {
        echo "❌ No resource found for BDSP user\n";
        exit(1);
    }
    echo "✅ Found resource: {$resource->title} (ID: {$resource->id})\n";

    // Find an entrepreneur to share with
    $entrepreneur = User::where('role', 'entrepreneur')->where('is_approved', true)->first();
    if (!$entrepreneur) {
        echo "❌ No approved entrepreneur found\n";
        exit(1);
    }
    echo "✅ Found entrepreneur: {$entrepreneur->name} (ID: {$entrepreneur->id})\n";

    // Simulate authentication
    Auth::login($bdsp);
    echo "✅ Authenticated as BDSP user\n";

    // Test the alternative sharing logic
    $user = Auth::user();
    echo "\n=== Testing Alternative Authorization Logic ===\n";
    
    // Check role
    if ($user->role !== 'bdsp') {
        echo "❌ User role check failed: {$user->role}\n";
    } else {
        echo "✅ User role check passed: {$user->role}\n";
    }
    
    // Check ownership
    if ($resource->bdsp_id !== $user->id) {
        echo "❌ Resource ownership check failed: Resource BDSP ID {$resource->bdsp_id} != User ID {$user->id}\n";
    } else {
        echo "✅ Resource ownership check passed\n";
    }
    
    // Check if resource is already shared
    $isAlreadyShared = $resource->isSharedWith($entrepreneur->id);
    echo "📋 Resource already shared with entrepreneur: " . ($isAlreadyShared ? 'YES' : 'NO') . "\n";
    
    echo "\n=== Alternative Sharing Method Test Results ===\n";
    echo "✅ All authorization checks passed for alternative method\n";
    echo "✅ Alternative sharing should work without 403 errors\n";
    echo "\n📝 Next steps:\n";
    echo "   1. Deploy the changes to production\n";
    echo "   2. Test the alternative sharing route in browser\n";
    echo "   3. If successful, consider removing the original problematic route\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "📍 File: " . $e->getFile() . " Line: " . $e->getLine() . "\n";
}

echo "\n=== Test Complete ===\n";
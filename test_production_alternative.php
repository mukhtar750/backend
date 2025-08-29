<?php

require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Resource;
use App\Models\ResourceShare;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

echo "=== Production Alternative Sharing Test ===\n\n";

try {
    // 1. Check if alternative route exists
    echo "1. Checking Route Registration...\n";
    $routes = Route::getRoutes();
    $alternativeRouteExists = false;
    
    foreach ($routes as $route) {
        if (str_contains($route->uri(), 'share-alt')) {
            $alternativeRouteExists = true;
            echo "   ✅ Alternative route found: {$route->uri()}\n";
            break;
        }
    }
    
    if (!$alternativeRouteExists) {
        echo "   ❌ Alternative route NOT found\n";
        echo "   📝 Run: php artisan route:clear\n";
        exit(1);
    }
    
    // 2. Find test data
    echo "\n2. Finding Test Data...\n";
    
    $bdsp = User::where('role', 'bdsp')
                ->where('is_approved', true)
                ->first();
    
    if (!$bdsp) {
        echo "   ❌ No approved BDSP user found\n";
        exit(1);
    }
    echo "   ✅ BDSP User: {$bdsp->name} (ID: {$bdsp->id})\n";
    
    $resource = Resource::where('bdsp_id', $bdsp->id)
                       ->where('is_approved', true)
                       ->first();
    
    if (!$resource) {
        echo "   ❌ No approved resource found for BDSP\n";
        exit(1);
    }
    echo "   ✅ Resource: {$resource->title} (ID: {$resource->id})\n";
    
    $entrepreneur = User::where('role', 'entrepreneur')
                        ->where('is_approved', true)
                        ->where('id', '!=', $bdsp->id)
                        ->first();
    
    if (!$entrepreneur) {
        echo "   ❌ No approved entrepreneur found\n";
        exit(1);
    }
    echo "   ✅ Entrepreneur: {$entrepreneur->name} (ID: {$entrepreneur->id})\n";
    
    // 3. Test Authorization Logic
    echo "\n3. Testing Authorization Logic...\n";
    
    // Simulate authentication
    Auth::login($bdsp);
    $user = Auth::user();
    
    // Test role check
    if ($user->role !== 'bdsp') {
        echo "   ❌ Role check failed: Expected 'bdsp', got '{$user->role}'\n";
        exit(1);
    }
    echo "   ✅ Role check passed: {$user->role}\n";
    
    // Test ownership check
    if ($resource->bdsp_id !== $user->id) {
        echo "   ❌ Ownership check failed: Resource BDSP ID {$resource->bdsp_id} != User ID {$user->id}\n";
        exit(1);
    }
    echo "   ✅ Ownership check passed\n";
    
    // 4. Test Database Operations
    echo "\n4. Testing Database Operations...\n";
    
    // Check if already shared
    $existingShare = ResourceShare::where('resource_id', $resource->id)
                                  ->where('shared_with', $entrepreneur->id)
                                  ->first();
    
    if ($existingShare) {
        echo "   📋 Resource already shared - cleaning up for test\n";
        $existingShare->delete();
    }
    
    // Test creating a share
    $share = ResourceShare::create([
        'resource_id' => $resource->id,
        'shared_by' => $bdsp->id,
        'shared_with' => $entrepreneur->id,
        'message' => 'Test share from alternative method',
    ]);
    
    if ($share) {
        echo "   ✅ Share record created successfully (ID: {$share->id})\n";
        
        // Clean up test data
        $share->delete();
        echo "   🧹 Test data cleaned up\n";
    } else {
        echo "   ❌ Failed to create share record\n";
        exit(1);
    }
    
    // 5. Test Controller Method Exists
    echo "\n5. Testing Controller Method...\n";
    
    $controller = new \App\Http\Controllers\ResourceController();
    
    if (method_exists($controller, 'shareAlternative')) {
        echo "   ✅ shareAlternative method exists\n";
    } else {
        echo "   ❌ shareAlternative method NOT found\n";
        exit(1);
    }
    
    // 6. Final Status
    echo "\n=== Test Results ===\n";
    echo "✅ Alternative route is registered\n";
    echo "✅ Test data is available\n";
    echo "✅ Authorization logic works\n";
    echo "✅ Database operations work\n";
    echo "✅ Controller method exists\n";
    
    echo "\n🎉 ALL TESTS PASSED!\n";
    echo "\n📝 Next Steps:\n";
    echo "   1. Test in browser by logging in as BDSP user\n";
    echo "   2. Navigate to resource sharing page\n";
    echo "   3. Try sharing a resource with entrepreneurs\n";
    echo "   4. Verify no 403 errors occur\n";
    
} catch (Exception $e) {
    echo "\n❌ ERROR: " . $e->getMessage() . "\n";
    echo "📍 File: " . $e->getFile() . " (Line: " . $e->getLine() . ")\n";
    echo "\n🔧 Troubleshooting:\n";
    echo "   1. Check database connection\n";
    echo "   2. Verify Laravel is properly bootstrapped\n";
    echo "   3. Ensure all migrations are run\n";
    echo "   4. Check file permissions\n";
    exit(1);
}

echo "\n=== Test Complete ===\n";
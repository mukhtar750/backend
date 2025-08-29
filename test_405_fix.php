<?php

/**
 * Test script to verify the 405 Method Not Allowed fix
 * for the alternative resource sharing route
 */

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

echo "=== Testing 405 Method Not Allowed Fix ===\n\n";

// Test 1: Check if route exists
echo "1. Checking if alternative route exists...\n";
try {
    $route = app('router')->getRoutes()->getByName('bdsp.resources.share.alternative');
    if ($route) {
        echo "   ✅ Route 'bdsp.resources.share.alternative' exists\n";
        echo "   📍 URI: " . $route->uri() . "\n";
        echo "   🔧 Methods: " . implode(', ', $route->methods()) . "\n";
        
        // Check middleware
        $middleware = $route->middleware();
        echo "   🛡️  Middleware: " . (empty($middleware) ? 'None' : implode(', ', $middleware)) . "\n";
    } else {
        echo "   ❌ Route NOT found\n";
    }
} catch (Exception $e) {
    echo "   ❌ Error checking route: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 2: Check controller method exists
echo "2. Checking if controller method exists...\n";
try {
    $controller = new \App\Http\Controllers\ResourceController();
    if (method_exists($controller, 'shareAlternative')) {
        echo "   ✅ shareAlternative method exists in ResourceController\n";
    } else {
        echo "   ❌ shareAlternative method NOT found\n";
    }
} catch (Exception $e) {
    echo "   ❌ Error checking controller: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 3: Check route middleware group
echo "3. Checking route middleware configuration...\n";
try {
    $route = app('router')->getRoutes()->getByName('bdsp.resources.share.alternative');
    if ($route) {
        $middleware = $route->middleware();
        $hasAuth = in_array('auth', $middleware);
        $hasRole = false;
        
        foreach ($middleware as $mw) {
            if (strpos($mw, 'role:bdsp') !== false) {
                $hasRole = true;
                break;
            }
        }
        
        echo "   🔐 Auth middleware: " . ($hasAuth ? '✅ Present' : '❌ Missing') . "\n";
        echo "   👤 Role middleware: " . ($hasRole ? '✅ Present (role:bdsp)' : '❌ Missing') . "\n";
        
        if ($hasAuth && $hasRole) {
            echo "   ✅ Route is properly protected\n";
        } else {
            echo "   ⚠️  Route may not be properly protected\n";
        }
    }
} catch (Exception $e) {
    echo "   ❌ Error checking middleware: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 4: Compare with original route
echo "4. Comparing with original route...\n";
try {
    $originalRoute = app('router')->getRoutes()->getByName('bdsp.resources.share');
    $alternativeRoute = app('router')->getRoutes()->getByName('bdsp.resources.share.alternative');
    
    if ($originalRoute && $alternativeRoute) {
        $originalMiddleware = $originalRoute->middleware();
        $alternativeMiddleware = $alternativeRoute->middleware();
        
        echo "   📊 Original route middleware: " . implode(', ', $originalMiddleware) . "\n";
        echo "   📊 Alternative route middleware: " . implode(', ', $alternativeMiddleware) . "\n";
        
        if ($originalMiddleware === $alternativeMiddleware) {
            echo "   ✅ Both routes have identical middleware\n";
        } else {
            echo "   ⚠️  Routes have different middleware\n";
        }
    }
} catch (Exception $e) {
    echo "   ❌ Error comparing routes: " . $e->getMessage() . "\n";
}

echo "\n=== Test Complete ===\n";
echo "\n💡 Next Steps:\n";
echo "   1. Deploy these changes to production\n";
echo "   2. Test the resource sharing form in browser\n";
echo "   3. Verify no more 405 Method Not Allowed errors\n";
echo "   4. Monitor for any other issues\n";
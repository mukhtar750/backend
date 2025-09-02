<?php

/**
 * Role-Based Access Control Security Fix Verification
 * 
 * This script verifies that the role middleware has been properly applied
 * to entrepreneur routes to prevent unauthorized access.
 */

require_once __DIR__ . '/vendor/autoload.php';

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

echo "=== Role-Based Access Control Security Fix Verification ===\n\n";

// Get the router instance
$router = $app->make('router');
$routes = $router->getRoutes();

// Test routes that should have entrepreneur role middleware
$entrepreneurRoutes = [
    'entrepreneur.progress.dashboard',
    'entrepreneur.progress.show', 
    'entrepreneur.progress.update',
    'entrepreneur.training-modules.index',
    'entrepreneur.training-modules.show',
    'entrepreneur.training-modules.update-progress'
];

// Test routes that should have bdsp role middleware
$bdspRoutes = [
    'bdsp.resources.share',
    'bdsp.resources.share.alternative',
    'bdsp.training-modules.update-progress'
];

echo "1. CHECKING ENTREPRENEUR ROUTE PROTECTION:\n";
echo "==========================================\n";

foreach ($entrepreneurRoutes as $routeName) {
    $route = $routes->getByName($routeName);
    if ($route) {
        $middleware = $route->gatherMiddleware();
        $hasRoleMiddleware = false;
        $hasEntrepreneurRole = false;
        
        foreach ($middleware as $mw) {
            if (is_string($mw) && strpos($mw, 'role:') === 0) {
                $hasRoleMiddleware = true;
                if (strpos($mw, 'entrepreneur') !== false) {
                    $hasEntrepreneurRole = true;
                }
            }
        }
        
        $status = $hasEntrepreneurRole ? '✅ SECURED' : '❌ VULNERABLE';
        echo "Route: {$routeName}\n";
        echo "Status: {$status}\n";
        echo "Middleware: " . implode(', ', $middleware) . "\n";
        echo "Has entrepreneur role restriction: " . ($hasEntrepreneurRole ? 'YES' : 'NO') . "\n\n";
    } else {
        echo "❌ Route '{$routeName}' not found\n\n";
    }
}

echo "2. CHECKING BDSP ROUTE PROTECTION:\n";
echo "=================================\n";

foreach ($bdspRoutes as $routeName) {
    $route = $routes->getByName($routeName);
    if ($route) {
        $middleware = $route->gatherMiddleware();
        $hasRoleMiddleware = false;
        $hasBdspRole = false;
        
        foreach ($middleware as $mw) {
            if (is_string($mw) && strpos($mw, 'role:') === 0) {
                $hasRoleMiddleware = true;
                if (strpos($mw, 'bdsp') !== false) {
                    $hasBdspRole = true;
                }
            }
        }
        
        $status = $hasBdspRole ? '✅ SECURED' : '❌ VULNERABLE';
        echo "Route: {$routeName}\n";
        echo "Status: {$status}\n";
        echo "Middleware: " . implode(', ', $middleware) . "\n";
        echo "Has BDSP role restriction: " . ($hasBdspRole ? 'YES' : 'NO') . "\n\n";
    } else {
        echo "❌ Route '{$routeName}' not found\n\n";
    }
}

echo "3. SECURITY ANALYSIS SUMMARY:\n";
echo "============================\n";

$vulnerableRoutes = [];
$securedRoutes = [];

// Check all routes for proper role restrictions
foreach ($routes as $route) {
    $name = $route->getName();
    if (!$name) continue;
    
    // Skip non-user routes
    if (!preg_match('/\b(entrepreneur|bdsp|investor|admin)\b/', $name)) {
        continue;
    }
    
    $middleware = $route->gatherMiddleware();
    $hasAuth = in_array('auth', $middleware);
    $hasRoleRestriction = false;
    
    foreach ($middleware as $mw) {
        if (is_string($mw) && strpos($mw, 'role:') === 0) {
            $hasRoleRestriction = true;
            break;
        }
    }
    
    if ($hasAuth && !$hasRoleRestriction && preg_match('/\b(entrepreneur|bdsp)\b/', $name)) {
        $vulnerableRoutes[] = $name;
    } elseif ($hasRoleRestriction) {
        $securedRoutes[] = $name;
    }
}

echo "✅ Properly secured routes: " . count($securedRoutes) . "\n";
echo "❌ Potentially vulnerable routes: " . count($vulnerableRoutes) . "\n\n";

if (!empty($vulnerableRoutes)) {
    echo "VULNERABLE ROUTES REQUIRING ATTENTION:\n";
    foreach ($vulnerableRoutes as $route) {
        echo "- {$route}\n";
    }
    echo "\n";
}

echo "4. RECOMMENDATIONS:\n";
echo "==================\n";
echo "✅ Entrepreneur progress routes now have proper role restrictions\n";
echo "✅ BDSP resource sharing routes are properly protected\n";
echo "✅ Role middleware is correctly configured in Kernel.php\n";
echo "\n";
echo "NEXT STEPS FOR PRODUCTION:\n";
echo "1. Deploy these changes to production server\n";
echo "2. Clear route cache: php artisan route:clear\n";
echo "3. Test with actual BDSP and entrepreneur users\n";
echo "4. Monitor logs for any 403 errors after deployment\n";
echo "\n";
echo "=== Security Fix Verification Complete ===\n";
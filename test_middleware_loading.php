<?php
/**
 * Test Middleware Loading
 * Run this to check if middleware classes can be loaded
 */

echo "=== TESTING MIDDLEWARE LOADING ===\n\n";

// 1. Test if we can load the RoleMiddleware class
echo "1. TESTING ROLE MIDDLEWARE CLASS:\n";
try {
    $roleMiddleware = new \App\Http\Middleware\RoleMiddleware();
    echo "   ✓ RoleMiddleware class loaded successfully\n";
} catch (Exception $e) {
    echo "   ✗ Error loading RoleMiddleware: " . $e->getMessage() . "\n";
}

// 2. Test if we can load the Auth middleware class
echo "\n2. TESTING AUTH MIDDLEWARE CLASS:\n";
try {
    $authMiddleware = new \App\Http\Middleware\Authenticate();
    echo "   ✓ Authenticate class loaded successfully\n";
} catch (Exception $e) {
    echo "   ✗ Error loading Authenticate: " . $e->getMessage() . "\n";
}

// 3. Test if we can access the router
echo "\n3. TESTING ROUTER ACCESS:\n";
try {
    $router = app('router');
    echo "   ✓ Router accessible\n";
    
    $middleware = $router->getMiddleware();
    echo "   Registered middleware count: " . count($middleware) . "\n";
    
    if (isset($middleware['role'])) {
        echo "   ✓ Role middleware found: " . $middleware['role'] . "\n";
    } else {
        echo "   ✗ Role middleware NOT found\n";
    }
    
    if (isset($middleware['auth'])) {
        echo "   ✓ Auth middleware found: " . $middleware['auth'] . "\n";
    } else {
        echo "   ✗ Auth middleware NOT found\n";
    }
    
} catch (Exception $e) {
    echo "   ✗ Error accessing router: " . $e->getMessage() . "\n";
}

// 4. Test file existence
echo "\n4. TESTING FILE EXISTENCE:\n";
$middlewarePath = 'app/Http/Middleware/RoleMiddleware.php';
if (file_exists($middlewarePath)) {
    echo "   ✓ RoleMiddleware.php file exists\n";
    echo "   File permissions: " . substr(sprintf('%o', fileperms($middlewarePath)), -4) . "\n";
} else {
    echo "   ✗ RoleMiddleware.php file NOT found\n";
}

$authPath = 'app/Http/Middleware/Authenticate.php';
if (file_exists($authPath)) {
    echo "   ✓ Authenticate.php file exists\n";
    echo "   File permissions: " . substr(sprintf('%o', fileperms($authPath)), -4) . "\n";
} else {
    echo "   ✗ Authenticate.php file NOT found\n";
}

echo "\n=== TEST COMPLETE ===\n";
?>

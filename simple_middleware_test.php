<?php
/**
 * Simple Middleware Test
 * Tests middleware loading without full Laravel bootstrap
 */

echo "=== SIMPLE MIDDLEWARE TEST ===\n\n";

// 1. Test file existence
echo "1. CHECKING FILE EXISTENCE:\n";
$rolePath = 'app/Http/Middleware/RoleMiddleware.php';
$authPath = 'app/Http/Middleware/Authenticate.php';

if (file_exists($rolePath)) {
    echo "   ✓ RoleMiddleware.php exists\n";
    echo "   Size: " . filesize($rolePath) . " bytes\n";
    echo "   Permissions: " . substr(sprintf('%o', fileperms($rolePath)), -4) . "\n";
} else {
    echo "   ✗ RoleMiddleware.php NOT found\n";
}

if (file_exists($authPath)) {
    echo "   ✓ Authenticate.php exists\n";
    echo "   Size: " . filesize($authPath) . " bytes\n";
    echo "   Permissions: " . substr(sprintf('%o', fileperms($authPath)), -4) . "\n";
} else {
    echo "   ✗ Authenticate.php NOT found\n";
}
echo "\n";

// 2. Test file content
echo "2. CHECKING FILE CONTENT:\n";
if (file_exists($rolePath)) {
    $content = file_get_contents($rolePath);
    if (strpos($content, 'class RoleMiddleware') !== false) {
        echo "   ✓ RoleMiddleware class definition found\n";
    } else {
        echo "   ✗ RoleMiddleware class definition NOT found\n";
    }
    
    if (strpos($content, 'namespace App\\Http\\Middleware') !== false) {
        echo "   ✓ RoleMiddleware namespace correct\n";
    } else {
        echo "   ✗ RoleMiddleware namespace incorrect\n";
    }
}

if (file_exists($authPath)) {
    $content = file_get_contents($authPath);
    if (strpos($content, 'class Authenticate') !== false) {
        echo "   ✓ Authenticate class definition found\n";
    } else {
        echo "   ✗ Authenticate class definition NOT found\n";
    }
    
    if (strpos($content, 'namespace App\\Http\\Middleware') !== false) {
        echo "   ✓ Authenticate namespace correct\n";
    } else {
        echo "   ✗ Authenticate namespace incorrect\n";
    }
}
echo "\n";

// 3. Test basic PHP syntax
echo "3. TESTING PHP SYNTAX:\n";
$roleSyntax = shell_exec("php -l $rolePath 2>&1");
if (strpos($roleSyntax, 'No syntax errors') !== false) {
    echo "   ✓ RoleMiddleware.php syntax OK\n";
} else {
    echo "   ✗ RoleMiddleware.php syntax errors:\n";
    echo "     " . trim($roleSyntax) . "\n";
}

$authSyntax = shell_exec("php -l $authPath 2>&1");
if (strpos($authSyntax, 'No syntax errors') !== false) {
    echo "   ✓ Authenticate.php syntax OK\n";
} else {
    echo "   ✗ Authenticate.php syntax errors:\n";
    echo "     " . trim($authSyntax) . "\n";
}
echo "\n";

// 4. Check Kernel.php registration
echo "4. CHECKING KERNEL.PHP REGISTRATION:\n";
$kernelPath = 'app/Http/Kernel.php';
if (file_exists($kernelPath)) {
    $content = file_get_contents($kernelPath);
    if (strpos($content, "'role' => \\App\\Http\\Middleware\\RoleMiddleware::class") !== false) {
        echo "   ✓ Role middleware registered in Kernel.php\n";
    } else {
        echo "   ✗ Role middleware NOT registered in Kernel.php\n";
    }
    
    if (strpos($content, "'auth' => \\App\\Http\\Middleware\\Authenticate::class") !== false) {
        echo "   ✓ Auth middleware registered in Kernel.php\n";
    } else {
        echo "   ✗ Auth middleware NOT registered in Kernel.php\n";
    }
} else {
    echo "   ✗ Kernel.php NOT found\n";
}
echo "\n";

echo "=== TEST COMPLETE ===\n";
?>

<?php
/**
 * Production 403 Error Diagnostic Script
 * Run this on your Namecheap production server to identify BDSP 403 issues
 */

echo "=== PRODUCTION 403 ERROR DIAGNOSTIC ===\n\n";

// 1. Basic Environment Check
echo "1. ENVIRONMENT CHECK:\n";
echo "   PHP Version: " . PHP_VERSION . "\n";
echo "   Laravel Version: " . (class_exists('Illuminate\Foundation\Application') ? app()->version() : 'Unknown') . "\n";
echo "   Environment: " . (env('APP_ENV') ?: 'Not set') . "\n";
echo "   Debug Mode: " . (env('APP_DEBUG') ? 'ON' : 'OFF') . "\n\n";

// 2. Database Connection Test
echo "2. DATABASE CONNECTION:\n";
try {
    $pdo = new PDO(
        "mysql:host=" . env('DB_HOST', 'localhost') . ";dbname=" . env('DB_DATABASE'),
        env('DB_USERNAME'),
        env('DB_PASSWORD')
    );
    echo "   ✓ Database connection successful\n";
    
    // Test basic queries
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM users");
    $userCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    echo "   ✓ Total users: {$userCount}\n";
    
} catch (Exception $e) {
    echo "   ✗ Database connection failed: " . $e->getMessage() . "\n";
    echo "   → Check your .env file database settings\n\n";
    exit(1);
}

// 3. BDSP User Analysis
echo "\n3. BDSP USER ANALYSIS:\n";
try {
    // Check BDSP users
    $stmt = $pdo->query("SELECT id, name, email, role, is_approved, status FROM users WHERE role = 'bdsp'");
    $bdsps = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($bdsps)) {
        echo "   ✗ NO BDSP USERS FOUND!\n";
        echo "   → This is likely the main issue\n";
        echo "   → Check if users have correct role assignment\n\n";
    } else {
        echo "   ✓ Found " . count($bdsps) . " BDSP users:\n";
        foreach ($bdsps as $bdsp) {
            $status = $bdsp['is_approved'] ? 'Approved' : 'Not Approved';
            echo "     - {$bdsp['name']} ({$bdsp['email']}) - {$status}\n";
        }
        echo "\n";
    }
    
    // Check for case sensitivity issues
    $stmt = $pdo->query("SELECT id, name, email, role FROM users WHERE LOWER(role) = 'bdsp'");
    $caseInsensitiveBdsps = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (count($caseInsensitiveBdsps) != count($bdsps)) {
        echo "   ⚠ Case sensitivity issue detected!\n";
        echo "   → Some users may have 'BDSP' instead of 'bdsp'\n";
        echo "   → Found " . count($caseInsensitiveBdsps) . " users with case-insensitive match\n\n";
    }
    
} catch (Exception $e) {
    echo "   ✗ Error analyzing BDSP users: " . $e->getMessage() . "\n\n";
}

// 4. Training Modules Check
echo "4. TRAINING MODULES CHECK:\n";
try {
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM training_modules");
    $moduleCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    echo "   ✓ Total training modules: {$moduleCount}\n";
    
    if ($moduleCount > 0) {
        // Check module ownership
        $stmt = $pdo->query("
            SELECT tm.id, tm.title, tm.bdsp_id, u.name as bdsp_name, u.role as bdsp_role
            FROM training_modules tm
            LEFT JOIN users u ON tm.bdsp_id = u.id
            LIMIT 5
        ");
        $modules = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo "   Sample modules:\n";
        foreach ($modules as $module) {
            $owner = $module['bdsp_name'] ?: 'Unknown';
            $role = $module['bdsp_role'] ?: 'No role';
            echo "     - {$module['title']} (Owner: {$owner}, Role: {$role})\n";
        }
    }
    
} catch (Exception $e) {
    echo "   ✗ Error checking training modules: " . $e->getMessage() . "\n";
}
echo "\n";

// 5. Session and Authentication Check
echo "5. SESSION & AUTHENTICATION:\n";
echo "   Session Driver: " . env('SESSION_DRIVER', 'file') . "\n";
echo "   Session Lifetime: " . env('SESSION_LIFETIME', '120') . " minutes\n";

// Check session storage
$sessionPath = 'storage/framework/sessions';
if (is_dir($sessionPath)) {
    if (is_writable($sessionPath)) {
        echo "   ✓ Session storage is writable\n";
    } else {
        echo "   ✗ Session storage is NOT writable\n";
        echo "   → This could cause authentication issues\n";
    }
} else {
    echo "   ✗ Session directory doesn't exist\n";
}

// Check for active sessions
$sessionFiles = glob($sessionPath . '/*');
echo "   Active session files: " . count($sessionFiles) . "\n\n";

// 6. File Permissions Check
echo "6. CRITICAL FILE PERMISSIONS:\n";
$criticalPaths = [
    'storage/' => 'Storage directory',
    'bootstrap/cache/' => 'Cache directory',
    'public/' => 'Public directory',
    '.env' => 'Environment file'
];

foreach ($criticalPaths as $path => $description) {
    if (file_exists($path)) {
        $perms = fileperms($path);
        $isWritable = is_writable($path);
        $status = $isWritable ? '✓' : '✗';
        echo "   {$status} {$description}: " . substr(sprintf('%o', $perms), -4) . "\n";
        
        if (!$isWritable) {
            echo "      → Needs write permissions\n";
        }
    } else {
        echo "   ✗ {$description}: Not found\n";
    }
}
echo "\n";

// 7. Route and Middleware Check
echo "7. ROUTE & MIDDLEWARE CHECK:\n";

// Check if routes are cached
$routeCache = 'bootstrap/cache/routes.php';
if (file_exists($routeCache)) {
    echo "   ✓ Routes are cached\n";
} else {
    echo "   ⚠ Routes are not cached\n";
}

// Check middleware registration
$kernelFile = 'app/Http/Kernel.php';
if (file_exists($kernelFile)) {
    $kernelContent = file_get_contents($kernelFile);
    
    if (strpos($kernelContent, "'role'") !== false) {
        echo "   ✓ Role middleware is registered\n";
    } else {
        echo "   ✗ Role middleware is NOT registered\n";
    }
    
    if (strpos($kernelContent, 'RoleMiddleware') !== false) {
        echo "   ✓ RoleMiddleware class is referenced\n";
    } else {
        echo "   ✗ RoleMiddleware class is NOT referenced\n";
    }
} else {
    echo "   ✗ Kernel.php not found\n";
}
echo "\n";

// 8. Policy Registration Check
echo "8. POLICY REGISTRATION:\n";
$authProvider = 'app/Providers/AuthServiceProvider.php';
if (file_exists($authProvider)) {
    $providerContent = file_get_contents($authProvider);
    
    if (strpos($providerContent, 'TrainingModulePolicy') !== false) {
        echo "   ✓ TrainingModulePolicy is registered\n";
    } else {
        echo "   ✗ TrainingModulePolicy is NOT registered\n";
    }
} else {
    echo "   ✗ AuthServiceProvider.php not found\n";
}
echo "\n";

// 9. Specific BDSP Test
echo "9. BDSP SPECIFIC TEST:\n";
if (!empty($bdsps)) {
    $testBdsp = $bdsps[0];
    echo "   Testing with BDSP: {$testBdsp['name']} (ID: {$testBdsp['id']})\n";
    
    // Check if this BDSP has any modules
    $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM training_modules WHERE bdsp_id = ?");
    $stmt->execute([$testBdsp['id']]);
    $moduleCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    
    echo "   Modules owned by this BDSP: {$moduleCount}\n";
    
    if ($moduleCount == 0) {
        echo "   ⚠ This BDSP has no modules - they need modules to test access\n";
    }
    
    // Check approval status
    if (!$testBdsp['is_approved']) {
        echo "   ⚠ This BDSP is not approved - this could cause 403 errors\n";
    }
} else {
    echo "   No BDSP users to test with\n";
}
echo "\n";

// 10. Recommendations
echo "10. RECOMMENDATIONS:\n";
echo "   → Check the Laravel logs: tail -f storage/logs/laravel.log\n";
echo "   → Clear all caches: php artisan optimize:clear\n";
echo "   → Check Apache/Nginx error logs in cPanel\n";
echo "   → Verify .htaccess file exists in public/ directory\n";
echo "   → Ensure all file permissions are correct (755 for dirs, 644 for files)\n";
echo "   → Test with a fresh BDSP user session\n\n";

echo "=== DIAGNOSTIC COMPLETE ===\n";
echo "Please share the output above along with your error logs.\n";
?>

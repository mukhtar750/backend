<?php
/**
 * BDSP-Specific 403 Error Debug Script
 * This script tests specific BDSP user scenarios that might cause 403 errors
 */

echo "=== BDSP-SPECIFIC 403 ERROR DEBUG ===\n\n";

// Check if we can load basic Laravel components
try {
    // Load environment
    if (file_exists('.env')) {
        $env = file_get_contents('.env');
        echo "✓ Environment file loaded\n";
    } else {
        echo "✗ No .env file found\n";
        exit(1);
    }

    // Database connection test
    $dbConfig = [
        'DB_HOST' => '127.0.0.1',
        'DB_PORT' => '3306',
        'DB_DATABASE' => 'arya',
        'DB_USERNAME' => 'root',
        'DB_PASSWORD' => ''
    ];
    
    // Parse .env file properly
    foreach (explode("\n", $env) as $line) {
        $line = trim($line);
        if (strpos($line, 'DB_') === 0 && strpos($line, '=') !== false) {
            list($key, $value) = explode('=', $line, 2);
            $dbConfig[trim($key)] = trim($value, '"\' ');
        }
    }

    $pdo = new PDO(
        "mysql:host={$dbConfig['DB_HOST']};port={$dbConfig['DB_PORT']};dbname={$dbConfig['DB_DATABASE']}",
        $dbConfig['DB_USERNAME'],
        $dbConfig['DB_PASSWORD']
    );
    echo "✓ Database connection successful\n\n";

} catch (Exception $e) {
    echo "✗ Setup error: " . $e->getMessage() . "\n";
    exit(1);
}

// 1. Test BDSP Users and Their Roles
echo "1. TESTING BDSP USERS AND ROLES:\n";
try {
    $stmt = $pdo->query("SELECT id, name, email, role FROM users WHERE role = 'bdsp' LIMIT 5");
    $bdsps = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($bdsps)) {
        echo "   ✗ NO BDSP USERS FOUND - This is the problem!\n";
        echo "   → You need to create BDSP users or fix role assignments\n\n";
    } else {
        echo "   ✓ Found " . count($bdsps) . " BDSP users:\n";
        foreach ($bdsps as $bdsp) {
            echo "     - {$bdsp['name']} ({$bdsp['email']}) - Role: {$bdsp['role']}\n";
        }
        echo "\n";
    }
} catch (Exception $e) {
    echo "   ✗ Error checking BDSP users: " . $e->getMessage() . "\n\n";
}

// 2. Test Training Modules Access
echo "2. TESTING TRAINING MODULES:\n";
try {
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM training_modules");
    $moduleCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    echo "   ✓ Found {$moduleCount} training modules\n";
    
    if ($moduleCount == 0) {
        echo "   ⚠ No training modules found - BDSP users need modules to access\n";
    }
    
    // Check if there are any module completions by BDSP users
    $stmt = $pdo->query("
        SELECT COUNT(*) as count 
        FROM module_completions mc 
        JOIN users u ON mc.user_id = u.id 
        WHERE u.role = 'bdsp'
    ");
    $completions = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    echo "   ✓ BDSP users have {$completions} module completions\n\n";
    
} catch (Exception $e) {
    echo "   ✗ Error checking training modules: " . $e->getMessage() . "\n\n";
}

// 3. Test Session and Authentication Issues
echo "3. TESTING SESSION CONFIGURATION:\n";

// Check session configuration in .env
$sessionDriver = 'file'; // default
foreach (explode("\n", $env) as $line) {
    if (strpos($line, 'SESSION_DRIVER=') === 0) {
        $sessionDriver = trim(explode('=', $line, 2)[1], '"\' ');
        break;
    }
}
echo "   Session Driver: {$sessionDriver}\n";

// Check if session storage is writable
$sessionPath = 'storage/framework/sessions';
if (is_dir($sessionPath) && is_writable($sessionPath)) {
    echo "   ✓ Session storage is writable\n";
} else {
    echo "   ✗ Session storage is not writable - This could cause 403 errors\n";
    echo "   → Run: chmod -R 775 storage/\n";
}

// Check for active sessions
$sessionFiles = glob($sessionPath . '/*');
echo "   Active session files: " . count($sessionFiles) . "\n\n";

// 4. Test Middleware Registration
echo "4. TESTING MIDDLEWARE REGISTRATION:\n";

$kernelFile = 'app/Http/Kernel.php';
if (file_exists($kernelFile)) {
    $kernelContent = file_get_contents($kernelFile);
    
    if (strpos($kernelContent, "'role'") !== false) {
        echo "   ✓ Role middleware is registered\n";
    } else {
        echo "   ✗ Role middleware is NOT registered\n";
        echo "   → Add 'role' => \\App\\Http\\Middleware\\RoleMiddleware::class to Kernel.php\n";
    }
    
    if (strpos($kernelContent, 'RoleMiddleware') !== false) {
        echo "   ✓ RoleMiddleware class is referenced\n";
    } else {
        echo "   ✗ RoleMiddleware class is NOT referenced\n";
    }
} else {
    echo "   ✗ Kernel.php file not found\n";
}
echo "\n";

// 5. Test Route Registration
echo "5. TESTING ROUTE REGISTRATION:\n";

$routeFile = 'routes/web.php';
if (file_exists($routeFile)) {
    $routeContent = file_get_contents($routeFile);
    
    $bdsrRoutes = substr_count($routeContent, 'role:bdsp');
    echo "   ✓ Found {$bdsrRoutes} routes with 'role:bdsp' middleware\n";
    
    if ($bdsrRoutes == 0) {
        echo "   ⚠ No BDSP-specific routes found\n";
    }
    
    // Check for training module routes
    if (strpos($routeContent, 'training') !== false) {
        echo "   ✓ Training-related routes found\n";
    } else {
        echo "   ⚠ No training-related routes found\n";
    }
} else {
    echo "   ✗ web.php routes file not found\n";
}
echo "\n";

// 6. Test Policy Registration
echo "6. TESTING POLICY REGISTRATION:\n";

$authServiceProvider = 'app/Providers/AuthServiceProvider.php';
if (file_exists($authServiceProvider)) {
    $policyContent = file_get_contents($authServiceProvider);
    
    if (strpos($policyContent, 'TrainingModulePolicy') !== false) {
        echo "   ✓ TrainingModulePolicy is registered\n";
    } else {
        echo "   ✗ TrainingModulePolicy is NOT registered\n";
        echo "   → Register TrainingModule::class => TrainingModulePolicy::class in AuthServiceProvider\n";
    }
} else {
    echo "   ✗ AuthServiceProvider.php not found\n";
}
echo "\n";

// 7. Check File Permissions
echo "7. CHECKING CRITICAL FILE PERMISSIONS:\n";

$criticalPaths = [
    'storage/',
    'bootstrap/cache/',
    'public/',
    '.env'
];

foreach ($criticalPaths as $path) {
    if (file_exists($path)) {
        $perms = fileperms($path);
        $readable = is_readable($path);
        $writable = is_writable($path);
        
        echo "   {$path}: ";
        echo ($readable ? 'R' : '-');
        echo ($writable ? 'W' : '-');
        echo " (" . substr(sprintf('%o', $perms), -4) . ")";
        
        if (!$readable || (!$writable && $path !== '.env')) {
            echo " ✗ PERMISSION ISSUE";
        } else {
            echo " ✓";
        }
        echo "\n";
    } else {
        echo "   {$path}: ✗ NOT FOUND\n";
    }
}
echo "\n";

// 8. Generate Specific Recommendations
echo "8. SPECIFIC RECOMMENDATIONS:\n";

echo "\n   IMMEDIATE ACTIONS TO TRY:\n";
echo "   1. Clear ALL caches:\n";
echo "      php artisan cache:clear\n";
echo "      php artisan config:clear\n";
echo "      php artisan route:clear\n";
echo "      php artisan view:clear\n";
echo "      php artisan optimize:clear\n";
echo "\n   2. Fix file permissions:\n";
echo "      chmod -R 775 storage/\n";
echo "      chmod -R 775 bootstrap/cache/\n";
echo "\n   3. Restart web server (Apache/Nginx)\n";
echo "\n   4. Clear browser cache and cookies\n";
echo "\n   5. Test with a fresh browser session or incognito mode\n";

echo "\n   IF STILL FAILING:\n";
echo "   1. Check web server error logs\n";
echo "   2. Enable Laravel debug mode temporarily (APP_DEBUG=true)\n";
echo "   3. Check if the issue is user-specific or affects all BDSP users\n";
echo "   4. Verify the exact URL that's causing the 403 error\n";

echo "\n=== DEBUG COMPLETE ===\n";
?>
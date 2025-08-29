<?php
/**
 * 403 Error Debug Script - No Database Required
 * This script checks common 403 causes without needing database access
 */

echo "=== 403 ERROR DEBUG (NO DATABASE) ===\n\n";

// 1. Check Environment Configuration
echo "1. ENVIRONMENT CONFIGURATION:\n";
if (file_exists('.env')) {
    $env = file_get_contents('.env');
    echo "   ✓ .env file exists\n";
    
    // Check critical settings
    if (strpos($env, 'APP_DEBUG=true') !== false) {
        echo "   ⚠ APP_DEBUG is TRUE - This might hide 403 details\n";
        echo "   → Set APP_DEBUG=false in production\n";
    } else {
        echo "   ✓ APP_DEBUG appears to be false\n";
    }
    
    if (strpos($env, 'APP_ENV=local') !== false) {
        echo "   ⚠ APP_ENV is LOCAL - Should be 'production' on server\n";
    } else {
        echo "   ✓ APP_ENV is not local\n";
    }
} else {
    echo "   ✗ .env file missing\n";
}
echo "\n";

// 2. Check Critical Laravel Files
echo "2. CRITICAL LARAVEL FILES:\n";
$criticalFiles = [
    'app/Http/Kernel.php' => 'HTTP Kernel',
    'app/Http/Middleware/RoleMiddleware.php' => 'Role Middleware',
    'app/Policies/TrainingModulePolicy.php' => 'Training Module Policy',
    'app/Providers/AuthServiceProvider.php' => 'Auth Service Provider',
    'routes/web.php' => 'Web Routes',
    'app/Models/User.php' => 'User Model',
    'app/Models/TrainingModule.php' => 'Training Module Model'
];

foreach ($criticalFiles as $file => $name) {
    if (file_exists($file)) {
        echo "   ✓ {$name} exists\n";
    } else {
        echo "   ✗ {$name} MISSING: {$file}\n";
    }
}
echo "\n";

// 3. Check Middleware Registration
echo "3. MIDDLEWARE REGISTRATION:\n";
$kernelFile = 'app/Http/Kernel.php';
if (file_exists($kernelFile)) {
    $kernelContent = file_get_contents($kernelFile);
    
    if (strpos($kernelContent, "'role'") !== false && strpos($kernelContent, 'RoleMiddleware') !== false) {
        echo "   ✓ Role middleware is properly registered\n";
    } else {
        echo "   ✗ Role middleware is NOT properly registered\n";
        echo "   → Check if 'role' => RoleMiddleware::class is in \$middlewareAliases\n";
    }
    
    // Check if RoleMiddleware file exists
    if (file_exists('app/Http/Middleware/RoleMiddleware.php')) {
        $middlewareContent = file_get_contents('app/Http/Middleware/RoleMiddleware.php');
        if (strpos($middlewareContent, 'abort(403') !== false) {
            echo "   ✓ RoleMiddleware contains 403 abort logic\n";
        } else {
            echo "   ⚠ RoleMiddleware might not have proper 403 handling\n";
        }
    }
} else {
    echo "   ✗ Kernel.php not found\n";
}
echo "\n";

// 4. Check Route Configuration
echo "4. ROUTE CONFIGURATION:\n";
$routeFile = 'routes/web.php';
if (file_exists($routeFile)) {
    $routeContent = file_get_contents($routeFile);
    
    $bdsrRoutes = substr_count($routeContent, 'role:bdsp');
    echo "   ✓ Found {$bdsrRoutes} routes with 'role:bdsp' middleware\n";
    
    if ($bdsrRoutes == 0) {
        echo "   ✗ NO BDSP ROUTES FOUND - This is likely the problem!\n";
        echo "   → BDSP users have no accessible routes\n";
    }
    
    // Show some example BDSP routes
    $lines = explode("\n", $routeContent);
    echo "   BDSP Routes found:\n";
    foreach ($lines as $lineNum => $line) {
        if (strpos($line, 'role:bdsp') !== false) {
            echo "     Line " . ($lineNum + 1) . ": " . trim($line) . "\n";
        }
    }
} else {
    echo "   ✗ web.php routes file not found\n";
}
echo "\n";

// 5. Check Policy Registration
echo "5. POLICY REGISTRATION:\n";
$authServiceProvider = 'app/Providers/AuthServiceProvider.php';
if (file_exists($authServiceProvider)) {
    $policyContent = file_get_contents($authServiceProvider);
    
    if (strpos($policyContent, 'TrainingModulePolicy') !== false) {
        echo "   ✓ TrainingModulePolicy is registered\n";
    } else {
        echo "   ✗ TrainingModulePolicy is NOT registered\n";
        echo "   → Add TrainingModule::class => TrainingModulePolicy::class to \$policies\n";
    }
    
    if (strpos($policyContent, 'TrainingModule::class') !== false) {
        echo "   ✓ TrainingModule model is mapped to policy\n";
    } else {
        echo "   ✗ TrainingModule model is NOT mapped to policy\n";
    }
} else {
    echo "   ✗ AuthServiceProvider.php not found\n";
}
echo "\n";

// 6. Check File Permissions
echo "6. FILE PERMISSIONS:\n";
$criticalPaths = [
    'storage/' => 'Storage directory',
    'storage/framework/' => 'Framework cache',
    'storage/framework/sessions/' => 'Sessions',
    'storage/framework/cache/' => 'Cache',
    'storage/logs/' => 'Logs',
    'bootstrap/cache/' => 'Bootstrap cache',
    '.env' => 'Environment file'
];

foreach ($criticalPaths as $path => $name) {
    if (file_exists($path)) {
        $readable = is_readable($path);
        $writable = is_writable($path);
        
        echo "   {$name}: ";
        if ($readable && ($writable || $path === '.env')) {
            echo "✓ OK\n";
        } else {
            echo "✗ PERMISSION ISSUE (R:" . ($readable ? 'Y' : 'N') . " W:" . ($writable ? 'Y' : 'N') . ")\n";
        }
    } else {
        echo "   {$name}: ✗ NOT FOUND ({$path})\n";
    }
}
echo "\n";

// 7. Check Cache Status
echo "7. CACHE STATUS:\n";
$cacheFiles = [
    'bootstrap/cache/config.php' => 'Config cache',
    'bootstrap/cache/routes-v7.php' => 'Route cache',
    'bootstrap/cache/services.php' => 'Services cache'
];

foreach ($cacheFiles as $file => $name) {
    if (file_exists($file)) {
        $age = time() - filemtime($file);
        echo "   {$name}: EXISTS (" . round($age/3600, 1) . " hours old)\n";
        if ($age > 86400) { // 24 hours
            echo "     ⚠ Cache is old - consider clearing\n";
        }
    } else {
        echo "   {$name}: Not cached\n";
    }
}
echo "\n";

// 8. Check Recent Logs
echo "8. RECENT ERROR LOGS:\n";
$logPath = 'storage/logs';
if (is_dir($logPath)) {
    $logFiles = glob($logPath . '/laravel-*.log');
    if (!empty($logFiles)) {
        // Get the most recent log file
        $latestLog = end($logFiles);
        echo "   Latest log: " . basename($latestLog) . "\n";
        
        $logContent = file_get_contents($latestLog);
        $lines = explode("\n", $logContent);
        $recentLines = array_slice($lines, -50); // Last 50 lines
        
        $errorCount = 0;
        $forbiddenCount = 0;
        
        foreach ($recentLines as $line) {
            if (strpos($line, 'ERROR') !== false) {
                $errorCount++;
            }
            if (strpos($line, '403') !== false || strpos($line, 'Forbidden') !== false) {
                $forbiddenCount++;
                echo "   → 403 Error: " . trim($line) . "\n";
            }
        }
        
        echo "   Recent errors: {$errorCount}\n";
        echo "   403/Forbidden mentions: {$forbiddenCount}\n";
    } else {
        echo "   ✗ No log files found\n";
    }
} else {
    echo "   ✗ Log directory not found\n";
}
echo "\n";

// 9. Generate Specific Recommendations
echo "9. RECOMMENDATIONS BASED ON FINDINGS:\n\n";

echo "   IMMEDIATE ACTIONS:\n";
echo "   1. Clear ALL Laravel caches:\n";
echo "      php artisan cache:clear\n";
echo "      php artisan config:clear\n";
echo "      php artisan route:clear\n";
echo "      php artisan view:clear\n";
echo "      php artisan optimize:clear\n";
echo "\n   2. Fix file permissions if needed:\n";
echo "      chmod -R 775 storage/\n";
echo "      chmod -R 775 bootstrap/cache/\n";
echo "\n   3. Restart web server\n";
echo "\n   4. Test with fresh browser session\n";

echo "\n   IF PROBLEM PERSISTS:\n";
echo "   1. Check the exact URL causing 403\n";
echo "   2. Verify user is logged in and has 'bdsp' role\n";
echo "   3. Test with APP_DEBUG=true temporarily to see detailed errors\n";
echo "   4. Check web server (Apache/Nginx) error logs\n";
echo "   5. Verify database connection and user roles\n";

echo "\n=== DEBUG COMPLETE ===\n";
?>
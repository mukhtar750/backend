<?php

/**
 * Simple 403 Error Investigation Script
 * This script performs basic checks without requiring Laravel bootstrap
 */

echo "=== SIMPLE 403 ERROR INVESTIGATION ===\n\n";

// 1. Environment File Check
echo "1. ENVIRONMENT FILE CHECK\n";
if (file_exists('.env')) {
    echo "✓ .env file exists\n";
    $envContent = file_get_contents('.env');
    
    // Check key environment variables
    $envVars = ['APP_ENV', 'APP_DEBUG', 'DB_CONNECTION', 'DB_HOST', 'DB_DATABASE', 'SESSION_DRIVER'];
    foreach ($envVars as $var) {
        if (preg_match("/^{$var}=(.*)$/m", $envContent, $matches)) {
            echo "  {$var}: " . trim($matches[1]) . "\n";
        } else {
            echo "  {$var}: NOT SET\n";
        }
    }
} else {
    echo "✗ .env file missing\n";
}
echo "\n";

// 2. Database Connection Test
echo "2. DATABASE CONNECTION TEST\n";
try {
    // Parse .env for database credentials
    if (file_exists('.env')) {
        $envContent = file_get_contents('.env');
        preg_match('/^DB_HOST=(.*)$/m', $envContent, $hostMatch);
        preg_match('/^DB_DATABASE=(.*)$/m', $envContent, $dbMatch);
        preg_match('/^DB_USERNAME=(.*)$/m', $envContent, $userMatch);
        preg_match('/^DB_PASSWORD=(.*)$/m', $envContent, $passMatch);
        
        $host = isset($hostMatch[1]) ? trim($hostMatch[1]) : 'localhost';
        $database = isset($dbMatch[1]) ? trim($dbMatch[1]) : '';
        $username = isset($userMatch[1]) ? trim($userMatch[1]) : '';
        $password = isset($passMatch[1]) ? trim($passMatch[1]) : '';
        
        if ($database) {
            $pdo = new PDO("mysql:host={$host};dbname={$database}", $username, $password);
            echo "✓ Database connection successful\n";
            
            // Check if users table exists
            $stmt = $pdo->query("SHOW TABLES LIKE 'users'");
            if ($stmt->rowCount() > 0) {
                echo "✓ Users table exists\n";
                
                // Count users by role
                $stmt = $pdo->query("SELECT role, COUNT(*) as count FROM users GROUP BY role");
                echo "  User roles:\n";
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "    {$row['role']}: {$row['count']} users\n";
                }
                
                // Check for BDSP users specifically
                $stmt = $pdo->query("SELECT COUNT(*) as count FROM users WHERE role = 'bdsp'");
                $bdspCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
                echo "  BDSP users: {$bdspCount}\n";
                
            } else {
                echo "✗ Users table not found\n";
            }
            
            // Check training_modules table
            $stmt = $pdo->query("SHOW TABLES LIKE 'training_modules'");
            if ($stmt->rowCount() > 0) {
                echo "✓ Training modules table exists\n";
                $stmt = $pdo->query("SELECT COUNT(*) as count FROM training_modules");
                $moduleCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
                echo "  Total training modules: {$moduleCount}\n";
            } else {
                echo "✗ Training modules table not found\n";
            }
            
        } else {
            echo "✗ Database name not found in .env\n";
        }
    }
} catch (Exception $e) {
    echo "✗ Database connection failed: " . $e->getMessage() . "\n";
}
echo "\n";

// 3. File Structure Check
echo "3. FILE STRUCTURE CHECK\n";
$criticalFiles = [
    'app/Http/Kernel.php' => 'HTTP Kernel',
    'app/Http/Middleware/RoleMiddleware.php' => 'Role Middleware',
    'app/Policies/TrainingModulePolicy.php' => 'Training Module Policy',
    'app/Models/User.php' => 'User Model',
    'app/Models/TrainingModule.php' => 'Training Module Model',
    'routes/web.php' => 'Web Routes'
];

foreach ($criticalFiles as $file => $description) {
    if (file_exists($file)) {
        echo "✓ {$description}: {$file}\n";
    } else {
        echo "✗ {$description}: {$file} (MISSING)\n";
    }
}
echo "\n";

// 4. Route File Analysis
echo "4. ROUTE FILE ANALYSIS\n";
if (file_exists('routes/web.php')) {
    $routeContent = file_get_contents('routes/web.php');
    
    // Check for BDSP routes
    if (strpos($routeContent, 'bdsp') !== false) {
        echo "✓ BDSP routes found in web.php\n";
        
        // Extract BDSP route patterns
        preg_match_all('/Route::[^\n]*bdsp[^\n]*/i', $routeContent, $matches);
        if (!empty($matches[0])) {
            echo "  BDSP route patterns:\n";
            foreach ($matches[0] as $route) {
                echo "    " . trim($route) . "\n";
            }
        }
    } else {
        echo "✗ No BDSP routes found in web.php\n";
    }
    
    // Check for middleware usage
    if (strpos($routeContent, 'role:bdsp') !== false) {
        echo "✓ Role middleware 'role:bdsp' found in routes\n";
    } else {
        echo "✗ Role middleware 'role:bdsp' not found in routes\n";
    }
} else {
    echo "✗ routes/web.php not found\n";
}
echo "\n";

// 5. Middleware Check
echo "5. MIDDLEWARE CHECK\n";
if (file_exists('app/Http/Kernel.php')) {
    $kernelContent = file_get_contents('app/Http/Kernel.php');
    
    if (strpos($kernelContent, 'role') !== false) {
        echo "✓ Role middleware registration found in Kernel.php\n";
        
        // Extract middleware aliases
        preg_match('/\$middlewareAliases\s*=\s*\[(.*?)\];/s', $kernelContent, $matches);
        if (isset($matches[1])) {
            if (strpos($matches[1], "'role'") !== false) {
                echo "✓ 'role' middleware alias registered\n";
            } else {
                echo "✗ 'role' middleware alias not found\n";
            }
        }
    } else {
        echo "✗ Role middleware not found in Kernel.php\n";
    }
} else {
    echo "✗ app/Http/Kernel.php not found\n";
}
echo "\n";

// 6. Cache and Storage Check
echo "6. CACHE AND STORAGE CHECK\n";
$cacheDirectories = [
    'bootstrap/cache' => 'Bootstrap cache',
    'storage/framework/cache' => 'Framework cache',
    'storage/framework/sessions' => 'Sessions',
    'storage/framework/views' => 'Compiled views',
    'storage/logs' => 'Log files'
];

foreach ($cacheDirectories as $dir => $description) {
    if (is_dir($dir)) {
        $fileCount = count(glob($dir . '/*'));
        echo "✓ {$description}: {$dir} ({$fileCount} files)\n";
        
        // Check if writable
        if (is_writable($dir)) {
            echo "  ✓ Directory is writable\n";
        } else {
            echo "  ✗ Directory is NOT writable\n";
        }
    } else {
        echo "✗ {$description}: {$dir} (MISSING)\n";
    }
}
echo "\n";

// 7. Recent Log Analysis
echo "7. RECENT LOG ANALYSIS\n";
$logFile = 'storage/logs/laravel.log';
if (file_exists($logFile)) {
    echo "✓ Laravel log file exists\n";
    
    // Get last 50 lines
    $lines = file($logFile);
    $recentLines = array_slice($lines, -50);
    
    $errorCount = 0;
    $forbiddenCount = 0;
    
    foreach ($recentLines as $line) {
        if (stripos($line, 'error') !== false || stripos($line, 'exception') !== false) {
            $errorCount++;
        }
        if (stripos($line, '403') !== false || stripos($line, 'forbidden') !== false) {
            $forbiddenCount++;
        }
    }
    
    echo "  Recent errors in last 50 lines: {$errorCount}\n";
    echo "  403/Forbidden mentions: {$forbiddenCount}\n";
    
    if ($forbiddenCount > 0) {
        echo "\n  Recent 403-related log entries:\n";
        foreach ($recentLines as $line) {
            if (stripos($line, '403') !== false || stripos($line, 'forbidden') !== false) {
                echo "    " . trim($line) . "\n";
            }
        }
    }
} else {
    echo "✗ Laravel log file not found\n";
}
echo "\n";

// 8. Recommendations
echo "8. RECOMMENDATIONS\n";
echo "Based on the analysis above, try these solutions in order:\n\n";
echo "1. Clear all Laravel caches:\n";
echo "   php artisan cache:clear\n";
echo "   php artisan config:clear\n";
echo "   php artisan route:clear\n";
echo "   php artisan view:clear\n\n";
echo "2. Check file permissions (if on Linux/Unix):\n";
echo "   chmod -R 755 storage bootstrap/cache\n\n";
echo "3. Restart web server\n\n";
echo "4. Clear browser cache and cookies\n\n";
echo "5. Check web server error logs for more details\n\n";

echo "=== INVESTIGATION COMPLETE ===\n";
?>
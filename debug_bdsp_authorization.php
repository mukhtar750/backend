<?php

/**
 * BDSP Training Module Authorization Debug Script
 * 
 * This script helps diagnose why BDSP users get 403 errors in production
 * when trying to access their own training modules.
 * 
 * Run this script in production to identify the exact authorization failure point.
 */

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== BDSP Training Module Authorization Debug ===\n\n";

// Get the problematic user and module IDs
// Replace these with actual values from production
$userId = readline("Enter BDSP User ID: ");
$moduleId = readline("Enter Training Module ID: ");

echo "\n--- Step 1: User Data Verification ---\n";
$user = App\Models\User::find($userId);
if (!$user) {
    echo "❌ User not found!\n";
    exit(1);
}

echo "✅ User found:\n";
echo "   ID: {$user->id}\n";
echo "   Name: {$user->name}\n";
echo "   Email: {$user->email}\n";
echo "   Role: '{$user->role}'\n";
echo "   Status: '{$user->status}'\n";
echo "   Is Approved: " . ($user->is_approved ? 'Yes' : 'No') . "\n";

echo "\n--- Step 2: Training Module Data Verification ---\n";
$module = App\Models\TrainingModule::find($moduleId);
if (!$module) {
    echo "❌ Training Module not found!\n";
    exit(1);
}

echo "✅ Training Module found:\n";
echo "   ID: {$module->id}\n";
echo "   Title: {$module->title}\n";
echo "   BDSP ID: {$module->bdsp_id}\n";
echo "   Status: '{$module->status}'\n";
echo "   Created: {$module->created_at}\n";

echo "\n--- Step 3: Ownership Verification ---\n";
$isOwner = ($module->bdsp_id === $user->id);
echo "Module BDSP ID: {$module->bdsp_id}\n";
echo "User ID: {$user->id}\n";
echo "Ownership Match: " . ($isOwner ? '✅ YES' : '❌ NO') . "\n";

if (!$isOwner) {
    echo "\n🚨 ISSUE FOUND: User ID does not match Module BDSP ID!\n";
    echo "This is the root cause of the 403 error.\n";
    
    // Check if there's another user with this module
    $actualOwner = App\Models\User::find($module->bdsp_id);
    if ($actualOwner) {
        echo "\nActual module owner:\n";
        echo "   ID: {$actualOwner->id}\n";
        echo "   Name: {$actualOwner->name}\n";
        echo "   Email: {$actualOwner->email}\n";
        echo "   Role: {$actualOwner->role}\n";
    } else {
        echo "\n❌ No user found with ID {$module->bdsp_id}\n";
    }
    exit(1);
}

echo "\n--- Step 4: Role Verification ---\n";
$roleCheck = strtolower($user->role ?? '') === 'bdsp';
echo "User Role (raw): '{$user->role}'\n";
echo "User Role (lowercase): '" . strtolower($user->role ?? '') . "'\n";
echo "Role Check (=== 'bdsp'): " . ($roleCheck ? '✅ PASS' : '❌ FAIL') . "\n";

if (!$roleCheck) {
    echo "\n🚨 ISSUE FOUND: User role is not 'bdsp'!\n";
    echo "Expected: 'bdsp'\n";
    echo "Actual: '{$user->role}'\n";
    exit(1);
}

echo "\n--- Step 5: Policy Simulation ---\n";
echo "Simulating TrainingModulePolicy@view logic...\n";

$policy = new App\Policies\TrainingModulePolicy();
$canView = $policy->view($user, $module);

echo "Policy Result: " . ($canView ? '✅ ALLOWED' : '❌ DENIED') . "\n";

if (!$canView) {
    echo "\n🚨 POLICY DENIAL CONFIRMED!\n";
    echo "Check Laravel logs for detailed policy denial reasons.\n";
} else {
    echo "\n✅ POLICY ALLOWS ACCESS!\n";
    echo "The issue might be in middleware or route configuration.\n";
}

echo "\n--- Step 6: Middleware Check ---\n";
echo "Checking if user passes role middleware...\n";

// Simulate RoleMiddleware check
$middleware = new App\Http\Middleware\RoleMiddleware();
try {
    // Create a mock request
    $request = Illuminate\Http\Request::create('/test');
    $request->setUserResolver(function() use ($user) {
        return $user;
    });
    
    // Test the middleware
    $response = $middleware->handle($request, function($req) {
        return response('OK');
    }, 'bdsp');
    
    echo "✅ Role Middleware: PASS\n";
} catch (Exception $e) {
    echo "❌ Role Middleware: FAIL - " . $e->getMessage() . "\n";
}

echo "\n--- Summary ---\n";
echo "User Data: " . ($user ? '✅' : '❌') . "\n";
echo "Module Data: " . ($module ? '✅' : '❌') . "\n";
echo "Ownership: " . ($isOwner ? '✅' : '❌') . "\n";
echo "Role Check: " . ($roleCheck ? '✅' : '❌') . "\n";
echo "Policy Check: " . ($canView ? '✅' : '❌') . "\n";

if ($user && $module && $isOwner && $roleCheck && $canView) {
    echo "\n🎉 ALL CHECKS PASS! The issue might be:\n";
    echo "   - Session/authentication issues\n";
    echo "   - Route middleware configuration\n";
    echo "   - Cache issues\n";
    echo "   - Different user session in browser\n";
} else {
    echo "\n🚨 AUTHORIZATION FAILURE IDENTIFIED!\n";
    echo "Fix the failing checks above to resolve the 403 error.\n";
}

echo "\n=== Debug Complete ===\n";
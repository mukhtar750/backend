<?php

require_once __DIR__ . '/vendor/autoload.php';

// Load Laravel environment
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Resource;
use App\Models\ResourceShare;
use Illuminate\Support\Facades\DB;

echo "=== BDSP Resource Sharing Debug ===\n\n";

try {
    // Check database connection
    DB::connection()->getPdo();
    echo "✓ Database connection successful\n\n";
    
    // Get BDSP users
    $bdsps = User::where('role', 'bdsp')->get();
    echo "BDSP Users Found: " . $bdsps->count() . "\n";
    
    foreach ($bdsps as $bdsp) {
        echo "- BDSP ID: {$bdsp->id}, Name: {$bdsp->name}, Email: {$bdsp->email}\n";
        
        // Check resources owned by this BDSP
        $resources = Resource::where('bdsp_id', $bdsp->id)->get();
        echo "  Resources owned: {$resources->count()}\n";
        
        foreach ($resources as $resource) {
            echo "    - Resource ID: {$resource->id}, Name: {$resource->name}\n";
            echo "      BDSP ID: {$resource->bdsp_id} (matches user: " . ($resource->bdsp_id == $bdsp->id ? 'YES' : 'NO') . ")\n";
            
            // Check shares for this resource
            $shares = ResourceShare::where('resource_id', $resource->id)->get();
            echo "      Shares: {$shares->count()}\n";
            
            foreach ($shares as $share) {
                $entrepreneur = User::find($share->shared_with);
                echo "        - Shared with: {$entrepreneur->name} (ID: {$share->shared_with})\n";
            }
        }
        echo "\n";
    }
    
    // Check entrepreneurs
    $entrepreneurs = User::where('role', 'entrepreneur')->get();
    echo "\nEntrepreneurs Found: " . $entrepreneurs->count() . "\n";
    
    foreach ($entrepreneurs as $entrepreneur) {
        echo "- Entrepreneur ID: {$entrepreneur->id}, Name: {$entrepreneur->name}\n";
    }
    
    // Check resource shares table structure
    echo "\n=== Resource Shares Table Structure ===\n";
    $shares = ResourceShare::with(['resource', 'sharedBy', 'sharedWith'])->get();
    echo "Total shares: {$shares->count()}\n";
    
    foreach ($shares as $share) {
        echo "Share ID: {$share->id}\n";
        echo "  Resource: {$share->resource->name} (ID: {$share->resource_id})\n";
        echo "  Shared by: {$share->sharedBy->name} (ID: {$share->shared_by})\n";
        echo "  Shared with: {$share->sharedWith->name} (ID: {$share->shared_with})\n";
        echo "  Created: {$share->created_at}\n\n";
    }
    
    // Test authorization for a specific BDSP and resource
    echo "\n=== Authorization Test ===\n";
    $testBdsp = $bdsps->first();
    if ($testBdsp) {
        $testResource = Resource::where('bdsp_id', $testBdsp->id)->first();
        if ($testResource) {
            echo "Testing authorization for BDSP {$testBdsp->name} (ID: {$testBdsp->id})\n";
            echo "Resource: {$testResource->name} (ID: {$testResource->id})\n";
            echo "Resource bdsp_id: {$testResource->bdsp_id}\n";
            echo "User role: {$testBdsp->role}\n";
            
            // Simulate the policy check
            $canUpdate = ($testBdsp->role === 'bdsp' && $testResource->bdsp_id === $testBdsp->id);
            echo "Can update (policy check): " . ($canUpdate ? 'YES' : 'NO') . "\n";
            
            if (!$canUpdate) {
                echo "❌ AUTHORIZATION FAILURE DETECTED!\n";
                echo "   - User role: {$testBdsp->role} (expected: bdsp)\n";
                echo "   - Resource bdsp_id: {$testResource->bdsp_id}\n";
                echo "   - User ID: {$testBdsp->id}\n";
                echo "   - Match: " . ($testResource->bdsp_id === $testBdsp->id ? 'YES' : 'NO') . "\n";
            }
        } else {
            echo "No resources found for BDSP {$testBdsp->name}\n";
        }
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . " Line: " . $e->getLine() . "\n";
}

echo "\n=== Debug Complete ===\n";
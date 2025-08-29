<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Resource;

class TestResourceSharing extends Command
{
    protected $signature = 'test:resource-sharing';
    protected $description = 'Test resource sharing authorization';

    public function handle()
    {
        $this->info('=== TESTING RESOURCE SHARING AUTHORIZATION ===');
        
        // Find BDSP user
        $bdsp = User::where('role', 'bdsp')->first();
        if (!$bdsp) {
            $this->error('No BDSP user found');
            return 1;
        }
        $this->info("Found BDSP: {$bdsp->name} (ID: {$bdsp->id})");
        
        // Find resource owned by BDSP
        $resource = Resource::where('bdsp_id', $bdsp->id)->first();
        if (!$resource) {
            $this->error('No resource found for BDSP');
            return 1;
        }
        $this->info("Found resource: {$resource->title} (ID: {$resource->id})");
        
        // Test authentication
        Auth::login($bdsp);
        $this->info('Authenticated as BDSP');
        
        // Test policy registration
        $policies = Gate::policies();
        if (isset($policies['App\\Models\\Resource'])) {
            $this->info('✓ ResourcePolicy is registered');
        } else {
            $this->error('✗ ResourcePolicy is NOT registered');
            $this->line('Registered policies: ' . implode(', ', array_keys($policies)));
        }
        
        // Test authorization
        $canUpdate = Gate::allows('update', $resource);
        $this->line("Gate::allows('update', resource): " . ($canUpdate ? 'YES' : 'NO'));
        
        // Test controller authorization
        try {
            Gate::authorize('update', $resource);
            $this->info('✓ Controller authorization would PASS');
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            $this->error('✗ Controller authorization would FAIL: ' . $e->getMessage());
        }
        
        // Check middleware
        $middlewareAliases = app('router')->getMiddleware();
        if (isset($middlewareAliases['role'])) {
            $this->info('✓ Role middleware is registered');
        } else {
            $this->error('✗ Role middleware is NOT registered');
        }
        
        $this->info('=== TEST COMPLETE ===');
        
        if ($canUpdate) {
            $this->info('✅ Resource sharing should work - 403 error should be resolved!');
        } else {
            $this->error('❌ Resource sharing will fail - 403 error will persist');
        }
        
        return 0;
    }
}
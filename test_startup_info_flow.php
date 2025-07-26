<?php

require_once 'vendor/autoload.php';

use App\Models\Startup;
use App\Models\User;
use App\Models\StartupInfoRequest;

// Test the startup info request flow
echo "=== Testing Startup Info Request Flow ===\n\n";

// 1. Check if we have approved startups
$approvedStartups = Startup::where('status', 'approved')->get();
echo "1. Approved Startups: " . $approvedStartups->count() . "\n";

if ($approvedStartups->count() > 0) {
    $startup = $approvedStartups->first();
    echo "   - First startup: " . $startup->name . "\n";
} else {
    echo "   - No approved startups found\n";
}

// 2. Check if we have investors
$investors = User::where('role', 'investor')->get();
echo "2. Investors: " . $investors->count() . "\n";

if ($investors->count() > 0) {
    $investor = $investors->first();
    echo "   - First investor: " . $investor->name . "\n";
} else {
    echo "   - No investors found\n";
}

// 3. Check existing info requests
$infoRequests = StartupInfoRequest::with(['investor', 'startup'])->get();
echo "3. Existing Info Requests: " . $infoRequests->count() . "\n";

foreach ($infoRequests as $request) {
    echo "   - " . $request->investor->name . " requested " . $request->startup->name . " (Status: " . $request->status . ")\n";
}

// 4. Test the relationships
if ($approvedStartups->count() > 0 && $investors->count() > 0) {
    $startup = $approvedStartups->first();
    $investor = $investors->first();
    
    echo "4. Testing Relationships:\n";
    echo "   - Startup has " . $startup->infoRequests()->count() . " info requests\n";
    echo "   - Investor has " . $investor->startupInfoRequests()->count() . " info requests\n";
    
    // Test if investor has access to startup
    $hasAccess = $startup->hasInvestorAccess($investor->id);
    echo "   - Investor has access to startup: " . ($hasAccess ? 'Yes' : 'No') . "\n";
}

echo "\n=== Test Complete ===\n"; 
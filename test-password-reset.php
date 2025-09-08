<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

// Test email
$email = 'test@example.com';

// Create password reset token
$token = Str::random(64);

// Store token in database
DB::table('password_reset_tokens')->updateOrInsert(
    ['email' => $email],
    [
        'email' => $email,
        'token' => $token,
        'created_at' => Carbon::now()
    ]
);

// Generate reset URL
$resetUrl = url(route('password.reset', ['token' => $token, 'email' => $email], false));

echo "Reset URL: {$resetUrl}\n";

// Send email with reset link
try {
    Mail::send('auth.emails.password', ['token' => $token, 'resetUrl' => $resetUrl], function($message) use ($email) {
        $message->to($email);
        $message->subject('Reset Your Password');
    });
    echo "Email sent successfully!\n";
} catch (\Exception $e) {
    echo "Failed to send email: " . $e->getMessage() . "\n";
}

echo "Check the logs for more information.\n";
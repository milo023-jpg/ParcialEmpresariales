<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$email = 'admin@test.com';
$user = \App\Models\User::where('email', $email)->first();

if (! $user) {
    echo "NO_USER\n";
    exit(0);
}

echo "Found user: {$user->email}\n";

event(new Laravel\Fortify\Events\TwoFactorAuthenticationEnabled($user));

echo "Dispatched event. Unread notifications: " . $user->fresh()->unreadNotifications->count() . "\n";

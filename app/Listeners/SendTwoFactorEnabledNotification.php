<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Laravel\Fortify\Events\TwoFactorAuthenticationEnabled;
use App\Notifications\TwoFactorEnabledNotification;

class SendTwoFactorEnabledNotification
{
    /**
     * Handle the event.
     */
    public function handle(TwoFactorAuthenticationEnabled $event)
    {
        $user = $event->user;

        try {
            Log::info('TwoFactorEnabled listener triggered for user: '.$user->email);

            // Send immediately for debugging to avoid queue dependence
            Notification::sendNow([$user], new TwoFactorEnabledNotification());

            Log::info('TwoFactorEnabled notification sent for user: '.$user->email);
        } catch (\Throwable $e) {
            // don't break 2FA flow if notification fails
            Log::error('Failed to send TwoFactorEnabledNotification: '.$e->getMessage());
        }
    }
}

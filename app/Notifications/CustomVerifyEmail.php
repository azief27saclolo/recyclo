<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\URL;
use Illuminate\Auth\Notifications\VerifyEmail as VerifyEmailBase;

class CustomVerifyEmail extends VerifyEmailBase
{
    /**
     * Get the verification URL for the given notifiable.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    protected function verificationUrl($notifiable)
    {
        // Simple direct approach to avoid any URL manipulation issues
        $baseUrl = config('app.url');
        $baseUrl = rtrim($baseUrl, '/');
        
        $path = '/email/verify/' . $notifiable->getKey() . '/' . sha1($notifiable->getEmailForVerification());
        $expiration = Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60));
        
        // Generate a proper signed URL manually
        $signature = hash_hmac('sha256', $path . $expiration->getTimestamp(), config('app.key'));
        
        return $baseUrl . $path . '?expires=' . $expiration->getTimestamp() . '&signature=' . $signature;
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->subject(Lang::get('Verify Email Address - Recyclo'))
            ->greeting('Hello ' . $notifiable->firstname . '!')
            ->line(Lang::get('Please click the button below to verify your email address.'))
            ->action(Lang::get('Verify Email Address'), $verificationUrl)
            ->line(Lang::get('If you did not create an account, no further action is required.'))
            ->line(Lang::get('Thank you for using Recyclo!'));
    }
}

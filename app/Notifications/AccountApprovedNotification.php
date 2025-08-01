<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AccountApprovedNotification extends Notification
{
    use Queueable;
    use RoleBasedUrlTrait;

    public function __construct()
    {
        //
    }

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable)
    {
        $dashboardUrl = $this->generateActionUrl($notifiable, 'dashboard');
        
        return (new MailMessage)
            ->subject('Account Approved - Welcome to Arya Venture Readiness Portal!')
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('Congratulations! Your account has been approved and you now have full access to the Venture Readiness Portal.')
            ->line('You can now:')
            ->line('• Access all platform features and resources')
            ->line('• Connect with mentors, investors, and other entrepreneurs')
            ->line('• Participate in training programs and pitch events')
            ->line('• Submit and manage your startup profile')
            ->action('Access Your Dashboard', $dashboardUrl)
            ->line('If you have any questions or need assistance, please don\'t hesitate to contact our support team.')
            ->line('Welcome aboard!');
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Account Approved',
            'message' => 'Your account has been approved! You can now access all features.',
            'type' => 'approval',
            'action_url' => $this->generateActionUrl($notifiable, 'dashboard'),
        ];
    }
}
<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Startup;

class StartupApprovedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $startup;

    public function __construct(Startup $startup)
    {
        $this->startup = $startup;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Your Startup Profile Has Been Approved')
            ->greeting('Congratulations!')
            ->line('Your startup profile "' . $this->startup->name . '" has been approved by the admin.')
            ->action('View Profile', url('/dashboard/entrepreneur-startup-profile'))
            ->line('Thank you for being part of our platform!');
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'Your startup profile "' . $this->startup->name . '" has been approved.'
        ];
    }
} 
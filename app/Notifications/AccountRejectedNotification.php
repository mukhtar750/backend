<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AccountRejectedNotification extends Notification
{
    use Queueable;

    public $reason;

    public function __construct($reason = null)
    {
        $this->reason = $reason;
    }

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable)
    {
        $mailMessage = (new MailMessage)
            ->subject('Account Registration Update - Venture Readiness Portal')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('Thank you for your interest in joining the Venture Readiness Portal.');
            
        if ($this->reason) {
            $mailMessage->line('Unfortunately, your account registration has been rejected for the following reason:')
                        ->line($this->reason);
        } else {
            $mailMessage->line('Unfortunately, your account registration has been rejected.');
        }
        
        return $mailMessage
            ->line('If you believe this decision was made in error or if you have additional information to provide, please feel free to contact our support team.')
            ->line('You may also resubmit your application with the necessary corrections.')
            ->line('Thank you for your understanding.');
    }

    public function toDatabase($notifiable)
    {
        $message = 'Your account registration has been rejected.';
        if ($this->reason) {
            $message .= " Reason: {$this->reason}";
        }

        return [
            'title' => 'Account Rejected',
            'message' => $message,
            'type' => 'rejection',
            'reason' => $this->reason,
        ];
    }
}
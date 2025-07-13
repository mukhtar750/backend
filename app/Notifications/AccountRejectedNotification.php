<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\DatabaseMessage;
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
        return ['database'];
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
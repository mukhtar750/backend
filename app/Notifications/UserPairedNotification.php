<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class UserPairedNotification extends Notification
{
    use Queueable;
use RoleBasedUrlTrait;

    public $otherUser;
    public $pairingType;

    public function __construct($otherUser, $pairingType)
    {
        $this->otherUser = $otherUser;
        $this->pairingType = $pairingType;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'title' => 'New Pairing',
            'message' => "You have been paired with {$this->otherUser->name} ({$this->otherUser->role}) for " . ucwords(str_replace('_', ' ', $this->pairingType)) . ".",
            'type' => 'pairing',
            'pairing_type' => $this->pairingType,
            'other_user_id' => $this->otherUser->id,
            'action_url' => $this->generateActionUrl($notifiable, 'dashboard'),
        ];
    }
}

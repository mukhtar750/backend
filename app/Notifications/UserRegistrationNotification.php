<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;

class UserRegistrationNotification extends Notification
{
    use Queueable;

    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'New User Registration',
            'message' => "New {$this->user->role} registered: {$this->user->name}",
            'user_id' => $this->user->id,
            'user_name' => $this->user->name,
            'user_role' => $this->user->role,
            'type' => 'registration',
            'action_url' => route('admin.user-management'),
        ];
    }
} 
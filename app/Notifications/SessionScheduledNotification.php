<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\MentorshipSession;
use App\Models\User;

class SessionScheduledNotification extends Notification
{
    use Queueable;

    public $session;
    public $scheduler;

    public function __construct(MentorshipSession $session, User $scheduler)
    {
        $this->session = $session;
        $this->scheduler = $scheduler;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'message' => "{$this->scheduler->name} has scheduled a session with you for {$this->session->topic} on " . $this->session->date_time->format('M j, Y g:i A'),
            'session_id' => $this->session->id,
            'scheduler_id' => $this->scheduler->id,
            'topic' => $this->session->topic,
            'date_time' => $this->session->date_time->toISOString(),
        ];
    }
} 
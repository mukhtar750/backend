<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\MentorshipSession;
use App\Models\User;

class AdminSessionScheduledNotification extends Notification
{
    use Queueable;

    public $session;
    public $bdsp;
    public $mentee;

    public function __construct(MentorshipSession $session, User $bdsp, User $mentee)
    {
        $this->session = $session;
        $this->bdsp = $bdsp;
        $this->mentee = $mentee;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'message' => "BDSP {$this->bdsp->name} has scheduled a session with {$this->mentee->name} for {$this->session->topic} on " . $this->session->date_time->format('M j, Y g:i A'),
            'session_id' => $this->session->id,
            'bdsp_id' => $this->bdsp->id,
            'mentee_id' => $this->mentee->id,
            'topic' => $this->session->topic,
            'date_time' => $this->session->date_time->toISOString(),
            'type' => 'session_scheduled'
        ];
    }
} 
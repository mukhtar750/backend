<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\TrainingSession;

class TrainingSessionNotification extends Notification
{
    use Queueable;
use RoleBasedUrlTrait;

    public $session;

    public function __construct(TrainingSession $session)
    {
        $this->session = $session;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'title' => 'New Training Session Scheduled',
            'message' => "A new training session '{$this->session->title}' is scheduled for " . \Carbon\Carbon::parse($this->session->date_time)->format('Y-m-d H:i') . ". Trainer: {$this->session->trainer}.",
            'session_id' => $this->session->id,
            'session_title' => $this->session->title,
            'date_time' => $this->session->date_time,
            'trainer' => $this->session->trainer,
            'type' => 'training',
            'action_url' => $this->generateActionUrl($notifiable, 'training-sessions.index'),
        ];
    }
}
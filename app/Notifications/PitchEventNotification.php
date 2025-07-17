<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\PitchEvent;

class PitchEventNotification extends Notification
{
    use Queueable;

    public $event;

    public function __construct(PitchEvent $event)
    {
        $this->event = $event;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'title' => 'New Pitch Event Published',
            'message' => "A new pitch event '{$this->event->title}' is scheduled for " . $this->event->event_date->format('Y-m-d H:i') . ".",
            'event_id' => $this->event->id,
            'event_title' => $this->event->title,
            'date_time' => $this->event->event_date,
            'type' => 'pitch_event',
            'action_url' => route('investor.pitch_events'),
        ];
    }
} 
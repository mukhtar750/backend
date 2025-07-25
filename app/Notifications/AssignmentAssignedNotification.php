<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Task;

class AssignmentAssignedNotification extends Notification
{
    use Queueable;
    public $task;
    public function __construct(Task $task) { $this->task = $task; }
    public function via($notifiable) { return ['database']; }
    public function toArray($notifiable)
    {
        return [
            'message' => 'You have a new assignment: ' . $this->task->title,
            'url' => route('submissions.show', $this->task->id),
        ];
    }
}

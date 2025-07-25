<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\TaskSubmission;

class TaskGradedNotification extends Notification
{
    use Queueable;
    public $submission;
    public function __construct(TaskSubmission $submission) { $this->submission = $submission; }
    public function via($notifiable) { return ['database']; }
    public function toArray($notifiable)
    {
        return [
            'message' => 'Your submission for "' . $this->submission->task->title . '" was graded: ' . ($this->submission->grade ?? 'N/A'),
            'url' => route('submissions.show', $this->submission->id),
        ];
    }
}

<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\TaskSubmission;

class TaskSubmissionNotification extends Notification
{
    use Queueable;
    public $submission;
    public function __construct(TaskSubmission $submission) { $this->submission = $submission; }
    public function via($notifiable) { return ['database']; }
    public function toArray($notifiable)
    {
        return [
            'message' => 'A task was submitted: ' . $this->submission->task->title,
            'url' => route('submissions.show', $this->submission->id),
        ];
    }
}

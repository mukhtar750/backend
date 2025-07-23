<?php

namespace App\Notifications;

use App\Models\PracticePitch;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PracticePitchStatusNotification extends Notification
{
    use Queueable;
use RoleBasedUrlTrait;

    public $pitch;
public $type;

    public function __construct(PracticePitch $pitch, $type)
    {
        $this->pitch = $pitch;
        $this->type = $type;
    }

    public function via($notifiable)
    {
        return ['database']; // Later, you can add 'mail'
    }

    public function toArray($notifiable)
    {
        return [
            'type' => $this->type,
            'title' => $this->getTitle(),
            'message' => $this->getMessage(),
            'pitch_id' => $this->pitch->id,
            'status' => $this->pitch->status,
            'action_url' => $this->getActionUrl($notifiable),
        ];
    }

    protected function getTitle()
    {
        switch ($this->type) {
            case 'admin_new':
                return 'New Practice Pitch Submitted';
            case 'entrepreneur_approved':
                return 'Pitch Approved';
            case 'entrepreneur_rejected':
                return 'Pitch Rejected';
            case 'entrepreneur_reviewed':
                return 'Feedback Received';
            case 'mentor_new':
                return 'New Pitch for Feedback';
            default:
                return 'Pitch Notification';
        }
    }

    protected function getMessage()
    {
        switch ($this->type) {
            case 'admin_new':
                return "A new practice pitch titled '{$this->pitch->title}' has been submitted by {$this->pitch->user->name} for review.";
            case 'entrepreneur_approved':
                return "Your pitch '{$this->pitch->title}' has been approved.";
            case 'entrepreneur_rejected':
                return "Your pitch '{$this->pitch->title}' was rejected." . ($this->pitch->admin_feedback ? " Feedback: {$this->pitch->admin_feedback}" : "");
            case 'entrepreneur_reviewed':
                return "You've received feedback on your pitch '{$this->pitch->title}': {$this->pitch->feedback}";
            case 'mentor_new':
                return "A new approved pitch titled '{$this->pitch->title}' from {$this->pitch->user->name} is available for feedback.";
            default:
                return "Notification about pitch '{$this->pitch->title}'.";
        }
    }

    protected function getActionUrl($notifiable)
    {
        return $this->generateActionUrl($notifiable, 'practice-pitches.index');
    }
}

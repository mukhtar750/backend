<?php

namespace App\Notifications;

use App\Models\PitchEventProposal;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProposalRejectedNotification extends Notification
{
    use Queueable;

    public $proposal;

    /**
     * Create a new notification instance.
     */
    public function __construct(PitchEventProposal $proposal)
    {
        $this->proposal = $proposal;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('📋 Update on Your Pitch Event Proposal')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('We have reviewed your pitch event proposal "' . $this->proposal->title . '".')
            ->line('Unfortunately, we are unable to approve this proposal at this time.')
            ->line('**Admin Feedback:** ' . $this->proposal->admin_feedback)
            ->action('View Proposal Details', route('investor.proposals.show', $this->proposal))
            ->line('We encourage you to submit new proposals that align with our platform guidelines.')
            ->salutation('Best regards, VR Portal Team');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'proposal_rejected',
            'title' => 'Proposal Update: ' . $this->proposal->title,
            'message' => 'Your pitch event proposal was not approved. Check details for feedback.',
            'proposal_id' => $this->proposal->id,
            'action_url' => route('investor.proposals.show', $this->proposal),
        ];
    }
}

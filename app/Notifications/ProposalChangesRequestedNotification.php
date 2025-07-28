<?php

namespace App\Notifications;

use App\Models\PitchEventProposal;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProposalChangesRequestedNotification extends Notification
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
            ->subject('📝 Changes Requested for Your Pitch Event Proposal')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('We have reviewed your pitch event proposal "' . $this->proposal->title . '".')
            ->line('We would like to request some changes before we can approve it.')
            ->line('**Admin Feedback:** ' . $this->proposal->admin_feedback)
            ->action('Update Your Proposal', route('investor.proposals.edit', $this->proposal))
            ->line('Please review the feedback and update your proposal accordingly.')
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
            'type' => 'proposal_changes_requested',
            'title' => 'Changes Requested: ' . $this->proposal->title,
            'message' => 'Changes have been requested for your pitch event proposal.',
            'proposal_id' => $this->proposal->id,
            'action_url' => route('investor.proposals.edit', $this->proposal),
        ];
    }
}

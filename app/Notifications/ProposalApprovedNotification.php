<?php

namespace App\Notifications;

use App\Models\PitchEventProposal;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProposalApprovedNotification extends Notification
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
            ->subject('🎉 Your Pitch Event Proposal Has Been Approved!')
            ->greeting('Congratulations, ' . $notifiable->name . '!')
            ->line('Your pitch event proposal "' . $this->proposal->title . '" has been approved by our admin team.')
            ->line('Your event has been scheduled and is now live on the platform.')
            ->action('View Event Details', route('pitch-events.show', $this->proposal->approvedEvent))
            ->line('Thank you for contributing to our ecosystem!')
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
            'type' => 'proposal_approved',
            'title' => 'Proposal Approved: ' . $this->proposal->title,
            'message' => 'Your pitch event proposal has been approved and scheduled.',
            'proposal_id' => $this->proposal->id,
            'event_id' => $this->proposal->approved_event_id,
            'action_url' => route('pitch-events.show', $this->proposal->approvedEvent),
        ];
    }
}

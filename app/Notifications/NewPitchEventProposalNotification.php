<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\PitchEventProposal;

class NewPitchEventProposalNotification extends Notification implements ShouldQueue
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
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Pitch Event Proposal Submitted')
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('A new pitch event proposal has been submitted by ' . $this->proposal->investor->name . '.')
            ->line('**Proposal Title:** ' . $this->proposal->title)
            ->line('**Event Type:** ' . $this->proposal->event_type)
            ->line('**Target Sector:** ' . $this->proposal->target_sector)
            ->line('**Target Stage:** ' . $this->proposal->target_stage)
            ->action('Review Proposal', route('admin.proposals.show', $this->proposal))
            ->line('Please review this proposal and take appropriate action.')
            ->salutation('Best regards, Venture Ready Portal');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'proposal_id' => $this->proposal->id,
            'investor_id' => $this->proposal->investor_id,
            'investor_name' => $this->proposal->investor->name,
            'title' => $this->proposal->title,
            'event_type' => $this->proposal->event_type,
            'target_sector' => $this->proposal->target_sector,
            'target_stage' => $this->proposal->target_stage,
            'status' => $this->proposal->status,
            'message' => 'New pitch event proposal submitted by ' . $this->proposal->investor->name,
            'action_url' => route('admin.proposals.show', $this->proposal),
        ];
    }
}

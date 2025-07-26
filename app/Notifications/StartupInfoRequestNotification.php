<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\StartupInfoRequest;

class StartupInfoRequestNotification extends Notification
{
    use Queueable;

    public $infoRequest;

    /**
     * Create a new notification instance.
     */
    public function __construct(StartupInfoRequest $infoRequest)
    {
        $this->infoRequest = $infoRequest;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Startup Info Request')
            ->line('An investor has requested access to a startup profile.')
            ->line('Startup: ' . $this->infoRequest->startup->name)
            ->line('Investor: ' . $this->infoRequest->investor->name)
            ->action('Review Request', route('admin.user-management', ['tab' => 'startup-profiles']))
            ->line('Please review and approve or reject this request.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'startup_info_request',
            'title' => 'New Startup Info Request',
            'message' => 'Investor ' . $this->infoRequest->investor->name . ' has requested access to ' . $this->infoRequest->startup->name,
            'startup_id' => $this->infoRequest->startup_id,
            'investor_id' => $this->infoRequest->investor_id,
            'request_id' => $this->infoRequest->id,
        ];
    }
}

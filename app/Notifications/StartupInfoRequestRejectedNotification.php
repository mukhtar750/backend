<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\StartupInfoRequest;

class StartupInfoRequestRejectedNotification extends Notification
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
            ->subject('Startup Info Request Rejected')
            ->line('Your request for startup information has been rejected.')
            ->line('Startup: ' . $this->infoRequest->startup->name)
            ->line('Reason: ' . ($this->infoRequest->admin_notes ?? 'No reason provided'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'startup_info_request_rejected',
            'title' => 'Startup Info Request Rejected',
            'message' => 'Your request for ' . $this->infoRequest->startup->name . ' has been rejected',
            'startup_id' => $this->infoRequest->startup_id,
            'request_id' => $this->infoRequest->id,
        ];
    }
}

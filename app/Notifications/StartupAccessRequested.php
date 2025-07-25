<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\StartupAccessRequest;

class StartupAccessRequested extends Notification
{
    use Queueable;

    protected $accessRequest;

    /**
     * Create a new notification instance.
     *
     * @param  \App\Models\StartupAccessRequest  $accessRequest
     * @return void
     */
    public function __construct(StartupAccessRequest $accessRequest)
    {
        $this->accessRequest = $accessRequest;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $investor = $this->accessRequest->investor;
        $startup = $this->accessRequest->startup;
        
        return (new MailMessage)
            ->subject('New Investor Access Request for ' . $startup->name)
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('An investor has requested access to view the full profile of your startup.')
            ->line('Investor: ' . $investor->name)
            ->line('Company: ' . ($investor->company_name ?? 'Not specified'))
            ->when($this->accessRequest->message, function ($mail) {
                return $mail->line('Message: "' . $this->accessRequest->message . '"');
            })
            ->action('Review Request', url('/dashboard/entrepreneur-startup-profile'))
            ->line('Thank you for using our platform!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $investor = $this->accessRequest->investor;
        $startup = $this->accessRequest->startup;
        
        return [
            'title' => 'New Investor Access Request',
            'message' => $investor->name . ' has requested access to view the full profile of ' . $startup->name,
            'action_url' => '/dashboard/entrepreneur-startup-profile',
            'investor_id' => $investor->id,
            'startup_id' => $startup->id,
            'access_request_id' => $this->accessRequest->id,
        ];
    }
}
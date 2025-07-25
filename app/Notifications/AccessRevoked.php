<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\StartupAccessRequest;

class AccessRevoked extends Notification
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
        $startup = $this->accessRequest->startup;
        
        return (new MailMessage)
            ->subject('Access Revoked: ' . $startup->name . ' Startup Profile')
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('Your access to the full profile of ' . $startup->name . ' has been revoked by the startup founder.')
            ->line('You can still view the teaser information about this startup.')
            ->action('View Startup Profiles', url('/investor/startup-profiles'))
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
        $startup = $this->accessRequest->startup;
        
        return [
            'title' => 'Startup Profile Access Revoked',
            'message' => 'Your access to ' . $startup->name . '\'s full profile has been revoked.',
            'action_url' => '/investor/startup-profiles',
            'startup_id' => $startup->id,
            'access_request_id' => $this->accessRequest->id,
        ];
    }
}
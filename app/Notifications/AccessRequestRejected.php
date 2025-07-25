<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\StartupAccessRequest;

class AccessRequestRejected extends Notification
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
        $mail = (new MailMessage)
            ->subject('Access Request Declined: ' . $startup->name . ' Startup Profile')
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('Your request to access the full profile of ' . $startup->name . ' has been declined.')
            ->line('You can still view the teaser information about this startup.')
            ->action('View Startup Profiles', url('/investor/startup-profiles'));
            
        if ($this->accessRequest->response_message) {
            $mail->line('Message from the startup founder:')
                 ->line('"' . $this->accessRequest->response_message . '"');
        }
        
        return $mail->line('Thank you for using our platform!');
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
            'title' => 'Startup Profile Access Declined',
            'message' => 'Your request to access ' . $startup->name . '\'s full profile has been declined.',
            'action_url' => '/investor/startup-profiles',
            'startup_id' => $startup->id,
            'access_request_id' => $this->accessRequest->id,
            'response_message' => $this->accessRequest->response_message,
        ];
    }
}
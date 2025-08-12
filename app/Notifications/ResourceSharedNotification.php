<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Resource;
use App\Models\User;

class ResourceSharedNotification extends Notification
{
    use Queueable;

    public $resource;
    public $sharedBy;
    public $message;

    /**
     * Create a new notification instance.
     */
    public function __construct(Resource $resource, User $sharedBy, $message = null)
    {
        $this->resource = $resource;
        $this->sharedBy = $sharedBy;
        $this->message = $message;
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
        $url = route('dashboard.entrepreneur');
        
        return (new MailMessage)
            ->subject('New Resource Shared with You')
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line($this->sharedBy->name . ' has shared a new resource with you.')
            ->line('Resource: ' . $this->resource->name)
            ->when($this->message, function ($message) {
                return $message->line('Message: "' . $this->message . '"');
            })
            ->action('View Resource', $url)
            ->line('You can now access this resource from your dashboard.')
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
            'type' => 'resource_shared',
            'resource_id' => $this->resource->id,
            'resource_name' => $this->resource->name,
            'shared_by_id' => $this->sharedBy->id,
            'shared_by_name' => $this->sharedBy->name,
            'message' => $this->message,
            'title' => 'New Resource Shared',
            'body' => $this->sharedBy->name . ' shared "' . $this->resource->name . '" with you.',
        ];
    }
}

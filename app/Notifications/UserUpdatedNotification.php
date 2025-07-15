<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class UserUpdatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $changes;

    /**
     * Create a new notification instance.
     *
     * @param array $changes
     */
    public function __construct(array $changes)
    {
        $this->changes = $changes;
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
        $mail = (new MailMessage)
            ->subject('Your Profile Has Been Updated')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('Your profile information has been updated by an administrator.');
        if (!empty($this->changes)) {
            $mail->line('The following fields were changed:');
            foreach ($this->changes as $field => $values) {
                $mail->line(ucwords(str_replace('_', ' ', $field)) . ': "' . $values['old'] . '" → "' . $values['new'] . '"');
            }
        }
        $mail->line('If you have any questions or concerns, please contact support.');
        return $mail;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'message' => 'Your profile was updated by an administrator.',
            'changes' => $this->changes,
        ];
    }
} 
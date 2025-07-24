<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\DatabaseMessage;
use App\Models\Pairing;

class AdminMentorshipAgreementCompletedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $pairing;

    public function __construct(Pairing $pairing)
    {
        $this->pairing = $pairing;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Mentorship Agreement Completed',
            'body' => 'Both mentor and mentee have signed the mentorship agreement for the pair: ' . $this->pairing->userOne->name . ' & ' . $this->pairing->userTwo->name,
            'url' => route('admin.user-management', ['tab' => 'pairings', 'pairing_id' => $this->pairing->id]),
            'pairing_id' => $this->pairing->id,
        ];
    }
} 
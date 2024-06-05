<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProfileLiked extends Notification
{
    use Queueable;

    private $liker;

    public function __construct($liker)
    {
        $this->liker = $liker;
    }

    public function via($notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toArray($notifiable): array
    {
        return [
            'liker_id' => $this->liker->id,
            'liker_name' => $this->liker->name,
            'message' => "{$this->liker->name} liked your profile",
        ];
    }

    public function toMail($notifiable): ?MailMessage
    {
        if ($notifiable->profile->opt_out) {
            return null;
        }

        $mailServerUrl = config('mail.mailers.smtp.host');
        $port = config('mail.mailers.smtp.port');
        $fp = @fsockopen($mailServerUrl, $port);
        if (! $fp) {
            return null;
        }

        return (new MailMessage)
            ->line("{$this->liker->name} liked your profile")
            ->action('View Profile', url('/profile/'.$this->liker->id))
            ->line('Thank you for using our application!');
    }
}

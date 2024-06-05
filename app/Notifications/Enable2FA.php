<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Enable2FA extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(): array
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): ?MailMessage
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
            ->line('You have not enabled 2FA on your account.')
            ->action('Enable 2FA', url('/user/profile/'.'#2fa'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'user_id' => $notifiable->id,
            '2fa_enabled' => false,
            'user_name' => $notifiable->name,
            'message' => 'You have not enabled 2FA on your account.',
        ];
    }
}

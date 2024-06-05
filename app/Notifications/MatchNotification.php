<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MatchNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(protected User $with)
    {
        //
    }

    public function via(): array
    {
        return ['database', 'mail'];
    }

    public function toMail(User $notifiable): ?MailMessage
    {
        return (new MailMessage)
            ->greeting("Hello, {$notifiable->name}!")
            ->line("You have matched with {$this->with->name}!")
            ->salutation('Thank you for using '.config('app.name'));
    }

    public function toArray(User $notifiable): array
    {
        return [
            'user_id' => $notifiable->id,
            'matched_with_id' => $notifiable->id,
            'message' => "You have matched with {$this->with->name}!",
        ];
    }
}

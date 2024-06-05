<?php

namespace App\Livewire;

use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Collection;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;

class OpenChats extends Component
{
    public User $user;

    public Collection $matches;

    /** @var array<int, Message> */
    #[Locked]
    public array $latestMessages = [];

    public function mount(): void
    {
        $this->user = auth()->user();
        $this->matches = $this->user->matches()->get()->pluck('likeable');

        foreach ($this->matches as $user) {
            $this->latestMessages[$user->id] = $this->latestMessage($user);
        }
    }

    #[On('echo-private:messages.{user.id},MessageSent')]
    public function messageReceived($event): void
    {
        $this->updateUserCards(Message::findOrFail($event['messageId']));
    }

    #[On('message-sent')]
    public function updateUserCards(Message $message): void
    {
        $id = $message->sender_id === $this->user->id
            ? $message->receiver_id
            : $message->sender_id;

        $this->latestMessages[$id] = $message;
    }

    public function latestMessage(User $sender): ?Message
    {
        return Message::query()
            ->between($this->user, $sender)
            ->latest('created_at')
            ->first();
    }

    public function redirectToUserProfile(int $user): void
    {
        $this->redirectRoute('user.profile', ['user' => $user], navigate: true);
    }

    public function render()
    {
        return view('livewire.open-chats');
    }
}

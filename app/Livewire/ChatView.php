<?php

namespace App\Livewire;

use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class ChatView extends Component
{
    use WithPagination;

    #[Locked]
    public User $user;

    #[Locked]
    public User $receiver;

    #[Locked]
    public Collection $messages;

    public function mount(User $receiver): void
    {
        $this->user = auth()->user();
        $this->receiver = $receiver;
        $this->messages = $this->loadMessages();
        $this->dispatch('scroll-to-bottom');
    }

    public function render()
    {
        return view('livewire.chat-view');
    }

    #[On('open-chat')]
    public function openChat(User $user): void
    {
        $this->receiver = $user;
        $this->messages = $this->loadMessages();
        $this->dispatch('scroll-to-bottom');
    }

    #[On('message-sent')]
    public function messageSent(Message $message): void
    {
        $this->messages->prepend($message);
        $this->dispatch('scroll-to-bottom');
    }

    #[On('echo-private:messages.{user.id},MessageSent')]
    public function messageReceived($event): void
    {
        $message = Message::findOrFail($event['messageId']);
        $this->messages->prepend($message);
    }

    protected function loadMessages(int $limit = 10, ?int $before = null): Collection
    {
        return Message::query()
            ->with('sender')
            ->between($this->user, $this->receiver)
            ->tap(function ($query) use ($before) {
                if (! is_null($before)) {
                    return $query->where('id', '<', $before);
                }

                return $query;
            })
            ->orderByDesc('created_at')
            ->limit($limit)
            ->get();
    }

    public function loadMoreMessages(): void
    {
        $before = $this->messages->min('id');

        $new = $this->loadMessages(before: $before);

        $this->messages->push(...$new);
    }
}

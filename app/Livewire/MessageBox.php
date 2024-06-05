<?php

namespace App\Livewire;

use App\Events\MessageSent;
use App\Models\User;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Reactive;
use Livewire\Attributes\Validate;
use Livewire\Component;

class MessageBox extends Component
{
    #[Validate('required|string|max:280')]
    public string $input = '';

    #[Locked]
    public User $user;

    #[Locked, Reactive]
    public User $receiver;

    public function mount(User $receiver): void
    {
        $this->user = auth()->user();
        $this->receiver = $receiver;
        $this->input = '';
    }

    public function addEmote(string $emote): void
    {
        $this->input .= $emote;
    }

    public function save(): void
    {
        $this->validate();

        $message = $this->receiver->received()->create([
            'sender_id' => $this->user->id,
            'content' => $this->input,
        ]);

        MessageSent::broadcast($message);

        $this->dispatch('message-sent', message: $message->id);

        $this->reset('input');
    }

    public function render()
    {
        return view('livewire.message-box');
    }
}

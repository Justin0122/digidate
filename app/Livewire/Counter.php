<?php

namespace App\Livewire;

use App\Events\CounterIncremented;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;

class Counter extends Component
{
    #[Locked]
    public int $count;

    public function mount(): void
    {
        $this->count = cache()->get('counter', 0);
    }

    public function clicked(): void
    {
        $this->count += 1;
        CounterIncremented::broadcast()->toOthers();
    }

    #[On('echo:counter,CounterIncremented')]
    public function increment(): void
    {
        $this->count += 1;
    }

    public function render()
    {
        return view('livewire.counter');
    }
}

<?php

namespace App\Listeners;

use App\Events\CounterIncremented;

class UpdateCachedCounterListener
{
    public function __construct()
    {
        //
    }

    public function handle(CounterIncremented $event): void
    {
        cache()->increment('counter');
    }
}

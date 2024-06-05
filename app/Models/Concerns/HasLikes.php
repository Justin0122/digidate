<?php

namespace App\Models\Concerns;

use App\Models\Like;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasLikes
{
    public function likes(): MorphMany
    {
        return $this->morphMany(Like::class, 'likeable');
    }
}

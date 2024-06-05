<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Message extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'content',
        'read_at',
    ];

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function scopeBetween(Builder $query, User $first, User $second): Builder
    {
        return $query
            ->whereIn('sender_id', [$first->id, $second->id])
            ->whereIn('receiver_id', [$first->id, $second->id]);
    }
}

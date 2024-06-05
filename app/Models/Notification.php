<?php

namespace App\Models;

use AnourValar\EloquentSerialize\Tests\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OwenIt\Auditing\Contracts\Auditable;

class Notification extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'receiver_id', 'summary', 'description',
    ];

    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

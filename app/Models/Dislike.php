<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use OwenIt\Auditing\Contracts\Auditable;

class Dislike extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    public function dislikeable(): MorphTo
    {
        return $this->morphTo();
    }
}

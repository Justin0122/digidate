<?php

namespace App\Models;

use App\Enums\Gender;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Profile extends Model implements Auditable, HasMedia
{
    use HasFactory, InteractsWithMedia, \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'user_id',
        'phone_number',
        'bio',
        'city',
        'date_of_birth',
        'gender',
        'straight',
        'opt_out',
    ];

    protected $casts = [
        'date_of_birth' => 'datetime',
        'gender' => Gender::class,
        'straight' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'profile_tags');
    }
}

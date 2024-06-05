<?php

namespace App\Models;

use App\Contracts\Dislikeable;
use App\Contracts\Likeable;
use App\Models\Concerns\HasDislikes;
use App\Models\Concerns\HasLikes;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\MediaLibrary\InteractsWithMedia;

class User extends Authenticatable implements Auditable, Dislikeable, FilamentUser, Likeable, MustVerifyEmail
{
    use HasApiTokens,
        HasDislikes,
        HasFactory,
        HasLikes,
        HasProfilePhoto,
        InteractsWithMedia,
        Notifiable,
        \OwenIt\Auditing\Auditable,
        TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname',
        'insertion',
        'lastname',
        'city',
        'email',
        'password',
        'admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'admin' => 'boolean',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function possibleAdmin(): bool
    {
        return str_ends_with($this->email, '@digidate.nl')
            && $this->hasVerifiedEmail();
    }

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->firstname,
        );
    }

    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class, 'user_id')->withDefault();
    }

    public function like(Likeable $likeable): self
    {
        if ($this->hasLiked($likeable)) {
            return $this;
        }

        (new Like)
            ->user()->associate($this)
            ->likeable()->associate($likeable)
            ->save();

        return $this;
    }

    public function unlike(Likeable $likeable): self
    {
        if (! $this->hasLiked($likeable)) {
            return $this;
        }

        $likeable->likes()
            ->whereHas('user', fn ($q) => $q->whereId($this->id))
            ->delete();

        return $this;
    }

    public function dislike(Dislikeable $dislikeable): self
    {
        if ($this->hasDisliked($dislikeable)) {
            return $this;
        }

        (new Dislike())
            ->user()->associate($this)
            ->dislikeable()->associate($dislikeable)
            ->save();

        return $this;
    }

    public function hasLiked(Likeable $likeable): bool
    {
        if (! $likeable->exists) {
            return false;
        }

        return $likeable->likes()
            ->whereHas('user', fn ($q) => $q->whereId($this->id))
            ->exists();
    }

    public function hasDisliked(Dislikeable $dislikeable): bool
    {
        if (! $dislikeable->exists) {
            return false;
        }

        return $dislikeable->dislikes()
            ->whereHas('user', fn ($q) => $q->whereId($this->id))
            ->exists();
    }

    public function unreadNotifications()
    {
        return $this->notifications()->whereNull('read_at');
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->admin && $this->possibleAdmin();
    }

    public function sent(): HasMany
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function received(): HasMany
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function likesSent(): HasMany
    {
        return $this->hasMany(Like::class, 'user_id');
    }

    public function matches(): HasMany
    {
        return $this->likesSent()
            ->where('likeable_type', User::class)
            ->whereHas('likeable.likesSent', function ($query) {
                $query->where('likeable_id', $this->id);
            })
            ->with('likeable');
    }
}

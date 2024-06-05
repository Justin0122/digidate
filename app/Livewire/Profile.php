<?php

namespace App\Livewire;

use App\Enums\Gender;
use App\Models\Dislike;
use App\Models\Like;
use App\Models\Tag;
use App\Models\User;
use App\Notifications\MatchNotification;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Profile extends Component
{
    use WithFileUploads;

    public $search = null;

    public $user;

    public $profile = [];

    public $form = [];

    public $totalUsers;

    #[Url(keep: true)]
    public $tags_amount = 0;

    #[Url(keep: true)]
    public $min_age = 18;

    #[Url]
    public $searchCity;

    public $city;

    #[Url(keep: true)]
    public $max_age = 100;

    public $totalTags;

    public $maxTags = 10;

    public $photo;

    /** @var MediaCollection */
    public $media;

    public function mount($userid = null): void
    {
        if ($userid == null) {
            $userid = auth()->id();
        }
        $this->user = User::findOrFail($userid);
        $this->media = $this->user->profile->getMedia('pictures');
        if ($this->user->id == auth()->id()) {
            $this->form = $this->user->profile->toArray();
            $this->totalTags = Tag::count();
        } else {
            $this->profile = $this->user->profile->toArray();
        }
    }

    public function render()
    {
        if ($this->user) {
            $profile = $this->user->profile;
            if (!$profile['gender']) {
                abort(404);
            }
            if ($this->max_age < $this->min_age) {
                $this->max_age = min($this->min_age + 5, 100);
            }
            $age = $profile->date_of_birth->age;

            $query = Tag::whereDoesntHave('profiles', function ($query) {
                $query->where('profile_id', $this->user->profile->id);
            })->orderBy('name');

            if ($this->search != null) {
                $query->where('name', 'like', '%' . $this->search . '%');
            }

            if ($this->maxTags != 'all') {
                $query->take($this->maxTags);
            }

            $this->city = $this->searchCity;
            $searchTags = $query->get();

            $liked = auth()->user()->hasLiked($this->user);
            $this->profile['liked'] = $liked;

        }

        return view('livewire.profile', [
            'user' => $this->user ?? null,
            'age' => $age ?? null,
            'searchTags' => $searchTags ?? null,
            'cities' => $this->getCities(),
            'liked' => $liked ?? null,
        ]);
    }

    private function getCities()
    {
        $query = \App\Models\Profile::select('city')->distinct();

        if ($this->searchCity) {
            $query->where('city', 'like', $this->searchCity . '%');
        }

        return $query->take(5)->orderBy('city', 'asc')->get()->pluck('city');
    }

    public function selectCity($city)
    {
        $this->searchCity = $city;
        $this->city = $city;
    }

    public function applyFilters()
    {
        $minAge = $this->min_age;
        $maxAge = $this->max_age;
        $excludeIds = Like::where('user_id', auth()->id())->pluck('likeable_id');
        $excludeIds[] = auth()->id();

        $currentUser = auth()->user();

        $query = User::query();

        $query->whereHas('profile', function ($query) use ($minAge, $maxAge) {
            $query->whereBetween('date_of_birth', [
                now()->subYears($maxAge)->format('Y-m-d'),
                now()->subYears($minAge)->format('Y-m-d'),
            ]);
        });

        $query->whereDoesntHave('likes', function ($query) {
            $query->where('likeable_id', auth()->id());
        });

        $query->whereNotIn('id', $excludeIds);

        $query->whereHas('profile', function ($query) use ($currentUser) {
            $gender = $currentUser->profile->gender;
            $straight = $currentUser->profile->straight;

            $query->where(function ($query) use ($gender, $straight) {
                if ($straight !== null) {
                    if ($gender == Gender::Woman && $straight == 1) {
                        $query->where('gender', Gender::Man)->where('straight', 1);
                    } elseif ($gender == Gender::Woman && $straight == 0) {
                        $query->where('gender', Gender::Woman)->where('straight', 0)->orWhere('straight', null);
                    } elseif ($gender == Gender::Man && $straight == 1) {
                        $query->where('gender', Gender::Woman)->where('straight', 1);
                    } elseif ($gender == Gender::Man && $straight == 0) {
                        $query->where('gender', Gender::Man)->where('straight', 0)->orWhere('straight', null);
                    }
                } else {
                    if ($gender == Gender::Woman) {
                        $query->where('gender', Gender::Man)->where('straight', 1)->orWhere('straight', null)->orWhere('gender', Gender::Woman)->where('straight', 0)->orWhere('straight', null);
                    } elseif ($gender == Gender::Man) {
                        $query->where('gender', Gender::Woman)->where('straight', 1)->orWhere('straight', null)->orWhere('gender', Gender::Man)->where('straight', 0)->orWhere('straight', null);
                    }
                }
            });
        });

        if ($currentUser->profile->tags->count() > 0) {
            $query->whereHas('profile', function ($query) use ($currentUser) {
                $query->whereHas('tags', function ($query) use ($currentUser) {
                    $query->whereIn('tag_id', $currentUser->profile->tags->pluck('id'));
                }, '>=', $this->tags_amount);
            });
        }

        if ($this->city) {
            $query->whereHas('profile', function ($query) {
                $query->where('city', 'like', '%' . $this->city . '%');
            });
        }

        $this->totalUsers = $query->count();
        $user = $query->inRandomOrder()->first();

        if ($user) {
            $this->user = $user;
            $this->media = $this->user->profile->getMedia('pictures');
            $this->profile = $this->user->profile->toArray();
        } else {
            $this->user = null;
        }
    }

    public function like()
    {
        $user = auth()->user();
        if ($user->hasDisliked($this->user)) {
            $dislike = Dislike::where('user_id', $user->id)->where('dislikeable_id', $this->user->id)->first();
            if ($dislike->created_at->diffInMonths(now()) >= 3) {
                $dislike->delete();
            } else {
                $timeLeft = $dislike->created_at->addMonths(3)->diffInDays(now()) . ' days';
                $this->addError('like', 'You can like this user in ' . $timeLeft);

                return;
            }
        }
        $user->like($this->user);

        if ($this->user->hasLiked($user)) {
            $this->user->notify(new MatchNotification(with: $user));
            $user->notify(new MatchNotification(with: $this->user));
        }
    }

    public function unlike()
    {
        $user = auth()->user();
        // TODO: cooldown of 3 months before being able to like again
        $user->unlike($this->user);
    }

    public function dislike(): void
    {
        $user = auth()->user();
        $user->unlike($this->user);
        $user->dislike($this->user);
        $this->applyFilters();
    }

    public function save(): void
    {
        $user = auth()->user();

        $this->validate([
            'form.bio' => 'required|min:10|max:100',
        ]);

        $user->profile->update($this->form);

        $this->changePreference();

        $this->dispatch('saved', 'Profile updated!');
    }

    public function savePicture(): void
    {
        $this->resetErrorBag('photo');

        if (is_null($this->photo)) {
            $this->addError('photo', 'No photo has been uploaded to save.');

            return;
        }

        $path = $this->photo->storePublicly('profile-pictures', 'public');

        $this->media[] = $this->user->profile
            ->addMediaFromDisk($path, 'public')
            ->toMediaCollection('pictures');
    }

    public function removePicture(int $id): void
    {
        $media = $this->media[$id];
        $this->user->profile->deleteMedia($media);
        unset($this->media[$id]);
    }

    public function prioritisePicture(int $id): void
    {
        /** @var Media $media */
        $media = $this->media[$id];
        $this->media->first()->update(['order_column' => $media->order_column]);
        $media->update(['order_column' => 1]);
        $this->media = $this->user->profile->getMedia('pictures');
    }

    public function removeTag($tagId): void
    {
        $this->user->profile->tags()->detach($tagId);
    }

    public function addTag($id): void
    {
        if ($this->user->profile->tags()->count() >= 5) {
            $this->dispatch('error', 'You can only have 5 tags!');

            return;
        }
        $this->user->profile->tags()->syncWithoutDetaching($id);
    }

    public function changePreference(): void
    {
        if ($this->form['straight'] == 1) {
            $this->form['straight'] = 1;
        } elseif ($this->form['straight'] == 2) {
            $this->form['straight'] = null;
        } else {
            $this->form['straight'] = 0;
        }

        $this->user->profile->update($this->form);
    }

}

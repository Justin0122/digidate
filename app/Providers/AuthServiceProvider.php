<?php

namespace App\Providers;

use App\Contracts\Likeable;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot()
    {
        $this->registerPolicies();

        // $user->can('like', $likeable)
        Gate::define('like', function (User $user, Likeable $likeable) {
            if (! $likeable->exists) {
                return Response::deny("Cannot like an object that doesn't exists");
            }

            if ($user->hasLiked($likeable)) {
                return Response::deny('Cannot like the same thing twice');
            }

            return Response::allow();
        });

        // $user->can('unlike', $likeable)
        Gate::define('unlike', function (User $user, Likeable $likeable) {
            if (! $likeable->exists) {
                return Response::deny("Cannot unlike an object that doesn't exists");
            }

            if (! $user->hasLiked($likeable)) {
                return Response::deny('Cannot unlike without liking first');
            }

            return Response::allow();
        });
    }
}

<?php

namespace App\Actions\Jetstream;

use App\Exceptions\LastAdminException;
use App\Models\User;
use Laravel\Jetstream\Contracts\DeletesUsers;

class DeleteUser implements DeletesUsers
{
    /**
     * Delete the given user.
     *
     * @throws LastAdminException
     */
    public function delete(User $user): void
    {
        if ($user->getAttribute('admin') === true) {
            throw new LastAdminException;
        }

        $user->deleteProfilePhoto();
        $user->tokens->each->delete();

        $user->firstname = 'Anonymous';
        $user->insertion = '';
        $user->lastname = 'User';
        $user->email = 'anonymous'.$user->id.'@deleted';
        $user->deleted_at = now();

        if (! empty($user->profile)) {
            $profile = $user->profile;
            $profile->bio = 'This user has been deleted';
            $profile->save();
        }

        $user->save();
    }
}

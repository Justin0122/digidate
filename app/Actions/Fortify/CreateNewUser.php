<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        // Voeg validatieregels toe om ervoor te zorgen dat de gebruiker 18 jaar of ouder is
        $validator = Validator::make($input, [
            'firstname' => ['required', 'string', 'max:255'],
            'insertion' => ['nullable', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phonenumber' => ['required', 'string', 'max:255'],
            'dateofbirth' => ['required', 'date', 'before_or_equal:'.Carbon::now()->subYears(18)->format('Y-m-d')],
            'gender' => ['required', 'string', 'max:255'],
            'straight' => ['required', 'string', 'max:255'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ], [
            'dateofbirth.before_or_equal' => 'Je moet minstens 18 jaar oud zijn om je te registreren.',
        ]);

        // Pas de validatie toe
        $validated = $validator->validate();

        $user = User::create([
            'firstname' => $validated['firstname'],
            'insertion' => $validated['insertion'],
            'lastname' => $validated['lastname'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $user->profile()->create([
            'city' => $validated['city'],
            'phone_number' => $validated['phonenumber'],
            'date_of_birth' => $validated['dateofbirth'],
            'gender' => $validated['gender'],
            'straight' => $validated['straight'],
        ]);

        return $user;
    }
}

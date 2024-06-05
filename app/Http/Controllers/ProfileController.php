<?php

namespace App\Http\Controllers;

use App\Models\User;

class ProfileController extends Controller
{
    public function show($user = null)
    {
        $user = User::findOrFail($user ?? auth()->id());

        return view('profile.userProfile', ['user' => $user]);
    }
}

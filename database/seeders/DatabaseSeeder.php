<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(1)->create([
            'firstname' => 'Test User',
            'email' => 'test@example.com',
        ])->each(function ($user) {
            $user->profile()->save(\App\Models\Profile::factory()->make());
        });

        \App\Models\User::factory(1)->admin()->create([
            'firstname' => 'Test Admin',
            'email' => 'admin@digidate.nl',
        ]);

        \App\Models\User::factory(100)->create();

        \App\Models\Tag::factory(100)->create();
    }
}

<?php

namespace Database\Factories;

use App\Models\Profile;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProfileFactory extends Factory
{
    protected $model = Profile::class;

    public function definition(): array
    {
        return [
            'phone_number' => $this->faker->e164PhoneNumber,
            'bio' => $this->faker->sentence(5),
            'gender' => $this->faker->boolean,
            'straight' => $this->faker->boolean,
            'city' => $this->faker->city,
            'date_of_birth' => $this->faker->dateTimeBetween('-100 years', '-18 years'),
        ];
    }
}

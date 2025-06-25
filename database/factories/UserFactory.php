<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use App\Enums\UserType;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        $memberId = strtoupper($this->faker->bothify('??#######'));
        return [
            'first_name' => $this->faker->firstName,
            'middle_name' => $this->faker->optional()->firstName,
            'last_name' => $this->faker->lastName,
            'extension_name' => $this->faker->optional()->suffix,
            'email' => $this->faker->unique()->safeEmail,
            'contact_number' => $this->faker->unique()->phoneNumber,
            'user_type' => 'Player',
            'password' => Hash::make($memberId),
        ];
    }
}

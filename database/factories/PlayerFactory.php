<?php

namespace Database\Factories;

use App\Models\Player;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\Gender;
use App\Enums\CivilStatus;
use App\Enums\BeltLevel;
use App\Enums\Religion;

class PlayerFactory extends Factory
{
    protected $model = Player::class;

    public function definition(): array
    {
        return [
            'member_id' => $this->faker->unique()->uuid,
            'pta_id' => $this->faker->optional()->uuid,
            'ncc_id' => $this->faker->optional()->uuid,
            'birth_date' => $this->faker->date(),
            'gender' => $this->faker->randomElement(['Male', 'Female']),
            'civil_status' => $this->faker->randomElement(CivilStatus::cases())->value,
            'belt_level' => $this->faker->randomElement(BeltLevel::cases())->value,
            'religion' => $this->faker->randomElement(Religion::cases())->value,
            'province_code' => 837,
            'municipality_code' => 83703,
            'brgy_code' => 83703005,
        ];
    }
}

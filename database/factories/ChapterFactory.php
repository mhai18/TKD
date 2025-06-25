<?php

namespace Database\Factories;

use App\Models\Chapter;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChapterFactory extends Factory
{
    protected $model = Chapter::class;

    public function definition(): array
    {
        return [
            'chapter_name' => $this->faker->company,
            'date_started' => $this->faker->date(),
            'province_code' => 837,
            'municipality_code' => 83703,
            'brgy_code' => 83703005,
        ];
    }
}

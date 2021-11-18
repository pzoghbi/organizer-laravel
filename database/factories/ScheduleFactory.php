<?php

namespace Database\Factories;

use App\Models\Schedule;
use Illuminate\Database\Eloquent\Factories\Factory;

class ScheduleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Schedule::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => \App\Models\User::all()->random()->id,
            'name' => $this->faker->locale(),
            'start' => $this->faker->dateTimeBetween('now', '+1 month'),
            'end' => $this->faker->dateTimeBetween('+1 month', '+10 months'),
            'is_active' => $this->faker->boolean()
        ];
    }
}

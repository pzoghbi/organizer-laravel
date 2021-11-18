<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class TaskFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Task::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user = \App\Models\User::all()->random();
        return [
            'user_id' => $user->id,
            'title' => $this->faker->jobTitle(),
            'details' => $this->faker->text(),
            'subject_id' => \App\Models\Subject::where('user_id', $user->id)->get()->random()->id,
            'type' => Arr::random(['Assignment', 'Exam', 'Reminder']),
            'datetime' => $this->faker->date(),
            'active' => $this->faker->boolean()
        ];
    }
}

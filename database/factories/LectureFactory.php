<?php

namespace Database\Factories;

use App\Models\Lecture;
use http\Client\Curl\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class LectureFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Lecture::class;

    /**
     * Define the model's default state.
     *
     * @return array
     * @throws \Exception
     */
    public function definition()
    {
        $user = \App\Models\User::all()->random();
        $start = $this->faker->time('H:i', '19:00');
        return [
            'schedule_id' => \App\Models\Schedule::where('user_id', $user->id)->get()->random()->id,
            'subject_id' => \App\Models\Subject::where('user_id', $user->id)->get()->random()->id,
            'day' => random_int(0, 5),
            'start' => $start,
            'end' => date_create(strtotime($start . '+1 hour')),
            'room' => $this->faker->text(5)
        ];
    }
}

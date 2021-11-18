<?php

namespace Database\Factories;

use App\Models\Material;
use Illuminate\Database\Eloquent\Factories\Factory;

class MaterialFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Material::class;

    /**
     * Define the model's default state.
     *
     * @return array
     * @throws \Exception
     */
    public function definition()
    {
        $user = \App\Models\User::all()->random();
        return [
            'path' => $this->faker->filePath(),
            'name' => $this->faker->text(64),
            'details' => $this->faker->realText(),
            'user_id' => $user->id,
            'subject_id' => \App\Models\Subject::where('user_id', $user->id)->get()->random()->id,
            'categories' => \App\Models\Category::where('user_id', $user->id)->get()->random()->id
        ];
    }
}

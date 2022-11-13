<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(1)->create();
        \App\Models\Subject::factory(5)->create();
//        \App\Models\Task::factory(50)->create();
        \App\Models\Schedule::factory(1)->create();
        \App\Models\Lecture::factory(12)->create();
//        \App\Models\Category::factory(10)->create();
//        \App\Models\Material::factory(30)->create();
    }
}

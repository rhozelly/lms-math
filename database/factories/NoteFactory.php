<?php

namespace Database\Factories;

use App\Models\Branch;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


class NoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id'=> User::all()->random(),
            'writer_id'=> User::all()->random(),
            'title'=> Str::random(15),
            'text'=> $this->faker->text(),
            'type'=> $this->faker->randomElement(['regular','out','new']),
            'branch_id'=> Branch::all()->random(),
        ];
    }
}

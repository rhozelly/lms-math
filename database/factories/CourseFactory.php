<?php

namespace Database\Factories;

use App\Models\Branch;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->randomElement(['초등과정','중등과정','고등과정','예비고과정','예비중과정']),
            'student_id' => User::students()->random(),
            'teacher_id' => User::teachers()->random(),
            'branch_id' => Branch::all()->random(),
            'courriculum_id' => $this->faker->randomDigit(),
            'start_day' => $this->faker->unixTime(),
            'end_day' => $this->faker->unixTime(),
            'type' => $this->faker->randomElement(['regual','makeup','free']),
            'tuition' => $this->faker->numberBetween(250000,420000),
            'active' => $this->faker->numberBetween(1,2),
        ];
    }
}

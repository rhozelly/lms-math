<?php

namespace Database\Factories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseDaysTimesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'course_id' => Course::factory(),
            'day1' => $this->faker->numberBetween(0,1),
            'day2' => $this->faker->numberBetween(0,1),
            'day3' => $this->faker->numberBetween(0,1),
            'day4' => $this->faker->numberBetween(0,1),
            'day5' => $this->faker->numberBetween(0,1),
            'day6' => $this->faker->numberBetween(0,1),
            'day7' => $this->faker->numberBetween(0,1),
            'start_time1' => $this->faker->time(),
            'end_time1' => $this->faker->time(),
            'start_time2' => $this->faker->time(),
            'end_time2' => $this->faker->time(),
            'start_time3' => $this->faker->time(),
            'end_time3' => $this->faker->time(),
            'start_time4' => $this->faker->time(),
            'end_time4' => $this->faker->time(),
            'start_time5' => $this->faker->time(),
            'end_time5' => $this->faker->time(),
            'start_time6' => $this->faker->time(),
            'end_time6' => $this->faker->time(),
            'start_time7' => $this->faker->time(),
            'end_time7' => $this->faker->time(),
        ];
    }
}

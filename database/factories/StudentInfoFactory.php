<?php

namespace Database\Factories;

use App\Models\Grade;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class StudentInfoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $schoolNameArr[] = "매현중학교";
        $schoolNameArr[] = "매현초등학교";
        $schoolNameArr[] = "권선고등학교";
        $schoolNameArr[] = "화홍고등학교";
        $schoolNameArr[] = "고반중학교";
        return [
            'user_id' => User::factory(),
            'grade_id' => Grade::all()->random(),
            'school_name' => $this->faker->randomElement($schoolNameArr),
            'parent_name' => $this->faker->name(),
            'parent_phone' => $this->faker->cellPhoneNumber(),
            'address' => $this->faker->metropolitanCity(),
            'first_day' => $this->faker->unixTime(),
            'payment_day' => $this->faker->unixTime(),
            'inflow_path' => $this->faker->domainName(), 
            'etc' => Str::random(10), 
        ];
    }
}

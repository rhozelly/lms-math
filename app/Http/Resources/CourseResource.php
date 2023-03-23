<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Faker\Factory as Faker;
class CourseResource extends JsonResource
{   
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {   
        $faker = Faker::create('App\Models\Course');
        return [
            'id' => $this->id,
            'name' => $this->name,
            'course' => date('Y-m-d',$this->start_day)." ~ ".date('Y-m-d',$this->end_day),
            'student' => isset($this->student)?$this->student:"",
            'teacher' => isset($this->teacher)?$this->teacher:"",
            'branch' => isset($this->branch)?$this->branch:"",
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'start_day' => date('Y-m-d',$this->start_day),
            'end_day' => date('Y-m-d',$this->end_day),
            'days_times' => isset($this->courseDaysTimes)?$this->courseDaysTimes:"",
            'payment_day' => isset($this->student->studentInfo)?date('Y-m-d',$this->student->studentInfo->payment_day):"",
            'tuition' => $this->tuition,
            'active' => $this->active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'totalTask' => $faker->randomElement(['98/110','99/109','120/186','290/320','9/56','122/240']),
            'progress' => $faker->numberBetween(0,100),
            'hours' => $faker->randomElement(['18:42','20:42','120:87','230:10','342:41','12:45']),
        ];
        // return parent::toArray($request);
    }
}

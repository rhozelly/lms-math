<?php

namespace App\Http\Controllers;

use App\Http\Resources\CourseResource;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return CourseResource::collection(Course::orderBy('id','desc')->get());
        // return CourseResource::collection(Course::all());
        // return Course::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return Course::create($request->all());
        $course = Course::create([
            'name' => $request->input('name'),
            'student_id' => $request->input('student_id'),
            'teacher_id' => $request->input('teacher_id'),
            'branch_id' => $request->input('branch_id'),
            'courriculum_id' => $request->input('courriculum_id'),
            'start_day' => $request->input('start_day'),
            'end_day' => $request->input('end_day'),
            'type' => $request->input('type'),
            'tuition' => $request->input('tuition'),
            'active' => $request->input('active'),
        ]);
        
        $course->courseDaysTimes()->create([
            'day1' => $request->input('day1'),
            'day2' => $request->input('day2'),
            'day3' => $request->input('day3'),
            'day4' => $request->input('day4'),
            'day5' => $request->input('day5'),
            'day6' => $request->input('day6'),
            'day7' => $request->input('day7'),
            'start_time1' => $request->input('start_time1'),
            'end_time1' => $request->input('end_time1'),
            'start_time2' => $request->input('start_time2'),
            'end_time2' => $request->input('end_time2'),
            'start_time3' => $request->input('start_time3'),
            'end_time3' => $request->input('end_time3'),
            'start_time4' => $request->input('start_time4'),
            'end_time4' => $request->input('end_time4'),
            'start_time5' => $request->input('start_time5'),
            'end_time5' => $request->input('end_time5'),
            'start_time6' => $request->input('start_time6'),
            'end_time6' => $request->input('end_time6'),
            'start_time7' => $request->input('start_time7'),
            'end_time7' => $request->input('end_time7'),
        ]);

        $course->studentInfo()->update([
            'payment_day' => $request->input('payment_day'),
        ]);
        
        $course->courseDaysTimes;
        return $course;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        return $course;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {
        // return $course->update($request->all());
        $course->update([
            'name' => $request->input('name'),
            'student_id' => $request->input('student_id'),
            'teacher_id' => $request->input('teacher_id'),
            'branch_id' => $request->input('branch_id'),
            'courriculum_id' => $request->input('courriculum_id'),
            'start_day' => $request->input('start_day'),
            'end_day' => $request->input('end_day'),
            'type' => $request->input('type'),
            'tuition' => $request->input('tuition'),
            'active' => $request->input('active'),
        ]);

        $course->courseDaysTimes()->update([
            'day1' => $request->input('day1'),
            'day2' => $request->input('day2'),
            'day3' => $request->input('day3'),
            'day4' => $request->input('day4'),
            'day5' => $request->input('day5'),
            'day6' => $request->input('day6'),
            'day7' => $request->input('day7'),
            'start_time1' => $request->input('start_time1'),
            'end_time1' => $request->input('end_time1'),
            'start_time2' => $request->input('start_time2'),
            'end_time2' => $request->input('end_time2'),
            'start_time3' => $request->input('start_time3'),
            'end_time3' => $request->input('end_time3'),
            'start_time4' => $request->input('start_time4'),
            'end_time4' => $request->input('end_time4'),
            'start_time5' => $request->input('start_time5'),
            'end_time5' => $request->input('end_time5'),
            'start_time6' => $request->input('start_time6'),
            'end_time6' => $request->input('end_time6'),
            'start_time7' => $request->input('start_time7'),
            'end_time7' => $request->input('end_time7'),
        ]);

        $course->studentInfo()->update([
            'payment_day' => $request->input('payment_day'),
        ]);
        
        $course->courseDaysTimes;
        return $course;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        $course->courseDaysTimes()->delete();
        return $course->delete();
    }

    public function list($user_id)
    {
        return CourseResource::collection(Course::where('student_id',$user_id)->get());
    }
}

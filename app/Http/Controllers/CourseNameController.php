<?php

namespace App\Http\Controllers;

use App\Models\CourseName;
use Illuminate\Http\Request;

class CourseNameController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return CourseName::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return CourseName::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CourseName  $courseName
     * @return \Illuminate\Http\Response
     */
    public function show(CourseName $courseName)
    {
        return $courseName;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CourseName  $courseName
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CourseName $courseName)
    {
        return $courseName->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CourseName  $courseName
     * @return \Illuminate\Http\Response
     */
    public function destroy(CourseName $courseName)
    {
        $courseName->delete();
    }
}

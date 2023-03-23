<?php

namespace App\Http\Controllers;

use App\Models\CourseLog;
use Illuminate\Http\Request;

class CourseLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return CourseLog::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return CourseLog::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CourseLog  $courseLog
     * @return \Illuminate\Http\Response
     */
    public function show(CourseLog $courseLog)
    {
        return $courseLog;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CourseLog  $courseLog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CourseLog $courseLog)
    {
        return $courseLog->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CourseLog  $courseLog
     * @return \Illuminate\Http\Response
     */
    public function destroy(CourseLog $courseLog)
    {
        return $courseLog->detele();
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\CoursePreset;
use Illuminate\Http\Request;

class CoursePresetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return CoursePreset::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return CoursePreset::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CoursePreset  $coursePreset
     * @return \Illuminate\Http\Response
     */
    public function show(CoursePreset $coursePreset)
    {
        return $coursePreset;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CoursePreset  $coursePreset
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CoursePreset $coursePreset)
    {
        $coursePreset->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CoursePreset  $coursePreset
     * @return \Illuminate\Http\Response
     */
    public function destroy(CoursePreset $coursePreset)
    {
        return $coursePreset->delete();
    }
}

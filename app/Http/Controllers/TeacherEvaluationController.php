<?php

namespace App\Http\Controllers;

use App\Models\TeacherEvaluation;
use Illuminate\Http\Request;

class TeacherEvaluationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return TeacherEvaluation::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return TeacherEvaluation::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TeacherEvaluation  $teacherEvaluation
     * @return \Illuminate\Http\Response
     */
    public function show(TeacherEvaluation $teacherEvaluation)
    {
        return $teacherEvaluation;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TeacherEvaluation  $teacherEvaluation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TeacherEvaluation $teacherEvaluation)
    {
        return $teacherEvaluation->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TeacherEvaluation  $teacherEvaluation
     * @return \Illuminate\Http\Response
     */
    public function destroy(TeacherEvaluation $teacherEvaluation)
    {
        return $teacherEvaluation->delete();
    }
}

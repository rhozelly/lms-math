<?php

namespace App\Http\Controllers;

use App\Models\StudentStatusLog;
use Illuminate\Http\Request;

class StudentStatusLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return StudentStatusLog::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return StudentStatusLog::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StudentStatusLog  $studentStatusLog
     * @return \Illuminate\Http\Response
     */
    public function show(StudentStatusLog $studentStatusLog)
    {
        return $studentStatusLog;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StudentStatusLog  $studentStatusLog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StudentStatusLog $studentStatusLog)
    {
        return $studentStatusLog->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StudentStatusLog  $studentStatusLog
     * @return \Illuminate\Http\Response
     */
    public function destroy(StudentStatusLog $studentStatusLog)
    {
        return $studentStatusLog->delete();
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\QualitativeEvaluation;
use Illuminate\Http\Request;

class QualitativeEvaluationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return QualitativeEvaluation::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return QualitativeEvaluation::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\QualitativeEvaluation  $qualitativeEvaluation
     * @return \Illuminate\Http\Response
     */
    public function show(QualitativeEvaluation $qualitativeEvaluation)
    {
        return $qualitativeEvaluation;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\QualitativeEvaluation  $qualitativeEvaluation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, QualitativeEvaluation $qualitativeEvaluation)
    {
        return $qualitativeEvaluation->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\QualitativeEvaluation  $qualitativeEvaluation
     * @return \Illuminate\Http\Response
     */
    public function destroy(QualitativeEvaluation $qualitativeEvaluation)
    {
        return $qualitativeEvaluation->delete();
    }
}

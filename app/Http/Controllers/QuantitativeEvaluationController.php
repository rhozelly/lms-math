<?php

namespace App\Http\Controllers;

use App\Models\QuantitativeEvaluation;
use Illuminate\Http\Request;

class QuantitativeEvaluationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return QuantitativeEvaluation::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return QuantitativeEvaluation::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\QuantitativeEvaluation  $quantitativeEvaluation
     * @return \Illuminate\Http\Response
     */
    public function show(QuantitativeEvaluation $quantitativeEvaluation)
    {
        return $quantitativeEvaluation;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\QuantitativeEvaluation  $quantitativeEvaluation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, QuantitativeEvaluation $quantitativeEvaluation)
    {
        return $quantitativeEvaluation->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\QuantitativeEvaluation  $quantitativeEvaluation
     * @return \Illuminate\Http\Response
     */
    public function destroy(QuantitativeEvaluation $quantitativeEvaluation)
    {
        return $quantitativeEvaluation->delete();
    }
}

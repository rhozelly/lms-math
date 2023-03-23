<?php

namespace App\Http\Controllers;

use App\Models\Tuition;
use Illuminate\Http\Request;

class TuitionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Tuition::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return Tuition::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tuition  $tuition
     * @return \Illuminate\Http\Response
     */
    public function show(Tuition $tuition)
    {
        return $tuition;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tuition  $tuition
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tuition $tuition)
    {
        return $tuition->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tuition  $tuition
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tuition $tuition)
    {
        return $tuition->delete();
    }
}

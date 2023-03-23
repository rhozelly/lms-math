<?php

namespace App\Http\Controllers;

use App\Http\Resources\NoteResource;
use App\Models\Note;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return [
            'total' => Note::all()->count(),
            'noteList' => NoteResource::collection(Note::orderBy('created_at','desc')->get()),
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $writer_id = Auth::user()->id;
        
        return Note::create([
            'writer_id' => $writer_id,
            'user_id' => $request->input('user_id'),
            'title' => $request->input('title'),
            'text' => $request->input('text'),
            'type' => $request->input('type'),
            'branch_id' => $request->input('branch_id'),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function show(Note $note)
    {
        return $note;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Note $note)
    {
        return $note->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function destroy(Note $note)
    {
        return $note->delete();
    }

    public function list($user_id)
    {
        return Note::where('user_id',$user_id)->get();
    }
}

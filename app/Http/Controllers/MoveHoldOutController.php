<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Note;
use App\Models\StudentStatusLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MoveHoldOutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $status = $request->input('status');
        switch ($status) {
            case 'move_normal':
            case 'move_issue':
                    $this->move($request);
                break;
            case 'hold':
            case 'out':
                $this->holdOut($request);
            break;
            default: break;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    private function move(Request $request)
    {   
        //수업 업데이트
        $course = Course::find($request->input('course_id'));
        $course->update([
            'teacher_id' => $request->input('new_teacher_id'),
        ]);
        // 상태 없데이트 type move, hold, out
        $this->createStatusLog($request);
        // 관리자 노트에 기록하기
        $this->createNote($request);
    }

    private function holdOut(Request $request)
    {   
        //수업 업데이트
        $course = Course::find($request->input('course_id'));
        $course->update([
            'active' => 0,
        ]);
        // 상태 없데이트 type move, hold, out
        $this->createStatusLog($request);
        // 관리자 노트에 기록하기
        $this->createNote($request);
    }

    private function createStatusLog(Request $request)
    {
        StudentStatusLog::create([
            'user_id' => $request->input('user_id'),
            'course_id' => $request->input('course_id'),
            'old_teacher_id' => $request->input('old_teacher_id'),
            'new_teacher_id' => $request->input('new_teacher_id'),
            'status' => $request->input('status'),
            'return_day' => $request->input('return_day'),
        ]);
    }

    private function createNote(Request $request)
    {
        $writer_id = Auth::user()->id;

        $status = $request->input('status');
        $type  = "-";
        $title = "";
        if($status == 'move_normal'):
            $type = "정산전반";
        elseif($status == 'move_issue'):
            $type = "이슈전반";
        elseif($status == 'hold'):
            $type = "홀드";
        elseif($status == 'out'):
            $type = "퇴원";
        endif;
        
        $title = "[{$type}] ";

        Note::create([
            'user_id' =>  $request->input('user_id'),
            'writer_id' =>  $writer_id,
            'title' =>  $title.$request->input('title'),
            'text' =>  $request->input('text'),
            'type' =>  $type,
            'branch_id' =>  $request->input('branch_id'),
        ]);
    }

}

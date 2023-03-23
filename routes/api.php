<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseLogController;
use App\Http\Controllers\CoursePresetController;
use App\Http\Controllers\CurriculumController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\QualitativeEvaluationController;
use App\Http\Controllers\QuantitativeEvaluationController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\StudentStatusLogController;
use App\Http\Controllers\TeacherEvaluationController;
use App\Http\Controllers\TuitionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CourseNameController;
use App\Http\Controllers\MoveHoldOutController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/phpinfo', function(){
    return phpinfo();
});

Route::post('/register', [RegisteredUserController::class,'store']);

//유저 정보 가져오기 테스트
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    $user = $request->user();
    $user->branch;
    $user->studentInfo;
    $user->role->ability = json_decode($user->role->ability);
    return $user;
});

//토큰 보기
Route::middleware('auth:sanctum')->get('tokens',function(Request $request){
    return $request->user()->tokens()->get();
});

//토큰지우기
Route::middleware('auth:sanctum')->get('tokens/delete',function(Request $request){
    return $request->user()->tokens()->delete();
});

//유저컨트롤러 테스트
Route::middleware('auth:sanctum')->get('/users',[UserController::class, 'index']);
// Route::get('/users',[UserController::class, 'index'])->middleware('web');
//유저 정보 변경
Route::put('/users/{user}',[UserController::class, 'update']); 
//비밀번호 변경
Route::put('/users/{user}/password',[UserController::class, 'passwordUpdate']); 

//특정 회원 가져오기
Route::get('/users/{user}',[UserController::class, 'show']); 

//노트 생성
Route::middleware('auth:sanctum')->post('/note',[NoteController::class, 'store']); 
//노트 리스트
Route::middleware('auth:sanctum')->get('/notes',[NoteController::class, 'index']); 
//특정 회원 노트 리스트
Route::middleware('auth:sanctum')->get('/notes/{user_id}',[NoteController::class, 'list']); 
//노트 읽기
Route::middleware('auth:sanctum')->get('/note/{note}',[NoteController::class, 'show']); 
//노트 수정
Route::middleware('auth:sanctum')->put('/note/{note}',[NoteController::class, 'update']); 
//노트 삭제
Route::middleware('auth:sanctum')->delete('/note/{note}',[NoteController::class, 'destroy']); 

//회사 생성
Route::middleware('auth:sanctum')->post('/company',[CompanyController::class, 'store']); 
//회사 리스트
Route::middleware('auth:sanctum')->get('/companies',[CompanyController::class, 'index']); 
//회사 읽기
Route::middleware('auth:sanctum')->get('/company/{company}',[CompanyController::class, 'show']); 
//회사 수정
Route::middleware('auth:sanctum')->put('/company/{company}',[CompanyController::class, 'update']); 
//회사 삭제
Route::middleware('auth:sanctum')->delete('/company/{company}',[CompanyController::class, 'destroy']); 

//지사 생성
Route::middleware('auth:sanctum')->post('/branch',[BranchController::class, 'store']); 
//지사 리스트
Route::middleware('auth:sanctum')->get('/branches',[BranchController::class, 'index']); 
//지사 읽기
Route::middleware('auth:sanctum')->get('/branch/{branch}',[BranchController::class, 'show']); 
//지사 수정
Route::middleware('auth:sanctum')->put('/branch/{branch}',[BranchController::class, 'update']); 
//지사 삭제
Route::middleware('auth:sanctum')->delete('/branch/{branch}',[BranchController::class, 'destroy']); 

//출석 생성
Route::middleware('auth:sanctum')->post('/attendance',[AttendanceController::class, 'store']); 
//출석 리스트
Route::middleware('auth:sanctum')->get('/attendances',[AttendanceController::class, 'index']); 
//출석 읽기
Route::middleware('auth:sanctum')->get('/attendance/{attendance}',[AttendanceController::class, 'show']); 
//출석 수정
Route::middleware('auth:sanctum')->put('/attendance/{attendance}',[AttendanceController::class, 'update']); 
//출석 삭제
Route::middleware('auth:sanctum')->delete('/attendance/{attendance}',[AttendanceController::class, 'destroy']); 

//신규&퇴원 생성
Route::middleware('auth:sanctum')->post('/studentStatusLog',[StudentStatusLogController::class, 'store']); 
//신규&퇴원 리스트
Route::middleware('auth:sanctum')->get('/studentStatusLogs',[StudentStatusLogController::class, 'index']); 
//신규&퇴원 읽기
Route::middleware('auth:sanctum')->get('/studentStatusLog/{studentStatusLog}',[StudentStatusLogController::class, 'show']); 
//신규&퇴원 수정
Route::middleware('auth:sanctum')->put('/studentStatusLog/{studentStatusLog}',[StudentStatusLogController::class, 'update']); 
//신규&퇴원 삭제
Route::middleware('auth:sanctum')->delete('/studentStatusLog/{studentStatusLog}',[StudentStatusLogController::class, 'destroy']); 

//역할 생성
Route::middleware('auth:sanctum')->post('/role',[RoleController::class, 'store']); 
//역할 리스트
Route::middleware('auth:sanctum')->get('/roles',[RoleController::class, 'index']); 
//역할 읽기
Route::middleware('auth:sanctum')->get('/role/{role}',[RoleController::class, 'show']); 
//역할 수정
Route::middleware('auth:sanctum')->put('/role/{role}',[RoleController::class, 'update']); 
//역할 삭제
Route::middleware('auth:sanctum')->delete('/role/{role}',[RoleController::class, 'destroy']); 

//수업 생성
Route::middleware('auth:sanctum')->post('/course',[CourseController::class, 'store']); 
//수업 리스트
Route::middleware('auth:sanctum')->get('/courses',[CourseController::class, 'index']); 
//수업 리스트 (특정 회원)
Route::middleware('auth:sanctum')->get('/courses/{user_id}',[CourseController::class, 'list']); 
//수업 읽기
Route::middleware('auth:sanctum')->get('/course/{course}',[CourseController::class, 'show']); 
//수업 수정
Route::middleware('auth:sanctum')->put('/course/{course}',[CourseController::class, 'update']); 
//수업 삭제
Route::middleware('auth:sanctum')->delete('/course/{course}',[CourseController::class, 'destroy']); 

//수업로그 생성
Route::middleware('auth:sanctum')->post('/courseLog',[CourseLogController::class, 'store']); 
//수업로그 리스트
Route::middleware('auth:sanctum')->get('/courseLogs',[CourseLogController::class, 'index']); 
//수업로그 읽기
Route::middleware('auth:sanctum')->get('/courseLog/{courseLog}',[CourseLogController::class, 'show']); 
//수업로그 수정
Route::middleware('auth:sanctum')->put('/courseLog/{courseLog}',[CourseLogController::class, 'update']); 
//수업로그 삭제
Route::middleware('auth:sanctum')->delete('/courseLog/{courseLog}',[CourseLogController::class, 'destroy']); 

//과정 프리셋 생성
Route::middleware('auth:sanctum')->post('/coursePreset',[CoursePresetController::class, 'store']); 
//과정 프리셋 리스트
Route::middleware('auth:sanctum')->get('/coursePresets',[CoursePresetController::class, 'index']); 
//과정 프리셋 읽기
Route::middleware('auth:sanctum')->get('/coursePreset/{coursePreset}',[CoursePresetController::class, 'show']); 
//과정 프리셋 수정
Route::middleware('auth:sanctum')->put('/coursePreset/{coursePreset}',[CoursePresetController::class, 'update']); 
//과정 프리셋 삭제
Route::middleware('auth:sanctum')->delete('/coursePreset/{coursePreset}',[CoursePresetController::class, 'destroy']); 

//커리큘럼 생성
Route::middleware('auth:sanctum')->post('/curriculum',[CurriculumController::class, 'store']); 
//커리큘럼 리스트
Route::middleware('auth:sanctum')->get('/curriculums',[CurriculumController::class, 'index']); 
//커리큘럼 읽기
Route::middleware('auth:sanctum')->get('/curriculum/{curriculum}',[CurriculumController::class, 'show']); 
//커리큘럼 수정
Route::middleware('auth:sanctum')->put('/curriculum/{curriculum}',[CurriculumController::class, 'update']); 
//커리큘럼 삭제
Route::middleware('auth:sanctum')->delete('/curriculum/{curriculum}',[CurriculumController::class, 'destroy']); 

//수걍료 생성
Route::middleware('auth:sanctum')->post('/tuition',[TuitionController::class, 'store']); 
//수걍료 리스트
Route::middleware('auth:sanctum')->get('/tuitions',[TuitionController::class, 'index']); 
//수걍료 읽기
Route::middleware('auth:sanctum')->get('/tuition/{tuition}',[TuitionController::class, 'show']); 
//수걍료 수정
Route::middleware('auth:sanctum')->put('/tuition/{tuition}',[TuitionController::class, 'update']); 
//수걍료 삭제
Route::middleware('auth:sanctum')->delete('/tuition/{tuition}',[TuitionController::class, 'destroy']); 

//수걍료 생성
Route::middleware('auth:sanctum')->post('/grade',[GradeController::class, 'store']); 
//수걍료 리스트
Route::middleware('auth:sanctum')->get('/grades',[GradeController::class, 'index']); 
//수걍료 읽기
Route::middleware('auth:sanctum')->get('/grade/{grade}',[GradeController::class, 'show']); 
//수걍료 수정
Route::middleware('auth:sanctum')->put('/grade/{grade}',[GradeController::class, 'update']); 
//수걍료 삭제
Route::middleware('auth:sanctum')->delete('/grade/{grade}',[GradeController::class, 'destroy']); 

//강사평가 생성
Route::middleware('auth:sanctum')->post('/teacherEvaluation',[TeacherEvaluationController::class, 'store']); 
//강사평가 리스트
Route::middleware('auth:sanctum')->get('/teacherEvaluations',[TeacherEvaluationController::class, 'index']); 
//강사평가 읽기
Route::middleware('auth:sanctum')->get('/teacherEvaluation/{teacherEvaluation}',[TeacherEvaluationController::class, 'show']); 
//강사평가 수정
Route::middleware('auth:sanctum')->put('/teacherEvaluation/{teacherEvaluation}',[TeacherEvaluationController::class, 'update']); 
//강사평가 삭제
Route::middleware('auth:sanctum')->delete('/teacherEvaluation/{teacherEvaluation}',[TeacherEvaluationController::class, 'destroy']); 

//정성평가 생성
Route::middleware('auth:sanctum')->post('/qualitativeEvaluation',[QualitativeEvaluationController::class, 'store']); 
//정성평가 리스트
Route::middleware('auth:sanctum')->get('/qualitativeEvaluations',[QualitativeEvaluationController::class, 'index']); 
//정성평가 읽기
Route::middleware('auth:sanctum')->get('/qualitativeEvaluation/{qualitativeEvaluation}',[QualitativeEvaluationController::class, 'show']); 
//정성평가 수정
Route::middleware('auth:sanctum')->put('/qualitativeEvaluation/{qualitativeEvaluation}',[QualitativeEvaluationController::class, 'update']); 
//정성평가 삭제
Route::middleware('auth:sanctum')->delete('/qualitativeEvaluation/{qualitativeEvaluation}',[QualitativeEvaluationController::class, 'destroy']); 

//정량평가 생성
Route::middleware('auth:sanctum')->post('/quantitativeEvaluation',[QuantitativeEvaluationController::class, 'store']); 
//정량평가 리스트
Route::middleware('auth:sanctum')->get('/quantitativeEvaluations',[QuantitativeEvaluationController::class, 'index']); 
//정량평가 읽기
Route::middleware('auth:sanctum')->get('/quantitativeEvaluation/{quantitativeEvaluation}',[QuantitativeEvaluationController::class, 'show']); 
//정량평가 수정
Route::middleware('auth:sanctum')->put('/quantitativeEvaluation/{quantitativeEvaluation}',[QuantitativeEvaluationController::class, 'update']); 
//정량평가 삭제
Route::middleware('auth:sanctum')->delete('/quantitativeEvaluation/{quantitativeEvaluation}',[QuantitativeEvaluationController::class, 'destroy']); 

//급여 생성
Route::middleware('auth:sanctum')->post('/salary',[SalaryController::class, 'store']); 
//급여 리스트
Route::middleware('auth:sanctum')->get('/salarys',[SalaryController::class, 'index']); 
//급여 읽기
Route::middleware('auth:sanctum')->get('/salary/{salary}',[SalaryController::class, 'show']); 
//급여 수정
Route::middleware('auth:sanctum')->put('/salary/{salary}',[SalaryController::class, 'update']); 
//급여 삭제
Route::middleware('auth:sanctum')->delete('/salary/{salary}',[SalaryController::class, 'destroy']); 

//수업이름 생성
Route::middleware('auth:sanctum')->post('/courseName',[CourseNameController::class, 'store']); 
//수업이름 리스트
Route::middleware('auth:sanctum')->get('/courseNames',[CourseNameController::class, 'index']); 
//수업이름 읽기
Route::middleware('auth:sanctum')->get('/courseName/{courseName}',[CourseNameController::class, 'show']); 
//수업이름 수정
Route::middleware('auth:sanctum')->put('/courseName/{courseName}',[CourseNameController::class, 'update']); 
//수업이름 삭제
Route::middleware('auth:sanctum')->delete('/courseName/{courseName}',[CourseNameController::class, 'destroy']); 

//수업이름 생성
Route::middleware('auth:sanctum')->post('/moveHoldOut',[MoveHoldOutController::class, 'store']); 
//수업이름 리스트
Route::middleware('auth:sanctum')->get('/moveHoldOuts',[MoveHoldOutController::class, 'index']); 
//수업이름 읽기
Route::middleware('auth:sanctum')->get('/moveHoldOut/{moveHoldOut}',[MoveHoldOutController::class, 'show']); 
//수업이름 수정
Route::middleware('auth:sanctum')->put('/moveHoldOut/{moveHoldOut}',[MoveHoldOutController::class, 'update']); 
//수업이름 삭제
Route::middleware('auth:sanctum')->delete('/moveHoldOut/{moveHoldOut}',[MoveHoldOutController::class, 'destroy']); 
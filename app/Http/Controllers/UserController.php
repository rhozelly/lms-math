<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Http\Resources\UserTotalResource;
use App\Models\Course;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        //파라미터 받기
        $itemsPerPage = $request->input('itemsPerPage');
        $sortBy       = $request->input('sortBy');
        $sortDesc     = $request->input('sortDesc');
        $activity     = $request->input('activity');
        $role_id      = $request->input('role_id');
        $branch_id    = $request->input('branch_id');
        $q            = $request->input('q');
        $searchType   = $request->input('searchType');

        //유저 모델 초기화
        $userList = new User();

        //Order By 추가
        if(isset($sortBy)&&isset($sortDesc)){
            $sort       = $sortDesc[0]?'DESC':'ASC';
            $sortByName = ($sortBy[0] == 'fullName')?'name':$sortBy[0];
            $userList   = $userList->orderBy($sortByName,$sort);
        }else{
            $userList   = $userList->orderBy('id','desc');
        }

        $searchField = "name";
        if(isset($searchType)){
            if($searchType == '이름'):
                $searchField = "name";
            elseif($searchType == '전화번호'):
                $searchField = "phone";
            endif;
        }

        //Where 추가
        if(isset($activity)) $userList = $userList->where('activity',(int)$activity);
        if(isset($role_id))  $userList = $userList->where('role_id',(int)$role_id);
        if(isset($branch_id)) $userList = $userList->where('branch_id',(int)$branch_id);
        if(isset($q)&&$q!=="")        $userList = $userList->where($searchField,'like',"%".$q."%");

        //전체 레코드 수 구하기
        $total = $userList->count();

        //페이징 추가
        if(isset($itemsPerPage)) $userList = $userList->paginate($itemsPerPage);
        else $userList = $userList->get();

        $filteredData = UserResource::collection($userList);

        return [
            'total' => $total,
            'filteredData' => $filteredData,
            'userTotal' => [
                ['title'=>'총 사용자','total'=>User::count()],
                User::numOfAdmin(),
                User::numOfTeachers(),
                User::numOfStudents(),
            ],
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {   
        return UserResource::make($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {   
        $request->validate([
            'username' => ['required',Rule::unique(User::class)->ignore($user->id)],
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($user->id),
            ],
        ]);

        $user->update([
            'username' => $request->input('username'),
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'birth' => $request->input('birth'),
            'sex' => $request->input('sex'),
            'branch_id' => $request->input('branch_id'),
            'role_id' => $request->input('role_id'),
            'activity' => (int)$request->input('activity'),
        ]);
        if(isset($user->studentInfo)){
            $user->studentInfo()->update([
                'grade_id' => $request->input('grade_id'),
                'school_name' => $request->input('school_name'),
                'parent_name' => $request->input('parent_name'),
                'parent_phone' => $request->input('parent_phone'),
                'first_day' => $request->input('first_day'),
                'payment_day' => $request->input('payment_day'),
                'address' => $request->input('address'),
                'inflow_path' => $request->input('inflow_path'),
                'etc' => $request->input('etc'),
            ]);
        }else{
            $user->studentInfo()->create([
                'grade_id' => $request->input('grade_id'),
                'school_name' => $request->input('school_name'),
                'parent_name' => $request->input('parent_name'),
                'parent_phone' => $request->input('parent_phone'),
                'first_day' => $request->input('first_day'),
                'payment_day' => $request->input('payment_day'),
                'address' => $request->input('address'),
                'inflow_path' => $request->input('inflow_path'),
                'etc' => $request->input('etc'),
            ]);
        }


        return $user;
    }

    public function passwordUpdate(Request $request, User $user)
    {   
        $new_password = Hash::make($request->input('new_password'));
        $user->update(['password' => $new_password]);
        return $user;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}

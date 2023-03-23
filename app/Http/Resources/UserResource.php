<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'total' => $this->count(),
            'id' => $this->id,
            'fullName' => $this->name,
            'role' => isset($this->role)?$this->role->level:'',
            'role_name' => isset($this->role)?$this->role->name:'',
            'role_id'   => isset($this->role)?(string)$this->role->id:'',
            'username' => $this->username,
            'company' => isset($this->branch->company)?$this->branch->company->name:'',
            'branch' => isset($this->branch)?$this->branch->name:'',
            'branch_id' => isset($this->branch)?(string)$this->branch->id:'',
            'email' => $this->email,
            'birth' => str_replace('-','',$this->birth),
            'phone' => $this->phone,
            'status' => $this->activity,
            'avatar' => '',
            'sex' => $this->sex,
            'grade' => isset($this->studentInfo->grade)?(string)$this->studentInfo->grade->name:'',
            'grade_id' => isset($this->studentInfo->grade)?(string)$this->studentInfo->grade->id:'',
            'school_name' => isset($this->studentInfo)?$this->studentInfo->school_name:'',
            'first_day' => isset($this->studentInfo)?date('Y-m-d',$this->studentInfo->first_day):'',
            'payment_day' => isset($this->studentInfo)?date('Y-m-d',$this->studentInfo->payment_day):'',
            'parent_name' => isset($this->studentInfo)?$this->studentInfo->parent_name:'',
            'parent_phone' => isset($this->studentInfo)?$this->studentInfo->parent_phone:'',
            'address' => isset($this->studentInfo)?$this->studentInfo->address:'',
            'inflow_path' => isset($this->studentInfo)?$this->studentInfo->inflow_path:'',
            'etc' => isset($this->studentInfo)?$this->studentInfo->etc:'',
            
            'contact' => $this->phone,
            'country' => '한국',
            // 'company' => '유에듀케이션',
        ];
        // return parent::toArray($request);
        // return User::orderBy('id','desc')->get();
        // return User::all();
        // $userTest = User::all()->role()->where('name','실장');
        // $userTest = User::students();
        // $role = Role::where('name','강사')->first();
        // $role = Role::where('name','학생')->first();
        // error_log($userTest);
        // return $role->students;
        // return $role->teachers;
        // $courses = Course::all();
        // $arr = array();
        // foreach($courses as $course){
        //     $student = $course->student;
        //     $teacher = $course->teacher;
        //     $student->role->ability=json_decode($student->role->ability);
        //     $teacher->role->ability=json_decode($teacher->role->ability);
        //     $student->branch;
        //     // $student->company;
        //     $teacher->branch;
        //     // $teacher->company;
        //     $student->grade;
        //     $teacher->grade;
        //     $arr[] = array($course);
        // }
        // return $arr;
        // return $userTest->random();
        // return Auth::user();
    }
}

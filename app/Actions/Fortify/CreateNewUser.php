<?php

namespace App\Actions\Fortify;

use App\Models\StudentInfo;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'username' => ['required',Rule::unique(User::class)],
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
        ])->validate();

        $user = User::create([
            'username' => $input['username'],
            'name' => $input['name'],
            'email' => $input['email'],
            'phone' => $input['phone'],
            'sex' => $input['sex'],
            'birth' => $input['birth'],
            'branch_id' => $input['branch_id'],
            'role_id' => $input['role_id'],
            'join_at' => now(),
            'activity' => true,
            'password' => Hash::make($input['password']),
        ]);

        $user->studentInfo()->create([
            'school_name'   => isset($input['school_name'])  ? $input['school_name']:'',
            'parent_name'   => isset($input['parent_name'])  ? $input['parent_name']:'',
            'parent_phone'  => isset($input['parent_phone']) ? $input['parent_phone']:'',
            'payment_day'   => isset($input['payment_day'])  ? $input['payment_day']:'',
            'first_day'     => isset($input['first_day'])    ? $input['first_day']:'',
            'address'       => isset($input['address'])      ? $input['address']:'',
            'inflow_path'   => isset($input['inflow_path'])  ? $input['inflow_path']:'',
            'etc'           => isset($input['etc'])          ? $input['etc']:'',
            'grade_id'      => isset($input['grade_id'])     ? $input['grade_id']:'',
        ]);

        return $user;
    }
}

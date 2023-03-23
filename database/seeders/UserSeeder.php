<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'username' => 'kuzco92',
            'name' => '이강준',
            'email' => 'kuzco92@gmail.com',
            'password' => Hash::make('123123123'),
            'phone' => "010-0000-0000",
            'birth' => "19920915",
            'sex' => "m",
            'branch_id' => 1,
            'role_id' => 1,
            'activity' => 1
        ]);
    }
}

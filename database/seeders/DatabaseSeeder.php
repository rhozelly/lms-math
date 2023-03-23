<?php

namespace Database\Seeders;

use App\Models\CourseName;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class, GradeSeeder::class, CompanySeeder::class, BranchSeeder::class, RoleSeeder::class, TuitionSeeder::class, CourseNameSeeder::class,
        ]);
        \App\Models\User::factory(50)->has(\App\Models\StudentInfo::factory())->create(); \App\Models\Course::factory(300)->has(\App\Models\CourseDaysTimes::factory())->create(); \App\Models\Note::factory(100)->create();
        // \App\Models\User::factory(50)->create();        
    }
}

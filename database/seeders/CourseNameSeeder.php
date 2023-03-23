<?php

namespace Database\Seeders;

use App\Models\CourseName;
use Illuminate\Database\Seeder;

class CourseNameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            ['branch_id'=>'1', 'name'=>'초등과정'],
            ['branch_id'=>'1', 'name'=>'중등과정'],
            ['branch_id'=>'1', 'name'=>'고등과정'],
            ['branch_id'=>'1', 'name'=>'특별과정'],
        ];
        foreach($datas as $data){
            CourseName::create($data);
        }
    }
}

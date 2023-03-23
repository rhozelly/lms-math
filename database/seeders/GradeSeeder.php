<?php

namespace Database\Seeders;

use App\Models\Grade;
use Illuminate\Database\Seeder;

class GradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        // $datas = array('id'=>'1','name'=>'초등학교 1학년');
        $datas[] = array('id'=>'1','name'=>'초등학교 1학년');
        $datas[] = array('id'=>'2','name'=>'초등학교 2학년');
        $datas[] = array('id'=>'3','name'=>'초등학교 3학년');
        $datas[] = array('id'=>'4','name'=>'초등학교 4학년');
        $datas[] = array('id'=>'5','name'=>'초등학교 5학년');
        $datas[] = array('id'=>'6','name'=>'초등학교 6학년');
        $datas[] = array('id'=>'7','name'=>'중학교 1학년');
        $datas[] = array('id'=>'8','name'=>'중학교 2학년');
        $datas[] = array('id'=>'9','name'=>'중학교 3학년');
        $datas[] = array('id'=>'10','name'=>'고등학교 1학년');
        $datas[] = array('id'=>'11','name'=>'고등학교 2학년');
        $datas[] = array('id'=>'12','name'=>'고등학교 3학년');
        foreach ($datas as $data) {
            Grade::create($data);
        }
        // Grade::create($datas);

        // Grade::create(
        //     ['id'=>'1','name'=>'초등학교 1학년'],
        //     ['id'=>'2','name'=>'초등학교 2학년'],
        //     ['id'=>'3','name'=>'초등학교 3학년'],
        //     ['id'=>'4','name'=>'초등학교 4학년'],
        //     ['id'=>'5','name'=>'초등학교 5학년'],
        //     ['id'=>'6','name'=>'초등학교 6학년'],
        //     ['id'=>'7','name'=>'중학교 1학년'],
        //     ['id'=>'8','name'=>'중학교 2학년'],
        //     ['id'=>'9','name'=>'중학교 3학년'],
        //     ['id'=>'10','name'=>'고등학교 1학년'],
        //     ['id'=>'11','name'=>'고등학교 학년'],
        //     ['id'=>'12','name'=>'고등학교 3학년'],
        // );
    }
}

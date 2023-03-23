<?php

namespace Database\Seeders;

use App\Models\Tuition;
use Illuminate\Database\Seeder;

class TuitionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas[] = array('price'=>250000,'grade_id'=>1); //초1
        $datas[] = array('price'=>250000,'grade_id'=>2); //초2
        $datas[] = array('price'=>250000,'grade_id'=>3); //초3
        $datas[] = array('price'=>250000,'grade_id'=>4); //초4
        $datas[] = array('price'=>270000,'grade_id'=>5); //초5 
        $datas[] = array('price'=>270000,'grade_id'=>6); //초6
        $datas[] = array('price'=>330000,'grade_id'=>7); //중1
        $datas[] = array('price'=>330000,'grade_id'=>8); //중2
        $datas[] = array('price'=>330000,'grade_id'=>9); //중3
        $datas[] = array('price'=>380000,'grade_id'=>10); //고1
        $datas[] = array('price'=>400000,'grade_id'=>11); //고2
        $datas[] = array('price'=>420000,'grade_id'=>12); //고3
        foreach ($datas as $data) {
            Tuition::create($data);
        }
    }
}

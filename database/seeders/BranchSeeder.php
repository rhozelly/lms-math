<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas[] = array('name'=>'권선관','company_id'=>1);
        $datas[] = array('name'=>'매탄관','company_id'=>1);
        $datas[] = array('name'=>'아이파크관','company_id'=>1);
        $datas[] = array('name'=>'청계관','company_id'=>1);
        $datas[] = array('name'=>'정자관','company_id'=>1);
        foreach ($datas as $data) {
            Branch::create($data);
        }
    }
}

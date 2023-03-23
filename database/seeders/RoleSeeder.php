<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $datas[] = array('name'=>'마스터','level'=>'admin','ability'=>'[{"action": "manage","subject": "all"}]');
        // $datas[] = array('name'=>'관리자','level'=>'admin','ability'=>'[{"action": "manage","subject": "all"}]');
        // $datas[] = array('name'=>'원장','level'=>'admin','ability'=>'[{"action": "manage","subject": "all"}]');
        // $datas[] = array('name'=>'실장','level'=>'admin','ability'=>'[{"action": "manage","subject": "all"}]');
        // $datas[] = array('name'=>'부장','level'=>'admin','ability'=>'[{"action": "manage","subject": "all"}]');
        // $datas[] = array('name'=>'강사','level'=>'admin','ability'=>'[{"action": "manage","subject": "all"}]');
        // $datas[] = array('name'=>'학생','level'=>'admin','ability'=>'[{"action": "manage","subject": "all"}]');
        $datas[] = array('name'=>'마스터','level'=>'admin','ability'=>'[{"action": "manage","subject": "all"}]');
        $datas[] = array('name'=>'관리자','level'=>'admin','ability'=>'[{"action": "admin","subject": "all"}]');
        $datas[] = array('name'=>'원장','level'=>'principal','ability'=>'[{"action": "principal","subject": "all"}]');
        $datas[] = array('name'=>'실장','level'=>'manager','ability'=>'[{"action": "manage","subject": "all"}]');
        $datas[] = array('name'=>'부장','level'=>'manager','ability'=>'[{"action": "manage","subject": "all"}]');
        $datas[] = array('name'=>'강사','level'=>'teacher','ability'=>'[{"action": "teacher","subject": "all"}]');
        $datas[] = array('name'=>'학생','level'=>'student','ability'=>'[{"action": "student","subject": "all"}]');
        foreach ($datas as $data) {
            Role::create($data);
        }
    }
}

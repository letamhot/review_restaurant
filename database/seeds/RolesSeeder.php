<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('roles')->delete();
        \DB::table('roles')->insert(array(
            0 =>
            array(
                'name' => 'Admin',
                'description' => 'Quyền admin',
            ),
            1 =>
            array(
                'name' => 'Mod',
                'description' => 'Quyền Mod',
            ),
            2 =>
            array(
                'name' => 'User',
                'description' => 'Quyền user',
            ),
        ));
    }
}

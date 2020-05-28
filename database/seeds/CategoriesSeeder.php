<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->delete();
        DB::table('categories')->insert(array(
            0 =>
            array(
                'name' => 'Loại Nhà hàng Khác',
                'slug' => Str::slug('oại nhà hàng Khác'),
            ),
            1 =>
            array(
                'name' => 'Nhà hàng Tiệc Cưới',
                'slug' => Str::slug('nhà hàng tiệc cưới'),
            ),
            2 =>
            array(
                'name' => 'Nhà hàng Cà Phê',
                'slug' => Str::slug('nhà hàng hàn quốc'),
            ),
            3 =>
            array(
                'name' => 'Nhà hàng Chay',
                'slug' => Str::slug('nhà hàng chay'),
            ),
            4 =>
            array(
                'name' => 'Nhà hàng mặn',
                'slug' => Str::slug('nhà hàng mặn'),
            ),
            5 =>
            array(
                'name' => 'Nhà hàng Bar',
                'slug' => Str::slug('nhà hàng bar'),
            ),
        ));
    }
}

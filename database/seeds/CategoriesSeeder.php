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
                'name' => 'Nhà hàng Thái Lan',
                'slug' => Str::slug('nhà hàng thái lan'),
            ),
            1 =>
            array(
                'name' => 'Nhà hàng Nhật Bản',
                'slug' => Str::slug('nhà hàng nhật bản'),
            ),
            2 =>
            array(
                'name' => 'Nhà hàng Hàn Quốc',
                'slug' => Str::slug('nhà hàng hàn quốc'),
            ),
            3 =>
            array(
                'name' => 'Nhà hàng Anh',
                'slug' => Str::slug('nhà hàng anh'),
            ),
            4 =>
            array(
                'name' => 'Nhà hàng Mỹ',
                'slug' => Str::slug('nhà hàng mỹ'),
            ),
            5 =>
            array(
                'name' => 'Nhà hàng Hà Lan',
                'slug' => Str::slug('nhà hàng hà lan'),
            ),
            6 =>
            array(
                'name' => 'Nhà hàng Trung Quốc',
                'slug' => Str::slug('nhà hàng trung quốc'),
            ),
            7 =>
            array(
                'name' => 'Nhà hàng Việt Nam',
                'slug' => Str::slug('nhà hàng việt nam'),
            ),
            8 =>
            array(
                'name' => 'Nhà hàng Thụy Sỹ',
                'slug' => Str::slug('nhà hàng thụy sỹ'),
            ),
            9 =>
            array(
                'name' => 'Nhà hàng Đức',
                'slug' => Str::slug('nhà hàng đức'),
            ),
        ));
    }
    
}

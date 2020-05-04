<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('tags')->delete();
        \DB::table('tags')->insert(array(
            0 =>
            array(
                'name' => 'seafood',
                'slug' => Str::slug('seafood'),
            ),
            1 =>
            array(
                'name' => 'bush_meat',
                'slug' => Str::slug('bush meat'),
            ),
            2 =>
            array(
                'name' => 'hamburger',
                'slug' => Str::slug('ham bur ger'),
            ),
            3 =>
            array(
                'name' => 'kimchi',
                'slug' => Str::slug('kim chi'),
            ),
            4 =>
            array(
                'name' => 'Thai_hot_pot',
                'slug' => Str::slug('lẩu thái'),
            ),
            5 =>
            array(
                'name' => 'wine',
                'slug' => Str::slug('rượu vang'),
            ),
            6 =>
            array(
                'name' => 'fastfood',
                'slug' => Str::slug('đồ ăn nhanh'),
            ),
        ));
    
    }
}

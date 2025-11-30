<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Users_addsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'user_id'     => '1',
            'post_code'   => '220-0051',
            'address'     => '神奈川県横浜市西区',
            'building'    => 'マンション１０１',
            'image'       => '1.png'
            ];
        DB::table('users_adds')->insert($param);

        $param = [
            'user_id'     => '2',
            'post_code'   => '220-0051',
            'address'     => '神奈川県横浜市西区',
            'building'    => 'マンション２０１',
            'image'       => '2.png'
            ];
        DB::table('users_adds')->insert($param);

        $param = [
            'user_id'     => '3',
            'post_code'   => '220-0051',
            'address'     => '神奈川県横浜市西区',
            'building'    => 'マンション３０１',
            'image'       => '3.png'
            ];
        DB::table('users_adds')->insert($param);
    }
}

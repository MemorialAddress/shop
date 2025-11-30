<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FavoritesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'item_id'       => '1',
            'user_id'       => '2'
            ];
        DB::table('favorites')->insert($param);

        $param = [
            'item_id'       => '6',
            'user_id'       => '1'
            ];
        DB::table('favorites')->insert($param);

    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PurchasesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'item_id'            => '2',
            'user_id'            => '2',
            'payment_method'     => 'カード支払い',
            'purchase_post_code' => '220-0051',
            'purchase_address'   => '神奈川県横浜市西区',
            'purchase_building'  => 'マンション１０１'
            ];
        DB::table('purchases')->insert($param);

        $param = [
            'item_id'            => '7',
            'user_id'            => '1',
            'payment_method'     => 'コンビニ払い',
            'purchase_post_code' => '220-0051',
            'purchase_address'   => '神奈川県横浜市西区',
            'purchase_building'  => 'マンション２０１'
            ];
        DB::table('purchases')->insert($param);

    }
}

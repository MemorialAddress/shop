<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'user_id'       => '1',
            'item_name'     => '腕時計',
            'brand_name'    => 'Rolax',
            'price'         => '15000',
            'item_describe' => 'スタイリッシュなデザインのメンズ腕時計',
            'category'      => '服飾',
            'condition'     => '良好'
            ];
        DB::table('items')->insert($param);

        $param = [
            'user_id'       => '1',
            'item_name'     => 'HDD',
            'brand_name'    => '西芝',
            'price'         => '5000',
            'item_describe' => '高速で信頼性の高いハードディスク',
            'category'      => '家電',
            'condition'     => '目立った傷や汚れなし'
            ];
        DB::table('items')->insert($param);

        $param = [
            'user_id'       => '1',
            'item_name'     => '玉ねぎ3束',
            'brand_name'    => 'なし',
            'price'         => '300',
            'item_describe' => '新鮮な玉ねぎ3束のセット',
            'category'      => '食品',
            'condition'     => 'やや傷や汚れあり'
            ];
        DB::table('items')->insert($param);

        $param = [
            'user_id'       => '1',
            'item_name'     => '革靴',
            'brand_name'    => '',
            'price'         => '4000',
            'item_describe' => 'クラシックなデザインの革靴',
            'category'      => '服飾',
            'condition'     => '状態が悪い'
            ];
        DB::table('items')->insert($param);

        $param = [
            'user_id'       => '1',
            'item_name'     => 'ノートPC',
            'brand_name'    => '',
            'price'         => '45000',
            'item_describe' => '高性能なノートパソコン',
            'category'      => '家電',
            'condition'     => '良好'
            ];
        DB::table('items')->insert($param);

        $param = [
            'user_id'       => '2',
            'item_name'     => 'マイク',
            'brand_name'    => 'なし',
            'price'         => '8000',
            'item_describe' => '高音質のレコーディング用マイク',
            'category'      => '家電',
            'condition'     => '目立った傷や汚れなし'
            ];
        DB::table('items')->insert($param);

        $param = [
            'user_id'       => '2',
            'item_name'     => 'ショルダーバッグ',
            'brand_name'    => '',
            'price'         => '3500',
            'item_describe' => 'おしゃれなショルダーバッグ',
            'category'      => '服飾',
            'condition'     => 'やや傷や汚れあり'
            ];
        DB::table('items')->insert($param);

        $param = [
            'user_id'       => '2',
            'item_name'     => 'タンブラー',
            'brand_name'    => 'なし',
            'price'         => '500',
            'item_describe' => '使いやすいタンブラー',
            'category'      => '食器',
            'condition'     => '状態が悪い'
            ];
        DB::table('items')->insert($param);

        $param = [
            'user_id'       => '3',
            'item_name'     => 'コーヒーミル',
            'brand_name'    => 'Starbacks',
            'price'         => '4000',
            'item_describe' => '手動のコーヒーミル',
            'category'      => '食器',
            'condition'     => '良好'
            ];
        DB::table('items')->insert($param);

        $param = [
            'user_id'       => '3',
            'item_name'     => 'メイクセット',
            'brand_name'    => '',
            'price'         => '2500',
            'item_describe' => '便利なメイクアップセット',
            'category'      => '服飾',
            'condition'     => '目立った傷や汚れなし'
            ];
        DB::table('items')->insert($param);

    }
}

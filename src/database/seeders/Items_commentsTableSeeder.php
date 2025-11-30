<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Items_commentsTableSeeder extends Seeder
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
            'user_id'       => '2',
            'comment'       => '始２３４５６７８９十１２３４５６７８９二１２３４５６７８９三１２３４５６７８９四１２３４５６７８９五１２３４５６７８９六１２３４５６７８９七１２３４５６７８９八１２３４５６７８９九１２３４５６７８９百１２３４５６７８９十１２３４５６７８９二１２３４５６７８９三１２３４５６７８９四１２３４５６７８９五１２３４５６７８９六１２３４５６７８９七１２３４５６７８９八１２３４５６７８９九１２３４５６７８９百１２３４５６７８９十１２３４５６７８９二１２３４５６７８９三１２３４５６７８９四１２３４５６７８９五１２３４終'
            ];
        DB::table('items_comments')->insert($param);

        $param = [
            'item_id'       => '6',
            'user_id'       => '1',
            'comment'       => '始２３４５６７８９十１２３４５６７８９二１２３４５６７８９三１２３４５６７８９四１２３４５６７８９五１２３４５６７８９六１２３４５６７８９七１２３４５６７８９八１２３４５６７８９九１２３４５６７８９百１２３４５６７８９十１２３４５６７８９二１２３４５６７８９三１２３４５６７８９四１２３４５６７８９五１２３４５６７８９六１２３４５６７８９七１２３４５６７８９八１２３４５６７８９九１２３４５６７８９百１２３４５６７８９十１２３４５６７８９二１２３４５６７８９三１２３４５６７８９四１２３４５６７８９五１２３４終'
            ];
        DB::table('items_comments')->insert($param);
    }
}

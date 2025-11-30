<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('purchases')->truncate();
        DB::table('items_comments')->truncate();
        DB::table('favorites')->truncate();
        DB::table('items')->truncate();
        DB::table('users_adds')->truncate();
        DB::table('users')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->call([
            UsersTableSeeder::class,
            Users_addsTableSeeder::class,
            ItemsTableSeeder::class,
            FavoritesTableSeeder::class,
            Items_commentsTableSeeder::class,
            PurchasesTableSeeder::class
        ]);
    }
}

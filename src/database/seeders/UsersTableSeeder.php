<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'name'                      => 'テスト　ユーザー１',
            'email'                     => 'test1@example.com',
            'email_verified_at'         => now(),
            'password'                  => Hash::make('password'),
            'two_factor_secret'         => null,
            'two_factor_recovery_codes' => null,
            'two_factor_confirmed_at'   => null,
            'remember_token'            => null
            ];
        DB::table('users')->insert($param);

        $param = [
            'name'                      => 'テスト　ユーザー２',
            'email'                     => 'test2@example.com',
            'email_verified_at'         => now(),
            'password'                  => Hash::make('password'),
            'two_factor_secret'         => null,
            'two_factor_recovery_codes' => null,
            'two_factor_confirmed_at'   => null,
            'remember_token'            => null
            ];
        DB::table('users')->insert($param);

        $param = [
            'name'                      => 'テスト　ユーザー３',
            'email'                     => 'test3@example.com',
            'email_verified_at'         => now(),
            'password'                  => Hash::make('password'),
            'two_factor_secret'         => null,
            'two_factor_recovery_codes' => null,
            'two_factor_confirmed_at'   => null,
            'remember_token'            => null
            ];
        DB::table('users')->insert($param);

    }
}

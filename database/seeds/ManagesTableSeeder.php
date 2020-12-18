<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ManagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 店舗アカウントの設定
        DB::table('manages')->insert([
            [
                'name' => 'MK GoTO',
                'domain' => 'mk-goto',
                'email' => 'mkgoto@lamp.jp',
                'email_verified_at' => date('Y-m-d H:i:s'),
                'tel' => '075-662-1700',
                // 'fax' => '0342432951',
                'password' => Hash::make('lamp1001'),

                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ]);
    }
}

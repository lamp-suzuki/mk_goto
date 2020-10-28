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
                'name' => 'MKトラベル',
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

        // 店舗の追加
        // DB::table('shops')->insert([
        //     [
        //         'manages_id' => 1,
        //         'name' => '本店',
        //         'zipcode' => '604-0024',
        //         'pref' => '京都府',
        //         'address1' => '京都市中京区下妙覚寺町',
        //         'address2' => '１９５ KMGビル 4F',
        //         'email' => 'info@lamp.jp',
        //         'tel' => '075-600-2721',

        //         'takeout_sun' => '11:00,14:00,15:00,19:00',
        //         'takeout_mon' => '11:00,14:00,15:00,19:00',
        //         'takeout_tue' => '11:00,14:00,15:00,19:00',
        //         'takeout_wed' => '11:00,14:00,15:00,19:00',
        //         'takeout_thu' => '11:00,14:00,15:00,19:00',
        //         'takeout_fri' => '11:00,14:00,15:00,19:00',
        //         'takeout_sat' => '11:00,14:00,15:00,19:00',

        //         'created_at' => date('Y-m-d H:i:s'),
        //         'updated_at' => date('Y-m-d H:i:s')
        //     ]
        // ]);
    }
}

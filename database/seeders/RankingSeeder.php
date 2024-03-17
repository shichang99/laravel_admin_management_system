<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RankingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table( 'rankings' )->insert( [
            [
                'name' => '{"en":"Member","zh":"会员"}',
                'status' => 1,
                'created_at' => date( 'Y-m-d H:i:00' ),
                'updated_at' => date( 'Y-m-d H:i:00' ),
            ]
        ] );
    }
}

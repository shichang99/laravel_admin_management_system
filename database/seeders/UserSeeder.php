<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table( 'users' )->insert( [
            [
                'country_id' => 136,
                'ranking_id' => 1,
                'package_id' => 0,
                'sponsor_id' => 0,
                'name' => 'tester',
                'email' => 'tester@gmail.com',
                'password' => Hash::make( 'tester1234' ),
                'security_pin' => Hash::make( '123456' ),
                'invitation_code' => strtoupper( \Str::random( 6 ) ),
                'sponsor_structure' => '-',
                'status' => 1,
                'created_by' => 0,
                'updated_by' => 0,
                'created_at' => date( 'Y-m-d H:i:s' ),
                'updated_at' => date( 'Y-m-d H:i:s' ),
            ],
        ] );

        DB::table( 'member_details' )->insert( [
            [
                'user_id' => 1,
                'fullname' => 'TESTER',
                'phone_number' => '123456789',
                'deposit_usdt_address' => 'Trc20addressDeposit',
                'withdrawal_usdt_address' => 'Trc20addressWithdrawal',
            ]
        ] );

        DB::table( 'member_wallets' )->insert( [
            [
                'user_id' => 1,
                'balance' => 1,
                'type' => 1,
            ]
        ] );
    }
}

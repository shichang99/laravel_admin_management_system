<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use Spatie\Permission\Models\Permission;

use Helper;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        DB::table( 'admins' )->insert( [
            [
                'name' => 'demo',
                'email' => 'demo@gmail.com',
                'password' => Hash::make( 'demo1234' ),
                'role' => 1,
                'status' => 1,
                'created_by' => 0,
                'updated_by' => 0,
                'created_at' => date( 'Y-m-d H:i:s' ),
                'updated_at' => date( 'Y-m-d H:i:s' ),
            ],
            [
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make( 'admin1234' ),
                'role' => 2,
                'status' => 1,
                'created_by' => 0,
                'updated_by' => 0,
                'created_at' => date( 'Y-m-d H:i:s' ),
                'updated_at' => date( 'Y-m-d H:i:s' ),
            ],
            [
                'name' => 'finance',
                'email' => 'finance@gmail.com',
                'password' => Hash::make( 'finance1234' ),
                'role' => 3,
                'status' => 1,
                'created_by' => 0,
                'updated_by' => 0,
                'created_at' => date( 'Y-m-d H:i:s' ),
                'updated_at' => date( 'Y-m-d H:i:s' ),
            ],
        ] );

        DB::table( 'roles' )->insert( [
            [ 'name' => 'super_admin', 'guard_name' => 'admin', 'created_at' => date( 'Y-m-d H:i:s' ), 'updated_at' => date( 'Y-m-d H:i:s' ) ],
            [ 'name' => 'admin', 'guard_name' => 'admin', 'created_at' => date( 'Y-m-d H:i:s' ), 'updated_at' => date( 'Y-m-d H:i:s' ) ],
            [ 'name' => 'finance', 'guard_name' => 'admin', 'created_at' => date( 'Y-m-d H:i:s' ), 'updated_at' => date( 'Y-m-d H:i:s' ) ],
        ] );

        DB::table( 'model_has_roles' )->insert( [
            [
                'role_id' => 1,
                'model_type' => 'App\Models\Admin',
                'model_id' => 1,
            ],
            [
                'role_id' => 2,
                'model_type' => 'App\Models\Admin',
                'model_id' => 2,
            ],
            [
                'role_id' => 3,
                'model_type' => 'App\Models\Admin',
                'model_id' => 3,
            ],
        ] );

        $modules = [
            [ 'name' => 'admins', 'guard_name' => 'admin', 'created_at' => date( 'Y-m-d H:i:s' ), 'updated_at' => date( 'Y-m-d H:i:s' ) ],
            [ 'name' => 'members', 'guard_name' => 'admin', 'created_at' => date( 'Y-m-d H:i:s' ), 'updated_at' => date( 'Y-m-d H:i:s' ) ],
            [ 'name' => 'wallets', 'guard_name' => 'admin', 'created_at' => date( 'Y-m-d H:i:s' ), 'updated_at' => date( 'Y-m-d H:i:s' ) ],
        ];

        DB::table( 'modules' )->insert( $modules );

        foreach ( $modules as $module ) {
            foreach ( Helper::moduleActions() as $action ) {
                Permission::create( [ 'name' => $action . ' ' . $module['name'], 'guard_name' => $module['guard_name'] ] );
            }
        }

        DB::table( 'role_has_permissions' )->insert( [
            [ 'permission_id' => 6, 'role_id' => 2 ],
            [ 'permission_id' => 10, 'role_id' => 2 ],
            [ 'permission_id' => 10, 'role_id' => 3 ],
        ] );
    }
}

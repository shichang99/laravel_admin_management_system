<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\{
    AdminService,
};

class AdministratorController extends Controller
{
    public function index() {

        $this->data['header']['title'] = __( 'template.administrators' );
        $this->data['content'] = 'admin.administrator.index';
        $this->data['breadcrumb'] = [
            [
                'url' => route( 'admin.dashboard' ),
                'text' => __( 'template.dashboard' ),
                'class' => '',
            ],
            [
                'url' => '',
                'text' => __( 'template.administrators' ),
                'class' => 'active',
            ],
        ];

        $roles = [];
        foreach ( \DB::table( 'roles' )->select( 'id', 'name' )->orderBy( 'id', 'ASC' )->get() as $role ) {
            array_push( $roles, [ 'key' => $role->name, 'value' => $role->id, 'title' => __( 'administrator.' . $role->name ) ] );
        }

        $this->data['data']['roles'] = $roles;

        return view( 'admin.main' )->with( $this->data );
    }

    public function adminLog() {

        $this->data['header']['title'] = __( 'template.admin_logs' );
        $this->data['content'] = 'admin.administrator.admin_log';
        $this->data['breadcrumb'] = [
            [
                'url' => route( 'admin.dashboard' ),
                'text' => __( 'template.dashboard' ),
                'class' => '',
            ],
            [
                'url' => route( 'admin.admin.list' ),
                'text' => __( 'template.administrators' ),
                'class' => '',
            ],
            [
                'url' => '',
                'text' => __( 'template.admin_logs' ),
                'class' => 'active',
            ],
        ];

        return view( 'admin.main' )->with( $this->data );
    }


    public function allAdmins( Request $request ) {

        return AdminService::allAdmins( $request );
    }

    public function oneAdmin( Request $request ) {

        return AdminService::oneAdmin( $request );
    }

    public function createAdmin( Request $request ) {

        return AdminService::createAdmin( $request );
    }

    public function updateAdmin( Request $request ) {

        return AdminService::updateAdmin( $request );
    }

    public function updateAdminStatus( Request $request ) {

        return AdminService::updateAdminStatus( $request );
    }

    public function allAdminLogs( Request $request ) {

        return AdminService::allAdminLogs( $request );
    }

}

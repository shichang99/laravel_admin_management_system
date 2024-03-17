<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\{
    MaintenanceService,
};

use App\Models\{
    UnderMaintenance,
};

class MaintenanceController extends Controller
{
    public function index( Request $request ) {
        $this->data['breadcrumb'] = [
            [
                'url' => route( 'admin.dashboard' ),
                'text' => __( 'template.dashboard' ),
                'class' => '',
            ],
            [
                'url' => '',
                'text' => __( 'template.maintenances' ),
                'class' => 'active',
            ],
        ];
        $this->data['header']['title'] = __( 'template.maintenances' );
        $this->data['content'] = 'admin.maintenance.index';

        return view( 'admin.main' )->with( $this->data );
    }

    public function create() {

        $this->data['header']['title'] = __( 'maintenance.maintenance_create' );
        $this->data['breadcrumb'] = [
            [
                'url' => route( 'admin.dashboard' ),
                'text' => __( 'template.dashboard' ),
                'class' => '',
            ],
            [
                'url' => route( 'admin.maintenance.list' ),
                'text' => __( 'template.maintenances' ),
                'class' => '',
            ],
            [
                'url' => '',
                'text' => __( 'maintenance.maintenance_create' ),
                'class' => 'active',
            ],
        ];
        $this->data['content'] = 'admin.maintenance.create';
        $this->data['data']['types'] = [
            [
                'title' => __( 'maintenance.daily_maintenance' ),
                'value' => '1',
            ],
            [
                'title' => __( 'maintenance.temporary_maintenance' ),
                'value' => '2',
            ],
            [
                'title' => __( 'maintenance.emergency_maintenance' ),
                'value' => '3',
            ],
        ];

        return view( 'admin.main' )->with( $this->data );
    }

    public function modify( Request $request ) {

        $this->data['header']['title'] = __( 'maintenance.maintenance_edit' );
        $this->data['breadcrumb'] = [
            [
                'url' => route( 'admin.dashboard' ),
                'text' => __( 'template.dashboard' ),
                'class' => '',
            ],
            [
                'url' => route( 'admin.maintenance.list' ),
                'text' => __( 'template.maintenances' ),
                'class' => '',
            ],
            [
                'url' => '',
                'text' => __( 'maintenance.maintenance_edit' ),
                'class' => 'active',
            ],
        ];
        $this->data['content'] = 'admin.maintenance.modify';
        $this->data['data']['types'] = [
            [
                'title' => __( 'maintenance.daily_maintenance' ),
                'value' => '1',
            ],
            [
                'title' => __( 'maintenance.temporary_maintenance' ),
                'value' => '2',
            ],
            [
                'title' => __( 'maintenance.emergency_maintenance' ),
                'value' => '3',
            ],
        ];
        $this->data['data']['maintenance'] = UnderMaintenance::find( \Crypt::decryptString( $request->id ) );

        return view( 'admin.main' )->with( $this->data );
    }

    public function allMaintenances( Request $request ) {

        return MaintenanceService::allMaintenances( $request );
    }

    public function oneMaintenance( Request $request ) {

        return MaintenanceService::oneMaintenance( $request );
    }

    public function createMaintenance( Request $request ) {

        return MaintenanceService::createMaintenance( $request );
    }

    public function updateMaintenance( Request $request ) {

        return MaintenanceService::updateMaintenance( $request );
    }

    public function updateMaintenanceStatus( Request $request ) {

        return MaintenanceService::updateMaintenanceStatus( $request );
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\{
    SettingService,
};

class SettingController extends Controller
{
    public function index( Request $request ) {

        $this->data['header']['title'] = __( 'template.settings' );
        $this->data['content'] = 'admin.setting.index';

        return view( 'admin.main' )->with( $this->data );
    }

    public function allSettings( Request $request ) {

        return SettingService::allSettings( $request );
    }

    public function oneSetting( Request $request ) {

        return SettingService::oneSetting( $request );
    }

    public function createSetting( Request $request ) {

        return SettingService::createSetting( $request );
    }

    public function updateSetting( Request $request ) {

        return SettingService::updateSetting( $request );
    }
}

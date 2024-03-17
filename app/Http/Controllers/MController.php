<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\{
    SysSetting,
    Announcement
};

class MController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $data = [];

    public function __construct() {

        if ( !app()->runningInConsole() ) {
            $routeArray = app( 'request' )->route()->getAction();
            list( $controller, $action ) = explode( '@', class_basename( $routeArray['controller'] ) );
    
            $this->data['controller'] = $controller;
            $this->data['action'] = $action;

            // $this->data['data']['marquee'] = Announcement::where('type',2)->where('status',1)->orderBy('created_at','desc')->first();
            // $this->data['data']['latest_announcement'] = Announcement::where('type',1)->where('status',1)->orderBy('created_at','desc')->first();
            // $this->data['data']['CUSTOMER_URL'] = SysSetting::where('status',1)->where('key','CUSTOMER_URL')->first()->value;
            $this->data['data']['CUSTOMER_URL'] = '-';
        }
    }
}

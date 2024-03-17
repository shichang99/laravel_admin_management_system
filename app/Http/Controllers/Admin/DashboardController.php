<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\{
    DashboardService,
};

class DashboardController extends Controller
{
    public function index() {
        
        $this->data['content'] = 'admin.dashboard.index';
        $this->data['data'] = DashboardService::dashboardData();

        return view( 'admin.main' )->with( $this->data );
    }
}

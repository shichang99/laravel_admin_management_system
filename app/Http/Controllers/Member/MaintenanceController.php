<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\{
    UnderMaintenance,
};

class MaintenanceController extends Controller
{
    public function dailyMaintenance() {

        $admin = \Session::get( 'ignoreMaintenance' );
        if ( $admin ) {
            if ( time() < $admin ) {
                return redirect()->route( 'home' );
            }
        }

        $daily = UnderMaintenance::where( 'status', 1 )
            ->where( 'type', 1 )
            ->whereRaw( '"' . date( 'H:i:s' ) . '" >= start_time' )
            ->whereRaw( '"' . date( 'H:i:s' ) . '" <= end_time' )
            ->latest()
            ->first();

        if ( !$daily ) {
            return redirect()->route( 'home' );
        }

        $this->data['basic'] = true;
        $this->data['logoutBtn'] = true;
        
        $this->data['templateStyle'] = "bg-02";
        $this->data['content'] = 'member.member.under_maintenance';
        $this->data['data']['maintenance'] = $daily;

        return view( 'member.main_pre_auth' )->with( $this->data );
    }

    public function temporaryMaintenance() {

        $admin = \Session::get( 'ignoreMaintenance' );
        if ( $admin ) {
            if ( time() < $admin ) {
                return redirect()->route( 'home' );
            }
        }

        $temporary = UnderMaintenance::where( 'status', 1 )
            ->where( 'type', 2 )
            ->where( 'start_date', '>=', date( 'Y-m-d' ) )
            ->where( 'end_date', '<=', date( 'Y-m-d' ) )
            ->whereRaw( '"' . date( 'H:i:s' ) . '" >= start_time' )
            ->whereRaw( '"' . date( 'H:i:s' ) . '" <= end_time' )
            ->latest()
            ->first();

        if ( !$temporary ) {
            return redirect()->route( 'home' );
        }

        $this->data['basic'] = true;
        $this->data['logoutBtn'] = true;
        
        $this->data['templateStyle'] = "bg-02";
        $this->data['content'] = 'member.member.under_maintenance';
        $this->data['data']['maintenance'] = $temporary;

        return view( 'member.main_pre_auth' )->with( $this->data );
    }

    public function emergencyMaintenance() {

        $admin = \Session::get( 'ignoreMaintenance' );
        if ( $admin ) {
            if ( time() < $admin ) {
                return redirect()->route( 'home' );
            }
        }

        $emergency = UnderMaintenance::where( 'status', 1 )
            ->where( 'type', 3 )
            ->latest()
            ->first();

        if ( !$emergency ) {
            return redirect()->route( 'home' );
        }

        $this->data['basic'] = true;
        $this->data['logoutBtn'] = true;
        
        $this->data['templateStyle'] = "bg-02";
        $this->data['content'] = 'member.member.under_maintenance';
        $this->data['data']['maintenance'] = $emergency;

        return view( 'member.main_pre_auth' )->with( $this->data );
    }
}

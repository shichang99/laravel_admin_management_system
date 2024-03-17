<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use App\Models\{
    UnderMaintenance,
};

class CheckMaintenance
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $admin = \Session::get( 'ignoreMaintenance' );
        if ( $admin ) {
            if ( time() < $admin ) {
                return $next( $request );
            }
        }

        $daily = UnderMaintenance::where( 'status', 1 )
            ->where( 'type', 1 )
            ->whereRaw( '"' . date( 'H:i:s' ) . '" >= start_time' )
            ->whereRaw( '"' . date( 'H:i:s' ) . '" <= end_time' )
            ->latest()
            ->first();

        if ( $daily ) {
            return redirect()->route( 'daily_maintenance' );
        }

        $temporary = UnderMaintenance::where( 'status', 1 )
            ->where( 'type', 2 )
            ->where( 'start_date', '>=', date( 'Y-m-d' ) )
            ->where( 'end_date', '<=', date( 'Y-m-d' ) )
            ->whereRaw( '"' . date( 'H:i:s' ) . '" >= start_time' )
            ->whereRaw( '"' . date( 'H:i:s' ) . '" <= end_time' )
            ->latest()
            ->first();

        if ( $temporary ) {
            return redirect()->route( 'temporary_maintenance' );
        }

        $emergency = UnderMaintenance::where( 'status', 1 )
            ->where( 'type', 3 )
            ->latest()
            ->first();

        if ( $emergency ) {
            return redirect()->route( 'emergency_maintenance' );
        }

        return $next( $request );
    }
}

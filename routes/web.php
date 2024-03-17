<?php

use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Member\{
    MemberController,
    MaintenanceController
};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get( 'daily-maintenance', [ MaintenanceController::class, 'dailyMaintenance' ] )->name( 'daily_maintenance' );
Route::get( 'temporary-maintenance', [ MaintenanceController::class, 'temporaryMaintenance' ] )->name( 'temporary_maintenance' );
Route::get( 'emergency-maintenance', [ MaintenanceController::class, 'emergencyMaintenance' ] )->name( 'emergency_maintenance' );

Route::middleware( 'auth:web' )->group( function() {

    Route::get( '/', function() {

        if ( isset( auth()->user()->name ) ) {
            return redirect()->route('home');
        }

        return redirect( 'login' );
    } );

    Route::prefix( 'member' )->group( function() {
        Route::get( '/', [ MemberController::class, 'index' ] )->name( 'member.home' );
        Route::get( 'profile', [ MemberController::class, 'profile' ] )->name( 'member.profile' );
        Route::post( 'announcements', [ MemberController::class, 'announcementRead' ] )->name( 'member.announcement_read' );

        // For other page in member site, add there
        // Route::get( 'xyz', [ MemberController::class, 'xyz' ] );
    } );

    // Or here also can, the only different is within prefix( 'member' ), URL is {domain}/member/xyz
    // there will be {domain}/qwe
    // Route::get( 'qwe', [ MemberController::class, 'qwe' ] );
} );

Route::prefix( 'member/api' )->group( function() {

    Route::post( 'tac', [ MemberController::class, 'requestTAC' ] );
    Route::post( 'resend-tac', [ MemberController::class, 'resendTAC' ] );
    Route::post( 'signup', [ MemberController::class, 'signup' ] );
} );

Route::get( 'lang/{lang}', function( $lang ) {

    if ( array_key_exists( $lang, Config::get( 'languages' ) ) ) {
        Session::put( 'appLocale', $lang );
    }
    
    return Redirect::back();
} );

Route::get( 'login', function() {

    if ( isset( auth()->user()->name ) ) {
        return redirect( 'member' );
    }
    
    $data['basic'] = true;
    $data['templateStyle'] = "bg-03";
    $data['content'] = 'member.auth.login';

    return view( 'member.main_pre_auth' )->with( $data );

} )->middleware( 'guest:admin' )->name( 'web.login' );

$limiter = config( 'fortify.limiters.login' );

Route::post( 'login', [ AuthenticatedSessionController::class, 'store' ] )->middleware( array_filter( [ 'guest:web', $limiter ? 'throttle:'.$limiter : null ] ) )->name( 'member.login' );

Route::post( 'logout', [ AuthenticatedSessionController::class, 'destroy' ] )->middleware( 'auth:web' )->name( 'web.logout' );

// This is admin route
require __DIR__ . '/admin.php';
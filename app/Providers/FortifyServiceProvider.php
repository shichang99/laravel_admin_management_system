<?php

namespace App\Providers;

use App\Actions\Fortify\{
    CreateNewUser,
    ResetUserPassword,
    UpdateUserPassword,
    UpdateUserProfileInformation
};

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;

use Illuminate\Support\Facades\Hash;

use App\Models\{
    Admin,
    User,
};

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ( request()->is( 'bol/*' ) ) {
            config()->set( 'fortify.guard', 'admin' );
            config()->set( 'fortify.home', '/admin/home' );
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        Fortify::authenticateUsing( function ( Request $request ) {

            if ( request()->is( 'bol/*' ) ) {

                \Session::forget( 'forceRedirectToMember' );

                $request->validate( [
                    'username' => [ 'required', function( $attribute, $value, $fail ) use ( $request ) {
                        $admin = Admin::where( 'name', $request->username )->first();
                        if ( !$admin || !Hash::check( $request->password, $admin->password ) ) {
                            $fail( __( 'auth.failed' ) );
                        }
                    } ],
                    'password' => 'required'
                ] );

                \Session::put( 'ignoreMaintenance', time() + 3600 );

                return Admin::where( 'name', $request->username )->first();

            } else {

                if( !empty( $request->from_admin ) ) {

                    if ( ( time() - $request->timestamp ) > 10 ) {
                        \Session::flash( 'login_failed', true );
                        return false;
                    }

                    $secret = \Crypt::decryptString( $request->secret );

                    if ( $secret != ( 'hellodontplayplay' . $request->timestamp ) ) {
                        \Session::flash( 'login_failed', true );
                        return false;
                    }

                    $user = User::where( 'name', $request->username )->first();
                    if ( $user ) {
                        \Session::put( 'forceRedirectToMember', 1 );
                    }
                    return $user;
                }

                $request->validate( [
                    'username' => [ 'required', function( $attribute, $value, $fail ) use ( $request ) {
                        $user = User::where( 'name', $request->username )->where( 'status', 1 )->first();
                        if ( !$user || !Hash::check( $request->password, $user->password ) ) {
                            $fail( __( 'auth.failed' ) );
                        }
                    } ],
                    'password' => 'required'
                ] );

                \Session::forget( 'ignoreMaintenance' );

                return User::where( 'name', $request->username )->where( 'status', 1 )->first();
            }
        } );

        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;

            return Limit::perMinute(15)->by($email.$request->ip());
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        $this->app->singleton(
            \Laravel\Fortify\Contracts\LoginResponse::class,
            \App\Http\Responses\LoginResponse::class
        );
    }
}

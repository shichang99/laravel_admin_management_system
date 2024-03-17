<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    /**
     * @param  $request
     * @return mixed
     */
    public function toResponse($request)
    {
        $home = '/';
        if ( request()->is( 'bol/*' ) ) {
            return redirect()->route( 'admin.admin.list' );
        }
       
        // if ( \Session::get( 'redirect' ) ) {
        //     $home = \Session::get( 'redirect' );
        // }

        return redirect()->intended( $home );
    }
}
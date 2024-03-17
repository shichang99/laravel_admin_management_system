<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Fortify\Contracts\LogoutResponse as LogoutResponseContract;
use Symfony\Component\HttpFoundation\Response;

class LogoutResponse implements LogoutResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function toResponse($request)
    {
        if ( request()->is( 'bol/*' ) ) {
            return $request->wantsJson() ? new JsonResponse( '', 204 ) : redirect( 'bol/login' );
        } else {
            return $request->wantsJson() ? new JsonResponse( '', 204 ) : redirect( 'login' );
        }
    }
}
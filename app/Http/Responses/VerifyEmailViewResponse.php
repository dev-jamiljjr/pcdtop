<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Laravel\Fortify\Contracts\VerifyEmailViewResponse as VerifyEmailViewResponseContract;
use Laravel\Fortify\Fortify;

class VerifyEmailViewResponse implements VerifyEmailViewResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        return $request->wantsJson()
            ? new JsonResponse('', 204)
            : view('auth.verify-email');
    }
}

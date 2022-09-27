<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function success(): Response {
        return response(
            [
                'status' => ResponseAlias::HTTP_OK,
                'success' => true,
                'data' => null
            ],
            ResponseAlias::HTTP_OK
        );
    }

    protected function internalError(): Response
    {
        return response(
            [
                'status' => ResponseAlias::HTTP_INTERNAL_SERVER_ERROR,
                'success' => false,
                'error' => 'Something went wrong'
            ],
            ResponseAlias::HTTP_INTERNAL_SERVER_ERROR
        );
    }
}

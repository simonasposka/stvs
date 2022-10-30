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

    protected function success($data = null): Response {
        return response(
            [
                'status' => ResponseAlias::HTTP_OK,
                'success' => true,
                'data' => $data
            ],
            ResponseAlias::HTTP_OK
        );
    }

    protected function unauthorized(?string $message = null): Response
    {
        return response(
            [
                'status' => ResponseAlias::HTTP_UNAUTHORIZED,
                'success' => false,
                'error' => $message ?? 'Unauthorized'
            ],
            ResponseAlias::HTTP_UNAUTHORIZED
        );
    }

    protected function notFound(): Response
    {
        return response(
            [
                'status' => ResponseAlias::HTTP_NOT_FOUND,
                'success' => false,
            ],
            ResponseAlias::HTTP_NOT_FOUND
        );
    }

    protected function error(?string $message = null): Response
    {
        return response(
            [
                'status' => ResponseAlias::HTTP_INTERNAL_SERVER_ERROR,
                'success' => false,
                'error' => $message ?? 'Something went wrong'
            ],
            ResponseAlias::HTTP_INTERNAL_SERVER_ERROR
        );
    }
}

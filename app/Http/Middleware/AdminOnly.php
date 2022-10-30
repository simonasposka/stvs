<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use PHPOpenSourceSaver\JWTAuth\Payload;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class AdminOnly extends Middleware
{
    public function handle($request, Closure $next, ...$guards)
    {
        try {
            /* @var $jwtPayload Payload */
            $jwtPayload = auth()->payload();
            $role = $jwtPayload->get('role');

            if ($role != 'admin') {
                return response(
                    [
                        'status' => ResponseAlias::HTTP_UNAUTHORIZED,
                        'success' => false,
                        'error' => 'unauthorized'
                    ],
                    ResponseAlias::HTTP_UNAUTHORIZED
                );
            }

            return $next($request);
        } catch (Exception $exception) {
            return response(
                [
                    'status' => ResponseAlias::HTTP_INTERNAL_SERVER_ERROR,
                    'success' => false,
                    'error' => $exception->getMessage()
                ],
                ResponseAlias::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}

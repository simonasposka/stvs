<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class CustomJwt extends Middleware
{
    public function handle($request, Closure $next, ...$guards)
    {
        try {
            $user = auth()->user();

            if ($user == null) {
                return response(
                    [
                        'status' => ResponseAlias::HTTP_FORBIDDEN,
                        'success' => false,
                        'error' => 'unauthenticated'
                    ],
                    ResponseAlias::HTTP_FORBIDDEN
                );
            }

            return $next($request);
        } catch (Exception $exception) {
            return response(
                [
                    'status' => ResponseAlias::HTTP_FORBIDDEN,
                    'success' => false,
                    'error' => $exception->getMessage()
                ],
                ResponseAlias::HTTP_FORBIDDEN
            );
        }
    }
}

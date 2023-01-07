<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JwtMiddleware extends BaseMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        try {

            $user = JWTAuth::parseToken()->authenticate();

        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return Response::json([
                'success' => false,
                'message' => 'Token is Invalid',
                'data' => null
            ]);
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return Response::json([
                'success' => false,
                'message' => 'Token is Expired',
                'data' => null
            ]);
        } catch (Exception $e) {
            return Response::json([
                'success' => false,
                'message' => 'Authorization Token not found',
                'data' => null
            ]);
        }

        return $next($request);
    }
}

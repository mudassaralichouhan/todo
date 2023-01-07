<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\Response as ResponseMessage;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function logout()
    {
        try {
            JWTAuth::invalidate();

            return Response::json([
                'success' => true,
                'message' => 'User has been logged out'
            ]);
        } catch (JWTException $e) {
            return Response::json([
                'success' => false,
                'message' => 'Sorry, user cannot be logged out'
            ], ResponseMessage::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function user()
    {
        $user = JWTAuth::authenticate();
        return Response::json(['user' => $user]);
    }
}

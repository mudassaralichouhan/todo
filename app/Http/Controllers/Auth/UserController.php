<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response as ResponseMessage;

class UserController extends Controller
{
    public function register(Request $request)
    {
        // Validate data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'string|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'required|min:6|max:50',
        ]);

        // Send failed response if request is not valid
        if ($validator->fails())
            return Response::json(['error' => $validator->messages()], 200);

        // Request is valid, create new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $user->sendEmailVerificationNotification();

        // User created, return success response
        return Response::json([
            'success' => true,
            'message' => 'User created successfully',
            'data' => $user
        ], ResponseMessage::HTTP_OK);
    }

    public function login(Request $request)
    {
        // valid credential
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6|max:50'
        ]);

        // Send failed response if request is not valid
        if ($validator->fails()) {
            return Response::json(['error' => $validator->messages()], 200);
        }

        // Request is validated
        // Create token
        try {
            if (! $token = JWTAuth::attempt($request->all())) {
                return Response::json([
                    'success' => false,
                    'message' => 'Login credentials are invalid.',
                ], 400);
            }
        } catch (JWTException $e) {
            return Response::json([
                'success' => false,
                'message' => 'Could not create token.',
            ], 500);
        }

        // Token created, return with success response and jwt token
        return Response::json([
            'success' => true,
            'token' => $token,
        ]);
    }
}

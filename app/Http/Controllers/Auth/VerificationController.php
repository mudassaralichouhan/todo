<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class VerificationController extends Controller
{
    public function verified(User $user) {
        return Response::json([
            'success' => true,
            'message' => 'Email verified.',
            'data' => $user
        ], 200);
    }

    public function verify($user_id, Request $request) {
        if (!$request->hasValidSignature()) {
            return Response::json([
                'success' => false,
                'message' => 'Invalid or Expired url provided.'
            ], 401);
        }

        $user = User::findOrFail($user_id);

        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }

        return Redirect::route('verification.verified', $user);
    }

    public function resend(Request $request) {

        // valid credential
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);

        // Send failed response if request is not valid
        if ($validator->fails()) {
            return Response::json(['error' => $validator->messages()], 200);
        }

        $user = User::where('email', $request->email)->first();

        if ($user->hasVerifiedEmail()) {
            return Response::json([
                'success' => false,
                'message' => 'Email already verified.'
            ], 400);
        }

        $user->sendEmailVerificationNotification();

        return Response::json([
            'success' => true,
            'message' => 'Email verification link sent on your email id'
        ], 200);
    }

    public function notice(Request $request) {
        return Response::json([
            'success' => false,
            'message' => 'You need to confirm your account. We have sent you an activation link to your email.',
        ], 200);
    }
}

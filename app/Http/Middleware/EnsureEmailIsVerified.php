<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class EnsureEmailIsVerified
{
    public function handle(Request $request, Closure $next)
    {
        $user = User::where('email', $request->email)->first();

        if ($user instanceof MustVerifyEmail && ! $user->hasVerifiedEmail()) {

            return Response::json([
                'success' => false,
                'message' => 'You need to confirm your account. We have sent you an activation link to your email.',
                'data' => null
            ], 422);
        }

        return $next($request);
    }
}

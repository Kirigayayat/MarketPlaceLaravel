<?php

namespace App\Http\Middleware;

use App\Models\PersonalToken;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthUser {

    public function handle(Request $request, Closure $next) {

        $token = $request->header('token');
        $personalToken = PersonalToken::where('token', $token)->first();
        if ($personalToken) {
            return $next($request);
        } else {
            return $this->error("Token Expired");
        }
    }

    public function error($message): JsonResponse{
        return response()->json([
            'code' => 400,
            'message' => $message
        ], 400);
    }
}

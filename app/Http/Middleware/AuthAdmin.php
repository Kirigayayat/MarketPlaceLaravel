<?php

namespace App\Http\Middleware;

use App\Models\PersonalToken;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthAdmin {
    public function handle(Request $request, Closure $next) {

        $token = $request->header('token');
        if (!$token) {
            return $this->error("Not authorization");
        }
        $personalToken = PersonalToken::where('token', $token)->first();
        if ($personalToken) {
            $user = $personalToken->user;
            try {
                if ($user->userRole->isAdmin) {
                    return $next($request);
                } else {
                    return $this->error("Hanya admin yang bisa akses");
                }
            } catch (\Exception $e) {
                return $this->error("Hanya admin yang bisa akses");
            }
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

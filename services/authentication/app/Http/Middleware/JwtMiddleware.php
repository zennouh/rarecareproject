<?php

namespace App\Http\Middleware;

use Closure;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Models\User;

class JwtMiddleware
{
    public function handle($request, Closure $next)
    {
        try {

            $authHeader = $request->header('Authorization');

            if (!$authHeader) {
                return response()->json([
                    'error' => 'Token manquant'
                ], 401);
            }

            $token = str_replace('Bearer ', '', $authHeader);

            $decoded = JWT::decode(
                $token,
                new Key(env('JWT_SECRET'), 'HS256')
            );

            $user = User::find($decoded->sub);

            if (!$user) {
                return response()->json([
                    'error' => 'Utilisateur introuvable'
                ], 404);
            }

            $request->auth = $user;

        } catch (\Exception $e) {

            return response()->json([
                'error' => 'Token invalide'
            ], 401);
        }

        return $next($request);
    }
}

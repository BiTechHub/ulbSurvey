<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiTokenAuth
{
    public function handle(Request $request, Closure $next)
    {
        $authHeader = $request->header('Authorization');

        if (!$authHeader || !str_starts_with($authHeader, 'Bearer ')) {
            return response()->json([
                'success' => false,
                'message' => 'Token missing'
            ], 401);
        }

        $token = trim(str_replace('Bearer', '', $authHeader));

        $user = DB::table('users')->where('api_token', $token)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid token'
            ], 401);
        }

        // ✅ Correct way
        $request->attributes->set('auth_user', $user);

        return $next($request);
    }
}

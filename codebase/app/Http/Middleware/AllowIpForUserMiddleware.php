<?php

namespace App\Http\Middleware;

use App\Models\UserAllowedIp;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

class AllowIpForUserMiddleware
{
    // public $allowedIps = json_decode(Auth()->user()->allowedIp);
    public $allowedIps = [

    ];

    public function skipedRoutes()
    {
        return [
            'api/v1/webhook/transactions',
            'api/v1/webhook/withdraw/pix',
        ];
    }

    public function handle(Request $request, Closure $next)
    {
        if(!is_null(auth('sanctum')->user())){
            $getAllow = UserAllowedIp::where('user_id', auth('sanctum')->user()->id)->value('ip');

            array_push($this->allowedIps, $getAllow);
        }

        if (in_array($request->path(), $this->skipedRoutes())) {
            return $next($request);
        }

        if (!in_array($request->ip(), $this->allowedIps)) {
            return response(json_encode(['message' => 'Access denied']), 403);
        }

        return $next($request);
    }
}
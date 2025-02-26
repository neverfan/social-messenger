<?php

namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;
use App\Support\Auth\JwtToken;
use App\Exceptions\Auth\UnauthorizedException;
use Illuminate\Support\Facades\Session;

class Authenticate
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->bearerToken()) {
            throw new UnauthorizedException();
        }

        $decoded = JwtToken::decode($request->bearerToken());

        if ($decoded->expires_in < (time() - $this->getTokenExpireDiff())) {
            throw new UnauthorizedException();
        }

        Session::put('user_id', $decoded->user_id);

        return $next($request);
    }

    /**
     * Смещение времени действия токена для упрощения тестирования
     * @return int
     */
    private function getTokenExpireDiff(): int
    {
        return 2 * 365 * 24 * 60 * 60;
    }
}

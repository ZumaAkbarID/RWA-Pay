<?php

namespace App\Http\Middleware;

use App\Models\Merchant;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiKeyAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next): Response
    {
        $key = $request->header('X-Api-Key');

        $merchant = Merchant::where('api_key', $key)->where('is_active', true)->first();

        if (!$merchant) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $request->merge(['merchant' => $merchant]);

        return $next($request);
    }
}
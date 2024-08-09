<?php

namespace App\Http\Middleware;

// use App\Traits\ResponseAPI;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DealerMiddleware
{
    // use ResponseAPI;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        if (!is_null(Auth::guard('api')->user()) && Auth::guard('api')->user()->type == "dealer") {
            return $next($request);
        }
        return $this->error('User is not Dealer', 500);
    }
}
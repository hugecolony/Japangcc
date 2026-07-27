<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::user()->role_as == '1' or ! Auth::user()->role_as == '2') {
            return redirect('home')->with('status', 'Access Denied! You are not Admin');
        }

        return $next($request);
    }
}

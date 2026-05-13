<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectSatuDataToLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->getHost() === 'satudata.jambiprov.go.id') {
            if (! $request->is('login') && ! Auth::check()) {
                return redirect('/login');
            }
            if ($request->is('login') && Auth::check()) {
                return redirect()->route('dashboard'); // Or any other route after login
            }
        }

        return $next($request);
    }
}

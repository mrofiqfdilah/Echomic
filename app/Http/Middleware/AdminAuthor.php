<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Closure;
use Illuminate\Support\Facades\Auth;


class AdminAuthor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, ...$guards)
    {
   
        if (Auth::check()) {
      
            $user = Auth::user();
            if ($user->level !== 'admin' || $user->level !== 'author') {
                return $next($request);
            }
        }

   
        return redirect('/home');
    }
}
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $userType
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, $userType)
    {
        if (Auth::check() && Auth::user()->user_type !== $userType) {
            // Flash a message to the session for SweetAlert
            session()->flash('alert', [
                'type' => 'error',
                'message' => 'You cannot access this page, please go back!'
            ]);

            // Redirect the user back
            return redirect()->back();
        }

        return $next($request);
    }
}


<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(auth()->guard('admin')->check() && auth()->guard('admin')->user()->status=='Active'){
            // Inertia::share([
            //     'sideMenus' =>getSideMenus(),
            // ]);
            return $next($request);
        }
        else{
            session()->flash('errMsg','Please Login First.');
            return redirect()->route('backend.auth.login');
        }
    }
}

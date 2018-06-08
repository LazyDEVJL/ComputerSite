<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Session;

class IsAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
       if(!Auth::guard('admin')->check()) {
          Session::flash('error', 'You have to log in first');
          return redirect('admin/login');
       }

        return $next($request);
    }
}

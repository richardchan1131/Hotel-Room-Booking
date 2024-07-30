<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Dashboard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if(!Auth::check()){
            return redirect(route('login', ['redirect' => $request->getRequestUri()]));
        }
        if (!Auth::check() or !Auth::user()->hasPermission('dashboard_access')) {
            return redirect('/');
        }
        return $next($request);
    }
}

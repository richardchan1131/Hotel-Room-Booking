<?php

namespace App\Pro\Middlewares;

use Illuminate\Support\Facades\Auth;

class ProPlan
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string|null $guard
     * @return mixed
     */
    public function handle($request, \Closure $next, $guard = null)
    {
        if (strpos($request->path(), 'install') === false && file_exists(storage_path() . '/installed')) {
            if (!isPro()) {
                return redirect(route('pro.upgrade'));
            }
        }

        return $next($request);
    }
}

<?php


namespace App\Http\Middleware;


class RequireChangePassword
{
    /**
     * The URIs that should be excluded from Require Change Password.
     *
     * @var array<int, string>
     */
    protected $except = [
        '*/auth/password',
        '*/change-password/store',
        '*/change-password',
        '/logout',
        '/auth/logout'
    ];
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  string|null $guard
     * @return mixed
     */
    public function handle($request, \Closure $next, $guard = null)
    {
        if(strpos($request->path(), 'install') === false and $user = $request->user() and $user->need_update_pw and !$this->inExceptArray($request) and !config('bc.disable_require_change_pw')){
            if($request->expectsJson()){
                return response()->json([
                    'status'=>0,
                    'message'=>__("For security, please change your password to continue"),
                    'code'=>"need_update_pw"
                ]);
            }
            return redirect(route('user.change_password',['need_update_pw'=>1]))->with('warning',__("For security, please change your password to continue"));
        }
        return $next($request);
    }

    /**
     * Determine if the request has a URI that should pass through CSRF verification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function inExceptArray($request)
    {
        foreach ($this->except as $except) {
            if ($except !== '/') {
                $except = trim($except, '/');
            }

            if ($request->fullUrlIs($except) || $request->is($except)) {
                return true;
            }
        }

        return false;
    }
}

<?php
namespace Modules\Tracking\Middleware;

class TrackingMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        $keys = [
            'utm_campaign',
            'utm_source',
            'utm_medium',
            'utm_content',
            'utm_term',
        ];
        foreach ($keys as $k){
            if($request->query($k)){
                setcookie($k,$request->query($k),time() + DAY_IN_SECONDS * 30);
            }
        }

        return $next($request);
    }
}

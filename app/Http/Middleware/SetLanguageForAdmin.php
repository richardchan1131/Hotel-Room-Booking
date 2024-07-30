<?php
namespace App\Http\Middleware;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

use Closure;
class SetLanguageForAdmin
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
        if (strpos($request->path(), 'install') === false && file_exists(storage_path() . '/installed')) {

            $request = \request();
            $locale = $request->segment(1);
            $languages = \Modules\Language\Models\Language::getActive();
            $localeCodes = Arr::pluck($languages,'locale');
            // For Admin
            if($locale == 'admin' and $request->cookie('bc_admin_locale')){
                $locale = $request->cookie('bc_admin_locale');
            }
            if(in_array($locale,$localeCodes)){
                app()->setLocale($locale);
            }else{
                app()->setLocale(setting_item('site_locale'));
            }

        }
        return $next($request);
    }
}

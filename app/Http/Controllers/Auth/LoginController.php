<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\UserMeta;
use Carbon\Carbon;
use Dotenv\Util\Str;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Matrix\Exception;
use Modules\User\Events\SendMailUserRegistered;
use \Laravel\Socialite\Facades\Socialite;
use App\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/user/profile';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectTo()
    {
        if(Auth::user()->hasPermission('dashboard_access')){
            return '/admin';
        }else{
            return $this->redirectTo;
        }
    }

    public function showLoginForm()
    {
        return view('auth.login',['page_title'=> __("Login")]);
    }

    public function socialLogin($provider)
    {
        $this->initConfigs($provider);
        $redirectTo = request()->server('HTTP_REFERER',url('/'));
        session()->put('url.intended',$redirectTo);

        return Socialite::driver($provider)->redirect();
    }

    protected function initConfigs($provider)
    {
        switch($provider){
            case "facebook":
            case "google":
            case "twitter":
                config()->set([
                    'services.'.$provider.'.client_id'=>setting_item($provider.'_client_id'),
                    'services.'.$provider.'.client_secret'=>setting_item($provider.'_client_secret'),
                    'services.'.$provider.'.redirect'=>'/social-callback/'.$provider,
                ]);
            break;
        }
    }

    public function socialCallBack($provider)
    {
        try {
            $this->initConfigs($provider);

            $user = Socialite::driver($provider)->user();

            $redirectTo = $this->getRedirectTo();
            session()->forget('url.intended');


            if (empty($user)) {
                return redirect()->to('login')->with('error', __('Can not authorize'));
            }

            $existUser = User::getUserBySocialId($provider, $user->getId());

            if (empty($existUser)) {

                $meta = UserMeta::query()->where('name', 'social_' . $provider . '_id')->where('val', $user->getId())->first();
                if (!empty($meta)) {
                    $meta->delete();
                }

                // if we can not get email, then fake email will be generated
                $email = $user->getEmail();
                $email = $email?:$user->getId().'@'.$provider;

                $userByEmail = User::query()->where('email', $email)->first();
                if (!empty($userByEmail)) {
                    return redirect()->route('login')->with('error', __('Email :email exists. Can not register new account with your social email', ['email' => $email]));
                }

                // Create New User
                $realUser = new User();
                $realUser->email = $email;
                $realUser->password = Hash::make(uniqid() . time());
                $realUser->name = $user->getName();
                $realUser->first_name = $user->getName();
                $realUser->status = 'publish';
                $realUser->email_verified_at = Carbon::now();

                $realUser->save();

                $realUser->addMeta('social_' . $provider . '_id', $user->getId());
                $realUser->addMeta('social_' . $provider . '_email', $email);
                $realUser->addMeta('social_' . $provider . '_name', $user->getName());
                $realUser->addMeta('social_' . $provider . '_avatar', $user->getAvatar());
                $realUser->addMeta('social_meta_avatar', $user->getAvatar());

                $realUser->assignRole(setting_item('user_role'));

                try {
                    event(new SendMailUserRegistered($realUser));
                } catch (Exception $exception) {
                    Log::warning("SendMailUserRegistered: " . $exception->getMessage());
                }

                // Login with user
                Auth::login($realUser);

                return redirect($redirectTo);

            } else {

                if ($existUser->deleted == 1) {
                    return redirect()->route('login')->with('error', __('User blocked'));
                }
                if (in_array($existUser->status, ['blocked'])) {
                    return redirect()->route('login')->with('error', __('Your account has been blocked'));
                }

                Auth::login($existUser);

                return redirect($redirectTo);
            }
        }catch (\Exception $exception)
        {
            $message = $exception->getMessage();
            if(empty($message) and request()->get('error_message')) $message = request()->get('error_message');
            if(empty($message)) $message = $exception->getCode();

            return redirect()->route('login')->with('error',$message);
        }
    }

    public function getRedirectTo(){
        $url = session()->get('url.intended', url('/'));
        session()->forget('url.intended');
        if($url == url('/') or $url ==route('login') or $url == route('auth.register')){
            $url = url('/');
        }
        return $url;
    }


}

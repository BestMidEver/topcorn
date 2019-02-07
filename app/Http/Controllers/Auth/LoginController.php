<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;

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
    //protected $redirectTo = '/recommendations';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function socialLogin($social, $remember_me)
    {
        Session::flash('remember_me', $remember_me);
        return Socialite::driver($social)->redirect();
    }

    public function handleProviderCallBack($social)
    {
        $userSocial = Socialite::driver($social)->user();

        $findUser = User::where(['email' => $userSocial->getEmail()])->first();

        if($findUser){
            Auth::login($findUser, filter_var(session('remember_me'), FILTER_VALIDATE_BOOLEAN) );

            $user = Auth::user();
            if($user->facebook_profile_pic == null){
                $user->facebook_id = $userSocial->id;
                $user->facebook_profile_pic = $userSocial->avatar;
                $user->save();
            }
            return redirect()->intended()->with('link', 'Profile updated!');
        }else{
            $user = new User;
            $user->name = $userSocial->name;
            $user->email = $userSocial->email;
            $user->password = Hash::make($userSocial->id+config('constants.facebook.password_spice'));
            $user->facebook_id = $userSocial->id;
            $user->lang = App::getlocale();
            $user->secondary_lang = Session::get('secondary_lang');
            $user->facebook_profile_pic = $userSocial->avatar;
            $user->save();
            Auth::login($user, filter_var(session('remember_me'), FILTER_VALIDATE_BOOLEAN) );
            return redirect()->intended()->with('link', 'Profile updated!');
        }
    }
}

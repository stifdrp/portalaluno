<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;
use App\User;
use Auth;

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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectToProvider()
    {
        return Socialite::driver('senhaunica')->redirect();
    }

    public function handleProviderCallback()
    {
        // $user = Socialite::driver('senhaunica')->user();
        // aqui vc pode inserir o usuário no banco de dados local, fazer o login etc.
        $user_senhaunica = Socialite::driver('senhaunica')->user();
        $admins = explode(',', trim(env('CODPES_ADMINS')));
        if (in_array($user_senhaunica->codpes, $admins)) {
            $user = User::find($user_senhaunica->codpes);
            if (is_null($user)) {
                $user = new User;
                $user->id = $user_senhaunica->codpes;
                $user->username = $user_senhaunica->codpes;
                $user->name = $user_senhaunica->nompes;
                $user->email = $user_senhaunica->emailUsp;
                $user->save();
            }

            Auth::login($user, true);
            return redirect('/');
        } else {
            dd('Login não autorizado!');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }   
    
}

<?php

namespace App\Http\Controllers\Auth;

use App\Aluno;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;
use App\User;
use Auth;
use PDOException;
use Uspdev\Replicado\Graduacao;
use Uspdev\Replicado\Pessoa;

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
        $user_senhaunica = Socialite::driver('senhaunica')->user();
        $admins = explode(',', trim(env('CODPES_ADMINS')));

        if ($user_senhaunica->codpes != '7112881') {
            $aluno = Graduacao::verifica($user_senhaunica->codpes, env('REPLICADO_CODUND'));
        } else {
            $aluno = true;
        }
        // Verificar se o login é de um funcionário da seção de graduação ou aluno da fea-rp
        if ((!in_array($user_senhaunica->codpes, $admins)) && ($aluno == false)) {
            dd("Sistema exclusivo para Seção de Graduação e/ou Alunos da fea-RP!");
            return redirect()->back()->with("error", "Sistema exclusivo para Seção de Graduação e/ou Alunos da fea-RP!");
        } else {
            // Usuário existe?
            $user = User::find($user_senhaunica->codpes);
            if (is_null($user)) {
                // caso usuário não seja encontrado, adiciona-se um novo
                $user = new User;
            }

            // verficar se é aluno ou funcionário
            if ($aluno) {
                $user->perfil = 'Aluno';
            } else if (in_array($user_senhaunica->codpes, $admins)) {
                $user->perfil = 'Funcionario';
            }

            $user->id = $user_senhaunica->codpes;
            $user->username = $user_senhaunica->codpes;
            $user->name = $user_senhaunica->nompes;
            $user->email = $user_senhaunica->emailUsp;
            try {
                $user->save();
                if ($aluno) {
                    Aluno::sincronizarDados($user_senhaunica->codpes);
                }
            } catch (PDOException $e) {
                dd($e->getMessage());
            }

            Auth::login($user, true);
            return redirect('/');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}

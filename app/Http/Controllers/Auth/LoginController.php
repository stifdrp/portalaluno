<?php

namespace App\Http\Controllers\Auth;

use App\Aluno;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;
use App\User;
use Auth;
use Illuminate\Support\Facades\Session;
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
        $aluno = Graduacao::verifica($user_senhaunica->codpes, env('REPLICADO_CODUND'));

        // Verificar se o login é de um funcionário da seção de graduação ou aluno da fea-rp
        if ((!in_array($user_senhaunica->codpes, $admins)) && ($aluno == false)) {
            dd("Sistema exclusivo para Seção de Graduação e/ou Alunos da fea-RP!");
            return redirect()->back()->with("error", "Sistema exclusivo para Seção de Graduação e/ou Alunos da fea-RP!");
        }

        // Caso usuário não exista, insere um novo
        $user = User::firstOrNew(['id' => $user_senhaunica->codpes]);
        $user->perfil = 'Aluno';

        // Caso número USP esteja no array admins define perfil como 'funcionário'
        if (in_array($user_senhaunica->codpes, $admins)) {
            $user->perfil = 'Funcionario';
        }

        $user->id = $user_senhaunica->codpes;
        $user->username = $user_senhaunica->codpes;
        $user->name = $user_senhaunica->nompes;
        $user->email = $user_senhaunica->emailUsp;
        try {
            $user->save();
        } catch (PDOException $e) {
            dd($e->getMessage());
        }

        // TODO: verificar se no login é o melhor momento de fazer sync
        // Sincronizar informação da base replicada
        if ($aluno) {
            // aqui a função irá retornar true/false
            $aluno_sinc = Aluno::sincronizarDados($user_senhaunica->codpes);
            Session::put(['dados_aluno' => Aluno::getAluno($user_senhaunica->codpes)]);
        }

        Auth::login($user, true);
        return redirect('/');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}

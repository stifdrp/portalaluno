<?php

namespace App\Http\Controllers;

use App\Aluno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class FuncionarioPerfilAlunoController extends Controller
{
    public function index()
    {
        return view('funcionario_perfil_aluno.index');
    }
    /**
     * @param Request $request
     * guarda perfil aluno em sessão
     */
    public function store(Request $request)
    {
        $aluno_perfil = Aluno::getAluno($request->nusp);
        if ($aluno_perfil) {
            Session::forget('perfil_aluno');
            Session::put(['perfil_aluno' => $aluno_perfil]);
        }

        return redirect()->route('home');
    }
}

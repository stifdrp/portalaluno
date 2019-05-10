<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CertificadoConclusaoController extends Controller
{
    //
    public function index()
    {
        return view('certificado_conclusao.index');
    }
}

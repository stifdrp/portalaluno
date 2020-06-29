<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\RespostaTemplate;

class Pedido extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    //public function enviarEmail($email_destino)
    //{
    ////dd($this);
    ////dd($email_destino);
    ////return 'email enviado com sucesso!';
    //return false;
    //}

    public function documentos_solicitados()
    {
        return $this->hasMany('App\DocumentoSolicitado');
    }

    public function respostas_template()
    {
        return $this->hasMany('App\RespostaTemplate');
    }

    public function resposta_inicial(Pedido $pedido)
    {
        if (is_null($pedido)) {
            return false;
        }

        $resposta_padrao = RespostaTemplate::select('cabecalho', 'corpo', 'rodape')
            ->where([
                'formulario_id' => $pedido->formulario_id,
                'tipo' => 0,
                'status' => true,
            ])
            ->get();

        if ($resposta_padrao->isNotEmpty()) {
            return $resposta_padrao->first();
        } else {
            return false;
        }
    }
}

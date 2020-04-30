<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RespostaTemplate extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $table = 'respostas_templates';

    public function formulario()
    {
        return $this->belongsTo('App\Formulario');
    }

    public static function tipos_respostas()
    {
        $tipos = [
            ['id' => "0", 'nome' => "Resposta inicial", 'descricao' => "E-mail inicial enviado ao aluno"],
            ['id' => "1", 'nome' => "Resposta final [SIM]", 'descricao' => "E-mail de finalização enviado ao aluno"],
            ['id' => "2", 'nome' => "Resposta final [NÃO]", 'descricao' => "E-mail de finalização enviado ao aluno"],
        ];

        return $tipos;
    }
}

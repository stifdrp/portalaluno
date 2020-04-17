<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentoDisponivel extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $table = 'documentos_disponiveis';

    public function formulario()
    {
        return $this->belongsTo('App\Formulario');
    }

    public function documento_socilitado()
    {
        return $this->hasMany('App\DocumentoSolicitado');
    }
}

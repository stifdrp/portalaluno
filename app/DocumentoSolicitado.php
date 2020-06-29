<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocumentoSolicitado extends Model
{
    use SoftDeletes;

    protected $primaryKey = ['documento_disponivel_id', 'pedido_id'];
    public $incrementing = false;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $table = 'documentos_solicitados';

    public function pedido()
    {
        return $this->belongsTo('App\Pedido');
    }

    public function documento_disponivel()
    {
        return $this->belongsTo('App\DocumentoDisponivel');
    }
}

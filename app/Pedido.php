<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pedido extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function enviarEmail($email_destino)
    {
        //dd($this);
        //dd($email_destino);
        //return 'email enviado com sucesso!';
        return false;
    }
}

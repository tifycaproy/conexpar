<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class beneficios extends Model
{
    protected $table = 'beneficios';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['codigo','descripcion','desde','hasta','usuario','fecha_registro','id_tipobeneficiario'];
    protected $guarded  = ['codigo'];
}

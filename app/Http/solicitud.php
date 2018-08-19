<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class solicitud extends Model
{
     protected $table = 'solicitud';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id','fecha_solicitud','fecha_tramite','nrosolicitud','cedula_trabajador','cedula_beneficiario','usuario_id'];
    protected $guarded  = ['id'];
}

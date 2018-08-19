<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class categoria extends Model
{
        protected $table = 'categoria';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id','beneficio_id','descripcion','estatus','usuario_id'];
    protected $guarded  = ['id'];

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class trabajador extends Model
{
    protected $connection = 'mysql';
    protected $table = 'jos_intranet_datos_trabajador';

    
    public function scopeCedula($query,$cedula)
    {
    	//dd("scope: ".$cedula);
       $query->where('cedula','=',$cedula);
    }
}

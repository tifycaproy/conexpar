<?php

namespace App\Http\Controllers\Configurar;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CargosController extends Controller
{
    public function index(){
    	return view('Configurar.Cargos.index');
    }
    public function update(){
    	return view('Configurar.Cargos.edit');
    }
}

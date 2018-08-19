<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\tipobeneficiario;
use App\beneficios;


class BeneficiarioController extends Controller
{
   public function index()
   {

   }
   public function create()
   {
      $tipobeneficiario = tipobeneficiario::orderby('id')->get();
      return view('beneficios.create')->with('tipobeneficario',$tipobeneficario);
   }
   public function show()
   {

   }
   public function edit()
   {

   }
   public function store()
   {

   }

   public function update()
   {

   }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\reembolso;
use App\trabajador;
use App\beneficiarios;


class ReembolsoController extends Controller
{
    public function index()
    {
       $reembolso = reembolso::orderby('CedBen')->paginate(6);
       $beneficiarios = beneficiarios::orderby('CEDBEN')->get();
       $trabajador = trabajador::orderby('cedula')->get();
       return view('reembolso.index')->with('reembolso',$reembolso)
       ->with('trabajador',$trabajador)
       ->with('beneficiarios',$beneficiarios);   
    }

    public function show($id)
    {

    }

    public function edit($id)
    {

    }
    public function destroy($id)
    {

    }


}

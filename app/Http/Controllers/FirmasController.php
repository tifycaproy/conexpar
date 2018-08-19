<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\firmas;
@session_start();
class FirmasController extends Controller
{
    public function index()
    {
      $firmas = firmas::orderby('id','asc')->paginate(6);
      return view('firmas.index')->with('firmas',$firmas);
    }
    public function create()
    {
      return view('firmas.create');
    }
    public function edit($id)
    {
       $firmas= firmas::find($id);
       return view('firmas.edit')->with('firmas',$firmas);
    }
    public function show($id)
    {
       $firmas= firmas::find($id);
       return view('firmas.show')->with('firmas',$firmas);

    }
    public function store(Request $request)
    {
    try {

        $nombre = $request["nombre"];
        $cargo  = $request["cargo"];
        $nivel  = $request["nivel"];
        $posicion = $request["posicion"];
        
        if(firmas::where('nombre',$nombre)->where('cargo',$cargo)->first()){
            return redirect()->route('firmas.index')->with("notificacion","Ya se encuentra Registrado");

        }
        $firmas = new firmas($request->all());
        $firmas->created_at   = date('Y-m-d');
        $firmas->updated_at   = date('Y-m-d');
        $firmas->usuario_id   = $_SESSION["user"];
        $firmas->save();

        $firmas = firmas::orderby('id','asc')->paginate(6);
        return view('firmas.index')->with("firmas",$firmas);

    } catch (Exception $e) {
        \Log::info('Error creating item: '.$e);
        return \Response::json(['created' => false], 500);
    }
       
    }
    public function update(Request $request, $id)
    {
       $firmas= firmas::find($id);
        $nombre = $request["nombre"];
        $cargo  = $request["cargo"];
        $nivel  = $request["nivel"];
        $posicion = $request["posicion"];
        $estatus  = $request["estatus"];       
        $firmas->nombre = $nombre;
        $firmas->nivel  = $nivel;
        $firmas->cargo =  $cargo;
        $firmas->posicion = $posicion;
        $firmas->estatus = $estatus;
        $firmas->save();
        return redirect()->route('firmas.index');
    }
}

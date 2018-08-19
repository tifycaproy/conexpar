<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\beneficios;

@session_start();
class BeneficiosController extends Controller
{
    public function index(Request $request)
    {
       $valor=$request["valor"];
       if(isset($valor))
         $beneficios = beneficios::where('descripcion','like',$valor.'%')->orderby('descripcion','asc')->paginate(8);
       else
        $beneficios = beneficios::orderby('descripcion','ASC')->paginate(8);
        return view('beneficios.index')->with("beneficios",$beneficios);
    }
    public function create()
    {
    	
    	return view('beneficios.create');

    }
    public function show($id)
    {
       $beneficio = beneficios::find($id);
       return view('beneficios.show')->with('beneficio',$beneficio); 
    }
    public function edit($id)
    {
       $beneficio    = beneficios::find($id);
       return view('beneficios.edit')->with('beneficio',$beneficio); 

    }
    public function store(Request $request)
    {

        try {

	    	$codigo           = $request["codigo"];
	    	$estatus          = $request["estatus"];
	    	$tipobeneficiario = $request["tipobeneficiario"];
        $detalle_factura  = $request["detalle_factura"];
        $retroactivo      = $request["retroactivo"]; 
        $aplica_sueldo    = $request["aplica_sueldo"];    
	    	if(beneficios::where('codigo',$codigo)->first()){
                return redirect()->route('beneficios.index')->with("notificacion","Ya se encuentra Registrado");

        }
        $beneficios = new beneficios($request->all());
        $beneficios->codigo           = $codigo;
        $beneficios->detalle_factura  = $detalle_factura;
        $beneficios->estatus          = $estatus;
        $beneficios->tipobeneficiario = $tipobeneficiario;
        $beneficios->retroactivo = $retroactivo;
        $beneficios->aplica_sueldo = $aplica_sueldo;
	      $beneficios->created_at = date('Y-m-d');
	      $beneficios->updated_at = date('Y-m-d');
	      $beneficios->usuario_id = $_SESSION["user"];
	      $beneficios->save();
        return redirect()->route('beneficios.index')->with("notificacion","Se ha guardado correctamente su información");

        } catch (Exception $e) {
            \Log::info('Error creating item: '.$e);
            return \Response::json(['created' => false], 500);
        }



    }
    public function update(Request $request,$id)
    {
      
      $descripcion = $request["descripcion"];
      $estatus          = $request["estatus"];
      $detalle_factura  = $request["detalle_factura"];
      $tipobeneficiario = $request["tipobeneficiario"];
      $retroactivo      = $request["retroactivo"]; 
      $aplica_sueldo    = $request["aplica_sueldo"]; 

      $beneficios   = beneficios::find($id);
      $beneficios->fill($request->all());
      $beneficios->detalle_factura  = $detalle_factura;
      $beneficios->aplica_sueldo = $aplica_sueldo;
      $beneficios->save();
      return redirect()->route('beneficios.index')->with("notificacion","Se ha guardado correctamente su información");
    }

    public function destroy($id)
    {
    	
        $beneficios= Beneficios::find($id);
        $beneficios->destroy($id);
        $beneficios = beneficios::orderby('descripcion','ASC')->paginate(4);
        return view('beneficios.index')->with("beneficios",$beneficios);

    }
}

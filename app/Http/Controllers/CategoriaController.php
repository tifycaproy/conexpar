<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\categoria;
use App\beneficios;
use DB;
@session_start();
class CategoriaController extends Controller
{
    public function index(Request $request)
    {
      $valor=$request->valor;
      if(isset($valor))
      {
         $categoria = DB::table('categoria as a')
                         ->join('beneficios as b','a.beneficio_id','=','b.codigo')
                         ->select('a.id','a.codigo_categoria','a.descripcion','a.estatus','a.created_at','b.descripcion as Beneficio')
                         ->where('b.descripcion','like',$valor.'%')
                         ->orderby('a.id','asc')->paginate(6);

                       }
      else{       
         $categoria = DB::table('categoria as a')
                         ->join('beneficios as b','a.beneficio_id','=','b.codigo')
                         ->select('a.id','a.codigo_categoria','a.descripcion','a.estatus','a.created_at','b.descripcion as Beneficio')
                         ->orderby('a.id','asc')->paginate(6);
      }
        return view('categoria.index')->with("categoria",$categoria);
    }
    public function create()
    {
    	$beneficio=beneficios::orderby('descripcion','ASC')->get();
    	return view('categoria.create')->with('beneficio',$beneficio);

    }
    public function show($id)
    {
       $categoria = categoria::find($id);
       $beneficio_id = $categoria->beneficio_id;
       $beneficios = beneficios::find($beneficio_id);
       $beneficio = $beneficios->descripcion;
       return view('categoria.show')->with('categoria',$categoria)->with('beneficio',$beneficio); 
       
    }
    public function edit($id)
    {
       $categoria = categoria::find($id);
       $beneficio_id = $categoria->beneficio_id;
       $beneficios = beneficios::find($beneficio_id);
       $beneficio = $beneficios->descripcion;
       return view('categoria.edit')->with('categoria',$categoria)->with('beneficio',$beneficio); 
    }
    public function store(Request $request)
    {

        try {

	    	$beneficio_id     = $request["beneficio_id"];
        $descripcion      = $request["descripcion"];
	    	$estatus          = $request["estatus"];
        $codigo_categoria = $request["codigo_categoria"];
	    	if(categoria::where('beneficio_id',$beneficio_id)->where('descripcion',$descripcion)->first()){
                return redirect()->route('categoria.index')->with("notificacion","Ya se encuentra Registrado");

            }
            $categoria = new categoria($request->all());
            $categoria->beneficio_id     = $beneficio_id;
            $categoria->codigo_categoria     = $codigo_categoria;
            $categoria->estatus          = $estatus;
            $categoria->descripcion      = $descripcion;
	        $categoria->created_at = date('Y-m-d');
	        $categoria->updated_at = date('Y-m-d');
	        $categoria->usuario_id = $_SESSION["user"];
	        $categoria->save();
            return redirect()->route('categoria.index')->with("notificacion","Se ha guardado correctamente su información");

        } catch (Exception $e) {
            \Log::info('Error creating item: '.$e);
            return \Response::json(['created' => false], 500);
        }



    }
    public function update(Request $request,$id)
    {
       $categoria = categoria::find($id);
       $categoria->descripcion = $request["descripcion"];
       $categoria->save();
       return redirect()->route('categoria.index')->with("notificacion","Se ha guardado correctamente su información");
    }
    public function destroy($id)
    {
    	
        $categoria= categoria::find($id);
        $categoria->destroy($id);
        $categoria = categoria::orderby('descripcion','ASC')->paginate(4);
        return view('categoria.index')->with("categoria",$categoria);

    }
}

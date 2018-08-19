<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\categoria;
use App\beneficios;
use App\valoracion;
use DB;
@session_start();

class ValoracionController extends Controller
{
    public function index(Request $request)
    {
      $valor = $request->valor;
      if(isset($valor))
        {
         $valoracion = DB::table('valoracion as a')
       ->join('beneficios as b','a.beneficio_id','=','b.id')
       ->join('categoria as c','a.categoria_id','=','c.id')
       ->select('a.id','a.desde','a.hasta','a.valor','a.created_at','b.descripcion as beneficio','c.descripcion as categoria')
       ->where('b.descripcion','like',$valor.'%')
       ->orderby('a.id','asc')->paginate(6);


        }else{
       $valoracion = DB::table('valoracion as a')
       ->join('beneficios as b','a.beneficio_id','=','b.id')
       ->join('categoria as c','a.categoria_id','=','c.id')
       ->select('a.id','a.desde','a.hasta','a.valor','a.created_at','b.descripcion as beneficio','c.descripcion as categoria')
       ->orderby('a.id','asc')->paginate(8);

        }
       
       return view('valoracion.index')->with("valoracion",$valoracion);
   }

   public function create()
   {
     $beneficio = beneficios::orderby('descripcion','asc')->get();
     return view('valoracion.crear')->with('beneficio',$beneficio);
 }
 public function store(Request $request)
 {
    try {

        $beneficio_id = $request["beneficio_id"];
        $categoria_id = $request["categoria_id"];
        $desde        = $request["desde"];
        $hasta        = $request["hasta"];
        $valor        = $request["valor"];
        if(valoracion::where('beneficio_id',$beneficio_id)->where('categoria_id',$categoria_id)->where('desde',$desde)->where('hasta',$hasta)->first()){
            return redirect()->route('valoracion.index')->with("notificacion","Ya se encuentra Registrado");

        }
        $valoracion = new valoracion($request->all());
        $valoracion->beneficio_id = $beneficio_id;
        $valoracion->categoria_id = $categoria_id;
        $valoracion->desde        = $desde;
        $valoracion->hasta        = $hasta;
        $valoracion->valor        = $valor;
        $valoracion->created_at   = date('Y-m-d');
        $valoracion->updated_at   = date('Y-m-d');
        $valoracion->usuario_id   = $_SESSION["user"];
        $valoracion->save();

        $valoracion = DB::table('valoracion as a')
        ->join('beneficios as b','a.beneficio_id','=','b.id')
        ->join('categoria as c','a.categoria_id','=','c.id')
        ->select('a.id','a.desde','a.hasta','a.valor','a.created_at','b.descripcion as beneficio','c.descripcion as categoria')
        ->orderby('a.id','asc')->paginate(6);
        return view('valoracion.index')->with("valoracion",$valoracion);

    } catch (Exception $e) {
        \Log::info('Error creating item: '.$e);
        return \Response::json(['created' => false], 500);
    }

}
public function show($id)
{
       $valoracion = valoracion::find($id);
       $beneficio_id = $valoracion->beneficio_id;
       $categoria_id = $valoracion->categoria_id;
       $beneficios = beneficios::find($beneficio_id);
       $beneficio = $beneficios->descripcion;
       $categorias = categoria::find($categoria_id);
       $categoria = $categorias->descripcion;
       return view('valoracion.show')->with("valoracion",$valoracion)->with('beneficio',$beneficio)->with('categoria',$categoria);
 
}
public function edit($id)
{
       $valoracion = valoracion::find($id);
       $beneficio_id = $valoracion->beneficio_id;
       $categoria_id = $valoracion->categoria_id;
       $beneficios = beneficios::find($beneficio_id);
       $beneficio = $beneficios->descripcion;
       $categorias = categoria::find($categoria_id);
       $categoria = $categorias->descripcion;
       return view('valoracion.edit')->with("valoracion",$valoracion)->with('beneficio',$beneficio)->with('categoria',$categoria);

}
public function update(Request $request, $id)
{
    $valoracion = valoracion::find($id);
    $valoracion->desde = $request["desde"];
    $valoracion->hasta = $request["hasta"];
    $valoracion->valor = $request["valor"];
    $valoracion->save();
        $valoracion = DB::table('valoracion as a')
        ->join('beneficios as b','a.beneficio_id','=','b.id')
        ->join('categoria as c','a.categoria_id','=','c.id')
        ->select('a.id','a.desde','a.hasta','a.valor','a.created_at','b.descripcion as beneficio','c.descripcion as categoria')
        ->orderby('a.id','asc')->paginate(6);
        return view('valoracion.index')->with("valoracion",$valoracion);

}

public function carga_categoria(Request $request)
{
  $request->all();
  if(isset($request["idbeneficio"])) $idbeneficio=$request["idbeneficio"];
  $categoria = categoria::where('beneficio_id',$idbeneficio)->get();
  foreach ($categoria as $cat) {
      echo '<option value="' .$cat->codigo_categoria. '">' .$cat->descripcion. '</option>';
  }
  return null;
}

 public function destroy($id)
    {
      
       $valoracion= valoracion::find($id);
       $valoracion->destroy($id);
       $valoracion = valoracion::orderby('descripcion','ASC')->paginate(4);
       $valoracion = DB::table('valoracion as a')
        ->join('beneficios as b','a.beneficio_id','=','b.id')
        ->join('categoria as c','a.categoria_id','=','c.id')
        ->select('a.id','a.desde','a.hasta','a.valor','a.created_at','b.descripcion as beneficio','c.descripcion as categoria')
        ->orderby('a.id','asc')->paginate(6);
        return view('valoracion.index')->with("valoracion",$valoracion);

    }
}

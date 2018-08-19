<?php

namespace App\Http\Controllers;
use App\beneficios;
use App\solicitud;
use App\categoria;
use App\User;
use Auth;
use DB;
@session_start();
use Illuminate\Http\Request;

class anularController extends Controller
{
  public function index(Request $request)
  {
    $beneficios = beneficios::where('estatus','Activo')->orderby('descripcion','asc')->get();
    $tipo            = $request["tipo"];
    if(isset($_SESSION["user"])){ 	
    $user            = $_SESSION["user"]; 
    $usuario = User::find($user);
    $perfil  = $usuario->rol_id;
    }
    
    if($perfil==2){
        $alto_nivel  = $_SESSION["altonivel"];
        $empleados   = $_SESSION["empleados"];
        $contratados = $_SESSION["contratados"];
        $obreros     = $_SESSION["obreros"];
        $jubilados   = $_SESSION["jubilados"];
        if(isset($alto_nivel))  $nomina = "ALTO NIVEL";
        if(isset($empleados))   $nomina = "EMPLEADOS";
        if(isset($contratados)) $nomina = "CONTRATADOS";
        if(isset($obreros))     $nomina = "OBREROS";
    }else{$nomina="";}
    return view('anular.anular')->with('beneficios',$beneficios)->with('nomina',$nomina)->with('perfil',$perfil);
  }
  public function create(Request $request)
  {

   $tipon = $request["tipon"];
   
   $zmes  = $request["zmes"];
   $user  = $_SESSION["user"]; 
   $tipo  = $request["tipo"]; 
   $beneficio_id = $request["beneficio_id"];
   $fecha_registro = $request["fecha_registro"];
   $fecha_tramite = $request["fecha_tramite"];
   if($fecha_registro!='' || $fecha_tramite=='' ){
   $solicitud = DB::table('solicitud as a')
            ->join('beneficios as b','a.beneficio_id','=','b.codigo') 
            ->join("categoria as c",function($join){
              $join->on("c.codigo_categoria","=","a.categoria_id")
              ->on("c.beneficio_id","=","a.beneficio_id");
            })    
            ->select('a.id', 'a.nrosolicitud','a.fecha_registro','a.cedula_trabajador as cedula','b.descripcion as beneficio','c.descripcion as dcategoria','a.monto','a.nombres','a.descripcion')
            ->where('fecha_registro','=',$fecha_registro)
            ->where('tipo_nomina','LIKE',$tipon)
            ->where('a.beneficio_id',$beneficio_id)
            ->orderBy('a.nrosolicitud','desc')
            ->paginate(6);
            $beneficios=beneficios::where('codigo',$beneficio_id)->first();
            $beneficio = $beneficios->descripcion;
        }
   if($fecha_registro=='' || $fecha_tramite!=''){
   $solicitud = DB::table('solicitud as a')
            ->join('beneficios as b','a.beneficio_id','=','b.codigo') 
            ->join("categoria as c",function($join){
              $join->on("c.codigo_categoria","=","a.categoria_id")
              ->on("c.beneficio_id","=","a.beneficio_id");
            })    
            ->select('a.id', 'a.nrosolicitud','a.fecha_registro','a.cedula_trabajador as cedula','b.descripcion as beneficio','c.descripcion as dcategoria','a.monto','a.nombres','a.descripcion')
            ->where('fecha_tramite','=',$fecha_tramite)
            ->where('tipo_nomina','LIKE',$tipon)
            ->where('a.beneficio_id',$beneficio_id)
            ->orderBy('a.nrosolicitud','desc')
            ->paginate(6);
            $beneficios=beneficios::where('codigo',$beneficio_id)->first();
            $beneficio = $beneficios->descripcion;
        }

   if($fecha_registro!='' || $fecha_tramite!=''){
   $solicitud = DB::table('solicitud as a')
            ->join('beneficios as b','a.beneficio_id','=','b.codigo') 
            ->join("categoria as c",function($join){
              $join->on("c.codigo_categoria","=","a.categoria_id")
              ->on("c.beneficio_id","=","a.beneficio_id");
            })    
            ->select('a.id', 'a.nrosolicitud','a.fecha_registro','a.cedula_trabajador as cedula','b.descripcion as beneficio','c.descripcion as dcategoria','a.monto','a.nombres','a.descripcion')
            ->where('fecha_tramite','=',$fecha_tramite)
            ->where('fecha_registro','=',$fecha_registro)
            ->where('tipo_nomina','LIKE',$tipon)
            ->where('a.beneficio_id',$beneficio_id)
            ->orderBy('a.nrosolicitud','desc')
            ->paginate(6);
            $beneficios=beneficios::where('codigo',$beneficio_id)->first();
            $beneficio = $beneficios->descripcion;
        }
    if(!isset($solicitud->nrosolicitud)){
      return redirect()->route('anular.index')->with("notificacion","No existe registros");
    }
    else{
    return view('anular.create')->with('solicitud',$solicitud)->with('nomina',$tipon)->with('fecha_registro',$fecha_registro)->with('fecha_tramite',$fecha_tramite)->with('beneficio_id',$beneficio_id)->with('beneficio',$beneficio);

    }
  }
  
  public function store(Request $request)
  {
  
   $tipon = $request["tipon"];
   
   $zmes  = $request["zmes"];
   $user  = $_SESSION["user"]; 
   $tipo  = $request["tipo"]; 
   $beneficio_id = $request["beneficio_id"];
   $fecha_registro = $request["fecha_registro"];
   $fecha_tramite = $request["fecha_tramite"];
   if($fecha_registro!='' || $fecha_tramite==''){
   $solicitud = DB::table('solicitud as a')
            ->join('beneficios as b','a.beneficio_id','=','b.codigo') 
            ->join("categoria as c",function($join){
              $join->on("c.codigo_categoria","=","a.categoria_id")
              ->on("c.beneficio_id","=","a.beneficio_id");
            })    
            ->select('a.id', 'a.nrosolicitud','a.fecha_registro','a.cedula_trabajador as cedula','b.descripcion as beneficio','c.descripcion as dcategoria','a.monto','a.nombres','a.descripcion')
            ->where('fecha_registro','=',$fecha_registro)
            ->where('tipo_nomina','LIKE',$tipon)
            ->where('a.beneficio_id',$beneficio_id)
            ->orderBy('a.nrosolicitud','desc')
            ->paginate(6);
            $beneficios=beneficios::where('codigo',$beneficio_id)->first();
            $beneficio = $beneficios->descripcion;
        }
   if($fecha_registro=='' || $fecha_tramite!=''){
   $solicitud = DB::table('solicitud as a')
            ->join('beneficios as b','a.beneficio_id','=','b.codigo') 
            ->join("categoria as c",function($join){
              $join->on("c.codigo_categoria","=","a.categoria_id")
              ->on("c.beneficio_id","=","a.beneficio_id");
            })    
            ->select('a.id', 'a.nrosolicitud','a.fecha_registro','a.cedula_trabajador as cedula','b.descripcion as beneficio','c.descripcion as dcategoria','a.monto','a.nombres','a.descripcion')
            ->where('fecha_tramite','=',$fecha_tramite)
            ->where('tipo_nomina','LIKE',$tipon)
            ->where('a.beneficio_id',$beneficio_id)
            ->orderBy('a.nrosolicitud','desc')
            ->paginate(6);
            $beneficios=beneficios::where('codigo',$beneficio_id)->first();
            $beneficio = $beneficios->descripcion;
        }
       if($fecha_registro!='' || $fecha_tramite!=''){
   $solicitud = DB::table('solicitud as a')
            ->join('beneficios as b','a.beneficio_id','=','b.codigo') 
            ->join("categoria as c",function($join){
              $join->on("c.codigo_categoria","=","a.categoria_id")
              ->on("c.beneficio_id","=","a.beneficio_id");
            })    
            ->select('a.id', 'a.nrosolicitud','a.fecha_registro','a.cedula_trabajador as cedula','b.descripcion as beneficio','c.descripcion as dcategoria','a.monto','a.nombres','a.descripcion')
            ->where('fecha_tramite','=',$fecha_tramite)
            ->where('fecha_registro','=',$fecha_registro)
            ->where('tipo_nomina','LIKE',$tipon)
            ->where('a.beneficio_id',$beneficio_id)
            ->orderBy('a.nrosolicitud','desc')
            ->paginate(6);
            $beneficios=beneficios::where('codigo',$beneficio_id)->first();
            $beneficio = $beneficios->descripcion;
        }

    foreach ($zsolicitud as $sol) {
       $id = $sol->id;
       $solicitud= solicitud::find($id);
       $solicitud->destroy($id);
        }            
  return redirect()->route('anular.index')->with("notificacion","Se ha eliminado correctamente su información");


  }
    
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\solicitud;
use App\beneficios;
use App\categoria;
use App\trabajador;
use App\User;
use App\firmas;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade as PDF;
@session_start();

class RptmensualController extends Controller
{
    public function index(){
     $user            = $_SESSION["user"]; 
         $usuario = User::find($user);
         $perfil  = $usuario->rol_id;
         if($perfil==2){
           if($usuario->alto_nivel==1)   $nomina="ALTO NIVEL";
           if($usuario->contratados==1) $nomina="CONTRATADOS";
           if($usuario->empleados==1)  $nomina="EMPLEADOS";
           if($usuario->obreros==1)    $nomina="OBREROS";
           if($usuario->jubilados==1)    $nomina="JUBILADOS";
       }
        else {$nomina="";}
	    $beneficios = beneficios::where('estatus','Activo')->get();
	    return view('repmensual.index')->with('perfil',$perfil)->with('nomina',$nomina)->with('beneficios',$beneficios);
    }

	public function create(Request $request)
  {
    
    $nomina         = $request["tipon"];
    $beneficio_id   = $request->beneficio_id;
    $mes            = $request->mes;
    $tipor          = $request->tipor;
    $fecha_tramite =  $request->fecha_tramite;
    //dd($request);
    if($nomina!=null && $beneficio_id!=null && $mes!=null && $fecha_tramite==null)
    {
      
      $solicitud = DB::table('solicitud as a')
              ->join('beneficios as b','a.beneficio_id','=','b.codigo') 
              ->join("categoria as c",function($join){
                $join->on("c.codigo_categoria","=","a.categoria_id")
                ->on("c.beneficio_id","=","a.beneficio_id");
              })    
              ->select('a.beneficio_id','b.descripcion as beneficio','a.categoria_id','c.descripcion as dcategoria',DB::raw('count(a.beneficio_id) as cantidad'), DB::raw('sum(a.monto) as montob') , DB::raw('sum(a.monto_retroactivo) as montor'),'a.tipo_nomina' )
              ->where('a.beneficio_id','=',$beneficio_id)
              ->where('a.tipo_nomina','LIKE',$nomina)
              ->whereMonth('a.fecha_tramite',$mes)
              ->where('a.fecha_tramite',$fecha_tramite)
              ->groupBy('beneficio_id','beneficio','categoria_id','dcategoria','tipo_nomina')
               ->get();
    }
    if($nomina!=null && $beneficio_id!=null && $mes==null && $fecha_tramite!=null)
    {
      $beneficios   = beneficios::where('id',$beneficio_id)->first();
      $beneficio    = $beneficios->descripcion;
      $solicitud    = DB::table('solicitud as a')
              ->join('beneficios as b','a.beneficio_id','=','b.codigo') 
              ->join("categoria as c",function($join){
                $join->on("c.codigo_categoria","=","a.categoria_id")
                ->on("c.beneficio_id","=","a.beneficio_id");
              })    
              ->select('a.beneficio_id','b.descripcion as beneficio','a.categoria_id','c.descripcion as dcategoria',DB::raw('count(a.beneficio_id) as cantidad') , DB::raw('sum(a.monto) as montob') , DB::raw('sum(a.monto_retroactivo) as montor') ,'a.tipo_nomina')
              ->where('a.beneficio_id','=',$beneficio_id)
              ->where('a.tipo_nomina','LIKE',$nomina)
              ->where('a.fecha_tramite',$fecha_tramite)
              ->groupBy('beneficio_id','beneficio','categoria_id','dcategoria','tipo_nomina')
              ->get();

    }

    if($nomina!=null && $beneficio_id==null && $mes!=null && $fecha_tramite!=null)
    {
      
      $beneficio = "";
      $solicitud    = DB::table('solicitud as a')
              ->join('beneficios as b','a.beneficio_id','=','b.codigo') 
              ->join("categoria as c",function($join){
                $join->on("c.codigo_categoria","=","a.categoria_id")
                ->on("c.beneficio_id","=","a.beneficio_id");
              })    
              ->select('a.beneficio_id','b.descripcion as beneficio','a.categoria_id','c.descripcion as dcategoria',DB::raw('count(a.beneficio_id) as cantidad') , DB::raw('sum(a.monto) as montob') , DB::raw('sum(a.monto_retroactivo) as montor' ) ,'a.tipo_nomina')
              ->where('a.tipo_nomina','LIKE',$nomina)
              ->whereMonth('a.fecha_tramite',$mes)
              ->where('a.fecha_tramite',$fecha_tramite)
              ->groupBy('beneficio_id','beneficio','categoria_id','dcategoria','tipo_nomina')
               ->get();
    }

    if($nomina!=null && $beneficio_id==null && $mes==null && $fecha_tramite!=null)
    {
      
      $solicitud    = DB::table('solicitud as a')
              ->join('beneficios as b','a.beneficio_id','=','b.codigo') 
              ->join("categoria as c",function($join){
                $join->on("c.codigo_categoria","=","a.categoria_id")
                ->on("c.beneficio_id","=","a.beneficio_id");
              })    
              ->select('a.beneficio_id','b.descripcion as beneficio','a.categoria_id','c.descripcion as dcategoria',DB::raw('count(a.beneficio_id) as cantidad') , DB::raw('sum(a.monto) as montob'), DB::raw('sum(a.monto_retroactivo) as montor') ,'a.tipo_nomina')
              ->where('a.tipo_nomina','LIKE',$nomina)
              ->where('a.fecha_tramite',$fecha_tramite)
              ->groupBy('beneficio_id','beneficio','categoria_id','dcategoria','tipo_nomina')
               ->get();
      
      $beneficio = "";
    }

   if($tipor=='1')
   {

    return view('repmensual.create')->with('solicitud',$solicitud)->with('nomina',$nomina)->with('beneficio',$beneficio)->with('beneficio_id',$beneficio_id)->with('mes',$mes)->with('fecha_tramite',$fecha_tramite);
   }
   $firmantes = firmas::where('posicion','1')->where('estatus','Activo')->first();
   if($tipor=='2')
   {
      $pdf = PDF::loadView('pdf.rptsolicitud',['solicitud'=>$solicitud,'firmas'=>$firmantes]);

      return $pdf->download('listado.pdf');
   }
   if($tipor=='3')
   {

Excel::create("Listado", function ($excel) use ($solicitud) {
    $excel->setTitle("listado");
    $excel->sheet("Sheet 1", function ($sheet) use ($solicitud) {
      $sheet->loadView('excel.rptmensual')->with('solicitud', $solicitud);
    });
  })->download('xls');
  return back();
   }

  }

}

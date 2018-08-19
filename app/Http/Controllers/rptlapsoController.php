<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\solicitud;
use App\beneficios;
use App\categoria;
use App\trabajador;
use App\User;
use DB;
use App\firmas;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade as PDF;
@session_start();

class rptlapsoController extends Controller
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
	    return view('replapso.index')->with('perfil',$perfil)->with('nomina',$nomina)->with('beneficios',$beneficios);
    }

	public function create(Request $request)
  {
    
    $nomina         = $request["tipon"];
    $beneficio_id   = $request->beneficio_id;
    $tipor          = $request->tipor;
    $tipol          = $request->tipol;
    $desde          =  $request->desde;
    $hasta          =  $request->hasta;
    $beneficio="";
    if($beneficio_id!=null && $tipol=='1')
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
              ->where('a.fecha_registro','>=',$desde)
              ->where('a.fecha_registro','<=',$hasta)
              ->groupBy('beneficio_id','beneficio','categoria_id','dcategoria','tipo_nomina')
               ->get();
    }
    if($beneficio_id==null && $tipol=='1')
    {
        
         $solicitud = DB::table('solicitud as a')
              ->join('beneficios as b','a.beneficio_id','=','b.codigo') 
              ->join("categoria as c",function($join){
                $join->on("c.codigo_categoria","=","a.categoria_id")
                ->on("c.beneficio_id","=","a.beneficio_id");
              })    
              ->select('a.beneficio_id','b.descripcion as beneficio','a.categoria_id','c.descripcion as dcategoria',DB::raw('count(a.beneficio_id) as cantidad'), DB::raw('sum(a.monto) as montob') , DB::raw('sum(a.monto_retroactivo) as montor'),'a.tipo_nomina' )
              ->where('a.tipo_nomina','LIKE',$nomina)
              ->where('a.fecha_registro','>=',$desde)
              ->where('a.fecha_registro','<=',$hasta)
              ->groupBy('beneficio_id','beneficio','categoria_id','dcategoria','tipo_nomina')
               ->get();
    }

    if($beneficio_id!=null && $tipol=='2')
    {
      $beneficios   = beneficios::where('id',$beneficio_id)->first();
      $beneficio    = $beneficios->descripcion;
      $grupos    = DB::table('solicitud as a')
              ->join('beneficios as b','a.beneficio_id','=','b.codigo') 
              ->join("categoria as c",function($join){
                $join->on("c.codigo_categoria","=","a.categoria_id")
                ->on("c.beneficio_id","=","a.beneficio_id");
              })    
              ->select('a.beneficio_id','b.descripcion as beneficio','a.categoria_id','c.descripcion as dcategoria','a.tipo_nomina')
              ->where('a.beneficio_id','=',$beneficio_id)
              ->where('a.tipo_nomina','LIKE',$nomina)
              ->where('a.fecha_registro','>=',$desde)
              ->where('a.fecha_registro','<=',$hasta)
              ->groupBy('beneficio_id','beneficio','categoria_id','dcategoria','tipo_nomina')
               ->get();
      $solicitud = DB::table('solicitud as a')
              ->join('beneficios as b','a.beneficio_id','=','b.codigo') 
              ->join("categoria as c",function($join){
                $join->on("c.codigo_categoria","=","a.categoria_id")
                ->on("c.beneficio_id","=","a.beneficio_id");
              })    
              ->select('a.id', 'a.nrosolicitud','a.fecha_registro','a.cedula_trabajador as cedula','b.descripcion as beneficio','c.descripcion as dcategoria','a.monto','a.beneficio_id','a.tipo_nomina','a.fecha_solicitud','a.nombres','a.monto_retroactivo','a.beneficiario','a.cedula_beneficiario','a.descripcion','a.categoria_id')
              ->where('a.beneficio_id','=',$beneficio_id)
              ->where('a.tipo_nomina','LIKE',$nomina)
              ->where('a.fecha_registro','>=',$desde)
              ->where('a.fecha_registro','<=',$hasta)
              ->orderBy('a.beneficio_id','asc')
              ->orderBy('a.categoria_id','asc')
              ->orderBy('a.nrosolicitud','asc')
              ->get();      

    }

    if($beneficio_id==null && $tipol=='2')
    {
     
      $grupos    = DB::table('solicitud as a')
              ->join('beneficios as b','a.beneficio_id','=','b.codigo') 
              ->join("categoria as c",function($join){
                $join->on("c.codigo_categoria","=","a.categoria_id")
                ->on("c.beneficio_id","=","a.beneficio_id");
              })    
              ->select('a.beneficio_id','b.descripcion as beneficio','a.categoria_id','c.descripcion as dcategoria','a.tipo_nomina')
              ->where('a.tipo_nomina','LIKE',$nomina)
              ->where('a.fecha_registro','>=',$desde)
              ->where('a.fecha_registro','<=',$hasta)
              ->groupBy('beneficio_id','beneficio','categoria_id','dcategoria','tipo_nomina')
               ->get();
      $solicitud = DB::table('solicitud as a')
              ->join('beneficios as b','a.beneficio_id','=','b.codigo') 
              ->join("categoria as c",function($join){
                $join->on("c.codigo_categoria","=","a.categoria_id")
                ->on("c.beneficio_id","=","a.beneficio_id");
              })    
              ->select('a.id', 'a.nrosolicitud','a.fecha_registro','a.cedula_trabajador as cedula','b.descripcion as beneficio','c.descripcion as dcategoria','a.monto','a.beneficio_id','a.tipo_nomina','a.fecha_solicitud','a.nombres','a.monto_retroactivo','a.beneficiario','a.cedula_beneficiario','a.descripcion','a.categoria_id')
              ->where('a.tipo_nomina','LIKE',$nomina)
              ->where('a.fecha_registro','>=',$desde)
              ->where('a.fecha_registro','<=',$hasta)
              ->orderBy('a.beneficio_id','asc')
              ->orderBy('a.categoria_id','asc')
              ->orderBy('a.nrosolicitud','asc')
              ->get();      

    }

   if($tipor=='1')
   {

    return view('replapso.create')->with('solicitud',$solicitud)->with('nomina',$nomina)->with('beneficio',$beneficio)->with('beneficio_id',$beneficio_id)->with('desde',$desde)->with('hasta',$hasta)->with('tipol',$tipol);
   }
   $firmantes = firmas::where('posicion','1')->where('estatus','Activo')->first();
   if($tipor=='2' && $tipol=='1')
   {
      $pdf = PDF::loadView('pdf.rptlapso',['solicitud'=>$solicitud,'desde'=>$desde,'hasta'=>$hasta,'firmas'=>$firmantes]);
      return $pdf->download('listado.pdf');
   }

   if($tipor=='2' && $tipol=='2')
   {
      $pdf = PDF::loadView('pdf.rptlapsod',['grupos'=>$grupos,'solicitud'=>$solicitud,'desde'=>$desde,'hasta'=>$hasta,'firmas'=>$firmantes]);
      return $pdf->download('listado.pdf');
   }

   if($tipor=='3' && $tipol=='1')
   {

    Excel::create("Listado", function ($excel) use ($solicitud,$desde,$hasta) {
      $excel->setTitle("listado");
      $excel->sheet("Sheet 1", function ($sheet) use ($solicitud,$desde,$hasta) {
      $sheet->loadView('excel.rptlapso')->with('solicitud', $solicitud)->with('desde',$desde)->with('hasta',$hasta);
    });
  })->download('xls');
  return back();
   }

   if($tipor=='3' && $tipol=='2')
   {

    Excel::create("Listado", function ($excel) use ($solicitud,$desde,$hasta) {
      $excel->setTitle("listado");
      $excel->sheet("Sheet 1", function ($sheet) use ($solicitud,$desde,$hasta) {
      $sheet->loadView('excel.rptlapsod')->with('solicitud', $solicitud)->with('desde',$desde)->with('hasta',$hasta);
    });
  })->download('xls');
  return back();
   }


  }

}

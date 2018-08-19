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

class RptSolicitudController extends Controller
{
	public function index(Request $request)
	{
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
	    return view('repsolicitud.index')->with('beneficio',$beneficios)->with('perfil',$perfil)->with('nomina',$nomina);

	}

	public function create(Request $request)
  {
    
    $nomina         = $request["tipon"];
    $beneficio_id   = $request->beneficio_id;
    $tipof          = $request->tipo_fecha;
    $tipor          = $request->tipor;
    $fecha_tramite  = "";
    $fecha_registro = "";
    if($tipof=='1') $fecha_registro = $request->fecha_registro;
    if($tipof=='2') $fecha_tramite =  $request->fecha_registro;
    if($nomina!=null && $beneficio_id!=null && $fecha_registro!=null && $fecha_tramite==null)
    {
      
      $grupos    = DB::table('solicitud as a')
              ->join('beneficios as b','a.beneficio_id','=','b.codigo') 
              ->join("categoria as c",function($join){
                $join->on("c.codigo_categoria","=","a.categoria_id")
                ->on("c.beneficio_id","=","a.beneficio_id");
              })    
              ->select('a.beneficio_id','b.descripcion as beneficio','a.categoria_id','c.descripcion as dcategoria','a.tipo_nomina')
              ->where('a.beneficio_id','=',$beneficio_id)
              ->where('a.tipo_nomina','LIKE',$nomina)
              ->where('a.fecha_tramite',$fecha_tramite)
              ->groupBy('beneficio_id','beneficio','categoria_id','dcategoria','tipo_nomina')
               ->get();
      $beneficios = beneficios::where('id',$beneficio_id)->first();
      $beneficio = $beneficios->descripcion;
      $solicitud = DB::table('solicitud as a')
              ->join('beneficios as b','a.beneficio_id','=','b.codigo') 
              ->join("categoria as c",function($join){
                $join->on("c.codigo_categoria","=","a.categoria_id")
                ->on("c.beneficio_id","=","a.beneficio_id");
              })    
              ->select('a.id', 'a.nrosolicitud','a.fecha_registro','a.cedula_trabajador as cedula','b.descripcion as beneficio','c.descripcion as dcategoria','a.monto','a.beneficio_id','a.tipo_nomina','a.fecha_solicitud','a.nombres','a.monto_retroactivo','a.beneficiario','a.cedula_beneficiario','a.descripcion')
              ->where('a.beneficio_id','=',$beneficio_id)
              ->where('a.tipo_nomina','LIKE',$nomina)
              ->where('a.fecha_registro',$fecha_registro)
              ->orderBy('a.beneficio_id','asc')
              ->orderBy('a.categoria_id','asc')
              ->orderBy('a.nrosolicitud','asc')
              ->get();      
    }
    if($nomina!=null && $beneficio_id!=null && $fecha_registro==null && $fecha_tramite!=null)
    {
      $beneficios = beneficios::where('id',$beneficio_id)->first();
      $beneficio = $beneficios->descripcion;
      $grupos    = DB::table('solicitud as a')
              ->join('beneficios as b','a.beneficio_id','=','b.codigo') 
              ->join("categoria as c",function($join){
                $join->on("c.codigo_categoria","=","a.categoria_id")
                ->on("c.beneficio_id","=","a.beneficio_id");
              })    
              ->select('a.beneficio_id','b.descripcion as beneficio','a.categoria_id','c.descripcion as dcategoria','a.tipo_nomina')
              ->where('a.beneficio_id','=',$beneficio_id)
              ->where('a.tipo_nomina','LIKE',$nomina)
              ->where('a.fecha_tramite',$fecha_tramite)
              ->groupBy('beneficio_id','beneficio','categoria_id','dcategoria','tipo_nomina')
               ->get();

      $solicitud = DB::table('solicitud as a')
              ->join('beneficios as b','a.beneficio_id','=','b.codigo') 
              ->join("categoria as c",function($join){
                $join->on("c.codigo_categoria","=","a.categoria_id")
                ->on("c.beneficio_id","=","a.beneficio_id");
              })    
              ->select('a.id', 'a.nrosolicitud','a.fecha_registro','a.cedula_trabajador as cedula','b.descripcion as beneficio','c.descripcion as dcategoria','a.monto','a.beneficio_id','a.tipo_nomina','a.fecha_solicitud','a.nombres','a.monto_retroactivo','a.beneficiario','a.cedula_beneficiario','a.descripcion')
              ->where('a.beneficio_id','=',$beneficio_id)
              ->where('a.tipo_nomina','LIKE',$nomina)
              ->where('a.fecha_tramite',$fecha_tramite)
              ->orderBy('a.beneficio_id','asc')
              ->orderBy('a.categoria_id','asc')
              ->orderBy('a.nrosolicitud','asc')
              ->get();      
    }

    if($nomina!=null && $beneficio_id==null && $fecha_registro!=null && $fecha_tramite==null)
    {
      
      $beneficio = "";
      $grupos    = DB::table('solicitud as a')
              ->join('beneficios as b','a.beneficio_id','=','b.codigo') 
              ->join("categoria as c",function($join){
                $join->on("c.codigo_categoria","=","a.categoria_id")
                ->on("c.beneficio_id","=","a.beneficio_id");
              })    
              ->select('a.beneficio_id','b.descripcion as beneficio','a.categoria_id','c.descripcion as dcategoria','a.tipo_nomina')
              ->where('a.tipo_nomina','LIKE',$nomina)
              ->where('a.fecha_registro',$fecha_registro)
              ->groupBy('beneficio_id','beneficio','categoria_id','dcategoria','tipo_nomina')
               ->get();
      


      $solicitud = DB::table('solicitud as a')
              ->join('beneficios as b','a.beneficio_id','=','b.codigo') 
              ->join("categoria as c",function($join){
                $join->on("c.codigo_categoria","=","a.categoria_id")
                ->on("c.beneficio_id","=","a.beneficio_id");
              })    
              ->select('a.id', 'a.nrosolicitud','a.fecha_registro','a.cedula_trabajador as cedula','b.descripcion as beneficio','c.descripcion as dcategoria','a.monto','a.beneficio_id','a.categoria_id','a.tipo_nomina','a.fecha_solicitud','a.nombres','a.beneficiario','a.monto_retroactivo','a.cedula_beneficiario','a.descripcion')
              ->where('a.tipo_nomina','LIKE',$nomina)
              ->where('a.fecha_registro',$fecha_registro)
              ->orderBy('a.beneficio_id','asc')
              ->orderBy('a.categoria_id','asc')
              ->orderBy('a.nrosolicitud','asc')
              ->get();      
    }

    if($nomina!=null && $beneficio_id==null && $fecha_registro==null && $fecha_tramite!=null)
    {
      
      $grupos    = DB::table('solicitud as a')
              ->join('beneficios as b','a.beneficio_id','=','b.codigo') 
              ->join("categoria as c",function($join){
                $join->on("c.codigo_categoria","=","a.categoria_id")
                ->on("c.beneficio_id","=","a.beneficio_id");
              })    
              ->select('a.beneficio_id','b.descripcion as beneficio','a.categoria_id','c.descripcion as dcategoria','a.tipo_nomina')
              ->where('a.tipo_nomina','LIKE',$nomina)
              ->where('a.fecha_tramite',$fecha_tramite)
              ->groupBy('beneficio_id','beneficio','categoria_id','dcategoria','tipo_nomina')
               ->get();
      
      $beneficio = "";
      $solicitud = DB::table('solicitud as a')
              ->join('beneficios as b','a.beneficio_id','=','b.codigo') 
              ->join("categoria as c",function($join){
                $join->on("c.codigo_categoria","=","a.categoria_id")
                ->on("c.beneficio_id","=","a.beneficio_id");
              })    
              ->select('a.id', 'a.nrosolicitud','a.fecha_registro','a.cedula_trabajador as cedula','b.descripcion as beneficio','c.descripcion as dcategoria','a.monto','a.beneficio_id','a.categoria_id','a.tipo_nomina','a.fecha_solicitud','a.nombres','a.beneficiario','a.monto_retroactivo','a.cedula_beneficiario','a.descripcion')
              ->where('a.tipo_nomina','LIKE',$nomina)
              ->where('a.fecha_tramite',$fecha_tramite)
              ->orderBy('a.beneficio_id','asc')
              ->orderBy('a.categoria_id','asc')
              ->orderBy('a.nrosolicitud','asc')
              ->get();      
    }

    $trabajador      = trabajador::whereIn('situacion',['3','9','10','11','5','8','9'])->orderby('cedula')->get();

   if($tipor=='1')
   {

    return view('repsolicitud.create')->with('solicitud',$solicitud)->with('nomina',$nomina)->with('trabajador',$trabajador)->with('beneficio',$beneficio)->with('beneficio_id',$beneficio_id)->with('fecha_registro',$fecha_registro)->with('fecha_tramite',$fecha_tramite)->with('tipor',$tipor);
   }
   $firmantes = firmas::where('posicion','1')->where('estatus','Activo')->first();
   if($tipor=='2')
   {
      $cantidad = count($grupos);
      $pdf = PDF::loadView('pdf.rptsolicitud',['solicitud'=>$solicitud,'grupos'=>$grupos,'firmas'=>$firmantes,'cantidad'=>$cantidad]);
      return $pdf->download('listado.pdf');
   }
   if($tipor=='3')
   {

Excel::create("Listado", function ($excel) use ($solicitud,$firmantes) {
    $excel->setTitle("listado");
    $excel->sheet("Sheet 1", function ($sheet) use ($solicitud,$firmantes) {
      $sheet->loadView('excel.rptsolicitud')->with('solicitud', $solicitud)->with('firmantes',$firmantes);
    });
  })->download('xls');
  return back();
   }

  }

  
  public function pdf(Request $request)
  {
    
    $nomina = $request["tipon"];
    $beneficio_id=$request->beneficio_id;
    $tipof = $request->tipo_fecha;
    $fecha_registro = $request->fecha_registro;
    $fecha_tramite =  $request->fecha_tramite;
    if($nomina!=null && $beneficio_id!=null && $fecha_registro!=null && $fecha_tramite==null)
    {
      $beneficios = beneficios::where('id',$beneficio_id)->first();
      $beneficio = $beneficios->descripcion;
      $solicitud = DB::table('solicitud as a')
              ->join('beneficios as b','a.beneficio_id','=','b.codigo') 
              ->join("categoria as c",function($join){
                $join->on("c.codigo_categoria","=","a.categoria_id")
                ->on("c.beneficio_id","=","a.beneficio_id");
              })    
              ->select('a.id', 'a.nrosolicitud','a.fecha_registro','a.cedula_trabajador as cedula','b.descripcion as beneficio','c.descripcion as dcategoria','a.monto','a.beneficio_id','a.tipo_nomina','a.fecha_solicitud','a.nombres','a.monto_retroactivo','a.beneficiario','a.cedula_beneficiario','a.descripcion')
              ->where('a.beneficio_id','=',$beneficio_id)
              ->where('a.tipo_nomina','LIKE',$nomina)
              ->where('a.fecha_registro',$fecha_registro)
              ->orderBy('a.beneficio_id','asc')
              ->orderBy('a.categoria_id','asc')
              ->orderBy('a.nrosolicitud','asc')
              ->get();      
    }
    if($nomina!=null && $beneficio_id!=null && $fecha_registro==null && $fecha_tramite!=null)
    {
      $beneficios = beneficios::where('id',$beneficio_id)->first();
      $beneficio = $beneficios->descripcion;
      $grupos    = DB::table('solicitud as a')
              ->join('beneficios as b','a.beneficio_id','=','b.codigo') 
              ->join("categoria as c",function($join){
                $join->on("c.codigo_categoria","=","a.categoria_id")
                ->on("c.beneficio_id","=","a.beneficio_id");
              })    
              ->select('a.beneficio_id','b.descripcion as beneficio','a.categoria_id','c.descripcion as dcategoria','a.tipo_nomina')
              ->where('a.tipo_nomina','LIKE',$nomina)
              ->where('a.fecha_tramite',$fecha_tramite)
              ->groupBy('beneficio_id','beneficio','categoria_id','dcategoria','tipo_nomina')
               ->get();
      $solicitud = DB::table('solicitud as a')
              ->join('beneficios as b','a.beneficio_id','=','b.codigo') 
              ->join("categoria as c",function($join){
                $join->on("c.codigo_categoria","=","a.categoria_id")
                ->on("c.beneficio_id","=","a.beneficio_id");
              })    
              ->select('a.id', 'a.nrosolicitud','a.fecha_registro','a.cedula_trabajador as cedula','b.descripcion as beneficio','c.descripcion as dcategoria','a.monto','a.beneficio_id','a.tipo_nomina','a.fecha_solicitud','a.nombres','a.monto_retroactivo','a.beneficiario','a.cedula_beneficiario','a.descripcion')
              ->where('a.beneficio_id','=',$beneficio_id)
              ->where('a.tipo_nomina','LIKE',$nomina)
              ->where('a.fecha_tramite',$fecha_tramite)
              ->orderBy('a.beneficio_id','asc')
              ->orderBy('a.categoria_id','asc')
              ->orderBy('a.nrosolicitud','asc')
              ->get();      
    }

    if($nomina!=null && $beneficio_id==null && $fecha_registro!=null && $fecha_tramite==null)
    {
      
      $beneficios = beneficios::orderby('descripcion')->get();
      $beneficio = "";
      $grupos    = DB::table('solicitud as a')
              ->join('beneficios as b','a.beneficio_id','=','b.codigo') 
              ->join("categoria as c",function($join){
                $join->on("c.codigo_categoria","=","a.categoria_id")
                ->on("c.beneficio_id","=","a.beneficio_id");
              })    
              ->select('a.beneficio_id','b.descripcion as beneficio','a.categoria_id','c.descripcion as dcategoria','a.tipo_nomina')
              ->where('a.tipo_nomina','LIKE',$nomina)
              ->where('a.fecha_tramite',$fecha_tramite)
              ->groupBy('beneficio_id','beneficio','categoria_id','dcategoria','tipo_nomina')
               ->get();
      $solicitud = DB::table('solicitud as a')
              ->join('beneficios as b','a.beneficio_id','=','b.codigo') 
              ->join("categoria as c",function($join){
                $join->on("c.codigo_categoria","=","a.categoria_id")
                ->on("c.beneficio_id","=","a.beneficio_id");
              })    
              ->select('a.id', 'a.nrosolicitud','a.fecha_registro','a.cedula_trabajador as cedula','b.descripcion as beneficio','c.descripcion as dcategoria','a.monto','a.beneficio_id','a.categoria_id','a.tipo_nomina','a.fecha_solicitud','a.nombres','a.beneficiario','a.monto_retroactivo','a.cedula_beneficiario','a.descripcion')
              ->where('a.tipo_nomina','LIKE',$nomina)
              ->where('a.fecha_registro',$fecha_registro)
              ->orderBy('a.beneficio_id','asc')
              ->orderBy('a.categoria_id','asc')
              ->orderBy('a.nrosolicitud','asc')
              ->get();      
    }

    if($nomina!=null && $beneficio_id==null && $fecha_registro==null && $fecha_tramite!=null)
    {
      
      $beneficios = beneficios::orderby('descripcion')->get();
      $beneficio = "";
      $grupos    = DB::table('solicitud as a')
              ->join('beneficios as b','a.beneficio_id','=','b.codigo') 
              ->join("categoria as c",function($join){
                $join->on("c.codigo_categoria","=","a.categoria_id")
                ->on("c.beneficio_id","=","a.beneficio_id");
              })    
              ->select('a.beneficio_id','b.descripcion as beneficio','a.categoria_id','c.descripcion as dcategoria','a.tipo_nomina')
              ->where('a.tipo_nomina','LIKE',$nomina)
              ->where('a.fecha_tramite',$fecha_tramite)
              ->groupBy('beneficio_id','beneficio','categoria_id','dcategoria','tipo_nomina')
               ->get();
      $solicitud = DB::table('solicitud as a')
              ->join('beneficios as b','a.beneficio_id','=','b.codigo') 
              ->join("categoria as c",function($join){
                $join->on("c.codigo_categoria","=","a.categoria_id")
                ->on("c.beneficio_id","=","a.beneficio_id");
              })    
              ->select('a.id', 'a.nrosolicitud','a.fecha_registro','a.cedula_trabajador as cedula','b.descripcion as beneficio','c.descripcion as dcategoria','a.monto','a.beneficio_id','a.categoria_id','a.tipo_nomina','a.fecha_solicitud','a.nombres','a.beneficiario','a.monto_retroactivo','a.cedula_beneficiario','a.descripcion')
              ->where('a.tipo_nomina','LIKE',$nomina)
              ->where('a.fecha_tramite',$fecha_tramite)
              ->orderBy('a.beneficio_id','asc')
              ->orderBy('a.categoria_id','asc')
              ->orderBy('a.nrosolicitud','asc')
              ->get();      
    }
      $beneficio = beneficios::orderby('codigo')->get();
      $categoria = categoria::orderby('beneficio_id')->get();
      $pdf = PDF::loadView('pdf.rptsolicitud',compact('solicitud','grupos','beneficios','categoria'));

        return $pdf->download('listado.pdf');
  }


public function Excel($nomina,$beneficio_id,$fecha_registro,$fecha_tramite)
  {
    
    if($nomina!=null && $beneficio_id!=null && $fecha_registro!=null && $fecha_tramite==null)
    {
      $beneficios = beneficios::where('id',$beneficio_id)->first();
      $beneficio = $beneficios->descripcion;
      $grupos    = DB::table('solicitud as a')
              ->join('beneficios as b','a.beneficio_id','=','b.codigo') 
              ->join("categoria as c",function($join){
                $join->on("c.codigo_categoria","=","a.categoria_id")
                ->on("c.beneficio_id","=","a.beneficio_id");
              })    
              ->select('a.beneficio_id','b.descripcion as beneficio','a.categoria_id','c.descripcion as dcategoria','a.tipo_nomina')
              ->where('a.tipo_nomina','LIKE',$nomina)
              ->where('a.fecha_tramite',$fecha_tramite)
              ->groupBy('beneficio_id','beneficio','categoria_id','dcategoria','tipo_nomina')
               ->get();
      $solicitud = DB::table('solicitud as a')
              ->join('beneficios as b','a.beneficio_id','=','b.codigo') 
              ->join("categoria as c",function($join){
                $join->on("c.codigo_categoria","=","a.categoria_id")
                ->on("c.beneficio_id","=","a.beneficio_id");
              })    
              ->select('a.id', 'a.nrosolicitud','a.fecha_registro','a.cedula_trabajador as cedula','b.descripcion as beneficio','c.descripcion as dcategoria','a.monto','a.beneficio_id','a.tipo_nomina','a.fecha_solicitud','a.nombres','a.monto_retroactivo','a.beneficiario','a.cedula_beneficiario','a.descripcion')
              ->where('a.beneficio_id','=',$beneficio_id)
              ->where('a.tipo_nomina','LIKE',$nomina)
              ->where('a.fecha_registro',$fecha_registro)
              ->orderBy('a.beneficio_id','asc')
              ->orderBy('a.categoria_id','asc')
              ->orderBy('a.nrosolicitud','asc')
              ->get();      
    }
    if($nomina!=null && $beneficio_id!=null && $fecha_registro==null && $fecha_tramite!=null)
    {
      $beneficios = beneficios::where('id',$beneficio_id)->first();
      $beneficio = $beneficios->descripcion;
      $grupos    = DB::table('solicitud as a')
              ->join('beneficios as b','a.beneficio_id','=','b.codigo') 
              ->join("categoria as c",function($join){
                $join->on("c.codigo_categoria","=","a.categoria_id")
                ->on("c.beneficio_id","=","a.beneficio_id");
              })    
              ->select('a.beneficio_id','b.descripcion as beneficio','a.categoria_id','c.descripcion as dcategoria','a.tipo_nomina')
              ->where('a.tipo_nomina','LIKE',$nomina)
              ->where('a.fecha_tramite',$fecha_tramite)
              ->groupBy('beneficio_id','beneficio','categoria_id','dcategoria','tipo_nomina')
               ->get();
      $solicitud = DB::table('solicitud as a')
              ->join('beneficios as b','a.beneficio_id','=','b.codigo') 
              ->join("categoria as c",function($join){
                $join->on("c.codigo_categoria","=","a.categoria_id")
                ->on("c.beneficio_id","=","a.beneficio_id");
              })    
              ->select('a.id', 'a.nrosolicitud','a.fecha_registro','a.cedula_trabajador as cedula','b.descripcion as beneficio','c.descripcion as dcategoria','a.monto','a.beneficio_id','a.tipo_nomina','a.fecha_solicitud','a.nombres','a.monto_retroactivo','a.beneficiario','a.cedula_beneficiario','a.descripcion')
              ->where('a.beneficio_id','=',$beneficio_id)
              ->where('a.tipo_nomina','LIKE',$nomina)
              ->where('a.fecha_tramite',$fecha_tramite)
              ->orderBy('a.beneficio_id','asc')
              ->orderBy('a.categoria_id','asc')
              ->orderBy('a.nrosolicitud','asc')
              ->get();      
    }

    if($nomina!=null && $beneficio_id==null && $fecha_registro!=null && $fecha_tramite==null)
    {
      
      $beneficios = beneficios::orderby('descripcion')->get();
      $beneficio = "";
      $grupos    = DB::table('solicitud as a')
              ->join('beneficios as b','a.beneficio_id','=','b.codigo') 
              ->join("categoria as c",function($join){
                $join->on("c.codigo_categoria","=","a.categoria_id")
                ->on("c.beneficio_id","=","a.beneficio_id");
              })    
              ->select('a.beneficio_id','b.descripcion as beneficio','a.categoria_id','c.descripcion as dcategoria','a.tipo_nomina')
              ->where('a.tipo_nomina','LIKE',$nomina)
              ->where('a.fecha_tramite',$fecha_tramite)
              ->groupBy('beneficio_id','beneficio','categoria_id','dcategoria','tipo_nomina')
               ->get();
      $solicitud = DB::table('solicitud as a')
              ->join('beneficios as b','a.beneficio_id','=','b.codigo') 
              ->join("categoria as c",function($join){
                $join->on("c.codigo_categoria","=","a.categoria_id")
                ->on("c.beneficio_id","=","a.beneficio_id");
              })    
              ->select('a.id', 'a.nrosolicitud','a.fecha_registro','a.cedula_trabajador as cedula','b.descripcion as beneficio','c.descripcion as dcategoria','a.monto','a.beneficio_id','a.categoria_id','a.tipo_nomina','a.fecha_solicitud','a.nombres','a.beneficiario','a.monto_retroactivo','a.cedula_beneficiario','a.descripcion')
              ->where('a.tipo_nomina','LIKE',$nomina)
              ->where('a.fecha_registro',$fecha_registro)
              ->orderBy('a.beneficio_id','asc')
              ->orderBy('a.categoria_id','asc')
              ->orderBy('a.nrosolicitud','asc')
              ->get();      
    }

    if($nomina!=null && $beneficio_id==null && $fecha_registro==null && $fecha_tramite!=null)
    {
      
      $beneficios = beneficios::orderby('descripcion')->get();
      $beneficio = "";
      $grupos    = DB::table('solicitud as a')
              ->join('beneficios as b','a.beneficio_id','=','b.codigo') 
              ->join("categoria as c",function($join){
                $join->on("c.codigo_categoria","=","a.categoria_id")
                ->on("c.beneficio_id","=","a.beneficio_id");
              })    
              ->select('a.beneficio_id','b.descripcion as beneficio','a.categoria_id','c.descripcion as dcategoria','a.tipo_nomina')
              ->where('a.tipo_nomina','LIKE',$nomina)
              ->where('a.fecha_tramite',$fecha_tramite)
              ->groupBy('beneficio_id','beneficio','categoria_id','dcategoria','tipo_nomina')
               ->get();
      $solicitud = DB::table('solicitud as a')
              ->join('beneficios as b','a.beneficio_id','=','b.codigo') 
              ->join("categoria as c",function($join){
                $join->on("c.codigo_categoria","=","a.categoria_id")
                ->on("c.beneficio_id","=","a.beneficio_id");
              })    
              ->select('a.id', 'a.nrosolicitud','a.fecha_registro','a.cedula_trabajador as cedula','b.descripcion as beneficio','c.descripcion as dcategoria','a.monto','a.beneficio_id','a.categoria_id','a.tipo_nomina','a.fecha_solicitud','a.nombres','a.beneficiario','a.monto_retroactivo','a.cedula_beneficiario','a.descripcion')
              ->where('a.tipo_nomina','LIKE',$nomina)
              ->where('a.fecha_tramite',$fecha_tramite)
              ->orderBy('a.beneficio_id','asc')
              ->orderBy('a.categoria_id','asc')
              ->orderBy('a.nrosolicitud','asc')
              ->get();      
    }
      $beneficio = beneficios::orderby('codigo')->get();
      $categoria = categoria::orderby('beneficio_id')->get();

    Excel::create('Listado de Beneficios procesados', function($excel) {
            $excel->sheet('Data', function($sheet) {
                //otra opción -> $products = Product::select('name')->get();
                $sheet->fromArray($solicitud);
                $sheet->setOrientation('landscape');
            });
        })->export('xls');
    if(isset($solicitud)) $data['status']='ok';
    else $data['status']='no';
  }



}

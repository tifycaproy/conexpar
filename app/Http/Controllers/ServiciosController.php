<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\trabajador;
use App\solicitud;
use App\valoracion;
use DB;
@session_start();

class ServiciosController extends Controller
{
  public function index(Request $request)
  {
   $user    = $_SESSION["user"]; 
   $mes   = $request["mes"];
   $usuario = User::find($user);
   $perfil  = $usuario->rol_id;
   if($perfil==2)
    {
     if($usuario->alto_nivel==1) 
     {
       $nomina="ALTO NIVEL";
       $tipo = 1; 
     }
     if($usuario->contratados==1){
       $nomina="CONTRATADOS";
       $tipo=2;                    
     } 
     if($usuario->empleados==1){
       $nomina="EMPLEADOS";
       $tipo=2;
     } 
     if($usuario->obreros==1){
      $nomina="OBREROS";
      $tipo = 4;
    } 
  }
  else
  { 
    $nomina=""; 
}  
    
 return view('servicios.index')->with('perfil',$perfil)->with('nomina',$nomina);

}
public function create(Request $request)
{
   $tipon = $request["tipon"];
   $mes   = $request["mes"];
   $zmes   = $mes[0];
   $user    = $_SESSION["user"]; 
   $usuario = User::find($user);
   $perfil  = $usuario->rol_id;
   $procesar = 0;
   if($zmes==1) $nmes="Enero";
   if($zmes==2)  $nmes="Febrero";
   if($zmes==3)  $nmes="Marzo";
   if($zmes==4)  $nmes="Abril";
   if($zmes==5)  $nmes="Mayo";
   if($zmes==6)  $nmes="Junio";
   if($zmes==7)  $nmes="Julio";
   if($zmes==8)  $nmes="Agosto";
   if($zmes==9)  $nmes="Septiembre";
   if($zmes==10) $nmes="Octubre";
   if($zmes==11) $nmes="Noviembre";
   if($zmes==12) $nmes="Diciembre";
   $ano = date('Y');
   if(isset($tipon))
   {   
     if($tipon=='ALTO NIVEL') $tipo=1;
     if($tipon=='EMPLEADOS')  $tipo=2;
     if($tipon=='OBREROS') $tipo=4;
     if($tipon=='CONTRATADOS') $tipo=2;
     if($tipon=='ALTO NIVEL' || $tipon=='OBREROS'){
       $trabajador = trabajador::select('cedula','apellidos','nombres','fecha_ingreso',DB::raw('TIMESTAMPDIFF(YEAR, fecha_ingreso, CURDATE()) as tiempo'),'tipo','categoria','fecha_vencimiento')
                     ->whereIn(DB::raw('TIMESTAMPDIFF(YEAR, fecha_ingreso, CURDATE())'),['5','10','15','20','25','28']) 
                     ->where('tipo','=',$tipo)->whereMonth('fecha_ingreso','=',$zmes)
                     ->whereIn('situacion',['3','9','10','11','5','8','9'])
                     ->orderby('cedula')->get();
     }
     if($tipon=='CONTRATADOS'){
       $nomina=2;
       $ano=date("Y")-1;       
       $trabajador = trabajador::select('cedula','apellidos','nombres','fecha_ingreso',DB::raw('TIMESTAMPDIFF(YEAR, fecha_ingreso, CURDATE()) as tiempo'),'tipo','categoria','fecha_vencimiento')
                     ->whereIn(DB::raw('TIMESTAMPDIFF(YEAR, fecha_ingreso, CURDATE())'),['5','10','15','20','25','28']) 
                     ->where('tipo','=',$tipo)->whereMonth('fecha_ingreso','=',$zmes)
                     ->whereIn('categoria',['27','28'])
                     ->whereIn('situacion',['3','9','10','11','5','8','9'])
                     ->orderby('cedula')->get();
       
     }
     if($tipon=='EMPLEADOS'){
       $trabajador = trabajador::select('cedula','apellidos','nombres','fecha_ingreso',DB::raw('TIMESTAMPDIFF(YEAR, fecha_ingreso, CURDATE()) as tiempo'),'tipo','categoria','fecha_vencimiento')
                     ->whereIn(DB::raw('TIMESTAMPDIFF(YEAR, fecha_ingreso, CURDATE())'),['5','10','15','20','25','28']) 
                     ->where('tipo','=',$tipo)->whereMonth('fecha_ingreso','=',$zmes)
                     ->whereIn('categoria',['24','26', '21'])
                     ->whereIn('situacion',['3','9','10','11','5','8','9'])
                     ->orderby('cedula')->get();
     }
     $nomina = $tipon;
   }

     $solicitud = solicitud::select(DB::raw('COUNT(nrosolicitud) as total'))->where('mes',$nmes)->whereYear('fecha_registro',$ano)->where('tipo_nomina',$tipon)->first();
   $total = 0;   
   if(isset($solicitud))  $total = $solicitud->total;             
   if($total>0){
     return redirect()->route('servicios.index')->with("notificacion","Ya ha sido procesado")->with('nomina',$tipon)->with('trabajador',$trabajador);
    }
    else{             
 
     return view('servicios.create')->with('perfil',$perfil)->with('nomina',$nomina)->with('trabajador',$trabajador)->with('nmes',$nmes)->with('zmes',$zmes)->with('tipo',$tipo);
    }
}
public function store(Request $request)
{
   $tipon = $request["tipo_nomina"];
   $mes   = $request["mes"];
   $zmes  = $request["zmes"];
   $user  = $_SESSION["user"]; 
   $tipo  = $request["tipo"]; 
   $fecha_registro = date('Y-m-d');
   $fecha_tramite = $request["fecha_tramite"];
   $ano=date("Y")-1;       
   
   if($tipon=='ALTO NIVEL' || $tipon=='OBREROS'){
       $trabajador = trabajador::select('cedula','apellidos','nombres','fecha_ingreso',DB::raw('TIMESTAMPDIFF(YEAR, fecha_ingreso, CURDATE()) as tiempo'),'tipo','categoria','fecha_vencimiento')
                     ->whereIn(DB::raw('TIMESTAMPDIFF(YEAR, fecha_ingreso, CURDATE())'),['5','10','15','20','25','28']) 
                     ->where('tipo','=',$tipo)->whereMonth('fecha_ingreso','=',$zmes)
                     ->whereIn('situacion',['3','9','10','11','5','8','9'])
                     ->orderby('cedula')->get();
   }
  if($tipon=='CONTRATADOS'){
       $trabajador = trabajador::select('cedula','apellidos','nombres','fecha_ingreso',DB::raw('TIMESTAMPDIFF(YEAR, fecha_ingreso, CURDATE()) as tiempo'),'tipo','categoria','fecha_vencimiento')
                     ->whereIn(DB::raw('TIMESTAMPDIFF(YEAR, fecha_ingreso, CURDATE())'),['5','10','15','20','25','28']) 
                     ->where('tipo','=',$tipo)->whereMonth('fecha_ingreso','=',$zmes)
                     ->whereIn('categoria',['27','28'])
                     ->whereIn('situacion',['3','9','10','11','5','8','9'])
                     ->orderby('cedula')->get();
     
  }
  if($tipon=='EMPLEADOS'){
       $trabajador = trabajador::select('cedula','apellidos','nombres','fecha_ingreso',DB::raw('TIMESTAMPDIFF(YEAR, fecha_ingreso, CURDATE()) as tiempo'),'tipo','categoria','fecha_vencimiento')
                     ->whereIn(DB::raw('TIMESTAMPDIFF(YEAR, fecha_ingreso, CURDATE())'),['5','10','15','20','25','28']) 
                     ->where('tipo','=',$tipo)->whereMonth('fecha_ingreso','=',$zmes)
                     ->whereIn('categoria',['24','26', '21'])
                     ->whereIn('situacion',['3','9','10','11','5','8','9'])
                     ->orderby('cedula')->get();
  }
  $solicitud = solicitud::select(DB::raw('MAX(nrosolicitud) as mayor'))->first();
  //dd($solicitud);
  $mayor = $solicitud->mayor;
  $mayor++;
  $ano=date("Y");
  $vencimiento = $ano."-12-31";
  foreach($trabajador as $traba) 
  {

 if($traba->fecha_vencimiento=='0000-00-00' || $traba->fecha_vencimiento >= $vencimiento)
  {	
    $sol = new solicitud();
    $sol->nrosolicitud        = $mayor;
    $sol->fecha_registro      = $fecha_registro;
    $sol->fecha_tramite       = $fecha_tramite;
    $sol->cedula_trabajador   = $traba->cedula;
    $sol->cedula_beneficiario = $traba->cedula;
    $sol->mes                 = $mes;
    $sol->beneficio_id        = '016';
    if($traba->tiempo == 5)  $sol->categoria_id='001';
    if($traba->tiempo == 10) $sol->categoria_id='002';
    if($traba->tiempo == 15) $sol->categoria_id='003';
    if($traba->tiempo == 20) $sol->categoria_id='004';
    if($traba->tiempo == 25) $sol->categoria_id='005';
    if($traba->tiempo == 28) $sol->categoria_id='006';
    $valoracion=valoracion::where('beneficio_id','016')
                ->where('categoria_id',$sol->categoria_id)
                ->where('hasta','=','9999-12-31')->first();
    
    $sol->monto = $valoracion->valor;
    $sol->descripcion = 'Premios por Años de Servicios procesados el '.$fecha_registro;
    $sol->observaciones = $sol->descripcion;
    $sol->tipo_nomina = $tipon;
    $sol->created_at = $fecha_registro;
    $sol->fecha_solicitud = $fecha_registro;
    $sol->updated_at = $fecha_registro;
    $sol->usuario_id = $user;
    $sol->beneficiario = $traba->apellidos." ".$traba->nombres;
    $sol->nombres = $traba->apellidos." ".$traba->nombres;
    $sol->save();
    $mayor++;
   }
  }

 return redirect()->route('servicios.index')->with("notificacion","Se ha guardado correctamente su información")->with('nomina',$tipon)->with('trabajador',$trabajador);

 
} 

}



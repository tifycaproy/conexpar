<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\solicitud;
use App\beneficios;
use App\categoria;
use App\valoracion;
use App\trabajador;
use App\cargos;
use App\ubicaciones;
use App\beneficiarios;
use DB;
use App\User;
@session_start();

class SolicitudController extends Controller
{


  public function index(Request $request)
  {
    $tipo            = $request["tipo"];
    $user            = $_SESSION["user"]; 
    $usuario = User::find($user);
    $perfil  = $usuario->rol_id;
    $trabajador      = trabajador::orderby('cedula')->get();
    
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
    }
    
    if(isset($tipo)){
         if($tipo[0]==0) //todos
         {
          if($perfil==1)
          {
           	$solicitud = DB::table('solicitud as a')
           	->join('beneficios as b','a.beneficio_id','=','b.codigo') 
           	->join("categoria as c",function($join){
           		$join->on("c.codigo_categoria","=","a.categoria_id")
           		->on("c.beneficio_id","=","a.beneficio_id");
           	})    
           	->select('a.id', 'a.nrosolicitud','a.fecha_registro','a.cedula_trabajador as cedula','b.descripcion as beneficio','c.descripcion as dcategoria','a.monto')
           	->orderBy('a.nrosolicitud','desc')
           	->paginate(10);
          }
          if($perfil==2){
            $solicitud = DB::table('solicitud as a')
            ->join('beneficios as b','a.beneficio_id','=','b.codigo') 
            ->join("categoria as c",function($join){
              $join->on("c.codigo_categoria","=","a.categoria_id")
              ->on("c.beneficio_id","=","a.beneficio_id");
            })    
            ->select('a.id', 'a.nrosolicitud','a.fecha_registro','a.cedula_trabajador as cedula','b.descripcion as beneficio','c.descripcion as dcategoria','a.monto')
            ->where('tipo_nomina','LIKE',$nomina)
            ->orderBy('a.nrosolicitud','desc')
            ->paginate(10);
          }

         }
         if($tipo[0]==1) //cedula
         {
         	$valor = $request["cedula"];
          if($perfil==1){

          $solicitud = DB::table('solicitud as a')
          ->join('beneficios as b','a.beneficio_id','=','b.codigo') 
          ->join("categoria as c",function($join){
            $join->on("c.codigo_categoria","=","a.categoria_id")
            ->on("c.beneficio_id","=","a.beneficio_id");
          })    
          ->select('a.id', 'a.nrosolicitud','a.fecha_registro','a.cedula_trabajador as cedula','b.descripcion as beneficio','c.descripcion as dcategoria','a.monto')
          ->where('cedula_trabajador','LIKE',$valor)
          ->orderBy('a.nrosolicitud','desc')
          ->paginate(10);
          }
          if($perfil==2)
          {
            $solicitud = DB::table('solicitud as a')
            ->join('beneficios as b','a.beneficio_id','=','b.codigo') 
            ->join("categoria as c",function($join){
              $join->on("c.codigo_categoria","=","a.categoria_id")
              ->on("c.beneficio_id","=","a.beneficio_id");
            })    
            ->select('a.id', 'a.nrosolicitud','a.fecha_registro','a.cedula_trabajador as cedula','b.descripcion as beneficio','c.descripcion as dcategoria','a.monto')
            ->where('cedula_trabajador','LIKE',$valor)
            ->where('tipo_nomina','LIKE',$nomina)
            ->orderBy('a.nrosolicitud','desc')
            ->paginate(10);

          }
         }
         if($tipo[0]==2) //nrosolicitud
         {
         	$valor = $request["nsolicitud"];
          if($perfil==1){
            $solicitud = DB::table('solicitud as a')
            ->join('beneficios as b','a.beneficio_id','=','b.codigo') 
            ->join("categoria as c",function($join){
             $join->on("c.codigo_categoria","=","a.categoria_id")
             ->on("c.beneficio_id","=","a.beneficio_id");
           })    
            ->select('a.id', 'a.nrosolicitud','a.fecha_registro','a.cedula_trabajador as cedula','b.descripcion as beneficio','c.descripcion as dcategoria','a.monto')
            ->where('nrosolicitud','=',$valor)
            ->orderBy('a.nrosolicitud','desc')
            ->paginate(10);
          }
          if($perfil==2)
          {
            $solicitud = DB::table('solicitud as a')
            ->join('beneficios as b','a.beneficio_id','=','b.codigo') 
            ->join("categoria as c",function($join){
             $join->on("c.codigo_categoria","=","a.categoria_id")
             ->on("c.beneficio_id","=","a.beneficio_id");
           })    
            ->select('a.id', 'a.nrosolicitud','a.fecha_registro','a.cedula_trabajador as cedula','b.descripcion as beneficio','c.descripcion as dcategoria','a.monto')
            ->where('nrosolicitud','=',$valor)
            ->where('tipo_nomina','LIKE',$nomina)
            ->orderBy('a.nrosolicitud','desc')
            ->paginate(10);

          }
         }
         if($tipo[0]==3) //fechasolicitud
         {
          $valor = $request["fsolicitud"];
          if($perfil==1){
           	$solicitud = DB::table('solicitud as a')
           	->join('beneficios as b','a.beneficio_id','=','b.codigo') 
           	->join("categoria as c",function($join){
           		$join->on("c.codigo_categoria","=","a.categoria_id")
           		->on("c.beneficio_id","=","a.beneficio_id");
           	})    
           	->select('a.id', 'a.nrosolicitud','a.fecha_registro','a.cedula_trabajador as cedula','b.descripcion as beneficio','c.descripcion as dcategoria','a.monto')
           	->where('fecha_solicitud','=',$valor)
           	->orderBy('a.nrosolicitud','desc')
           	->paginate(10);
          }
          if($perfil==2)
          {
            $solicitud = DB::table('solicitud as a')
            ->join('beneficios as b','a.beneficio_id','=','b.codigo') 
            ->join("categoria as c",function($join){
              $join->on("c.codigo_categoria","=","a.categoria_id")
              ->on("c.beneficio_id","=","a.beneficio_id");
            })    
            ->select('a.id', 'a.nrosolicitud','a.fecha_registro','a.cedula_trabajador as cedula','b.descripcion as beneficio','c.descripcion as dcategoria','a.monto')
            ->where('fecha_solicitud','=',$valor)
            ->where('tipo_nomina','LIKE',$nomina)
            ->orderBy('a.nrosolicitud','desc')
            ->paginate(10);
          }
         }
         if($tipo[0]==4) //fechatramite
         {
         	$valor = $request["ftramite"];
          if($tipo==1){
            $solicitud = DB::table('solicitud as a')
            ->join('beneficios as b','a.beneficio_id','=','b.codigo') 
            ->join("categoria as c",function($join){
              $join->on("c.codigo_categoria","=","a.categoria_id")
              ->on("c.beneficio_id","=","a.beneficio_id");
            })    
            ->select('a.id', 'a.nrosolicitud','a.fecha_registro','a.cedula_trabajador as cedula','b.descripcion as beneficio','c.descripcion as dcategoria','a.monto')
            ->where('fecha_tramite','LIKE',$valor)
            ->orderBy('a.nrosolicitud','desc')
            ->paginate(10);

          }
          if($tipo==2)
          {
            $solicitud = DB::table('solicitud as a')
            ->join('beneficios as b','a.beneficio_id','=','b.codigo') 
            ->join("categoria as c",function($join){
              $join->on("c.codigo_categoria","=","a.categoria_id")
              ->on("c.beneficio_id","=","a.beneficio_id");
            })    
            ->select('a.id', 'a.nrosolicitud','a.fecha_registro','a.cedula_trabajador as cedula','b.descripcion as beneficio','c.descripcion as dcategoria','a.monto')
            ->where('fecha_tramite','LIKE',$valor)
            ->where('tipo_nomina','LIKE',$nomina)           
            ->orderBy('a.nrosolicitud','desc')
            ->paginate(10);
          }

          }
       }             	

       else{
         if($perfil==1)
         {
           $solicitud = DB::table('solicitud as a')
           ->join('beneficios as b','a.beneficio_id','=','b.codigo') 
           ->join("categoria as c",function($join){
            $join->on("c.codigo_categoria","=","a.categoria_id")
            ->on("c.beneficio_id","=","a.beneficio_id");
          })  
           ->select('a.id', 'a.nrosolicitud','a.fecha_registro','a.cedula_trabajador as cedula','b.descripcion as beneficio','c.descripcion as dcategoria','a.monto')

           ->orderBy('a.nrosolicitud','desc')
           ->paginate(10);

         }
         if($perfil==2){
           $solicitud = DB::table('solicitud as a')
           ->join('beneficios as b','a.beneficio_id','=','b.codigo') 
           ->join("categoria as c",function($join){
            $join->on("c.codigo_categoria","=","a.categoria_id")
            ->on("c.beneficio_id","=","a.beneficio_id");
          })  
           ->select('a.id', 'a.nrosolicitud','a.fecha_registro','a.cedula_trabajador as cedula','b.descripcion as beneficio','c.descripcion as dcategoria','a.monto')
            ->where('tipo_nomina','LIKE',$nomina)           
           ->orderBy('a.nrosolicitud','desc')
           ->paginate(10);

         }
       } 
       //dd($solicitud);
      
       return view("solicitud.index")->with("solicitud",$solicitud)->with('trabajador',$trabajador);
     }

    public function create()
    {
        $beneficio= beneficios::where('estatus',"Activo")->get();
        return view('solicitud.crear')->with('beneficio',$beneficio);
    }
    
    public function buscar_trabajador(Request $request)
    {
      $request->all();
      $edad=0;

      if(isset($request["cedula"])){
          $trabajador= trabajador::cedula($request->get("cedula"))->first();
          if(!isset($trabajador->cedula)){
               $data["status"]='No';
                $data["result"]='';
                $data["edad"]=$edad;
          }      
          else{  
          $fecha_nacimiento = $trabajador->fecha_nacimiento;
          $codcargo = $trabajador->cargo;
          $tipo = $trabajador->tipo;
          switch ($tipo) {
          	case '1':  
          		$tipon = "ALTO NIVEL";
          		break;
          	case '2':
          	   $tipon = "EMPLEADOS";
          	   break;
          	case '3':
          	   $tipon = "JUBILADOS";
          	   break;
          	case '4':
          	   $tipon = "OBREROS";
          	   break;
          }
          $altonivel   = $_SESSION["altonivel"];
          $contratados = $_SESSION["contratados"];
          $empleados   = $_SESSION["empleados"];
          $jubilados   = $_SESSION["jubilados"];
          $obreros     = $_SESSION["obreros"];
          $categoria = $trabajador->categoria;
          if($categoria=="27" || $categoria=="28") $tipon="CONTRATADOS";
          $cargos = cargos::where('cod_concepto',$codcargo)->where('tipo',$tipo)->first();
          $cargo = $cargos->concepto;
          list($anonaz,$mesnaz,$dianaz) = explode("-",$fecha_nacimiento); 
          $dia=date("d");
          $mes=date("m");
          $ano=date("Y");   
          $fechar = date("Y-m-d");
          if (($mesnaz == $mes) && ($dianaz > $dia)) {
            $ano=($ano-1); }
          if ($mesnaz > $mes) {
             $ano = ($ano-1);
          }  

          $edad = ($ano - $anonaz);
          
           
           $data["result"]=$trabajador;
           $data["edad"]=$edad;
           $data["cargo"]=$cargo;
           $data["nomina"]=$tipon;
           $data["fechar"]=$fechar;
           if($tipon=="ALTO NIVEL" and $altonivel==1){
           	$data["status"]='Ok';
           }
           if($tipon=="ALTO NIVEL" and $altonivel==0){
           	$data["status"]='NP';
           }
           if($tipon=="EMPLEADOS" and $empleados==1){
           	$data["status"]='Ok';
           }
           if($tipon=="EMPLEADOS" and $empleados==0){
           	$data["status"]='NP';
           }
           if($tipon=="OBREROS" and $obreros==1){
           	$data["status"]='Ok';
           }
           if($tipon=="OBREROS" and $obreros==0){
           	$data["status"]='NP';
           }
           if($tipon=="CONTRATADOS" and $contratados==1){
           	$data["status"]='Ok';
           }
           if($tipon=="CONTRATADOS" and $contratados==0){
           	$data["status"]='NP';
           }
           if($tipon=="JUBILADOS" and $jubilados==1){
           	$data["status"]='Ok';
           }
           if($tipon=="JUBILADOS" and $jubilados==0){
           	$data["status"]='NP';
           }

          }
        }         
          return $data;

    }
  

    public function buscar_valor(Request $request)
    {
    	$request->all();
    	if(isset($request["idcategoria"]))
    	{
    	   $categoriaid = $request["idcategoria"];
           $beneficioid = $request["idbeneficio"];
           $beneficios = beneficios::where('codigo',$beneficioid)->first();
           $tipovalor = $beneficios->tipo;
           $retroactivo = $beneficios->retroactivo;
    	   $categoria = categoria::where('codigo_categoria',$categoriaid)->where('beneficio_id',$beneficioid)->first(); 
    	   $valoracion = valoracion::where('beneficio_id',$beneficioid)->where('categoria_id',$categoriaid)->first();
    	   $data["status"]     = 'Ok';
           $data["tipo_valor"] = $tipovalor;
           $data["valor"]      = $valoracion->valor;
    	   $data["retro"]      = $retroactivo;
           $data["detalle_factura"] = $beneficios->detalle_factura;
           $data["aplica_sueldo"] = $beneficios->aplica_sueldo;
    	}
      else
      {
          $data["status"]='No';
          $data["tipo_valor"] = "";
          $data["valor"] = 0;
          $data["retro"] = 0;
          $data["detalle_factura"] = 0;
    	}
    	return $data;
    }
    public function carga_categoria(Request $request)
    {
      $request->all();
      if(isset($request["idbeneficio"])) $idbeneficio = $request["idbeneficio"];
      $categoria = categoria::where('beneficio_id',$idbeneficio)->get();
      foreach ($categoria as $cat) {
          echo '<option value="' .$cat->codigo_categoria. '">' .$cat->descripcion. '</option>';
      }
    
     return null;

    }
    
    public function carga_beneficiario(Request $request)
    {
      
      $request->all();
      if(isset($request["idbeneficio"])) $idbeneficio = $request["idbeneficio"];
      $beneficios = beneficios::where('id',$idbeneficio)->first();
      $tipo= $beneficios->tipobeneficiario;

      if(isset($request["ced"])) 
      {
           $cedula = $request["ced"];
           $nom = $request["ape"];
           if($tipo=='Familiar'){
              $beneficiarios = beneficiarios::where('CEDTIT',$cedula)->get();
              foreach ($beneficiarios as $ben) {
               echo '<option value="'.$ben->CEDBEN.'">'.$ben->Beneficiario.'</option>';
              }
           }else{ echo '<option value="'.$cedula.'">'.$nom.'</option>'; }
      }
      return null;

    }

    
    public function edit($id)
    {
        $solicitud = solicitud::find($id);
        $idbeneficio = $solicitud->beneficio_id;
        $idcategoria = $solicitud->categoria_id;
        $ced         = $solicitud->cedula_trabajador;
        $cedben      = $solicitud->cedula_beneficiario;
        $trabajador= trabajador::cedula($ced)->first();
        $beneficio   = beneficios::where('codigo','=',$idbeneficio)->first();
        $categoria   = categoria::where('beneficio_id','=',$idbeneficio)->where('codigo_categoria','=',$idcategoria)->first();
        $codcargo = $trabajador->cargo;
        $tipo = $trabajador->tipo;
        $cargos = cargos::where('cod_concepto',$codcargo)->where('tipo',$tipo)->first();
        $cargo = $cargos->concepto;
        $beneficiario = beneficiarios::where('cedben',$cedben)->first();
        if(isset($beneficiario)) 
          $bene=$beneficiario->beneficiario;
        else
          $bene=$trabajador->apellidos." ".$trabajador->nombres;
        return view('solicitud.edit')->with('solicitud',$solicitud)->with('trabajador',$trabajador)->with('beneficio',$beneficio)->with('categoria',$categoria)->with('cargo',$cargo)->with('bene',$bene);

    }
    
    public function store(Request $request)
    {

        try {
 
	    	$nrosolicitud        = $request["nrosolicitud"];
	    	$fechasolicitud      = $request["fecha_solicitud"];
	    	$fecharegistro       = $request["fecha_registro"];
	    	$fechatramite        = $request["fecha_tramite"];
	    	$cedula_trabajador   = $request["cedula"];
	    	$cedula_beneficiario = $request["cedula_beneficiario"];
	    	$beneficio_id        = $request["beneficio_id"];
	    	$categoria_id        = $request["categoria_id"];
	    	$monto               = $request["monto"];
	    	$nfactura            = $request["nrofactura"];
        $monto_factura       = $request["montofactura"];
        $fecha_factura       = $request["fechaf"];
        $tipo_nomina         = $request["nomina"];
        $descripcion         = $request["descripcion"];
        $observaciones       = $request["observaciones"];    
        $monto_retroactivo   = $request["montor"];    
        $cantidad            = $request["cantidad"];
        $beneficiario        = $request["beneficiario"];

        $nombres             = $request["nombres"];
        if(!isset($beneficiario)) $beneficiario = $nombres;
	    	if(solicitud::where('nrosolicitud',$nrosolicitud)->where('fecha_solicitud',$fechasolicitud)->where('fecha_registro',$fecharegistro)->where('beneficio_id',$beneficio_id)->where('categoria_id',$categoria_id)->where('cedula_trabajador',$cedula_trabajador)->where('cedula_beneficiario',$cedula_beneficiario)->first()){
          return redirect()->route('beneficios.index')->with("notificacion","Ya se encuentra Registrado");

        }

        $solicitud = new solicitud($request->all());
        $solicitud->nrosolicitud        = $nrosolicitud;
        $solicitud->fecha_solicitud     = $fechasolicitud;
        $solicitud->fecha_registro      = $fecharegistro;
        $solicitud->fecha_tramite       = $fechatramite;
        $solicitud->cedula_trabajador   = $cedula_trabajador;
        $solicitud->cedula_beneficiario = $cedula_beneficiario;
        $solicitud->beneficio_id        = $beneficio_id;
        $solicitud->categoria_id        = $categoria_id;
        $solicitud->monto               = $monto;
        $solicitud->cantidad            = $cantidad;
        $solicitud->monto_retroactivo   = $monto_retroactivo;
        $solicitud->nfactura            = $nfactura;
        $solicitud->monto_factura       = $monto_factura;
        $solicitud->fecha_factura       = $fecha_factura;
        $solicitud->tipo_nomina         = $tipo_nomina;
        $solicitud->descripcion         = $descripcion;
        $solicitud->observaciones       = $observaciones; 
        $solicitud->beneficiario        = $beneficiario;
        $solicitud->nombres             = $nombres;
	      $solicitud->created_at = date('Y-m-d');
	      $solicitud->updated_at = date('Y-m-d');
	      $solicitud->usuario_id = $_SESSION["user"];
	      $solicitud->save();
        return redirect()->route('solicitud.index')->with("notificacion","Se ha guardado correctamente su información");

        } catch (Exception $e) {
            \Log::info('Error creating item: '.$e);
            return \Response::json(['created' => false], 500);
        }

    }
    
    public function update(Request $request, $id)
    {
       $solicitud = solicitud::find($id);
       $solicitud->fecha_tramite    = $request["fecha_tramite"];
       $solicitud->fecha_solicitud = $request["fecha_solicitud"];
       $solicitud->descripcion     = $request["descripcion"];
       $solicitud->observaciones   = $request["observaciones"];
       $solicitud->save();
       return redirect()->route('solicitud.index')->with("notificacion","Se ha guardado correctamente su información");
    }

    public function show($id)
    {
        $solicitud = solicitud::find($id);
        if(isset($solicitud)){

             $idbeneficio = $solicitud->beneficio_id;
            $idcategoria = $solicitud->categoria_id;
        $ced         = $solicitud->cedula_trabajador;
        $cedben      = $solicitud->cedula_beneficiario;
        $trabajador= trabajador::cedula($ced)->first();
        $beneficio   = beneficios::where('codigo','=',$idbeneficio)->first();
        $categoria   = categoria::where('beneficio_id','=',$idbeneficio)->where('codigo_categoria','=',$idcategoria)->first();
        $codcargo = $trabajador->cargo;
        $tipo = $trabajador->tipo;
        $cargos = cargos::where('cod_concepto',$codcargo)->where('tipo',$tipo)->first();
        $cargo = $cargos->concepto;
        $beneficiario = beneficiarios::where('cedben',$cedben)->first();
        if(isset($beneficiario)) 
          $bene=$beneficiario->beneficiario;
        else
          $bene=$trabajador->apellidos." ".$trabajador->nombres;
        return view('solicitud.show')->with('solicitud',$solicitud)->with('trabajador',$trabajador)->with('beneficio',$beneficio)->with('categoria',$categoria)->with('cargo',$cargo)->with('bene',$bene);
      }
    }
    public function destroy($id){
       $solicitud= solicitud::find($id);
       $solicitud->destroy($id);
      return redirect()->route('solicitud.index')->with("notificacion","Se ha eliminado correctamente su información");


    }

}

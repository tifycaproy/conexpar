<html>
<head>
  <meta charset="utf-8">
 <style type="text/css">

 .container_12 {
  margin-left: 25px;
  margin-right: 25px;

}

#header { position: fixed; left: 0px; top: -180px; right: 0px; height: 150px; background-color: orange; text-align: center; }
#footer { position: fixed; left: 0px; bottom: -180px; right: 0px; height: 150px; background-color: lightblue; }
#footer .page:after { content: counter(page, upper-roman); }

</style>  
<title></title>
</head>
<body>
  
  <?php 
  $i=1;
  $z=1;
  $gbeneficio="";
  $total_beneficio=0;
  $gcategoria="";
  $total_categoria=0;  
  ?>
  @foreach($grupos as $grupo)
  
  <table border="1" width="550"  cellspacing="0" cellpadding="0">
   <tr>
    <td colspan="8">
     <table border="0" width="550"  cellspacing="0" cellpadding="0">
       <tr>
         <td align="center">  
          <img src="{{ asset('img/logo.png')}}" width="12%"><br>
          <font size="8px"><b>Dirección General de Desarrollo Humano</b><br><b>Dirección de Bienestar Social</b></font>
        </td>
        <td colspan="2" align="center">
          <font size="11px"><strong>Beneficio:{{ $grupo->beneficio}}<br>
           Nómina: {{ $grupo->tipo_nomina}}</strong></font>
         </td>    
         <td colspan="5"><font size="9px"><b>Fecha de Emision: {{date("d-m-y")}}</b></font>
         </td>
       </tr>
       </table>
     </td>
   </tr>   

 </table>
 
 <table border="0" width="550"  cellspacing="0" cellpadding="0">   
   <tr> 
     <td colspan="8"><font size="11px"><b>Categoria de Beneficio: {{ $grupo->dcategoria}}</b></font></td>
   </tr>
   <tr> 
     <td colspan="8">
      <table border="0" width="550"  cellspacing="0" cellpadding="0" >
       <tr>
        <td bgcolor="#cccccc" width="30"> <font size="9px"><b>Fecha Reg.</b></font></td>
        <td bgcolor="#cccccc" width="30"> <font size="9px"><b>Nºsolicitud</b></font></td>
        <td bgcolor="#cccccc" width="100"> <font size="9px"><b>Trabajador</b></font></td>
        <td bgcolor="#cccccc" width="100"> <font size="9px"><b>Beneficiario</b></font></td>
        <td bgcolor="#cccccc" width="30" align="right"> <font size="9px"><b>Monto</b></font></td>
        <td bgcolor="#cccccc" width="30" align="right"> <font size="9px"><b>Prima Antig</b></font></td>
        <td bgcolor="#cccccc" width="30"align="right"> <font size="9px"><b>Retroactivo</b></font></td>
        <td bgcolor="#cccccc" width="30" align="right"> <font size="9px"><b>Total</b></font></td>
      </tr>
    <?php 
    $i=0;
    $totalm = 0;
    $total_beneficio = 0;
    $total_categoria = 0;
    ?>
      
      @foreach($solicitud as $solici) 
      @if($solici->beneficio_id == $grupo->beneficio_id && $solici->categoria_id == $grupo->categoria_id)
      <tr>  
       <td width="30"> <font size="9px">{{$solici->fecha_solicitud}}</font></td>
       <td width="30"> <font size="9px">{{$solici->nrosolicitud}}</font></td>
       <td width="100"> <font size="9px">{{$solici->cedula}}<br>{{$solici->nombres}}</font></td>
       <td width="100"> <font size="9px">{{$solici->cedula_beneficiario}}<br>{{ $solici->beneficiario}}</font></td>
       <td width="30" align="right"> 
        <font size="9px">
          <?php echo number_format($solici->monto,2);?>
        </font>
      </td>
      <td width="30" align="right"> <font size="9px"></font></td>
      <td width="30" align="right"> <font size="9px"><?php echo number_format($solici->monto_retroactivo,2);?></font></td>
      <td width="30" align="right"> <font size="9px"><?php $total= $solici->monto + $solici->monto_retroactivo;
      echo number_format($total,2)?></font></td>
    </tr>
    <tr><td width="550" colspan="8"><font size="9px"> <b>Observaciones:</b><?php echo utf8_decode($solici->descripcion);?></font></td></tr>
    <tr><td colspan="8"><hr></td></tr>
    <?php 
    $i++;
    $totalm = $totalm + $solici->monto;
    $total_beneficio = $total_beneficio + $total;
    $total_categoria = $total_categoria + $total;
    ?>
    @endif 
    @endforeach 
    <tr>
        <td bgcolor="#cccccc" width="30"> <font size="9px"><b>Total por Beneficio</b></font></td>
        <td bgcolor="#cccccc" width="30"> <font size="9px"><b></b></font></td>
        <td bgcolor="#cccccc" width="100"> <font size="9px"><b>Cantidad</b></font></td>
        <td bgcolor="#cccccc" width="100"> <font size="9px"><b>{{ $i}}</b></font></td>
        <td bgcolor="#cccccc" width="30" align="right"> <font size="9px"><b><?php echo number_format($totalm,2);?></b></font></td>
        <td bgcolor="#cccccc" width="30" align="right"> <font size="9px"><b></b></font></td>
        <td bgcolor="#cccccc" width="30"align="right"> <font size="9px"><b></b></font></td>
        <td bgcolor="#cccccc" width="30" align="right"> <font size="9px"><b><?php echo number_format($total_beneficio,2);?></b></font></td>
      </tr>
  
  </table>
</td>
</tr> 
<br>
<br>
<tr>
</tr>

</table> 
<br>
<br>
<table table border="0" width="550"  cellspacing="0" cellpadding="0" >
  <tr>
    <td align="center" colspan="4"><p><font size="9px">Elaborado por: </font></p></td>
    <td align="center" colspan="4"><p><font size="9px">__________________ <br>{{ $firmas->nivel}} {{ $firmas->nombre}}<br>{{ $firmas->cargo}}</font></p></td>
  </tr>
</table>

<?php $z++; ?>
@if($z <= $cantidad)
<div style="page-break-after:always;"></div>      
@endif
@endforeach




</body>
</html>
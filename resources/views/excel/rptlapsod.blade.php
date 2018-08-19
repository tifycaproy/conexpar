	<?php 
		   $i=1;
		   $total_beneficio=0;
		   $total_categoria=0;  
		?>
        <table border="1" width="550"  cellspacing="0" cellpadding="0">
              <tr>
                  <td align="center" colspan="11">  
                     <font size="8px"><b>Dirección General de Desarrollo Humano</b></font>
                  </td>
              </tr>
              <tr>
                  <td align="center" colspan="11">  
                     <font size="8px"><b>Dirección de Bienestar Social</b></font>
                  </td>
              </tr>       
              <tr>
                 <td align="center" colspan="11">  
                     <font size="8px"><b>Fecha de Emision: {{date("d-m-y")}}</b></font>
                  </td>

              </tr>
              <tr>
                 <td align="center" colspan="11">  
                     <font size="8px"><b>Listado de Beneficios Procesados por Lapso</b></font>
                  </td>

              </tr>
              <tr>
                 <td align="center" colspan="11">  
                     <font size="8px"><b>Desde:{{$desde}} - Hasta:{{$hasta}}</b></font>
                  </td>

              </tr>

            </table>

            <table border="0" width="550"  cellspacing="0" cellpadding="0">   
               <tr>
                   <td bgcolor="#cccccc" width="30"> <font size="9px"><b>Fecha Reg.</b></font></td>
                  <td bgcolor="#cccccc" width="30"> <font size="9px"><b>Nºsolicitud</b></font></td>
                  <td bgcolor="#cccccc" width="30"> <font size="9px"><b>Cédula</b></font></td>
                  <td bgcolor="#cccccc" width="100"> <font size="9px"><b>Trabajador</b></font></td>
                  <td bgcolor="#cccccc" width="100"> <font size="9px"><b>Beneficiario</b></font></td>
                  <td bgcolor="#cccccc" width="30" align="right"> <font size="9px"><b>Monto</b></font></td>
                  <td bgcolor="#cccccc" width="30" align="right"> <font size="9px"><b>Prima Antig</b></font></td>
                  <td bgcolor="#cccccc" width="30"align="right"> <font size="9px"><b>Retroactivo</b></font></td>
                  <td bgcolor="#cccccc" width="30" align="right"> <font size="9px"><b>Total</b></font></td>
                  <td bgcolor="#cccccc" width="30" align="right"> <font size="9px"><b>Nómina</b></font></td>
                  <td bgcolor="#cccccc" width="100"> <font size="9px"><b>Observaciones</b></font></td>
              </tr>

            @foreach($solicitud as $solici) 
           			   <tr>	
           		       <td width="30"> <font size="9px">{{$solici->fecha_solicitud}}</font></td>
         		          <td width="30"> <font size="9px">{{$solici->nrosolicitud}}</font></td>
                      <td width="30"> <font size="9px">{{$solici->cedula}}</font></td>
         		          <td width="100"> <font size="9px">{{$solici->nombres}}</font></td>
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
       		           	<?php 
                            $total_beneficio = $total_beneficio + $total;
                            $total_categoria = $total_categoria + $total;
                        ?>
                        <td width="30"> <font size="9px">{{$solici->tipo_nomina}}</font></td>
                      <td><font size="9px"><?php echo utf8_decode($solici->descripcion);?></font></td> 
		       @endforeach 
               </table>
           
     
      
  	

		
	

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
	  $total_beneficio = 0;
    $zmontob = 0;
    $zmontor = 0;
    $totalc = 0;
    $i=1;
		?>
			
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
				    	           <font size="11px"><strong>Resumen Mensual de Beneficios Procesados<br>
					              </strong></font>
					         </td>		
	                         <td colspan="5"><font size="9px"><b>Fecha de Emision: {{date("d-m-y")}}</b></font>
	                         </td>
                         </tr>
                    </table>
               </td>
               </tr>   
            </table>
            
            <table border="0" width="550"  cellspacing="0" cellpadding="0">   
			                         				
                    @foreach($solicitud as $solici) 
                    @if($i==1)
                                <tr>
                  <td bgcolor="#cccccc" colspan="6" width="30"> <font size="9px"><b>Nómina: {{ $solici->tipo_nomina}}</b></font></td>
                 </tr>

                 <tr>
                  <td bgcolor="#cccccc" width="30"> <font size="9px"><b>Beneficio</b></font></td>
                  <td bgcolor="#cccccc" width="30"> <font size="9px"><b>Categoria</b></font></td>
                  <td bgcolor="#cccccc" width="100"> <font size="9px"><b>Cantidad</b></font></td>
                  <td bgcolor="#cccccc" width="30" align="right"> <font size="9px"><b>Monto</b></font></td>
                  <td bgcolor="#cccccc" width="30"align="right"> <font size="9px"><b>Retroactivo</b></font></td>
                  <td bgcolor="#cccccc" width="30" align="right"> <font size="9px"><b>Total</b></font></td>
                 </tr>

                    @endif
           			   <tr>	
           	          <td width="30"> <font size="9px">{{$solici->beneficio}}</font></td>
         		          <td width="30"> <font size="9px">{{$solici->dcategoria}}</font></td>
         		          <td width="100"> <font size="9px">{{$solici->cantidad}}</font></td>
         		          <td width="30" align="right"> 
         			        <font size="9px">
         		             <?php echo number_format($solici->montob,2);?>
         		            </font>
         		          </td>
         		          <td width="30" align="right"> <font size="9px"><?php echo number_format($solici->montor,2);?></font></td>
         		          <td width="30" align="right"> <font size="9px"><?php $total= $solici->montob + $solici->montor;
         		                                       echo number_format($total,2)?></font></td>
                             </tr>
       		           	<?php 
                            $total_beneficio = $total_beneficio + $total;
                            $zmontob = $zmontob + $solici->montob;
                            $zmontor = $zmontor + $solici->montor;
                            $totalc = $totalc + $solici->cantidad;
                            $i++;
                        ?>
		       @endforeach 
                   <tr> 
                      <td bgcolor="#cccccc" width="30"> <font size="9px">Total</font></td>
                      <td bgcolor="#cccccc" width="30"> <font size="9px"></font></td>
                      <td bgcolor="#cccccc" width="100"> <font size="9px">{{$totalc}}</font></td>
                      <td bgcolor="#cccccc" width="30" align="right"> 
                      <font size="9px">
                         <?php echo number_format($zmontob,2);?>
                        </font>
                      </td>
                      <td bgcolor="#cccccc" width="30" align="right"> <font size="9px"><?php echo number_format($zmontor,2);?></font></td>
                      <td bgcolor="#cccccc" width="30" align="right"> <font size="9px"><?php echo number_format($total_beneficio,2)?></font></td>
              </tr>

               </table>
              </td>
           </tr>	
        </table> 
        <br>
        <table>
          <tr>
            <td colspan="3">Elaborado Por: </td>
            <td colspan="3">Autorizado Por:</td>
          </tr>
        </table>
       
  	

		
	
	</body>
</html>
<?php
session_start();
/*
*Archivos de Sistema
*/
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsPoo->Ruta = '../../';
$InsProyecto->Ruta = '../../';

////CONFIGURACIONES GENERALES
require_once($InsProyecto->MtdRutConfiguraciones().'CnfSistema.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfEmpresa.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfConexion.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfNotificacion.php');
////MENSAJES GENERALES
require_once($InsProyecto->MtdRutMensajes().'MsjGeneral.php');
////CLASES GENERALES
require_once($InsProyecto->MtdRutClases().'ClsSesion.php');
require_once($InsProyecto->MtdRutClases().'ClsSesionObjeto.php');
require_once($InsProyecto->MtdRutClases().'ClsMensaje.php');
require_once($InsProyecto->MtdRutLibrerias().'PHPMailer_5.2.4/class.phpmailer.php');
require_once($InsProyecto->MtdRutClases().'ClsCorreo.php');

////CLASES GENERALES
require_once($InsProyecto->MtdRutConexiones().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');
////FUNCIONES GENERALES
require_once($InsProyecto->MtdRutFunciones().'FncGeneral.php');


if($_GET['P']==2){
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition:  filename=\"KARDEX_".date('d-m-Y').".xls\";");
}

?>
<html>
<head>

<?php
if($_GET['P']<>2){
?>
<!--
Estilos
-->
<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssGeneral.css">
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.3.2.min.js"></script>
<?php
}
?>

</head>
<body>
<script type="text/javascript">

$().ready(function() {
<?php 
if($_GET['P']==1){
?> 
	setTimeout("window.close();",2500);	
	window.print(); 
<?php 
}
?>
});

</script>
      
       
<?php
$POST_FechaInicio = $_GET['CmpFechaInicio'];
$POST_FechaFin = $_GET['CmpFechaFin'];
$POST_Moneda = $_GET['CmpMoneda'];
$POST_SucursalId = $_GET['CmpSucursalId'];

$POST_VehiculoId = $_GET['CmpVehiculoId'];
$POST_VehiculoCodigoIdentificador = $_GET['CmpVehiculoCodigoIdentificador'];
$POST_UnidadMedidaUso = $_GET['CmpVehiculoUnidadMedidaKardex'];

$POST_VehiculoIngresoId = $_GET['CmpVehiculoIngresoId'];
$POST_VehiculoIngresoVIN = $_GET['CmpVehiculoIngresoVIN'];



require_once($InsPoo->MtdPaqAlmacen().'ClsKardexVehiculo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculo.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

$InsKardexVehiculo = new ClsKardexVehiculo();
$InsVehiculo = new ClsVehiculo();

$aux = explode("/",$POST_FechaInicio);

$KardexFechaInicio = "01/01/".$aux[2];



//if(!empty($POST_AlmacenId)){
//	$stipo = "";	
//}else{
//	$stipo = "1,2";
//}


//deb($POST_UnidadMedidaUso);
//MtdObtenerKardexVehiculos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'VmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oUso=NULL,$oMoneda=NULL,$oFechaTipo="VmvFecha",$oSucursal=NULL,$oVehiculoId=NULL,$oVehiculoIngresoId=NULL)
$ResKardexVehiculo = $InsKardexVehiculo->MtdObtenerKardexVehiculos(NULL,NULL,NULL,'ein.EinVIN,vmd.VmdFecha ASC,(vmd.VmdTiempoCreacion) ASC','',NULL,$POST_VehiculoId ,FncCambiaFechaAMysql($KardexFechaInicio),FncCambiaFechaAMysql($POST_FechaFin),$POST_UnidadMedidaUso,$POST_Moneda,"vmd.VmdFecha",$POST_SucursalId,NULL,$POST_VehiculoIngresoId );
$ArrKardexVehiculos = $ResKardexVehiculo['Datos'];

$InsVehiculo->VehId = $POST_VehiculoId;
$InsVehiculo->MtdObtenerVehiculo(false);

?>

<?php if($_GET['P']==1){?>

<table cellpadding="0" cellspacing="0" width="100%" border="0">
<tr>
  <td colspan="3" align="left"><span class="EstReporteCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
</tr>
<tr>
  <td width="23%" align="left" valign="top">
  <img src="../../imagenes/logos/logo_impresion.png" width="150" alt="Logo" title="Logo" border="0" />
    
    
  </td>
  <td width="54%" align="center" valign="top">
  
  
  <span class="EstReporteTitulo">KARDEX
 
  <?php
  if($POST_finicio == $POST_ffin){
?>
<?php echo $POST_finicio; ?>
<?php
  }else{
?>
<?php echo $POST_finicio; ?> AL <?php echo $POST_ffin; ?>
<?php  
  }
?>

<br>
<?php echo $InsProducto->ProId ;?> - 
<?php echo $InsProducto->ProNombre ;?>

</span>


  </td>
  <td width="23%" align="right" valign="top"><span class="EstReporteDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> <br />
    <span class="EstReporteDatosImpresion"><?php echo $_SESSION['SisSucNombre'];?></span> <br />
    <span class="EstReporteDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
</tr>
</table>




<hr class="EstReporteLinea">

<?php }?>


<table class="EstTablaListado">
            <tbody class="EstTablaListadoBody">
            <tr>
              <td rowspan="2">Cod. Original:</td>
              <td rowspan="2"><?php echo $InsProducto->ProCodigoOriginal;?></td>
              <td rowspan="2">Nombre:</td>
              <td rowspan="2"><?php echo $InsProducto->ProNombre;?></td>
              <td rowspan="2">&nbsp;</td>
              <td rowspan="2">&nbsp;</td>

            </tr>
 </tbody>

</table>


            <table class="EstTablaListado" width="100%">
            <thead class="EstTablaListadoHead">
            <tr>
              <th width="17" rowspan="2">#</th>
              <th width="66" rowspan="2">Ficha</th>
              <th width="40" rowspan="2">Doc. Ident.</th>
              <th width="40" rowspan="2">Afectado</th>
              <th width="40" rowspan="2">Fecha Mov.</th>
              <th width="76" rowspan="2">Documento</th>
              <th width="38" rowspan="2"><ipo>Serie</ipo></th>
              <th width="77" rowspan="2">Numero</th>
              <th width="17" rowspan="2">Fecha Comprob.</th>
              <th width="17" rowspan="2">VIN</th>
              <th width="17" rowspan="2">&nbsp;</th>
              <th width="115" rowspan="2">Tipo Operacion</th>
              <th colspan="3">Entradas</th>
              <th colspan="3">Salidas</th>
              <th colspan="3">Saldo</th>
              </tr>
            <tr>
              <th>Cantidad</th>
              <th>Costo Unitario</th>
              <th>Costo Total</th>
              <th>Cantidad</th>
              <th>Costo Unitario</th>
              <th>Costo Total</th>
              <th>Cantidad</th>
              <th>Costo Unitario</th>
              <th>Costo Total</th>
              </tr>
              
            </thead>
            <tbody class="EstTablaListadoBody">
	<?php

	$CostoTotalMovimientoEntradas = 0;
	$CostoTotalMovimientoSalidas = 0;
	
	
	$TotalMovimientoEntradas = 0;
	$TotalMovimientoSalidas = 0;
	
	$TotalMontoMovimientoEntradas = 0;
	$TotalMontoMovimientoSalidas = 0;
	
	$TotalEntradaGeneral = 0;
	$TotalSalidaGeneral = 0;
	
	$MostrarSaldoAnterior = true;
	$MostrarSaldoAnterior2 = true;
	
	$j = 1;
	$Primera = true;
	$MostrarInventario = true;	
	foreach($ArrKardexVehiculos as $DatKardex){

		$DatKardex->KdvCostoUnitario = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$DatKardex->KdvCostoUnitario:($DatKardex->KdvCostoUnitario/$DatKardex->KdvTipoCambio));  
		$DatKardex->KdvCostoIngreso = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$DatKardex->KdvCostoIngreso:($DatKardex->KdvCostoIngreso/$DatKardex->KdvTipoCambio));  

?>
    
<?php
	
	if( FncConvetirTimestamp($DatKardex->KdvFecha) < FncConvetirTimestamp($POST_FechaInicio)){	

		if($DatKardex->KdvMovimientoTipo==1  ){
			
			$TotalEntradaGeneral += $DatKardex->KdvCantidad;

			$CostoActual = $DatKardex->KdvCostoUnitario;
			$CostoTotalActual = $CostoActual * $DatKardex->KdvCantidad;
			
			$CantidadSaldo =  ($TotalEntradaGeneral - $TotalSalidaGeneral);
			
			if($Primera ){
				$CostoUnitarioAnterior = $CostoActual;
				$Primera = false;
			}else{
				//$CostoUnitarioAnterior = round(($CostoUnitarioAnterior + $CostoActual)/2,2);	
				$CostoUnitarioAnterior = (($CostoUnitarioAnterior + $CostoActual)/2);	
			}
	
		}

		if($DatKardex->KdvMovimientoTipo==2){
			
			$TotalSalidaGeneral += $DatKardex->KdvCantidad;

			$CostoActual = $CostoUnitarioAnterior;
			$CostoTotalActual = $CostoActual * $DatKardex->KdvCantidad;

			$CantidadSaldo =  ($TotalEntradaGeneral - $TotalSalidaGeneral);			
		}

	}else{
		
		$MostrarSaldoAnterior2 = false;
		
?>         
              

<?php
if($MostrarSaldoAnterior){
?>
	<tr>
	  <td height="30" align="center">&nbsp;</td>
	  <td align="center">-</td>
	  <td align="center">&nbsp;</td>
	  <td align="center">-</td>
	  <td height="30" align="center">-</td>
	  <td height="30" align="center">-</td>
	  <td height="30" align="center">-</td>
	  <td height="30" align="center">-</td>
	  <td align="center">-</td>
	  <td align="center">&nbsp;</td>
	  <td height="30" align="center">-</td>
	  <td height="30" align="left">.</td>
	  <td height="30" align="center" valign="top" bgcolor="#99CCCC"><!--Saldo Anterior--></td>
	  <td width="72" height="30" align="center" valign="top" bgcolor="#99CCCC">&nbsp;</td>
	  <td width="58" height="30" align="center" valign="top" bgcolor="#99CCCC">&nbsp;</td>
	  <td width="60" height="30" align="center" valign="top" bgcolor="#FFCC66">&nbsp;</td>
	  <td width="72" height="30" align="center" valign="top" bgcolor="#FFCC66">&nbsp;</td>
	  <td width="58" height="30" align="center" valign="top" bgcolor="#FFCC66">&nbsp;</td>
	  <td width="60" height="30" align="center" valign="top" bgcolor="#66CC99"><?php  
		echo number_format($CantidadSaldo,2);
		?></td>
	  <td width="72" height="30" align="center" valign="top" bgcolor="#66CC99"><?php 
	 	echo number_format($CostoUnitarioAnterior,2);
		?></td>
	  <td width="64" align="center" valign="top" bgcolor="#66CC99"><?php 
		echo number_format($CostoTotalAnterior,2);
		?></td>
	  </tr>
<?php
}
$MostrarSaldoAnterior = false;
?>



			<?php
            if($DatKardex->TopId == "TOP-10015" and $MostrarInventario){
            ?>
                <tr>
                    <td colspan="21" align="center">
                    INVENTARIO
                    </td>
                </tr>
            <?php
				$CantidadSaldo = 0;
				$MostrarInventario = false;								
            }
            ?>
            
            

	<tr>
	  <td align="left"><?php echo $j;?></td>
	  <td align="left" valign="top">
      
      
		<?php
		switch($DatKardex->KdvMovimientoTipo){
			case 1:
		?>
                
                


<?php
				switch($DatKardex->KdvMovimientoSubTipo){
					case 6:
		?>
                <a target="_blank" href="../../principal.php?Mod=TrasladoSucursal&Form=Ver&Id=<?php echo $DatKardex->TalId ?>">
                <?php echo $DatKardex->TalId;?>
                </a>
        
        <?php		  
					break;
						
					default:
						
											?>
          <a target="_blank" href="../../principal.php?Mod=SucursalMovimientoEntrada&Form=Ver&Id=<?php echo $DatKardex->KdvId ?>">
                <?php echo $DatKardex->KdvId;?>
                </a>
        
<?php	
					break;
						
				}
?>




		<?php
			break;
		  
			case 2:
		?>

<?php
					switch($DatKardex->KdvMovimientoSubTipo){
						
						
							case 6:
		?>
                <a target="_blank" href="../../principal.php?Mod=TrasladoSucursal&Form=Ver&Id=<?php echo $DatKardex->TalId ?>">
                <?php echo $DatKardex->TalId;?>
                </a>
        
        <?php		  
					break;
					
					
					
								case 5:
		?>
                <a target="_blank" href="../../principal.php?Mod=NotaCreditoCompra&Form=Ver&Id=<?php echo $DatKardex->KdvId ?>">
                <?php echo $DatKardex->KdvId;?>
                </a>
        
        <?php		  
						break;
						
						default:
						
											?>
            <a target="_blank" href="../../principal.php?Mod=SucursalMovimientoSalida&Form=Ver&Id=<?php echo $DatKardex->KdvId ?>">
            <?php echo $DatKardex->KdvId;?>
            </a>
        
<?php	
						break;
						
					}
?>
        
        <?php
	  
			break;
			
			
		}
		?>
      </td>
	  <td align="left" valign="top"><?php echo $DatKardex->CliNumeroDocumento;?>
	  
	  <?php echo $DatKardex->PrvNumeroDocumento;?>
      
      </td>
	  <td align="left" valign="top">
	    
	    <?php echo $DatKardex->CliNombre;?>      
	    <?php echo $DatKardex->CliApellidoPaterno;?>
	    <?php echo $DatKardex->CliApellidoMaterno;?>
	    
	    <?php echo $DatKardex->PrvNombre;?>
	    <?php echo $DatKardex->PrvApellidoPaterno;?>
	    <?php echo $DatKardex->PrvApellidoMaterno;?>
      </td>
	  <td align="left" valign="top"><?php echo $DatKardex->KdvFecha;?></td>
	  <td align="left" valign="top">
	  
          [<?php echo $DatKardex->CtiCodigo;?>]
          <?php echo $DatKardex->CtiNombre;?>
          
      </td>
	  <td align="left" valign="top">
      
	<?php
    if(empty($DatKardex->KdvComprobanteNumero)){
    ?>
		<?php list($Serie,$Numero)=explode("-",$DatKardex->KdvComprobanteNumero2);?>
    <?php  
    }else{
    ?>
		<?php list($Serie,$Numero)=explode("-",$DatKardex->KdvComprobanteNumero);?>        
    <?php  
    }
    ?>

		<?php echo $Serie;?>&nbsp;
	  </td>
	  <td align="left" valign="top">
      <?php echo $Numero;?>&nbsp;
      
      <?php
	  if(!empty($DatKardex->KdvFoto)){
	?>
     <a  target="_blank" href="../../subidos/vehiculo_movimiento_fotos/<?php echo $DatKardex->KdvFoto;?>"  title=""><img  src="../../imagenes/documento.gif" width="20" height="20" border="0"  /></a>
    <?php
	  }
	  ?>
      </td>
	  <td align="left" valign="top"><?php echo $DatKardex->KdvComprobanteFecha;?></td>
	  <td align="left" valign="top">
      
      
      <?php echo $DatKardex->EinVIN;?>
      </td>
	  <td align="left" valign="top">
	  
<?php
switch($DatKardex->KdvMovimientoTipo){
	case 1:
?>
	    E
<?php
		$TotalMovimientoEntradas++;
		$TotalMontoMovimientoEntradas+=$DatKardex->KdvCantidad;
	break;
	
	case 2:
?>
	    S
<?php	
		$TotalMovimientoSalidas++;
		$TotalMontoMovimientoSalidas+=$DatKardex->KdvCantidad;
	break;
	
	default:
?>
	    -
  <?php	
	break;
}
?>

</td>
	  <td align="left" valign="top">[<?php echo $DatKardex->TopCodigo?>]  <?php echo $DatKardex->TopNombre?> </td>
	  <td width="60" align="center" valign="top" bgcolor="#99CCCC">
	  			
				
				
                  <!--
            ENTRADAS - CANTIDAD
            -->
				
				<?php
				if($DatKardex->KdvMovimientoTipo==1  ){
				?>
                
					<?php echo number_format($DatKardex->KdvCantidad,2);?>
                    
					<?php
					$TotalEntradaGeneral += $DatKardex->KdvCantidad;
					$CantidadSaldo =  ($TotalEntradaGeneral - $TotalSalidaGeneral);		
					
					$CostoActual = $DatKardex->KdvCostoUnitario;
					$CostoTotalActual = $CostoActual * $DatKardex->KdvCantidad;
					$CostoTotalMovimientoEntradas += $CostoTotalActual;
					
					if($Primera ){
						//$CostoUnitarioAnterior = $CostoActual;
						$CostoTotalAnterior = $CostoTotalActual;
						$Primera = false;
						//echo "PS";
					}else{
						//$CostoUnitarioAnterior = (($CostoUnitarioAnterior + $CostoActual)/2);	
						$CostoTotalAnterior = (($CostoTotalAnterior + $CostoActual));	
						
						//deb($CostoTotalAnterior);
						//deb($CostoActual);
						//echo "PN";
					}
				
					//$CostoTotalSaldo = ($CostoUnitarioAnterior * $CantidadSaldo);
					$CostoTotalSaldo = ($CostoTotalAnterior);	
					$CostoUnitarioSaldo = $CostoTotalSaldo/$CantidadSaldo;	
						
				}
				?>
                
                
                &nbsp;
                </td>
              <td width="72" align="center" valign="top" bgcolor="#99CCCC">
				
				
                  <!--
            ENTRADAS - COSTO UNITARIO
            -->
            
				<?php
				if($DatKardex->KdvMovimientoTipo==1  ){
				?>
					
					<?php //echo number_format($DatKardex->KdvCostoUnitario,2)?>
                    <?php echo number_format($CostoActual,2)?>
                    
		        <?php
				}
				?>
                &nbsp;
              
      </td>
              <td width="58" align="center" valign="top" bgcolor="#99CCCC">
			  
                  <!--
            ENTRADAS - COSTO TOTAL
            -->
            
				<?php
				if($DatKardex->KdvMovimientoTipo==1  ){
				?>
					<?php echo number_format($CostoTotalActual,2)?>
				<?php
				}
				?>
                &nbsp;
	  </td>
              <td width="60" align="center" valign="top" bgcolor="#FFCC66">
			  
			<!--
            SALIDAS - CANTIDAD
            -->
            
            <?php //echo number_format($CantidadSaldo,2);?>
			<?php //echo number_format($CostoUnitarioAnterior,2);?>
      		<?php //echo number_format($CostoTotalSaldo,2);?>
            
              	<?php
				if($DatKardex->KdvMovimientoTipo==2){
				?>
                	
					<span style="color:#CCC;"><?php echo $CostoTotalAnterior;?></span>
					<?php   
					
					if($DatKardex->KdvSubTipo == 3){
						
						//$DatKardex->KdvCostoIngreso = $$DatKardex->KdvCostoIngreso *-1;
						
					}else{
						
						
					}
					
				//	$TotalSalidaGeneral += $DatKardex->KdvCantidad;
//					$CantidadSaldo =  ($TotalEntradaGeneral - $TotalSalidaGeneral);		
//					
//					$Cantidad = $DatKardex->KdvCantidad;
//					$CostoActual = $DatKardex->KdvCostoIngreso;
//					$CostoTotalActual = $CostoActual * $DatKardex->KdvCantidad;
//					
//					$CostoTotalMovimientoSalidas += $CostoTotalActual;
//					
//					$CostoTotalAnterior = (($CostoTotalAnterior - $CostoActual));	
//					
//					$CostoTotalSaldo = ($CostoTotalAnterior);	
//					$CostoUnitarioSaldo = $CostoTotalSaldo/(empty($CantidadSaldo)?1:$CantidadSaldo);

					$TotalSalidaGeneral += $DatKardex->KdvCantidad;
					$CantidadSaldo =  ($TotalEntradaGeneral - $TotalSalidaGeneral);		
					
					$Cantidad = $DatKardex->KdvCantidad;
					$CostoActual = $DatKardex->KdvCostoIngreso;
					$CostoTotalActual = $CostoActual * $DatKardex->KdvCantidad;
					
					$CostoTotalMovimientoSalidas += $CostoTotalActual;
					
					//$CostoTotalAnterior = (($CostoTotalAnterior - $CostoActual));	
					
					$CostoTotalSaldo = ($CostoTotalAnterior - $CostoTotalActual);	
					$CostoUnitarioSaldo = $CostoTotalSaldo/(empty($CantidadSaldo)?1:$CantidadSaldo);
					
					$CostoTotalAnterior = $CostoTotalSaldo;
					
					?>
                    
                    <?php echo number_format($Cantidad,2);?>
                    
                <?php
				}
				?>
               
                &nbsp;
	  </td>
              <td width="72" align="center" valign="top" bgcolor="#FFCC66">
			  
                <!--
            SALIDAS - COSTO UNITARIO
            -->
			    <?php
				if($DatKardex->KdvMovimientoTipo==2 ){
				?>
					<?php echo number_format($CostoActual,2)?>
				<?php
				}
				?>&nbsp;				
		</td>
              <td width="58" align="center" valign="top" bgcolor="#FFCC66">
                 <!--
            SALIDAS - COSTO TOTAL
            -->
			    <?php
				if($DatKardex->KdvMovimientoTipo==2  ){
				?>

					<?php echo number_format($CostoTotalActual,2)?>
                    
		        <?php
				}
				?>
                
                &nbsp;		
	  </td>
			<td width="60" align="center" valign="top" bgcolor="#66CC99">
				 
			<!--
            SALDO - CANTIDAD
            -->
            
			<?php echo number_format($CantidadSaldo,2);?>
              
			</td>
			<td width="72" align="center" valign="top" bgcolor="#66CC99">
               
			<!--
            SALDO - COSTO UNITARIO
            -->
            
			<?php //echo number_format($CostoUnitarioAnterior,2);?>
            <?php echo number_format($CostoUnitarioSaldo,2);?>
                
			</td>
			<td width="64" align="center" valign="top" bgcolor="#66CC99">
                
			<!--
            SALDO - COSTO TOTAL
            -->
            
      		<?php echo number_format($CostoTotalSaldo,2);?>
            
            </td>
			</tr>
 
<?php
}
?>
<?php

?>          

            		
            


            <?php	
				$j++;
			}
			?>
            
	
<?php
if($MostrarSaldoAnterior2){
?>
	<tr>
	  <td height="30" align="center">&nbsp;</td>
	  <td align="center">-</td>
	  <td align="center">&nbsp;</td>
	  <td align="center">-</td>
	  <td height="30" align="center">-</td>
	  <td height="30" align="center">-</td>
	  <td height="30" align="center">-</td>
	  <td height="30" align="center">-</td>
	  <td align="center">-</td>
	  <td align="center">&nbsp;</td>
	  <td height="30" align="center">-</td>
	  <td height="30" align="left">..</td>
	  <td height="30" align="center" valign="top" bgcolor="#99CCCC"><!--Saldo Anterior--></td>
	  <td height="30" align="center" valign="top" bgcolor="#99CCCC">&nbsp;</td>
	  <td height="30" align="center" valign="top" bgcolor="#99CCCC">&nbsp;</td>
	  <td height="30" align="center" valign="top" bgcolor="#FFCC66">&nbsp;</td>
	  <td height="30" align="center" valign="top" bgcolor="#FFCC66">&nbsp;</td>
	  <td height="30" align="center" valign="top" bgcolor="#FFCC66">&nbsp;</td>
	  <td height="30" align="center" valign="top" bgcolor="#66CC99"><?php  
		echo number_format($CantidadSaldo,2);
		?></td>
	  <td height="30" align="center" valign="top" bgcolor="#66CC99"><?php 
	 	echo number_format($CostoUnitarioAnterior,2);
		?></td>
	  <td align="center" valign="top" bgcolor="#66CC99"><?php 
		echo number_format($CostoTotalAnterior,2);
		?></td>
	  </tr>
<?php
}
?>		

                           <tr>
                             <td align="right">&nbsp;</td>
                             <td align="right">&nbsp;</td>
                             <td align="right">&nbsp;</td>
                             <td align="right">&nbsp;</td>
                             <td align="right">&nbsp;</td>
                             <td align="right">&nbsp;</td>
                             <td align="right">&nbsp;</td>
                             <td align="right">&nbsp;</td>
                             <td align="right">&nbsp;</td>
                             <td align="right">&nbsp;</td>
                             <td align="right">&nbsp;</td>
                             <td align="right">&nbsp;</td>
                             <td align="right"><?php echo number_format($TotalEntradaGeneral,2);?>&nbsp;</td>
                             <td align="right">&nbsp;</td>
                             <td align="right">&nbsp;</td>
                             <td align="right"><?php echo number_format($TotalSalidaGeneral,2);?>&nbsp;</td>
                             <td align="right">&nbsp;</td>
                             <td align="right">&nbsp;</td>
                             <td align="right">
							 
                             <?php
							 $CantidadSaldoGeneral = $TotalEntradaGeneral - $TotalSalidaGeneral;
							 
							 ?>
							 <?php echo number_format($CantidadSaldoGeneral,2);?>
                             
                             </td>
                             <td align="right">&nbsp;</td>
                             <td>&nbsp;</td>
                           </tr>
              </tbody>
            </table>
 

<?php
$CostoTotalMovimientoSaldos = $CostoTotalMovimientoEntradas - $CostoTotalMovimientoSalidas;
?>

 <table class="EstTablaListado">
 <thead class="EstTablaListadoHead">
 <tr>
   <th>Concepto</th>
   <th>Monto</th>
 </tr>
 </thead>
 <tbody class="EstTablaListadoBody">
 <tr>
   <td>Costo Total Entradas:</td>
   <td><?php echo number_format($CostoTotalMovimientoEntradas,2);?></td>
 </tr>
 <tr>
   <td>Costo Total Salidas:</td>
   <td><?php echo number_format($CostoTotalMovimientoSalidas,2);?></td>
 </tr>
 <tr>
   <td>Costo Saldo:</td>
 <td><?php echo number_format($CostoTotalMovimientoSaldos,2);?></td>
 </tr>
 </tbody>
 </table>
  
 (*) Tiene costos adicionales
 
 
</body>
</html>


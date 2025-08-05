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
	header("Content-Disposition:  filename=\"KARDEX_LISTADO_".date('d-m-Y').".xls\";");
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



require_once($InsPoo->MtdPaqAlmacen().'ClsKardex.php');

$InsKardex = new ClsKardex();

// MtdObtenerKardexs($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL)
$ResKardex = $InsKardex->MtdObtenerKardexs(NULL,NULL,NULL,'KdxFecha ASC,(KdxTiempoCreacion) ASC','',NULL,NULL,FncCambiaFechaAMysql($_POST['FechaInicio']),FncCambiaFechaAMysql($_POST['FechaFin']),NULL);
$ArrKardexs = $ResKardex['Datos'];

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
            <thead class="EstTablaListadoHead">
            <tr>
              <th rowspan="2">#</th>
              <th rowspan="2">Cod. Mov.</th>
              <th rowspan="2">Cod. Ori.</th>
              <th rowspan="2">Cod. Alt.</th>
              <th rowspan="2">Nombre</th>
              <th rowspan="2">Tipo</th>
              <th rowspan="2">Fecha</th>
              <th rowspan="2">Doc.</th>
              <th rowspan="2">Serie</th>
              <th rowspan="2">Numero</th>
              <th rowspan="2">&nbsp;</th>
              <th rowspan="2">Tipo Operacion</th>
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
	foreach($ArrKardexs as $DatKardex){

	?>
    
<?php
	if( FncConvetirTimestamp($DatKardex->KdxFecha)<FncConvetirTimestamp($_POST['FechaInicio'])){	

		if($DatKardex->KdxMovimientoTipo==1  ){
			$TotalEntradaGeneral += $DatKardex->KdxCantidad;

			$CostoActual = $DatKardex->KdxCostoUnitario;
			$CostoTotalActual = $CostoActual * $DatKardex->KdxCantidad;
			
			$Saldo =  ($TotalEntradaGeneral - $TotalSalidaGeneral);
			
			if($Primera ){
				$CostoUnitarioAnterior = $CostoActual;
				$Primera = false;
			}else{
				//$CostoUnitarioAnterior = round(($CostoUnitarioAnterior + $CostoActual)/2,2);	
				$CostoUnitarioAnterior = (($CostoUnitarioAnterior + $CostoActual)/2);	
			}
	
		}

		if($DatKardex->KdxMovimientoTipo==2){
			$TotalSalidaGeneral += $DatKardex->KdxCantidad;

			$CostoActual = $CostoUnitarioAnterior;
			$CostoTotalActual = $CostoActual * $DatKardex->KdxCantidad;

			$Saldo =  ($TotalEntradaGeneral - $TotalSalidaGeneral);			
		}

	}else{
		
		$MostrarSaldoAnterior2 = false;
?>         
              

<?php
if($MostrarSaldoAnterior){
?>
	<tr>
	  <td height="30" align="center"><?php //echo $j;?>-</td>
	  <td align="center">-</td>
	  <td align="center">&nbsp;</td>
	  <td align="center">&nbsp;</td>
	  <td align="center">&nbsp;</td>
	  <td align="center">&nbsp;</td>
	  <td height="30" align="center">-</td>
	  <td height="30" align="center">-</td>
	  <td height="30" align="left">-</td>
	  <td height="30" align="center">-</td>
	  <td height="30" align="center">-</td>
	  <td height="30" align="left">&nbsp;</td>
	  <td height="30" align="right"><!--Saldo Anterior--></td>
	  <td height="30" align="right" bgcolor="#99CCCC">&nbsp;</td>
	  <td height="30" align="right">&nbsp;</td>
	  <td height="30" align="right">&nbsp;</td>
	  <td height="30" align="right" bgcolor="#FFCC66">&nbsp;</td>
	  <td height="30" align="right">&nbsp;</td>
	  <td height="30" align="right"><?php  
		echo number_format($Saldo,3);
		?></td>
	  <td height="30" align="right" bgcolor="#66CC99"><?php 
	 	echo number_format($CostoUnitarioAnterior,3);
		?></td>
	  <td height="30" align="right"><?php 
		echo number_format($CostoTotalAnterior,3);
		?></td>
	  </tr>
<?php
}
$MostrarSaldoAnterior = false;
?>


<?php
if($DatKardex->TopId == ""){
?>


<?php
}
?>


	<tr>
	  <td align="left"><?php echo $j;?></td>
	  <td align="left">
		<?php
		switch($DatKardex->KdxMovimientoTipo){
			case 1:
		?>
            <a target="_blank" href="../../principal.php?Mod=AlmacenMovimientoEntrada&Form=Ver&Id=<?php echo $DatKardex->KdxId ?>">
            <?php echo $DatKardex->KdxId;?>
            </a>
		<?php
			break;
		  
			case 2:
		?>
            <a target="_blank" href="../../principal.php?Mod=AlmacenMovimientoSalida&Form=Ver&Id=<?php echo $DatKardex->KdxId ?>">
            <?php echo $DatKardex->KdxId;?>
            </a>
        
        <?php		  
			break;
		}
		?>
      </td>
	  <td align="left"><?php echo $DatKardex->ProCodigoOriginal;?></td>
	  <td align="left"><?php echo $DatKardex->ProCodigoAlternativo;?></td>
	  <td align="left"><?php echo $DatKardex->ProNombre;?></td>
	  <td align="left"><?php echo $DatKardex->RtiNombre;?></td>
	  <td align="left"><?php echo $DatKardex->KdxFecha;?></td>
	  <td align="left">
	  
          [<?php echo $DatKardex->CtiCodigo;?>]
          <?php echo $DatKardex->CtiNombre;?>
      </td>
	  <td align="left">
      <?php list($Serie,$Numero)=explode("-",$DatKardex->KdxComprobanteNumero);?>
		<?php echo $Serie;?>
	  </td>
	  <td align="left">
      <?php echo $Numero;?>
      </td>
	  <td align="left">
	  
<?php
switch($DatKardex->KdxMovimientoTipo){
	case 1:
?>
	    E
<?php
		$TotalMovimientoEntradas++;
		$TotalMontoMovimientoEntradas+=$DatKardex->KdxCantidad;
	break;
	
	case 2:
?>
	    S
<?php	
		$TotalMovimientoSalidas++;
		$TotalMontoMovimientoSalidas+=$DatKardex->KdxCantidad;
	break;
	
	default:
?>
	    -
  <?php	
	break;
}
?>

</td>
	  <td align="left">[<?php echo $DatKardex->TopCodigo?>]  <?php echo $DatKardex->TopNombre?> </td>
	  <td align="right">
	  			<?php
				if($DatKardex->KdxMovimientoTipo==1  ){
				?>
					<?php echo number_format($DatKardex->KdxCantidad,3);?>
					<?php
					$TotalEntradaGeneral += $DatKardex->KdxCantidad;

					$CostoActual = $DatKardex->KdxCostoUnitario;
					$CostoTotalActual = $CostoActual * $DatKardex->KdxCantidad;
					
					$Saldo =  ($TotalEntradaGeneral - $TotalSalidaGeneral);		
					
					
					if($Primera ){
						$CostoUnitarioAnterior = $CostoActual;
						$Primera = false;
					}else{
						//$CostoUnitarioAnterior = round(($CostoUnitarioAnterior + $CostoActual)/2,2);	
						$CostoUnitarioAnterior = (($CostoUnitarioAnterior + $CostoActual)/2);	
					}
					//$CostoTotalSaldo = round($CostoUnitarioAnterior * $Saldo,2);
					$CostoTotalSaldo = ($CostoUnitarioAnterior * $Saldo);			
				}
				?>
                
                
                &nbsp;
                </td>
              <td align="right" bgcolor="#99CCCC">
				<?php
				if($DatKardex->KdxMovimientoTipo==1  ){
				?>
					<?php echo number_format($DatKardex->KdxCostoUnitario,3)?>
		        <?php
				}
				?>
                &nbsp;
              
      </td>
              <td align="right">
			  
				<?php
				if($DatKardex->KdxMovimientoTipo==1  ){
				?>
					<?php echo number_format($CostoTotalActual,3)?>
				<?php
				}
				?>
                &nbsp;
	  </td>
              <td align="right">
			  	<?php
				if($DatKardex->KdxMovimientoTipo==2){
				?>
                	<?php echo number_format($DatKardex->KdxCantidad,3);?>
					<?php
                    $TotalSalidaGeneral += $DatKardex->KdxCantidad;
					
					$CostoActual = $CostoUnitarioAnterior;
					$CostoTotalActual = $CostoActual * $DatKardex->KdxCantidad;
		
					$Saldo =  ($TotalEntradaGeneral - $TotalSalidaGeneral);		
					
					//$CostoTotalSaldo = round($Saldo * $CostoUnitarioAnterior,2);	
					$CostoTotalSaldo = ($Saldo * $CostoUnitarioAnterior);	
					?>
                <?php
				}
				?>&nbsp;
			</td>
              <td align="right" bgcolor="#FFCC66">
			  
			    <?php
				if($DatKardex->KdxMovimientoTipo==2 ){
				?>
					<?php echo number_format($CostoActual,3)?>
				<?php
				}
				?>&nbsp;				
		</td>
              <td align="right">
              
			    <?php
				if($DatKardex->KdxMovimientoTipo==2  ){
				?>
					<?php echo number_format($CostoTotalActual,3)?>
		        <?php
				}
				?>&nbsp;		
	  </td>
			<td align="right">
				<?php echo number_format($Saldo,3);?>
	  </td>
			<td align="right" bgcolor="#66CC99">
				<?php echo number_format($CostoUnitarioAnterior,3);?>
	  </td>
			<td align="right">
            	<?php
				
				?>
				<?php echo number_format($CostoTotalSaldo,3);?>              
	    </td>
		</tr>
 
<?php
}
?>

            		
            


            <?php	
				$j++;
			}
			?>
            
	
<?php
if($MostrarSaldoAnterior2){
?>
	<tr>
	  <td height="30" align="center"><?php //echo $j;?>-</td>
	  <td align="center">-</td>
	  <td align="center">&nbsp;</td>
	  <td align="center">&nbsp;</td>
	  <td align="center">&nbsp;</td>
	  <td align="center">&nbsp;</td>
	  <td height="30" align="center">-</td>
	  <td height="30" align="center">-</td>
	  <td height="30" align="left">-</td>
	  <td height="30" align="center">-</td>
	  <td height="30" align="center">-</td>
	  <td height="30" align="left">&nbsp;</td>
	  <td height="30" align="right"><!--Saldo Anterior--></td>
	  <td height="30" align="right" bgcolor="#99CCCC">&nbsp;</td>
	  <td height="30" align="right">&nbsp;</td>
	  <td height="30" align="right">&nbsp;</td>
	  <td height="30" align="right" bgcolor="#FFCC66">&nbsp;</td>
	  <td height="30" align="right">&nbsp;</td>
	  <td height="30" align="right"><?php  
		echo number_format($Saldo,3);
		?></td>
	  <td height="30" align="right" bgcolor="#66CC99"><?php 
	 	echo number_format($CostoUnitarioAnterior,3);
		?></td>
	  <td height="30" align="right"><?php 
		echo number_format($CostoTotalAnterior,3);
		?></td>
	  </tr>
<?php
}
?>		

                           <tr>
                             <td align="right">&nbsp;</td>
                             <td align="center">&nbsp;</td>
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
                             <td align="right"><?php echo number_format($TotalEntradaGeneral,3);?></td>
                             <td align="right">&nbsp;</td>
                             <td align="right">&nbsp;</td>
                             <td align="right"><?php echo number_format($TotalSalidaGeneral,3);?></td>
                             <td align="right">&nbsp;</td>
                             <td align="right">&nbsp;</td>
                             <td align="right">&nbsp;</td>
                             <td align="right">&nbsp;</td>
                             <td align="right">&nbsp;</td>
                           </tr>
              </tbody>
            </table>
 
 
 
</body>
</html>


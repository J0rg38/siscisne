<?php
session_start();
////PRINCIPALES
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
	header("Content-Disposition:  filename=\"REPORTE_PRODUCTO_VENTA_".date('d-m-Y').".xls\";");
}
?>
<html>
<head>

<?php
if($_GET['P']<>2){
?>
<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssReporte.css">
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.7.2.min.js"></script> 
<?php
}
?>

</head>
<body>
<script type="text/javascript">

$().ready(function() {
<?php if($_GET['P']==1){?> 
	setTimeout("window.close();",2500);	
	window.print(); 

<?php }?>
});

</script>
<?php

$POST_finicio = isset($_POST['CmpFechaInicio'])?$_POST['CmpFechaInicio']:"01".date("/m/Y");
$POST_ffin = isset($_POST['CmpFechaFin'])?$_POST['CmpFechaFin']:date("d/m/Y");



$POST_UnidadMedidaUso = $_POST['CmpProductoUnidadMedidaKardex'];
$POST_ProductoId = $_POST['CmpProductoId'];

if(empty($POST_ProductoId )){
	die("Escoja un producto");
}
require_once($InsPoo->MtdPaqAlmacen().'ClsKardex.php');

$InsKardex = new ClsKardex();

// MtdObtenerKardexs($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL)
$ResKardex = $InsKardex->MtdObtenerKardexs($Campo,"esigual",$POST_ProductoId,'AmoFecha ASC,(AmdTiempoCreacion) ASC','',NULL,$POST_ProductoId,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),$POST_UnidadMedidaUso);
$ArrKardexs = $ResKardex['Datos'];

?>

<?php if($_GET['P']==1){?>
<table cellpadding="0" cellspacing="0" width="100%" border="0">
<tr>
  <td colspan="3" align="left"><span class="EstReporteCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
</tr>
<tr>
  <td width="23%" align="left" valign="top">
  <?php
		if(!empty($SistemaLogo) and file_exists("../../imagenes/".$SistemaLogo)){
		?>
    <img src="../../imagenes/<?php echo $SistemaLogo;?>" width="271" height="92" />
    <?php
		}else{
		?>
    <img src="../../imagenes/logotipo.png" width="243" height="59" />
    <?php	
		}
		?>
  </td>
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">REPORTE DE KARDEX VALORIZADO DE PRODUCTOS 
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



 </span></td>
  <td width="23%" align="right" valign="top"><span class="EstReporteDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> <br />

    <span class="EstReporteDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
</tr>
</table>
<hr class="EstReporteLinea">

<?php }?>
        
        <table class="EstTablaReporte" width="100%">
            <thead class="EstTablaReporteHead">
            <tr>
              <th width="17" rowspan="3">#</th>
              <th colspan="6"><ipo></ipo>                DOCUMENTO DE TRASLADO COMPROBANTE DE PAGO</th>
              <th width="17" rowspan="3">-</th>
              <th colspan="3">ENTRADAS</th>
              <th colspan="3">SALIDAS</th>
              <th colspan="3">SALDO FINAL</th>
            </tr>
            <tr>
              <th colspan="6">DOCUMENTO INTERNO O SIMILAR</th>
              <th>CANT.</th>
              <th>COSTO UNI.</th>
              <th>COSTO TOTAL</th>
              <th>CANT.</th>
              <th>COSTO UNI.</th>
              <th>COSTO TOTAL</th>
              <th>CANT.</th>
              <th>COSTO UNI.</th>
              <th>COSTO TOTAL</th>
            </tr>
            <tr>
              <th width="66">PRODUCTO</th>
              <th width="66">COD. MOV.</th>
              <th width="40">FECHA</th>
              <th width="76">TIPO</th>
              <th width="38">SERIE</th>
              <th width="77">SERIE</th>
              <th>&nbsp;</th>
              <th>&nbsp;</th>
              <th>&nbsp;</th>
              <th>&nbsp;</th>
              <th>&nbsp;</th>
              <th>&nbsp;</th>
              <th>&nbsp;</th>
              <th>&nbsp;</th>
              <th>&nbsp;</th>
            </tr>
              
            </thead>
            <tbody class="EstTablaReporteBody">
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
	$MostrarInventario = true;	
	foreach($ArrKardexs as $DatKardex){

	?>
    
<?php
	if( FncConvetirTimestamp($DatKardex->KdxFecha)<FncConvetirTimestamp($POST_finicio)){	

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
	  <td height="30" align="center">&nbsp;</td>
	  <td align="center">&nbsp;</td>
	  <td align="center">&nbsp;</td>
	  <td height="30" align="center">-</td>
	  <td align="center">&nbsp;</td>
	  <td height="30" align="left">-</td>
	  <td height="30" align="center">-</td>
	  <td height="30" align="center">-</td>
	  <td height="30" align="center" valign="top"><!--Saldo Anterior--></td>
	  <td width="72" height="30" align="center" valign="top" bgcolor="#99CCCC">&nbsp;</td>
	  <td width="58" height="30" align="center" valign="top">&nbsp;</td>
	  <td width="60" height="30" align="center" valign="top">&nbsp;</td>
	  <td width="72" height="30" align="center" valign="top" bgcolor="#FFCC66">&nbsp;</td>
	  <td width="58" height="30" align="center" valign="top">&nbsp;</td>
	  <td width="60" height="30" align="center" valign="top"><?php  
		echo number_format($Saldo,2);
		?></td>
	  <td width="72" height="30" align="center" valign="top" bgcolor="#66CC99"><?php 
	 	echo number_format($CostoUnitarioAnterior,2);
		?></td>
	  <td width="64" height="30" align="center" valign="top"><?php 
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
                    <td colspan="17" align="center">
                    INVENTARIO
                    </td>
                </tr>
            <?php
				$Saldo = 0;
				$MostrarInventario = false;								
            }
            ?>
            
            

	<tr>
	  <td align="left"><?php echo $j;?></td>
	  <td align="left" valign="top"><?php echo $DatKardex->ProCodigoOriginal;?></td>
	  <td align="left" valign="top">
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
	  <td align="left" valign="top"><?php echo $DatKardex->KdxFecha;?></td>
	  <td align="left" valign="top"><?php echo $DatKardex->RtiNombre;?></td>
	  <td align="left" valign="top">
	    <?php list($Serie,$Numero)=explode("-",$DatKardex->KdxComprobanteNumero);?>
	    <?php echo $Serie;?>&nbsp;
      </td>
	  <td align="left" valign="top">
      <?php echo $Numero;?>&nbsp;
      </td>
	  <td align="left" valign="top">
	    
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
	  <td width="60" align="center" valign="top">
	  			<?php
				if($DatKardex->KdxMovimientoTipo==1  ){
				?>
					<?php echo number_format($DatKardex->KdxCantidad,2);?>
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
              <td width="72" align="center" valign="top" bgcolor="#99CCCC">
				<?php
				if($DatKardex->KdxMovimientoTipo==1  ){
				?>
					<?php echo number_format($DatKardex->KdxCostoUnitario,2)?>
		        <?php
				}
				?>
                &nbsp;
              
      </td>
              <td width="58" align="center" valign="top">
			  
				<?php
				if($DatKardex->KdxMovimientoTipo==1  ){
				?>
					<?php echo number_format($CostoTotalActual,2)?>
				<?php
				}
				?>
                &nbsp;
	  </td>
              <td width="60" align="center" valign="top">
			  	<?php
				if($DatKardex->KdxMovimientoTipo==2){
				?>
                	<?php echo number_format($DatKardex->KdxCantidad,2);?>
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
              <td width="72" align="center" valign="top" bgcolor="#FFCC66">
			  
			    <?php
				if($DatKardex->KdxMovimientoTipo==2 ){
				?>
					<?php echo number_format($CostoActual,2)?>
				<?php
				}
				?>&nbsp;				
		</td>
              <td width="58" align="center" valign="top">
              
			    <?php
				if($DatKardex->KdxMovimientoTipo==2  ){
				?>
					<?php echo number_format($CostoTotalActual,2)?>
		        <?php
				}
				?>&nbsp;		
	  </td>
			<td width="60" align="center" valign="top">
				<?php echo number_format($Saldo,2);?>
	  </td>
			<td width="72" align="center" valign="top" bgcolor="#66CC99">
				<?php echo number_format($CostoUnitarioAnterior,2);?>
	  </td>
			<td width="64" align="center" valign="top">
            	<?php
				
				?>
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
	  <td align="center">&nbsp;</td>
	  <td align="center">&nbsp;</td>
	  <td height="30" align="center">-</td>
	  <td align="center">&nbsp;</td>
	  <td height="30" align="left">-</td>
	  <td height="30" align="center">-</td>
	  <td height="30" align="center">-</td>
	  <td height="30" align="center" valign="top"><!--Saldo Anterior--></td>
	  <td height="30" align="center" valign="top" bgcolor="#99CCCC">&nbsp;</td>
	  <td height="30" align="center" valign="top">&nbsp;</td>
	  <td height="30" align="center" valign="top">&nbsp;</td>
	  <td height="30" align="center" valign="top" bgcolor="#FFCC66">&nbsp;</td>
	  <td height="30" align="center" valign="top">&nbsp;</td>
	  <td height="30" align="center" valign="top"><?php  
		echo number_format($Saldo,2);
		?></td>
	  <td height="30" align="center" valign="top" bgcolor="#66CC99"><?php 
	 	echo number_format($CostoUnitarioAnterior,2);
		?></td>
	  <td height="30" align="center" valign="top"><?php 
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
                             <td align="right"><?php //echo number_format($TotalEntradaGeneral,2);?>&nbsp;</td>
                             <td align="right">&nbsp;</td>
                             <td align="right">&nbsp;</td>
                             <td align="right"><?php //echo number_format($TotalSalidaGeneral,2);?>&nbsp;</td>
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
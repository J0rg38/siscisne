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

<link rel="stylesheet" type="text/css" href="css/CssKardex.css">
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

$POST_ProductoTipo = $_POST['ProductoTipo'];
$POST_Moneda = $_POST['Moneda'];
$POST_FechaTipo = (empty($_POST['CmpFechaTipo'])?"AmoFecha":$_POST['CmpFechaTipo']);

$POST_FechaInicio = $_POST['FechaInicio'];
$POST_FechaFin = $_POST['FechaFin'];
$POST_AlmacenId = $_POST['CmpAlmacenId'];


require_once($InsPoo->MtdPaqAlmacen().'ClsKardex.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');

$InsKardex = new ClsKardex();
$InsProducto = new ClsProducto();

$aux = explode("/",$POST_FechaInicio);

$KardexFechaInicio = "01/01/".$aux[2];

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
    <img src="../../imagenes/<?php echo $SistemaLogo;?>" />
    <?php
		}else{
		?>
    <img src="../../imagenes/logotipo.png" />
    <?php	
		}
		?>
    
    
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

<?php
// MtdObtenerProductos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'ProId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oTipo=NULL,$oValidarStock=1,$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oVehiculoVersion=NULL,$oVehiculoAno=NULL,$oTieneIngreso=false,$oReferencia=NULL) {
$ResProducto = $InsProducto->MtdObtenerProductos(NULL,NULL,NULL,"ProNombre","ASC",NULL,1,$POST_ProductoTipo,1,NULL,NULL,NULL,NULL,NULL,false,NULL);
$ArrProductos = $ResProducto['Datos'];


?>

<?php
foreach($ArrProductos as $DatProducto){
?>

	<?php

//  MtdObtenerKardexs($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oUso=NULL,$oMoneda=NULL,$oFechaTipo="AmoFecha",$oAlmacen=NULL) 
    //$ResKardex = $InsKardex->MtdObtenerKardexs(NULL,NULL,NULL,'AmoFecha ASC,(AmdTiempoCreacion) ASC','',NULL,$DatProducto->ProId,FncCambiaFechaAMysql($KardexFechaInicio),FncCambiaFechaAMysql($POST_FechaFin),1,$POST_Moneda,$POST_FechaTipo,$POST_AlmacenId);
//	$ResKardex = $InsKardex->MtdObtenerKardexs(NULL,NULL,NULL,'AmoFecha ASC,(AmdTiempoCreacion) ASC','',NULL,$DatProducto->ProId,FncCambiaFechaAMysql($KardexFechaInicio),FncCambiaFechaAMysql($POST_FechaFin),1,$POST_Moneda,$POST_FechaTipo,$POST_AlmacenId);
	$ResKardex = $InsKardex->MtdObtenerKardexs(NULL,NULL,NULL,'AmoFecha ASC,(AmdTiempoCreacion) ASC','',NULL,$DatProducto->ProId,FncCambiaFechaAMysql($KardexFechaInicio),FncCambiaFechaAMysql($POST_FechaFin),1,$POST_Moneda,"amd.AmdFecha",$POST_AlmacenId);
    $ArrKardexs = $ResKardex['Datos'];
	
    ?>        
    
    <?php
	if(!empty($ArrKardexs)){
	?>
    
    <div class="EstKardexTitulo">
    KARDEX VALORADO <?php echo $DatProducto->ProNombre;?> (<?php echo $DatProducto->ProCodigoOriginal;?>)
 </div>
            <table class="EstTablaListado" width="100%">
            <thead class="EstTablaListadoHead">
            <tr>
              <th width="17" rowspan="3">#</th>
              <th colspan="11">DOCUMENTO DE TRASLADO / COMPROBANTE DE PAGO</th>
              <th width="115" rowspan="2">TIPO DE OPERACION</th>
              <th width="115" rowspan="2">&nbsp;</th>
              <th colspan="3" rowspan="2">ENTRADAS</th>
              <th colspan="3" rowspan="2">SALIDAS</th>
              <th colspan="3" rowspan="2">SALDO</th>
              <th width="50" rowspan="3">FECHA REGISTRO</th>
              <th rowspan="2">&nbsp;</th>
            </tr>
            <tr>
              <th colspan="7">DOCUMENTO INTERNO O SIMILAR</th>
              <th colspan="4"><ipo></ipo>
                DOC. REFERENCIA</th>
              </tr>
            <tr>
              <th width="100">FICHA</th>
              <th width="100">AFECTADO</th>
              <th width="100">CODIGO</th>
              <th width="100">CLAS. PROD.</th>
              <th width="100">TIPO PRODUCTO</th>
              <th width="100">FECHA</th>
              <th width="100">TIPO</th>
              <th width="100">SERIE</th>
              <th width="100">NUMERO</th>
              <th width="100">FECHA</th>
              <th width="100">UBICACION</th>
              <th width="100">INGRESO O SALIDA</th>
              <th width="100">INV. INICIAL</th>
              <th width="50" align="center">CANT.</th>
              <th width="50" align="center">COSTO UNI.</th>
              <th width="50" align="center">COSTO TOTAL</th>
              <th width="50" align="center">CANT.</th>
              <th width="50" align="center">COSTO UNI.</th>
              <th width="50" align="center">COSTO TOTAL</th>
              <th width="50" align="center">CANT.</th>
              <th width="50" align="center">COSTO UNI.</th>
              <th width="50" align="center">COSTO TOTAL</th>
              <th width="50" align="center">&nbsp;</th>
            </tr>
              
            </thead>
            <tbody class="EstTablaListadoBody">
            
            
        
	<?php
	
	$Saldo = 0;
	$CostoUnitarioAnterior = 0;
	$CostoTotalAnterior = 0;

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
	$TotalFilas = count($ArrKardexs);
	
	foreach($ArrKardexs as $DatKardex){
		
		$DatKardex->KdxCostoUnitario = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$DatKardex->KdxCostoUnitario:($DatKardex->KdxCostoUnitario/$DatKardex->KdxTipoCambio));  

	?>
    
<?php
	if( FncConvetirTimestamp($DatKardex->KdxFecha) < FncConvetirTimestamp($POST_FechaInicio)){	
//	if( FncConvetirTimestamp($DatKardex->KdxFecha)<FncConvetirTimestamp($_POST['FechaInicio'])){	

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
	  <td width="100" align="center">&nbsp;</td>
	  <td width="100" align="center">&nbsp;</td>
	  <td width="100" align="center">-</td>
	  <td width="100" align="center">&nbsp;</td>
	  <td width="100" align="center">-</td>
	  <td width="100" height="30" align="center">-</td>
	  <td width="100" height="30" align="center">-</td>
	  <td width="100" height="30" align="center">-</td>
	  <td width="100" align="center">-</td>
	  <td width="100" align="center">-</td>
	  <td width="100" height="30" align="center">-</td>
	  <td width="100" align="center">-</td>
	  <td width="100" height="30" align="center">-</td>
	  <td width="50" height="30" align="center" valign="top" bgcolor="#99CCCC"><!--Saldo Anterior-->-</td>
	  <td width="50" height="30" align="center" valign="top" bgcolor="#99CCCC">-</td>
	  <td width="50" height="30" align="center" valign="top" bgcolor="#99CCCC">-</td>
	  <td width="50" height="30" align="center" valign="top" bgcolor="#FFCC66">-</td>
	  <td width="50" height="30" align="center" valign="top" bgcolor="#FFCC66">-</td>
	  <td width="50" height="30" align="center" valign="top" bgcolor="#FFCC66">-</td>
	  <td width="50" height="30" align="center" valign="top"><?php  
		echo number_format($Saldo,2);
		?></td>
	  <td width="50" height="30" align="center" valign="top"><?php 
	 	echo number_format($CostoUnitarioAnterior,2);
		?></td>
	  <td width="50" align="center" valign="top"><?php 
		echo number_format($CostoTotalAnterior,2);
		?></td>
	  <td width="50" align="center" valign="top">-</td>
	  <td width="50" height="30" align="center" valign="top">&nbsp;</td>
	  </tr>
<?php
}
$MostrarSaldoAnterior = false;
?>



			<?php
            if($DatKardex->TopId == "TOP-10015" and $MostrarInventario){
            ?>
                <tr>
                    <td colspan="25" align="center">
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
	  <td width="100" align="center" valign="top"> <?php echo $DatKardex->KdxId;?></td>
	  <td width="100" align="center" valign="top">
	  
	  <?php echo $DatKardex->CliNombre;?>
	  <?php echo $DatKardex->CliApellidoPaterno;?>
	  <?php echo $DatKardex->CliApellidoMaterno;?>
      
        <?php echo $DatKardex->PrvNombre;?>
	  <?php echo $DatKardex->PrvApellidoPaterno;?>
	  <?php echo $DatKardex->PrvApellidoMaterno;?>
      
      </td>
	  <td width="100" align="center" valign="top">
		<?php
		/*switch($DatKardex->KdxMovimientoTipo){
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
		}*/
		?>
        <?php echo $DatKardex->ProCodigoOriginal;?>
        
      </td>
	  <td width="100" align="center" valign="top"><?php echo $DatKardex->PcaNombre;?></td>
	  <td width="100" align="center" valign="top"><?php echo $DatKardex->RtiNombre;?></td>
	  <td width="100" align="center" valign="top"><?php echo $DatKardex->KdxFecha;?></td>
	  <td width="100" align="center" valign="top">
	  
          [<?php echo $DatKardex->CtiCodigo;?>]
          <?php echo $DatKardex->CtiNombre;?>
      </td>
	  <td width="100" align="center" valign="top">
    
    
    
      <?php //list($Serie,$Numero)=explode("-",$DatKardex->KdxComprobanteNumero);?>
      	<?php
    if(empty($DatKardex->KdxComprobanteNumero)){
    ?>
		<?php list($Serie,$Numero)=explode("-",$DatKardex->KdxComprobanteNumero2);?>
    <?php  
    }else{
    ?>
		<?php list($Serie,$Numero)=explode("-",$DatKardex->KdxComprobanteNumero);?>        
    <?php  
    }
    ?>
      
      
		<?php echo $Serie;?>&nbsp;
	  </td>
	  <td width="100" align="center" valign="top"><?php echo $Numero;?></td>
	  <td width="100" align="center" valign="top"><?php echo $DatKardex->KdxComprobanteFecha;?></td>
	  <td width="100" align="center" valign="top"><?php echo $DatKardex->KdxUbicacion;?></td>
	  <td width="100" align="center" valign="top"><?php
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
[<?php echo $DatKardex->TopCodigo?>] <?php echo $DatKardex->TopNombre?></td>
	  <td width="100" align="center" valign="top">-</td>
	  <td width="50" align="center" valign="top" bgcolor="#99CCCC">
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
                
                
               
                </td>
              <td width="50" align="center" valign="top" bgcolor="#99CCCC">
				<?php
				if($DatKardex->KdxMovimientoTipo==1  ){
				?>
					<?php echo number_format($DatKardex->KdxCostoUnitario,2)?>
		        <?php
				}
				?>
              
              
      </td>
              <td width="50" align="center" valign="top" bgcolor="#99CCCC">
			  
				<?php
				if($DatKardex->KdxMovimientoTipo==1  ){
				?>
					<?php echo number_format($CostoTotalActual,2)?>
				<?php
				}
				?>
              
	  </td>
              <td width="50" align="center" valign="top" bgcolor="#FFCC66">
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
				?>
			</td>
              <td width="50" align="center" valign="top" bgcolor="#FFCC66">
			  
			    <?php
				if($DatKardex->KdxMovimientoTipo==2 ){
				?>
					<?php echo number_format($CostoActual,2)?>
				<?php
				}
				?>		
		</td>
              <td width="50" align="center" valign="top" bgcolor="#FFCC66">
              
			    <?php
				if($DatKardex->KdxMovimientoTipo==2  ){
				?>
					<?php echo number_format($CostoTotalActual,2)?>
		        <?php
				}
				?>
	  </td>
			<td width="50" align="center" valign="top" bgcolor="#66CC99">
				<?php echo number_format($Saldo,2);?>
	  </td>
			<td width="50" align="center" valign="top" bgcolor="#66CC99">
				<?php echo number_format($CostoUnitarioAnterior,2);?>
	  </td>
			<td width="50" align="center" valign="top" bgcolor="#66CC99"><?php
				
				?>
            <?php echo number_format($CostoTotalSaldo,2);?></td>
			<td width="50" align="center" valign="top"> <?php echo $DatKardex->KdxTiempoCreacion;?></td>
			<td width="50" align="center" valign="top">
            
            <?php
			if($TotalFilas == $j){
			?>
             ***
            <?php	
			}
			?>
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
	  <td width="100" align="center">&nbsp;</td>
	  <td width="100" align="center">&nbsp;</td>
	  <td width="100" align="center">-</td>
	  <td width="100" align="center">&nbsp;</td>
	  <td width="100" align="center">-</td>
	  <td width="100" height="30" align="center">-</td>
	  <td width="100" height="30" align="center">-</td>
	  <td width="100" height="30" align="center">-</td>
	  <td width="100" align="center">-</td>
	  <td width="100" align="center">-</td>
	  <td width="100" height="30" align="center">-</td>
	  <td width="100" align="center">-</td>
	  <td width="100" height="30" align="center">-</td>
	  <td width="50" height="30" align="center" valign="top" bgcolor="#99CCCC"><!--Saldo Anterior-->-</td>
	  <td width="50" height="30" align="center" valign="top" bgcolor="#99CCCC">-</td>
	  <td width="50" height="30" align="center" valign="top" bgcolor="#99CCCC">-</td>
	  <td width="50" height="30" align="center" valign="top" bgcolor="#FFCC66">-</td>
	  <td width="50" height="30" align="center" valign="top" bgcolor="#FFCC66">-</td>
	  <td width="50" height="30" align="center" valign="top" bgcolor="#FFCC66">-</td>
	  <td width="50" height="30" align="center" valign="top" bgcolor="#66CC99"><?php  
		echo number_format($Saldo,2);
		?></td>
	  <td width="50" height="30" align="center" valign="top" bgcolor="#66CC99"><?php 
	 	echo number_format($CostoUnitarioAnterior,2);
		?></td>
	  <td width="50" align="center" valign="top" bgcolor="#66CC99"><?php 
		echo number_format($CostoTotalAnterior,2);
		?></td>
	  <td width="50" align="center" valign="top">-</td>
	  <td width="50" height="30" align="center" valign="top">&nbsp;</td>
	  </tr>
<?php
}
?>		

                           <tr>
                             <td align="right">&nbsp;</td>
                             <td width="100" align="center">&nbsp;</td>
                             <td width="100" align="center">&nbsp;</td>
                             <td width="100" align="center">-</td>
                             <td width="100" align="center">&nbsp;</td>
                             <td width="100" align="center">-</td>
                             <td width="100" align="center">-</td>
                             <td width="100" align="center">-</td>
                             <td width="100" align="center">-</td>
                             <td width="100" align="center">-</td>
                             <td width="100" align="center">-</td>
                             <td width="100" align="center">-</td>
                             <td width="100" align="center">-</td>
                             <td width="100" align="center">-</td>
                             <td width="50" align="center" bgcolor="#99CCCC"><?php //echo number_format($TotalEntradaGeneral,2);?>&nbsp;</td>
                             <td width="50" align="center" bgcolor="#99CCCC">-</td>
                             <td width="50" align="center" bgcolor="#99CCCC">-</td>
                             <td width="50" align="center" bgcolor="#FFCC66"><?php //echo number_format($TotalSalidaGeneral,2);?>&nbsp;</td>
                             <td width="50" align="center" bgcolor="#FFCC66">-</td>
                             <td width="50" align="center" bgcolor="#FFCC66">-</td>
                             <td width="50" align="center" bgcolor="#66CC99">-</td>
                             <td width="50" align="center" bgcolor="#66CC99">-</td>
                             <td width="50" align="center" bgcolor="#66CC99">-</td>
                             <td width="50" align="center">-</td>
                             <td width="50" align="center">&nbsp;</td>
                           </tr>
              </tbody>
            </table>
 

<br>
    <?php	
	}
	?>



<?php	
}
?>

 
  *** Saldo final
</body>
</html>


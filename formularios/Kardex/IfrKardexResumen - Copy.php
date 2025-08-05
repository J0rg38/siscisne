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
	header("Content-Disposition:  filename=\"KARDEX_RESUMEN_".date('d-m-Y').".xls\";");
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

$POST_ProductoTipo = $_GET['ProductoTipo'];
$POST_Moneda = $_GET['Moneda'];
$POST_FechaTipo = (empty($_GET['FechaTipo'])?"AmoFecha":$_GET['FechaTipo']);

$POST_FechaInicio = $_GET['FechaInicio'];
$POST_FechaFin = $_GET['FechaFin'];

$POST_Almacen = $_GET['Almacen'];
$POST_Sucursal = $_GET['Sucursal'];


require_once($InsPoo->MtdPaqAlmacen().'ClsKardex.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');

$InsKardex = new ClsKardex();
$InsProducto = new ClsProducto();
$InsSucursal = new ClsSucursal();

$aux = explode("/",$POST_FechaInicio);
$KardexFechaInicio = "01/01/".$aux[2];


$InsSucursal->SucId = $POST_Sucursal;
$InsSucursal->MtdObtenerSucursal();

$InventarioFechaInicio = (empty($InsSucursal->SucInventarioFechaInicio)?$SistemaInventarioFecha:$InsSucursal->SucInventarioFechaInicio);



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
  
  
  <span class="EstReporteTitulo">RESUMEN DE KARDEX 
 
<?php
if($POST_FechaInicio == $POST_FechaFin){
?>
	<?php echo $POST_FechaInicio; ?>
<?php
}else{
?>
	<?php echo $POST_FechaInicio; ?> AL <?php echo $POST_FechaFin; ?>
<?php  
}
?>



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

//MtdObtenerProductos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'ProId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oTipo=NULL,$oValidarStock=1,$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oVehiculoVersion=NULL,$oVehiculoAno=NULL,$oTieneIngreso=false,$oReferencia=NULL,$oFecha=NULL,$oTieneSock=0,$oProductoCategoria=NULL,$oUsoEstricto=false,$oVehiculoMarca=NULL,$oCalcularPrecio=NULL,$oTieneCodigoOriginal=false) {
$ResProducto = $InsProducto->MtdObtenerProductos(NULL,NULL,NULL,"ProNombre","ASC",NULL,1,$POST_ProductoTipo,1,NULL,NULL,NULL,NULL,false,NULL,NULL,0,NULL,false,NULL,NULL,false);
$ArrProductos = $ResProducto['Datos'];

?> <table class="EstTablaListado" width="100%">
            <thead class="EstTablaListadoHead">

   
<tr>
  <th width="21" rowspan="2" align="center">#</th>
  <th width="124" rowspan="2" align="center">COD. ORIG</th>
  <th width="405" rowspan="2" align="center">NOMBRE</th>
  <th width="134" rowspan="2" align="center">MARCA</th>
  <th width="134" rowspan="2" align="center">TIPO</th>
  <th width="134" rowspan="2" align="center">REF.</th>
  <th width="134" rowspan="2" align="center">CATEGORIA</th>
  <th width="134" rowspan="2" align="center">FECHA ULTIMA ENTRADA</th>
  <th width="134" rowspan="2" align="center">FECHA ULTIMA SALIDA</th>
  <th width="134" rowspan="2" align="center">U.M.</th>
  <th colspan="9" align="center" >
    
    <?php
  if($POST_FechaInicio == $POST_FechaFin){
?>
    <?php echo $POST_FechaInicio; ?>
    <?php
  }else{
?>
    <?php echo $POST_FechaInicio; ?> AL <?php echo $POST_FechaFin; ?>
    <?php  
  }
?>
    
  </th>
</tr>
<tr>
      <th width="63" align="center" >ENTRADAS CANT.</th>
      <th width="63" align="center" >ENTRADA COSTO UNI.</th>
      <th width="128" align="center" >ENTRADA COSTO TOTAL</th>
                             <th width="60" align="center" >SALIDA CANT.</th>
                             <th width="60" align="center" >SALIDA COSTO UNI.</th>
                             <th width="122" align="center" >SALIDA COSTO TOTAL</th>
                             <th width="130" align="center" >SALDO CANT.</th>
                             <th width="130" align="center" >SALDO COSTO UNI.</th>
                             <th width="130" align="center" >SALDO COSTO TOTAL</th>
              </tr>
  
            </thead>
            <tbody class="EstTablaListadoBody">

<?php
$i = 1;
foreach($ArrProductos as $DatProducto){
?>

	<?php

	//MtdObtenerKardexs($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oUso=NULL,$oMoneda=NULL,$oFechaTipo="AmoFecha",$oAlmacen=NULL,$oSucursal=NULL) 
    $ResKardex = $InsKardex->MtdObtenerKardexs(NULL,NULL,NULL,'AmoFecha ASC,(AmdTiempoCreacion) ASC','',NULL,$DatProducto->ProId,FncCambiaFechaAMysql($InventarioFechaInicio),FncCambiaFechaAMysql($POST_FechaFin),"1",$POST_Moneda,$POST_FechaTipo,$POST_Almacen,$POST_Sucursal);
    $ArrKardexs = $ResKardex['Datos'];
	
    ?>        
    
    <?php
	if(!empty($ArrKardexs)){
	?>
    
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

	
	
	////////////////////////////////
	
	$TotalEntradaFiltro = 0;
	$TotalSalidaFiltro = 0;
	
	
	
	$TotalCostoTotalEntradaFiltro = 0;
	$TotalCostoUnitarioEntradaFiltro = 0;
	
	$TotalCostoTotalSalidaFiltro = 0;
	$TotalCostoUnitarioSalidaFiltro = 0;
	
	$TotalCostoTotalSaldoFiltro = 0;
	$TotalCostoUnitarioSaldoFiltro = 0;
	
	
	////////////////////////////////
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
        //	if( FncConvetirTimestamp($DatKardex->KdxFecha)<FncConvetirTimestamp($_GET['FechaInicio'])){	
        
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
                
                }
                $MostrarSaldoAnterior = false;
                ?>
                
                <?php
                if($DatKardex->TopId == "TOP-10015" and $MostrarInventario){
                    
                    $Saldo = 0;
                    $MostrarInventario = false;			
                                        
                }
                ?>

				<?php
                switch($DatKardex->KdxMovimientoTipo){
                    case 1:
                
                        $TotalMovimientoEntradas++;
                        $TotalMontoMovimientoEntradas+=$DatKardex->KdxCantidad;
                    break;
                    
                    case 2:
                
                        $TotalMovimientoSalidas++;
                        $TotalMontoMovimientoSalidas+=$DatKardex->KdxCantidad;
                    break;
                    
                    default:
                
                    break;
                }
                ?>

	  			<?php
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
					//$CostoTotalSaldo = round($CostoUnitarioAnterior * $Saldo,2);
					$CostoTotalSaldo = ($CostoUnitarioAnterior * $Saldo);	
						

					$TotalEntradaFiltro += $DatKardex->KdxCantidad;
					$TotalCostoTotalEntradaFiltro += $CostoTotalActual;
				}
				?>
                
                
			  	<?php
				if($DatKardex->KdxMovimientoTipo==2){
				
				
                    $TotalSalidaGeneral += $DatKardex->KdxCantidad;
					
					$CostoActual = $CostoUnitarioAnterior;
					$CostoTotalActual = $CostoActual * $DatKardex->KdxCantidad;
		
					$Saldo =  ($TotalEntradaGeneral - $TotalSalidaGeneral);		
					
					//$CostoTotalSaldo = round($Saldo * $CostoUnitarioAnterior,2);	
					$CostoTotalSaldo = ($Saldo * $CostoUnitarioAnterior);	
	
					
					$TotalSalidaFiltro  += $DatKardex->KdxCantidad;
					$TotalCostoTotalSalidaFiltro += $CostoTotalActual;
	
				}
				?>
	
         
			<?php
			}
			?>

            		
            


	<?php	
        $j++;
    }
    ?>
    
    
    <?php
	
	$TotalSaldoFiltro = $TotalEntradaFiltro - $TotalSalidaFiltro;
	$TotalCostoTotalSaldoFiltro = $TotalCostoTotalEntradaFiltro - $TotalCostoTotalSalidaFiltro;
	
	if($TotalEntradaFiltro>0){
		$TotalCostoUnitarioEntradaFiltro = $TotalCostoTotalEntradaFiltro / $TotalEntradaFiltro;	
	}
	
	if($TotalSalidaFiltro>0){
		$TotalCostoUnitarioSalidaFiltro = $TotalCostoTotalSalidaFiltro / $TotalSalidaFiltro;	
	}
	
	if($TotalSaldoFiltro>0){
		$TotalCostoUnitarioSaldoFiltro = $TotalCostoTotalSaldoFiltro / $TotalSaldoFiltro;	
	}
	
	
	?>
<tr>
    <td width="21" align="center"><?php echo $i;?></td>
    <td width="124" align="right">
                             <?php echo $DatProducto->ProCodigoOriginal;?>
    </td>
    <td width="405" align="right"><?php echo $DatProducto->ProNombre;?></td>
                             <td width="134" align="right"><?php echo $DatProducto->VmaNombre;?></td>
                             <td width="134" align="right"><?php echo $DatProducto->RtiNombre;?></td>
                             <td width="134" align="right"><?php echo $DatProducto->ProReferencia;?></td>
                             <td width="134" align="right"><?php echo $DatProducto->PcaNombre;?></td>
                             <td width="134" align="right"><?php echo $DatProducto->ProFechaUltimaEntrada;?></td>
                             <td width="134" align="right"><?php echo $DatProducto->ProFechaUltimaSalida;?></td>
                             <td width="134" align="right"><?php echo $DatProducto->UmeNombre;?></td>
                             <td width="63" align="right" bgcolor="#99CCCC">
							 <?php echo number_format($TotalEntradaFiltro,2);?>
                             </td>
                             <td width="63" align="right" bgcolor="#99CCCC">
                              <?php echo number_format($TotalCostoUnitarioEntradaFiltro,2);?>
                             </td>
                             <td width="128" align="right" bgcolor="#99CCCC">
                              <?php echo number_format($TotalCostoTotalEntradaFiltro,2);?>
                             </td>
                             <td width="60" align="right" bgcolor="#FFCC66"><?php echo number_format($TotalSalidaFiltro,2);?></td>
                             <td width="60" align="right" bgcolor="#FFCC66"><?php echo number_format($TotalCostoUnitarioSalidaFiltro,2);?></td>
                             <td width="122" align="right" bgcolor="#FFCC66"><?php echo number_format($TotalCostoTotalSalidaFiltro,2);?></td>
                             <td width="130" align="right" bgcolor="#66CC99">
                             
                             <?php //$Saldo = $TotalEntradaGeneral - $TotalSalidaGeneral;?>
                             
							 <?php echo number_format($TotalSaldoFiltro,2);?>
                             
                             </td>
                             <td width="130" align="right" bgcolor="#66CC99"><?php echo number_format($TotalCostoUnitarioSaldoFiltro,2);?></td>
                             <td width="130" align="right" bgcolor="#66CC99"><?php echo number_format($TotalCostoTotalSaldoFiltro,2);?></td>
              </tr>
    
    <?php	
		$i++;
	}
	?>



<?php	
}
?>
 
              </table>
 
</body>
</html>


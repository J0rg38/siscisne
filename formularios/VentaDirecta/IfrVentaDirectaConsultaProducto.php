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
require_once($InsProyecto->MtdRutConfiguraciones().'CnfFormularioNota.php');
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
	header("Content-Disposition:  filename=\"CONSULTA_PRODUCTO_VENTA_DIRECTA_".date('d-m-Y').".xls\";");
}
?>
<html>
<head>

<?php
if($_GET['P']<>2){
?>
<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssReporte.css">
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.7.2.min.js"></script> 

<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutFunciones();?>FncGeneral.js"></script>

<script  src="<?php echo $InsProyecto->MtdRutLibrerias();?>tbox/thickbox.js"></script>
<script type="text/javascript" src="js/JsVentaDirectaSeguimiento.js"></script> 
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

$POST_finicio = isset($_POST['CmpFechaInicio'])?$_POST['CmpFechaInicio']:"01/".date("m/Y");
$POST_ffin = isset($_POST['CmpFechaFin'])?$_POST['CmpFechaFin']:date("d/m/Y");


$POST_CodigoOriginal = $_POST['CmpCodigoOriginal'];

$POST_ord = isset($_POST['CmpOrden'])?$_POST['CmpOrden']:"VdiFecha";
$POST_sen = isset($_POST['CmpSentido'])?$_POST['CmpSentido']:"DESC";

require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirecta.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirectaDetalle.php');

require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompra.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaConcretada.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoEntrada.php');

require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVentaConcretada.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaConcretadaDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoEntradaDetalle.php');
require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompraDetalle.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsFactura.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFacturaDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoleta.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoletaDetalle.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCodigoReemplazo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoReemplazo.php');


//MtdSeguimientoVentaDirectaDetalles($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'VddId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVentaDirecta=NULL,$oEstado=NULL,$oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oMoneda=NULL,$oCliente=NULL,$oConOrdenCompraReferencia=NULL)
$InsVentaDirectaDetalle = new ClsVentaDirectaDetalle();
$ResVentaDirectaDetalle = $InsVentaDirectaDetalle->MtdSeguimientoVentaDirectaDetalles("ProCodigoOriginal","esigual",$POST_CodigoOriginal,$POST_ord,$POST_sen,NULL,NULL,NULL,NULL,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),NULL,NULL,NULL);
$ArrVentaDirectaDetalles = $ResVentaDirectaDetalle['Datos'];

$InsProductoReemplazo = new ClsProductoReemplazo();
$ResProductoReemplazo = $InsProductoReemplazo->MtdObtenerProductoReemplazos("PreCodigo1,PreCodigo2,PreCodigo3,PreCodigo4,PreCodigo5,PreCodigo6,PreCodigo7,PreCodigo8,PreCodigo9,PreCodigo10,PreCodigo11,PreCodigo12","esigual",$POST_CodigoOriginal ,"PreId","ASC",NULL,1);
$ArrProductoReemplazos = $ResProductoReemplazo['Datos'];

?>

<?php if($_GET['P']==1){?>
<table cellpadding="0" cellspacing="0" width="100%" border="0">
<tr>
  <td colspan="3" align="left"><span class="EstReporteCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
</tr>
<tr>
  <td width="23%" align="left" valign="top"><img src="../../imagenes/logos/logo_impresion.png" width="150" alt="Logo" title="Logo" border="0" />
  </td>
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">SEGUIMIENTO DE ORDENES DE VENTA
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
        
        <table class="EstTablaReporte" width="100%" border="0" cellpadding="2" cellspacing="2">
        <thead class="EstTablaReporteHead">
        <tr>
          <th width="2%" rowspan="2">#</th>
          <th width="4%" rowspan="2">ORD. VEN.</th>
          <th width="5%" rowspan="2">FECHA</th>
          <th width="4%" rowspan="2">COD.</th>
          <th width="7%" rowspan="2">REPUESTO</th>
          <th width="5%" rowspan="2">CANT.</th>
          <th width="7%" rowspan="2">CLIENTE</th>
          <th width="4%" rowspan="2">O.C. REF.</th>
          <th width="5%" rowspan="2">O.C. REF. FECHA</th>
          <th colspan="2">ORD. COMPRA</th>
          <th colspan="2">DESPACHO</th>
          <th colspan="2">FACTURA GM</th>
          <th colspan="2">FICHA SALIDA </th>
          <th colspan="2">COMPROB. </th>
          <th>&nbsp;</th>
        </tr>
        <tr>
          <th width="4%">NUM.</th>
          <th width="7%">FECHA</th>
          <th width="5%">CANT.</th>
          <th width="7%">FECHA</th>
          <th width="4%">NUM.</th>
          <th width="7%">FECHA</th>
          <th width="5%">FICHA.</th>
          <th width="5%">FECHA</th>
          <th width="4%">NUM.</th>
          <th width="8%">FECHA</th>
          <th width="1%">&nbsp;</th>
          </tr>
        </thead>
        <tbody class="EstTablaReporteBody">
        
        <?php
		
		$c=1;
		if(!empty($ArrVentaDirectaDetalles)){
	        foreach($ArrVentaDirectaDetalles as $DatVentaDirectaDetalle){
        ?>
        <tr class="EstTablaListado"  >
          <td align="right" valign="middle"   ><?php echo $c;?></td>
          <td align="right" valign="middle"   >
		  
			<a target="_blank" href="../../principal.php?Mod=VentaDirecta&Form=Ver&Id=<?php echo $DatVentaDirectaDetalle->VdiId;?>" >
			<?php echo $DatVentaDirectaDetalle->VdiId;  ?>
            </a>          
				</td>
              <td align="right" ><?php echo ($DatVentaDirectaDetalle->VdiFecha);?></td>
              <td align="right" valign="middle"   ><?php echo $DatVentaDirectaDetalle->ProCodigoOriginal;  ?></td>
              <td align="right" valign="middle"   ><?php echo $DatVentaDirectaDetalle->ProNombre;  ?></td>
              <td align="right" valign="middle"   ><?php echo number_format($DatVentaDirectaDetalle->VddCantidad,2);  ?></td>
              <td align="right" ><?php echo $DatVentaDirectaDetalle->CliNombre;  ?>
              <?php echo $DatVentaDirectaDetalle->CliApellidoPaterno;  ?>
              
              <?php echo $DatVentaDirectaDetalle->CliApellidoMaterno;  ?> </td>
              <td align="right" >&nbsp;<?php echo $DatVentaDirectaDetalle->VdiOrdenCompraNumero;  ?></td>
              <td align="right" >&nbsp;<?php echo $DatVentaDirectaDetalle->VdiOrdenCompraFecha;  ?></td>
              <td align="right" >
			  
              
              <?php
$InsPedidoCompraDetalle = new ClsPedidoCompraDetalle();
///MtdObtenerPedidoCompraDetalles($oCampo=NULL,$oFiltro=NULL,$oOrden = 'PcdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPedidoCompra=NULL,$oEstado=NULL,$oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oOrdenCompra=NULL,$oCliente=NULL,$oConOrdenCompra=NULL,$oVentaDirectaDetalleId=NULL,$oPedidoCompraEstado=NULL)
$ResPedidoCompraDetalle = $InsPedidoCompraDetalle->MtdObtenerPedidoCompraDetalles(NULL,NULL,'PcdId','Desc',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,$DatVentaDirectaDetalle->VddId,3);
$ArrPedidoCompraDetalles = $ResPedidoCompraDetalle['Datos'];
//MtdObtenerVentaConcretadaDetalles($oCampo=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVentaConcretada=NULL,$oEstado=NULL,$oProducto=NULL,$oVentaDirectaDetalleId=NULL)
?>
	  <?php
if(!empty($ArrPedidoCompraDetalles)){
	foreach($ArrPedidoCompraDetalles as $DatPedidoCompraDetalle){
?>
	  <a href="javascript:FncOrdenCompraVistaPreliminar('<?php echo $DatPedidoCompraDetalle->OcoId;?>')"><?php echo $DatPedidoCompraDetalle->OcoId;?></a>
	  <?php	
	}	
}
?>

</td>
              <td align="right" >
			  
			  
			  <?php
$InsPedidoCompraDetalle = new ClsPedidoCompraDetalle();
$ResPedidoCompraDetalle = $InsPedidoCompraDetalle->MtdObtenerPedidoCompraDetalles(NULL,NULL,'PcdId','Desc',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,$DatVentaDirectaDetalle->VddId,3);
$ArrPedidoCompraDetalles = $ResPedidoCompraDetalle['Datos'];
?>
	  <?php
if(!empty($ArrPedidoCompraDetalles)){
	foreach($ArrPedidoCompraDetalles as $DatPedidoCompraDetalle){
?>
	  <?php echo $DatPedidoCompraDetalle->OcoFecha;?>
	  <?php	
	}	
}
?></td>
              <td align="right" ><?php echo number_format($DatVentaDirectaDetalle->VddCantidadPorLlegar,2);  ?></td>
              <td align="right" ><?php echo $DatVentaDirectaDetalle->VddFechaPorLlegar;  ?></td>
              <td align="right" >&nbsp;

<?php
$InsAlmacenMovimientoEntradaDetalle = new ClsAlmacenMovimientoEntradaDetalle();
											//$InsAlmacenMovimientoEntradaDetalle->MtdObtenerAlmacenMovimientoEntradaDetalles($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oAlmacenMovimientoEntrada=NULL,$oEstado=NULL,$oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oCliente=NULL,$oConOrdenCompra=0,$oOrdenCompra=NULL,$oPedidoCompraDetalleId=NULL);
$ResAlmacenMovimientoEntradaDetalle  = $InsAlmacenMovimientoEntradaDetalle->MtdObtenerAlmacenMovimientoEntradaDetalles(NULL,NULL,NULL,'AmdId','Desc',1,"1",NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,$DatVentaDirectaDetalle->VddId);
$ArrAlmacenMovimientoEntradaDetalles = $ResAlmacenMovimientoEntradaDetalle['Datos'];


?>

<?php
if(!empty($ArrAlmacenMovimientoEntradaDetalles)){
	foreach($ArrAlmacenMovimientoEntradaDetalles as $DatAlmacenMovimientoEntradaDetalle){
?>

<a href="javascript:FncAlmacenMovimientoEntradaVistaPreliminar('<?php echo $DatAlmacenMovimientoEntradaDetalle->AmoId;?>')">
<?php echo $DatAlmacenMovimientoEntradaDetalle->AmoComprobanteNumero;?>
</a>
	  <?php
	}
}
?>

 
              </td>
              <td align="right" >
              
              <?php
$InsAlmacenMovimientoEntradaDetalle = new ClsAlmacenMovimientoEntradaDetalle();
											//$InsAlmacenMovimientoEntradaDetalle->MtdObtenerAlmacenMovimientoEntradaDetalles($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oAlmacenMovimientoEntrada=NULL,$oEstado=NULL,$oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oCliente=NULL,$oConOrdenCompra=0,$oOrdenCompra=NULL,$oPedidoCompraDetalleId=NULL);
$ResAlmacenMovimientoEntradaDetalle  = $InsAlmacenMovimientoEntradaDetalle->MtdObtenerAlmacenMovimientoEntradaDetalles(NULL,NULL,NULL,'AmdId','Desc',1,"1",NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,$DatVentaDirectaDetalle->VddId);
$ArrAlmacenMovimientoEntradaDetalles = $ResAlmacenMovimientoEntradaDetalle['Datos'];

?>

<?php
if(!empty($ArrAlmacenMovimientoEntradaDetalles)){
	foreach($ArrAlmacenMovimientoEntradaDetalles as $DatAlmacenMovimientoEntradaDetalle){
?>
	<?php echo $DatAlmacenMovimientoEntradaDetalle->AmoComprobanteFecha;?>
<?php
	}
}
?>

</td>
              <td align="right" >

<?php
$VentaConcretadaId = "";
$VentaConcretadaFecha = "";
$VentaConcretadaRevisar = false;
?>

<?php
$InsVentaConcretadaDetalle = new ClsVentaConcretadaDetalle();
$ResVentaConcretadaDetalle = $InsVentaConcretadaDetalle->MtdObtenerVentaConcretadaDetalles(NULL,NULL,'AmdId','Desc',NULL,NULL,NULL,NULL,$DatVentaDirectaDetalle->VddId,3);
$ArrVentaConcretadaDetalles = $ResVentaConcretadaDetalle['Datos'];

?>
<?php
if(!empty($ArrVentaConcretadaDetalles)){
	foreach($ArrVentaConcretadaDetalles as $DatVentaConcretadaDetalle){
?>

	<?php
	$VentaConcretadaId = $DatVentaConcretadaDetalle->AmoId;
	$VentaConcretadaFecha = $DatVentaConcretadaDetalle->AmoFecha;
	?>

<?php
	}
}
?>

	<a href="javascript:FncVentaConcretadaVistaPreliminar('<?php echo $VentaConcretadaId;?>')">
	<?php echo $VentaConcretadaId;?> 
	</a>
    
    <?php
	if($VentaConcretadaRevisar){
	?>
	    <span title="Revisar">[R]</span>    
    <?php	
	}
	?>
    
    
              </td>
              <td align="right" ><?php echo $VentaConcretadaFecha;?></td>
              <td align="right" ><?php
$FacturaId = "";
$FacturaTalonarioId = "";
$FacturaFecha = "";
$FacturaTalonarioNumero = "";
$FacturaRevisar = false;
?>

    
<?php
$InsFacturaDetalle = new ClsFacturaDetalle();
$ResFacturaDetalle = $InsFacturaDetalle->MtdObtenerFacturaDetalles(NULL,NULL,'FdeId','Desc',NULL,NULL,NULL,NULL,5,$DatVentaDirectaDetalle->VddId);
$ArrFacturaDetalles = $ResFacturaDetalle['Datos'];
?>

<?php
if(!empty($ArrFacturaDetalles)){
	foreach($ArrFacturaDetalles as $DatFacturaDetalle){
?>
		<?php
		$FacturaId = $DatFacturaDetalle->FacId;
		$FacturaTalonarioId = $DatFacturaDetalle->FtaId;
		$FacturaFecha = $DatFacturaDetalle->FacFechaEmision;
		$FacturaTalonarioNumero = $DatFacturaDetalle->FtaNumero;
		?>
        
                        
<a href="javascript:FncFacturaVistaPreliminar('<?php echo $FacturaId;?>','<?php echo $FacturaTalonarioId;?>')">
<?php echo $FacturaTalonarioNumero;?> - <?php echo $FacturaId;?> 
</a>


        
<?php
	}
}
?>




<?php
$BoletaId = "";
$BoletaTalonarioId = "";
$BoletaFecha = "";
$BoletaTalonarioNumero = "";
$BoletaRevisar = false;
?>


<?php
$InsBoletaDetalle = new ClsBoletaDetalle();
$ResBoletaDetalle = $InsBoletaDetalle->MtdObtenerBoletaDetalles(NULL,NULL,'BdeId','Desc',NULL,NULL,NULL,NULL,5,$DatVentaDirectaDetalle->VddId);
$ArrBoletaDetalles = $ResBoletaDetalle['Datos'];
?>

<?php
if(!empty($ArrBoletaDetalles)){
	foreach($ArrBoletaDetalles as $DatBoletaDetalle){
?>
		<?php
		$BoletaId = $DatBoletaDetalle->BolId;
		$BoletaTalonarioId = $DatBoletaDetalle->BtaId;
		$BoletaFecha = $DatBoletaDetalle->BolFechaEmision;
		$BoletaTalonarioNumero = $DatBoletaDetalle->BtaNumero;
		?>
        
        
        <a href="javascript:FncBoletaVistaPreliminar('<?php echo $BoletaId;?>','<?php echo $BoletaTalonarioId;?>')">
			<?php echo $BoletaTalonarioNumero;?> - <?php echo $BoletaId;?>
            
          
		</a>

<?php
	}
}
?>

		
</td>
              <td align="right" >
              
              
              
              <?php echo $FacturaFecha;?>
    
    <?php echo $BoletaFecha;?>
    </td>
              <td align="right" >&nbsp;</td>
          </tr>
        <?php	
		$c++;
			}
			
        }else{
		?>
			<tr>
                <td align="right">&nbsp;</td>
                <td colspan="18" align="left">
                
                <?php
				if(!empty($ArrProductoReemplazos)){
					
					$reemplazo = "puede intentar con los siguientes codigos de reemplazo: ";
					foreach($ArrProductoReemplazos as $DatProductoReemplazo){
						
						$reemplazo .= " ".$DatProductoReemplazo->PreCodigo1;
						$reemplazo .= " ".$DatProductoReemplazo->PreCodigo2;
						$reemplazo .= " ".$DatProductoReemplazo->PreCodigo3;
						$reemplazo .= " ".$DatProductoReemplazo->PreCodigo4;
						$reemplazo .= " ".$DatProductoReemplazo->PreCodigo5;
						$reemplazo .= " ".$DatProductoReemplazo->PreCodigo6;
						$reemplazo .= " ".$DatProductoReemplazo->PreCodigo7;
						$reemplazo .= " ".$DatProductoReemplazo->PreCodigo8;
						$reemplazo .= " ".$DatProductoReemplazo->PreCodigo9;
						$reemplazo .= " ".$DatProductoReemplazo->PreCodigo10;
						
					}					
					
				}

				?>
                
                No se encontraron resultados <?php echo $reemplazo;?> 
                </td>
                <td align="left"></td>
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
            <td colspan="2" align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
          </tr>
		</tbody>
		<tfoot class="EstTablaReporteFoot">
		</tfoot>
		</table>





</body>
</html>
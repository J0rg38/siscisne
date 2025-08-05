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
	header("Content-Disposition:  filename=\"REPORTE_VENTA_DIRECTA_".date('d-m-Y').".xls\";");
}
?>
<html>
<head>

<?php
if($_GET['P']<>2){
?>
<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssReporte.css">
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.7.2.min.js"></script> 

<script type="text/javascript" src="js/JsReporteVentaDirectaResumen.js"></script>

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

$POST_ClienteId = $_POST['CmpClienteId'];
$POST_ClienteNombre = $_POST['CmpClienteNombre'];

$POST_ord = isset($_POST['CmpOrden'])?$_POST['CmpOrden']:"VdiId";
$POST_sen = isset($_POST['CmpSentido'])?$_POST['CmpSentido']:"DESC";

$POST_Moneda = ($_POST['CmpMoneda']);

$POST_ConOrdenCompra = ($_POST['CmpConOrdenCompra']);


require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompra.php');
require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompraDetalle.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirecta.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirectaDetalle.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVentaConcretadaDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFacturaDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoletaDetalle.php');

$InsVentaDirectaDetalle = new ClsVentaDirectaDetalle();
$InsCliente = new ClsCliente();
$InsMoneda = new ClsMoneda();


if(empty($POST_ClienteId) and !empty($POST_ClienteNombre)){
	
	$ResCliente = $InsCliente->MtdObtenerClientes("CliNombre,CliApellidoPaterno,CliApellidoMaterno","contiene",$POST_ClienteNombre,"CliId","ASC",1,"1",NULL,NULL);
	$ArrClientes = $ResCliente['Datos'];
	
	if(!empty($ArrClientes)){
		foreach($ArrClientes as $DatCliente){
			$POST_ClienteId = $DatCliente->CliId;
		}
	}

}


if(empty($POST_ClienteId) and !empty($POST_ClienteNumeroDocumento)){
	
	$ResCliente = $InsCliente->MtdObtenerClientes("CliNumeroDocumento","contiene",$POST_ClienteNumeroDocumento,"CliId","ASC",1,"1",NULL,NULL);
	$ArrClientes = $ResCliente['Datos'];
	
	if(!empty($ArrClientes)){
		foreach($ArrClientes as $DatCliente){
			$POST_ClienteId = $DatCliente->CliId;
		}
	}

}

$ResVentaDirectaDetalle = $InsVentaDirectaDetalle->MtdObtenerVentaDirectaDetalles(NULL,NULL,NULL,'VddId','Desc',NULL,NULL,NULL,NULL,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),$POST_Moneda,$POST_ClienteId,$POST_ConOrdenCompra);
$ArrVentaDirectaDetalles = $ResVentaDirectaDetalle['Datos'];
//$ResVentaDirecta = $InsVentaDirecta->MtdObtenerVentaDirectas(NULL,NULL,NULL,$POST_ord,$POST_sen,NULL,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),3,0,NULL,NULL,$POST_Moneda,$POST_ClienteId,$POST_ConOrdenCompra);
//$ArrVentaDirectas = $ResVentaDirecta['Datos'];
$POST_Moneda = (empty($POST_Moneda)?$EmpresaMonedaId:$POST_Moneda);
//deb($POST_Moneda);
$InsMoneda = new ClsMoneda();
$InsMoneda->MonId = $POST_Moneda;
$InsMoneda->MtdObtenerMoneda();

?>

<?php if($_GET['P']==1){?>
<table cellpadding="0" cellspacing="0" width="100%" border="0">
<tr>
  <td colspan="3" align="left"><span class="EstReporteCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
</tr>
<tr>
  <td width="23%" align="left" valign="top"><img src="../../imagenes/logos/logo_reporte.png" width="150"  />
  </td>
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">RESUMEN DE ORDENES DE VENTA C/ DETALLE DEL
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

<style type="text/css">
tbody.EstTablaReporteBody td{
white-space: nowrap;
}
</style>
<?php }?>
        
        
      
        <table class="EstTablaReporte" width="100%" border="0" cellpadding="2" cellspacing="2">
        <thead class="EstTablaReporteHead">
        <tr>
          <th width="1%" rowspan="2">#</th>
          <th width="3%" rowspan="2">ORD. VEN.</th>
          <th width="6%" rowspan="2">COD. ORIGINAL</th>
          <th width="5%" rowspan="2">NOMBRE</th>
          <th colspan="6" align="center">ESTADO GENERAL</th>
          <th>DATOS DEL CLIENTE</th>
          <th colspan="2">ORDEN DE COMPRA</th>
          <th colspan="3" align="center">DESPACHO</th>
          <th colspan="3" align="center">ALMACEN</th>
          <th colspan="3" align="center">FACTURACION</th>
          </tr>
        <tr>
          <th width="3%">O.C. REF.</th>
          <th width="4%">O.C. REF / FECHA</th>
          <th width="7%" align="center">ESTADO ATENCION</th>
          <th width="5%" align="center">MONEDA</th>
          <th width="3%" align="center">CANT.</th>
          <th width="5%" align="center">IMPORTE</th>
          <th width="5%">CLIENTE</th>
          <th width="5%">ORD. COMPRA</th>
          <th width="5%" align="center">FECHA </th>
          <th width="3%" align="center">CANT.</th>
          <th width="4%" align="center">FECHA</th>
          <th width="5%" align="center">ESTADO LLEGADA</th>
          <th width="4%" align="center">DOC. SALIDA</th>
          <th width="7%" align="center">FECHA</th>
          <th width="3%" align="center">CANT.</th>
          <th width="6%" align="center">COMPROB. EMITIDO</th>
          <th width="4%" align="center">FECHA</th>
          <th width="7%" align="center">TOTAL</th>
          </tr>
        </thead>
        <tbody class="EstTablaReporteBody">
        
        
        <?php
		$VentaDirectaSumaTotal = 0;
		$FacturaSumaTotal = 0;
		$c=1;
		$fondo = "";
		//$fondo = "#CCCCCC";
		$VentaDirectaIdAnterior = "";
		
        foreach($ArrVentaDirectaDetalles as $DatVentaDirectaDetalle){
			
			//if($DatVentaDirectaDetalle->VdiId == $VentaDirectaIdAnterior){
//				$aux = 1;
//			}
//			
//			$VentaDirectaIdAnterior = $DatVentaDirectaDetalle->VdiId;
//			
//			if($aux == 1){
//				$fondo = "#FFFFFF";	
//			}else if($aux == 2){
//				$fondo = "#CCCCCC";
//			}
        ?>
        
       
        
                  <tr id="Fila_<?php echo $c;?>" >
                <td bgcolor="<?php echo $fondo;?>" align="right" valign="middle"   ><?php echo $c;?></td>
                <td bgcolor="<?php echo $fondo;?>"  align="right" valign="top"   ><a target="_blank" href="../../principal.php?Mod=VentaDirecta&Form=Ver&Id=<?php echo ($DatVentaDirectaDetalle->VdiId);?>"><?php echo ($DatVentaDirectaDetalle->VdiId);?></a></td>
                <td bgcolor="<?php echo $fondo;?>"  align="right" valign="top"   ><?php echo ($DatVentaDirectaDetalle->ProCodigoOriginal);?></td>
                <td bgcolor="<?php echo $fondo;?>"  align="right" valign="top"   >
				
                <?php echo ($DatVentaDirectaDetalle->ProNombre);?></td>
                <td bgcolor="<?php echo $fondo;?>"  align="right" valign="top"   >&nbsp; 
				
				
				
				<a target="_blank" href="../../principal.php?Mod=VentaDirecta&Form=VerEstado&Id=<?php echo ($DatVentaDirectaDetalle->VdiId);?>">
				<?php echo ($DatVentaDirectaDetalle->VdiOrdenCompraNumero);?>
                </a>
                
                </td>
                <td bgcolor="<?php echo $fondo;?>"  align="right" valign="top"   >&nbsp; <?php echo ($DatVentaDirectaDetalle->VdiOrdenCompraFecha);?></td>
                <td bgcolor="<?php echo $fondo;?>" align="right" valign="top"  >
				

           <?php
switch($DatVentaDirectaDetalle->VddEstado){
	case 1:
?>
CONSIDERAR
<?php
	break;
	
	case 2:
?>
<span style="color:#F00">  ANULADO</span>
  <?php
	break;


	case 3:
?>
 <span style="color:#F00"> INTERNO</span>
  <?php
	break;
	
	
	case 4:
?>
  <span style="color:#F00">DEVOLUCION</span>
  <?php
	break;

	case 5:
?>
 <span style="color:#F00"> DAÑADO</span>
  <?php
	break;
		
	default:
?>
  -
  <?php
	break;
}
?>



  

			</td>
                <td bgcolor="<?php echo $fondo;?>" align="right" valign="top"  ><?php echo ($DatVentaDirectaDetalle->MonNombre);?></td>
                <td bgcolor="<?php echo $fondo;?>" align="right" valign="top"  ><?php echo number_format($DatVentaDirectaDetalle->VddCantidad,2);?></td>
                <td bgcolor="<?php echo $fondo;?>" align="right" valign="top"  >


				<?php $DatVentaDirectaDetalle->VddImporte = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$DatVentaDirectaDetalle->VddImporte:($DatVentaDirectaDetalle->VddImporte/$DatVentaDirectaDetalle->VdiTipoCambio));?>
                 


		<?php
		if($DatVentaDirectaDetalle->VdiIncluyeImpuesto == 2){
			$DatVentaDirectaDetalle->VddImporte = $DatVentaDirectaDetalle->VddImporte * 1.18;
		}
		

?>

<?PHP

//deb($DatVentaDirectaDetalle->VddEstado);
switch($DatVentaDirectaDetalle->VddEstado){
	case 1://CONSIDERAR
		$VentaDirectaSumaTotal += $DatVentaDirectaDetalle->VddImporte;
	break;
	
	case 2://ANULADO

	break;


	case 3:// INTERNO

	break;
	
	
	case 4://DEVOLUCION

	break;

	case 5://DAÑADO

		
	default:

	break;
	
}
		
		
		?>
		
		<?php echo number_format($DatVentaDirectaDetalle->VddImporte,2);?>
        
                  </td>
                <td bgcolor="<?php echo $fondo;?>"  align="right" valign="top"   >
                
               
               
                <?php echo ($DatVentaDirectaDetalle->CliNombre);?>
                <?php echo ($DatVentaDirectaDetalle->CliApellidoPaterno);?>
                <?php echo ($DatVentaDirectaDetalle->CliApellidoMaterno);?>
               
                </td>
<td bgcolor="<?php echo $fondo;?>"  align="right" valign="top"   >
  
  
  
<?php
$OrdenCompraId = "";

//$InsPedidoCompra = new ClsPedidoCompra();
//$ResPedidoCompra = $InsPedidoCompra->MtdObtenerPedidoCompras(NULL,NULL,NULL,"PcoFecha","ASC",NULL,NULL,NULL,NULL,NULL,0,$DatVentaDirectaDetalle->VdiId);
//$ArrPedidoCompras = $ResPedidoCompra['Datos'];

$InsPedidoCompraDetalle = new ClsPedidoCompraDetalle();
// MtdObtenerPedidoCompraDetalles($oCampo=NULL,$oFiltro=NULL,$oOrden = 'PcdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPedidoCompra=NULL,$oEstado=NULL,$oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oOrdenCompra=NULL,$oCliente=NULL,$oConOrdenCompra=NULL,$oVentaDirectaDetalleId=NULL,$oPedidoCompraEstado=NULL,$oFecha="PcoFecha",$oValidarRecibido=false,$oConFichaIngreso=false,$oOrdenCompraEstado=NULL)

$ResPedidoCompraDetalle = $InsPedidoCompraDetalle->MtdObtenerPedidoCompraDetalles(NULL,NULL,"PcdId","ASC",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,$DatVentaDirectaDetalle->VddId,NULL,"PcoFecha",false,false,NULL);
$ArrPedidoCompraDetalles = $ResPedidoCompraDetalle['Datos'];


?>
  
<?php
if(!empty($ArrPedidoCompraDetalles)){
	foreach($ArrPedidoCompraDetalles as $DatPedidoCompraDetalle){
?>
 <!-- <a target="_blank" href="../../principal.php?Mod=OrdenCompra&Form=Ver&Id=<?php echo ($DatPedidoCompra->OcoId);?>">-->
    <?php 
	
	echo $OrdenCompraId = $DatPedidoCompraDetalle->OcoId;
	
	//echo $DatPedidoCompra->OcoId?><br>
   <!-- </a>-->
  <?php
	}
}
?>
  
  &nbsp;
  
</td>
<td bgcolor="<?php echo $fondo;?>" align="center" valign="top"  >
  
  <?php
$InsPedidoCompra = new ClsPedidoCompra();
$ResPedidoCompra = $InsPedidoCompra->MtdObtenerPedidoCompras(NULL,NULL,NULL,"PcoFecha","ASC",NULL,NULL,NULL,NULL,NULL,0,$DatVentaDirectaDetalle->VdiId);
$ArrPedidoCompras = $ResPedidoCompra['Datos'];
?>
  
  <?php
if(!empty($ArrPedidoCompras)){
	foreach($ArrPedidoCompras as $DatPedidoCompra){
?>
  
  <?php echo $DatPedidoCompra->OcoFecha?><br>
  
  <?php
	}
}
?>
  
  
  &nbsp;
</td>
<td bgcolor="#66CC99" align="right" valign="top"  >


<?php
if(!empty($DatVentaDirectaDetalle->VddCantidadPorLlegar)){
?>

<?php echo number_format($DatVentaDirectaDetalle->VddCantidadPorLlegar,2);?>

<?php	
}else{
?>
&nbsp;
<?php	
}
?>



</td>
<td bgcolor="#66CC99" align="right" valign="top"  >
<?php echo ($DatVentaDirectaDetalle->VddFechaPorLlegar);?>

&nbsp;</td>
<td bgcolor="#66CC99" align="right" valign="top"  >

<?php //deb($DatVentaDirectaDetalle->AmdEstado);?>

<?php
			switch($DatVentaDirectaDetalle->AmdEstado){
				case 1:
			?>
            	No Llego
            <?php	
				break;
				
				case 2:
			?>
            Da&ntilde;ado
            <?php	
				break;
				
				case 3:
			?>
            Conforme
            <?php	
				break;
			}
			?>
            
                
            
            
            
</td>
<td bgcolor="#FFCC99" align="right" valign="top"  >
  
  <?php
$VentaConcretadaId = "";
$VentaConcretadaFecha = "";
$VentaConcretadaRevisar = false;
$VentaConcretadaDetalleCantidad = 0;
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
  <?php echo $VentaConcretadaId = $DatVentaConcretadaDetalle->VcoId;?><br>
  <?php
	}
}
?>
  &nbsp; </td>
<td bgcolor="#FFCC99" align="right" valign="top"  ><?php
$VentaConcretadaId = "";
$VentaConcretadaFecha = "";
$VentaConcretadaRevisar = false;
$VentaConcretadaDetalleCantidad = 0;
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
	<?php echo $VentaConcretadaFecha = $DatVentaConcretadaDetalle->VcoFecha;?> <br>
  <?php
	}
}
?>

&nbsp;</td>
<td bgcolor="#FFCC99" align="right" valign="top"  >


<?php
$VentaConcretadaId = "";
$VentaConcretadaFecha = "";
$VentaConcretadaRevisar = false;
$VentaConcretadaDetalleCantidad = 0;
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

	<?php  $VentaConcretadaDetalleCantidad = $DatVentaConcretadaDetalle->VcdCantidad;?> 
    <?php echo number_format($VentaConcretadaDetalleCantidad,2);?>
    <br>
    
  <?php
	}
}
?>



</td>
<td bgcolor="#88C5E1" align="right" valign="top"  >


<?php
$FacturaId = "";
$FacturaTalonarioId = "";
$FacturaFecha = "";
$FacturaTalonarioNumero = "";
$FacturaRevisar = false;
$FacturaDetalleImporte = 0;
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
		$FacturaTalonarioNumero = $DatFacturaDetalle->FtaNumero;
		?>
        
		<?php echo $FacturaTalonarioNumero;?> - <?php echo $FacturaId;?><br> 
   
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
$BoletaImporte = 0;
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
		$BoletaTalonarioNumero = $DatBoletaDetalle->BtaNumero;
		?>
        
		<?php echo $BoletaTalonarioNumero;?> - <?php echo $BoletaId;?><br>

<?php
	}
}
?>


&nbsp;
</td>
<td bgcolor="#88C5E1" align="right" valign="top"  >




<?php
$FacturaId = "";
$FacturaTalonarioId = "";
$FacturaFecha = "";
$FacturaTalonarioNumero = "";
$FacturaRevisar = false;
$FacturaDetalleImporte = 0;
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

		<?php echo $FacturaFecha = $DatFacturaDetalle->FacFechaEmision;?><br>
   
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
$BoletaImporte = 0;
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
		<?php echo $BoletaFecha = $DatBoletaDetalle->BolFechaEmision;?><br>
<?php
	}
}
?>


&nbsp;</td>
<td bgcolor="#88C5E1" align="right" valign="top"  >
  




<?php
$FacturaId = "";
$FacturaTalonarioId = "";
$FacturaFecha = "";
$FacturaTalonarioNumero = "";
$FacturaRevisar = false;
$FacturaDetalleImporte = 0;
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
		
		$DatFacturaDetalle->FdeImporte = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$DatFacturaDetalle->FdeImporte:($DatFacturaDetalle->FdeImporte/$DatFacturaDetalle->FacTipoCambio));
		
		if($DatFacturaDetalle->FacIncluyeImpuesto == 2){
			$DatFacturaDetalle->FdeImporte = $DatFacturaDetalle->FdeImporte * 1.18;
		}
		?>
        
		<?php
		echo number_format($DatFacturaDetalle->FdeImporte,2);
		?>
        
        <?php
		$FacturaSumaTotal += $DatFacturaDetalle->FdeImporte;
		?>
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
$BoletaImporte = 0;
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
		$DatBoletaDetalle->BdeImporte = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$DatBoletaDetalle->BdeImporte:($DatBoletaDetalle->BdeImporte/$DatBoletaDetalle->BolTipoCambio));
		
		?>
        
        <?php
		echo number_format($DatBoletaDetalle->BdeImporte,2);
		?>
        
        <?php
		$FacturaSumaTotal += $DatBoletaDetalle->BdeImporte;
		?>
<?php
	}
}
?>

  &nbsp;
  
</td>
</tr>
		<?php	
			
		?>
  
      
              
        <?php
		 $c++;
        }
        ?>
        
          <tr>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td colspan="4" align="right">SUMA TOTAL:</td>
            <td align="right">&nbsp;</td>
            <td align="right">
			
			<?php echo $InsMoneda->MonSimbolo;?> <?php echo number_format($VentaDirectaSumaTotal,2);?></td>
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
            <td align="right"><?php echo $InsMoneda->MonSimbolo;?> <?php echo number_format($FacturaSumaTotal,2);?></td>
          </tr>
          
          
		</tbody>
		<tfoot class="EstTablaReporteFoot">
		</tfoot>
		</table>





</body>
</html>
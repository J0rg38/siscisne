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
	header("Content-Disposition:  filename=\"REPORTE_PROVEEDOR_LINEA_CREDITO_".date('d-m-Y').".xls\";");
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

$POST_ProveedorId = $_POST['CmpProveedorId'];
$POST_ProveedorNombre = $_POST['CmpProveedorNombre'];

$POST_finicio = isset($_POST['CmpFechaInicio'])?$_POST['CmpFechaInicio']:"01/01/".date("Y");
$POST_ffin = isset($_POST['CmpFechaFin'])?$_POST['CmpFechaFin']:date("d/m/Y");

$POST_Moneda = ($_POST['CmpMoneda']);
//$POST_Moneda = isset($_POST['CmpMoneda'])?$_POST['CmpMoneda']:"MON-10001";


require_once($InsPoo->MtdPaqLogistica().'ClsProveedor.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompra.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoEntrada.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsPagoProveedor.php');
require_once($InsPoo->MtdPaqReporte().'ClsReporteOrdenCompra.php');

require_once($InsPoo->MtdPaqReporte().'ClsReporteAlmacenMovimientoEntrada.php');


$InsProveedor = new ClsProveedor();
$InsMoneda = new ClsMoneda();
$InsAlmacenMovimientoEntrada = new ClsAlmacenMovimientoEntrada();
$InsOrdenCompra = new ClsOrdenCompra();
$InsPagoProveedor = new ClsPagoProveedor();
$InsReporteOrdenCompra = new ClsReporteOrdenCompra();
$InsReporteAlmacenMovimientoEntrada = new ClsReporteAlmacenMovimientoEntrada();


//if(empty($POST_ProveedorId)){
//	
//	if(!empty($POST_ProveedorNombre)){
//
//	$ResProveedor = $InsProveedor->MtdObtenerProveedores("PrvNombreCompleto","contiene",$POST_ProveedorNombre,"PrvTiempoCreacion","ASC",1,NULL,NULL);
//		$ArrProveedores = $ResProveedor['Datos'];
//		
//		if(!empty($ArrProveedores)){
//			
//			$InsProveedor->PrvId = $ArrProveedores[0]->PrvId;
//			unset($ArrProveedores);
//			
//			$InsProveedor->MtdObtenerProveedor();
//	
//		}	
//
//		
//	}
//
//}else{
//
//	$InsProveedor->PrvId = $POST_ProveedorId;
//	$InsProveedor->MtdObtenerProveedor();
//		
//}

if(empty($POST_ProveedorId) and !empty($POST_ProveedorNombre)){
	
	$ResProveedor = $InsProveedor->MtdObtenerProveedores("CliNombre,CliApellidoPaterno,CliApellidoMaterno","contiene",$POST_ProveedorNombre,"CliId","ASC",1,"1",NULL,NULL);
	$ArrProveedores = $ResProveedor['Datos'];
	
	if(!empty($ArrProveedores)){
		foreach($ArrProveedores as $DatProveedor){
			$POST_ProveedorId = $DatProveedor->CliId;
		}
	}

}

if(empty($POST_ProveedorId) and !empty($POST_ProveedorNumeroDocumento)){
	
	$ResProveedor = $InsProveedor->MtdObtenerProveedores("CliNumeroDocumento","contiene",$POST_ProveedorNumeroDocumento,"CliId","ASC",1,"1",NULL,NULL);
	$ArrProveedores = $ResProveedor['Datos'];
	
	if(!empty($ArrProveedores)){
		foreach($ArrProveedores as $DatProveedor){
			$POST_ProveedorId = $DatProveedor->CliId;
		}
	}

}

if(empty($POST_ProveedorId)){
	die("No se pudo identificar al proveedor");
}


//$InsMoneda->MonId = empty($POST_Moneda)?$EmpresaMonedaId:$POST_Moneda;
$InsMoneda->MonId = $POST_Moneda;
$InsMoneda->MtdObtenerMoneda();


//MtdObtenerPagoProveedores($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PovId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oMoneda=NULL,$oCuenta=NULL,$oProveedor=NULL)
$ResPagoProveedor = $InsPagoProveedor->MtdObtenerPagoProveedores("prv.PrvNombre,PrvApellidoPaterno,prv.PrvApellidoMaterno",$POST_con,$POST_fil,$POST_ord,$POST_sen,$POST_pag,$POST_est,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),$POST_Moneda,NULL,$POST_ProveedorId);
$ArrPagoProveedors = $ResPagoProveedor['Datos'];


$TotalPagoProveedor = 0;

if(!empty($ArrPagoProveedors)){
	foreach($ArrPagoProveedors as $DatPagoProveedor){
		
		if($DatPagoProveedor->MonId<>$EmpresaMonedaId ){
			$DatPagoProveedor->PovMonto = round($DatPagoProveedor->PovMonto / $DatPagoProveedor->PovTipoCambio,2);
		}
	
		$TotalPagoProveedor += $DatPagoProveedor->PovMonto;
		
	}
}


				//	 public function MtdObtenerReporteOrdenCompra($oCampo=NULL,$oFiltro=NULL,$oOrden = 'PcdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oOrdenCompra=NULL,$oCliente=NULL,$oMoneda=NULL,$oOrdenCompraTipo=NULL,$oTipoPedido=NULL,$oProveedor=NULL) {
$ResReporteOrdenCompraResumen = $InsReporteOrdenCompra->MtdObtenerReporteOrdenCompra(NULL,NULL,NULL,NULL,NULL,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),NULL,NULL,$POST_Moneda,NULL,NULL,$POST_ProveedorId);
$ArrReporteOrdenCompraResumenes = $ResReporteOrdenCompraResumen['Datos'];

//deb($ArrReporteOrdenCompraResumenes);
$TotalOrdenCompra = 0;

if(!empty($ArrReporteOrdenCompraResumenes)){
	foreach($ArrReporteOrdenCompraResumenes as $DatReporteOrdenCompraResumen){

		if($DatReporteOrdenCompraResumen->MonId<>$EmpresaMonedaId ){
			$DatReporteOrdenCompraResumen->PcoTotal = round($DatReporteOrdenCompraResumen->PcoTotal / $DatReporteOrdenCompraResumen->PcoTipoCambio,2);
		}
		
		$TotalOrdenCompra += $DatReporteOrdenCompraResumen->PcoTotal;
		
	}
}


$TotalAlmacenMovimientoEntrada = 0;

//// MtdObtenerAlmacenMovimientoEntradas($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'AmoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oOrigen=NULL,$oMoneda=NULL,$oOrdenCompra=NULL,$oPedidoCompra=NULL,$oPedidoCompraDetalle=NULL,$oCliente=NULL,$oFecha="AmoFecha",$oConOrdenCompra=0,$oCancelado=0,$oProveedor=NULL,$oVentaDirecta=NULL,$oCondicionPago=NULL,$oSubTipo=NULL,$oAlmacen=NULL) 
//$ResAlmacenMovimientoEntrada = $InsAlmacenMovimientoEntrada->MtdObtenerAlmacenMovimientoEntradas(NULL,NULL,NULL,NULL,NULL,NULL,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),3,NULL,$POST_Moneda,NULL,NULL,NULL,NULL,"AmoComprobanteFecha",0,0,$POST_ProveedorId,NULL,NULL,1,NULL);
//$ArrAlmacenMovimientoEntradas = $ResAlmacenMovimientoEntrada['Datos'];


//MtdObtenerAlmacenMovimientoEntradaEspeciales($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'AmoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oOrigen=NULL,$oMoneda=NULL,$oOrdenCompra=NULL,$oPedidoCompra=NULL,$oPedidoCompraDetalle=NULL,$oCliente=NULL,$oFecha="AmoFecha",$oConOrdenCompra=0,$oCancelado=0,$oProveedor=NULL,$oVentaDirecta=NULL,$oCondicionPago=NULL,$oSubTipo=NULL,$oAlmacen=NULL,$oFechaInicioOrdenCompra=NULL,$oFechaFinOrdenCompra=NULL) {
$ResAlmacenMovimientoEntrada = $InsReporteAlmacenMovimientoEntrada->MtdObtenerAlmacenMovimientoEntradaEspeciales(NULL,NULL,NULL,NULL,NULL,NULL,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),3,NULL,$POST_Moneda,NULL,NULL,NULL,NULL,"AmoComprobanteFecha",0,0,$POST_ProveedorId,NULL,NULL,1,NULL,NULL,FncCambiaFechaAMysql($POST_finicio));
$ArrAlmacenMovimientoEntradas = $ResAlmacenMovimientoEntrada['Datos'];

if(!empty($ArrAlmacenMovimientoEntradas)){
	foreach($ArrAlmacenMovimientoEntradas as $DatAlmacenMovimientoEntrada){
		
		if($DatAlmacenMovimientoEntrada->MonId<>$EmpresaMonedaId ){
			$DatAlmacenMovimientoEntrada->AmoTotal = round($DatAlmacenMovimientoEntrada->AmoTotal / $DatAlmacenMovimientoEntrada->AmoTipoCambio,2);
		}
		
		$TotalAlmacenMovimientoEntrada += $DatAlmacenMovimientoEntrada->AmoTotal;
		
	}
}

$TotalDisponible = $TotalPagoProveedor - $TotalOrdenCompra - $TotalAlmacenMovimientoEntrada;
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
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">REPORTE DE LINEA DE CREDITO DE PROVEEDOR DEL
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
<tr>
  <td width="3%">&nbsp;</td>
  <td width="94%">&nbsp;</td>
  <td width="3%">&nbsp;</td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td align="center">
  
  
<?php
	
//	if($InsProveedor->MonId<>$EmpresaMonedaId ){
//		
//		$InsProveedor->PrvLineaCredito = round($InsProveedor->PrvLineaCredito  / $InsProveedor->PrvTipoCambio,2);
//	
//	}
//	
	
?>

<table class="EstTablaReporte" width="400" border="0" cellpadding="2" cellspacing="2">
<thead class="EstTablaReporteHead">

 <tr>
        <th colspan="3">
        LINEA DE CREDITO:
        <?php echo $InsProveedor->PrvNombre;?>
                <?php echo $InsProveedor->PrvApellidoPaterno;?>
                        <?php echo $InsProveedor->PrvApellidoMaterno;?>
        </th>
        </tr>
</thead>
    <tbody class="EstTablaReporteBody">
     
     
      <tr>
        <td width="60%" align="left">(A) Total Pagado:</td>
        <td width="3%" align="right">:</td>
        <td width="37%" align="left">
		<?php echo $InsMoneda->MonSimbolo;?>
        
        
		<?php echo number_format($TotalPagoProveedor,2); ?></td>
      </tr>

      <tr>
        <td align="left">(B) Total de Ordenes de Compra:</td>
        <td align="right">:</td>
        <td align="left">
        
        <?php echo $InsMoneda->MonSimbolo;?> <?php echo number_format($TotalOrdenCompra,2); ?>
        
        
        </td>
      </tr>
      <tr>
        <td align="left">(C) Total Facturado</td>
        <td align="right">:</td>
        <td align="left"><?php echo $InsMoneda->MonSimbolo;?> <?php echo number_format($TotalAlmacenMovimientoEntrada,2); ?></td>
      </tr>
      <tr>
        <td align="left">Linea Disponible Real (A-B-C):</td>
        <td align="right">&nbsp;</td>
        <td align="left"><?php echo $InsMoneda->MonSimbolo;?> <?php echo number_format($TotalDisponible,2); ?></td>
      </tr>
      </tbody>
    <tfoot class="EstTablaReporteFoot">
    </tfoot>
  </table></td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
</table>
</body>
</html>
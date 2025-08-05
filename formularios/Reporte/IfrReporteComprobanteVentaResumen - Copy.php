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
	header("Content-Disposition:  filename=\"RESUMEN_FACTURA_".date('d-m-Y').".xls\";");
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

$POST_finicio = isset($_POST['CmpFechaInicio'])?$_POST['CmpFechaInicio']:"01/01/".date("Y");
$POST_ffin = isset($_POST['CmpFechaFin'])?$_POST['CmpFechaFin']:date("d/m/Y");

$POST_ord = isset($_POST['CmpOrden'])?$_POST['CmpOrden']:"FechaEmision";
$POST_sen = isset($_POST['CmpSentido'])?$_POST['CmpSentido']:"DESC";

$POST_Moneda = ($_POST['CmpMoneda']);

$POST_ClienteNombre = ($_POST['CmpClienteNombre']);
$POST_ClienteNumeroDocumento = ($_POST['CmpClienteNumeroDocumento']);
$POST_ClienteId = ($_POST['CmpClienteId']);

$POST_CondicionPago = ($_POST['CmpCondicionPago']);
$POST_Personal = ($_POST['CmpPersonal']);




require_once($InsPoo->MtdPaqContabilidad().'ClsFactura.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsPago.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsNotaCredito.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoleta.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsNotaCredito.php');

$InsPago = new ClsPago();
$InsFactura = new ClsFactura();
$InsMoneda = new ClsMoneda();
$InsCliente = new ClsCliente();
$InsNotaCredito = new ClsNotaCredito();
$InsBoleta = new ClsBoleta();
$InsNotaCredito = new ClsNotaCredito();

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


//MtdObtenerFacturas($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'FacId',$oSentido = 'Desc',$oPaginacion = '0,10',$oSucursal=NULL,$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oCredito=NULL,$oRegimen=NULL,$oCondicionPago=NULL,$oNotaCredito=NULL,$oMoneda=NULL,$oCliente=NULL,$oAlmacenMovimiento=NULL,$oDiaVencer=NULL,$oPagado=NULL,$oOrdenVentaVehiculo=NULL,$oVentaDirecta=NULL,$oVendedor=NULL) 
$ResFactura = $InsFactura->MtdObtenerFacturas(NULL,NULL,NULL,"Fac".$POST_ord,$POST_sen,NULL,NULL,NULL,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),NULL,NULL,NULL,NULL,NULL,$POST_Moneda,$POST_ClienteId,NULL,NULL,NULL,NULL,NULL,$POST_Personal);
$ArrFacturas = $ResFactura['Datos'];

//MtdObtenerBoletas($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'BolId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oRegimen=NULL,$oCondicionPago=NULL,$oMoneda=NULL,$oAlmacenMovimiento=NULL,$oCliente=NULL) {
$ResBoleta = $InsBoleta->MtdObtenerBoletas(NULL,NULL,NULL,"Bol".$POST_ord,$POST_sen,NULL,NULL,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),NULL,NULL,NULL,$POST_Moneda,NULL,$POST_ClienteId);
$ArrBoletas = $ResBoleta['Datos'];


//MtdObtenerNotaCreditos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'NcrId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oSucursal=NULL,$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oMoneda=NULL,$oDocumentoId=NULL,$oDocumentoTalonarioId=NULL,$oSucursal=NULL,$oClienteId=NULL)
$ResNotaCredito = $InsNotaCredito->MtdObtenerNotaCreditos(NULL,NULL,NULL,"Ncr".$POST_ord,$POST_sen,1,NULL,NULL,NULL,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),NULL,$POST_Moneda,NULL,NULL,NULL,$POST_ClienteId);
$ArrNotaCreditos = $ResNotaCredito['Datos'];


?>

<?php
if($_GET['P']==2){
?>
<table cellpadding="0" cellspacing="0" width="100%" border="0">
<tr>
  <td colspan="3" align="left"><span class="EstReporteCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
</tr>
<tr>
  <td width="23%" align="left" valign="top">&nbsp;</td>
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">RESUMEN DE FACTURAS DEL
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
  <td width="23%" align="right" valign="top">&nbsp;</td>
</tr>
</table>
<?php	
}
?>

<?php if($_GET['P']==1){?>
<table cellpadding="0" cellspacing="0" width="100%" border="0">
<tr>
  <td colspan="3" align="left"><span class="EstReporteCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
</tr>
<tr>
  <td width="23%" align="left" valign="top">

    <img src="../../imagenes/logos/logo_reporte.png" width="243" height="59" />

  </td>
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">RESUMEN DE FACTURAS DEL
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
          <th width="10%" rowspan="2">Número correlativo del registro o código unico de la operación</th>
          <th width="10%" rowspan="2">Fecha de emisión del comprobante de pago o documento</th>
          <th width="10%" rowspan="2">Fecha de vencimiento y/o pago</th>
          <th colspan="3">COMROBANTE DE PAGO O DOCUMENTO</th>
          <th colspan="3">INFORMACION DEL CLIENTE</th>
          <th width="5%" rowspan="2">Valor facturado de la exportación</th>
          <th width="5%" rowspan="2">Base imponible de la operación gravada</th>
          <th colspan="2">IMPORTE TOTAL DE LA OPERACION</th>
          <th width="7%" rowspan="2">IGV Y/O IPM</th>
          <th width="7%" rowspan="2">Otros tributos y cargos que no forman parte de la base imponible</th>
          <th width="7%" rowspan="2">Importe total del comprobante de pago</th>
          <th width="7%" rowspan="2">Tipo de cambio</th>
          <th colspan="4">Referencia del comprobante de pago o documento original que se modifica</th>
          <th width="7%" rowspan="2">estado</th>
          <th width="7%" rowspan="2">total Descuento</th>
          <th width="7%" rowspan="2">total Venta Gratuita</th>
          <th colspan="2">SUNAT</th>
          <th width="7%" rowspan="2">Moneda</th>
          </tr>
        <tr>
          <th width="10%">tipo (Tabla 10)</th>
          <th width="10%">N° serie o N° de serie de la maquina registradora</th>
          <th width="10%">Número</th>
          <th width="5%">Tipo (Tabla12)</th>
          <th width="5%">Número</th>
          <th width="5%">Apellidos y nombres, denominación o razon social</th>
          <th width="31%">exonerada</th>
          <th width="7%">inafecta</th>
          <th width="7%">fecha</th>
          <th width="7%">Tipo (Tabla 10)</th>
          <th width="7%">Serie</th>
          <th width="7%">Nro. del comprobante de pago o documento</th>
          <th width="7%">Accion</th>
          <th width="7%">Rpta.</th>
          </tr>
        </thead>
        <tbody class="EstTablaReporteBody">
        
        
        <?php
		$c=1;
		
		$FacturaSubTotal = 0;
		$FacturaImpuesto = 0;
		$FacturaTotal = 0;
		
		$FacturaAmortizadoTotal = 0;
		$FacturaSaldoTotal = 0;
		
		$TotalCredito30 = 0;
		$TotalCredito30Mas = 0;
		$TotalContado = 0;
		$TotalFacturaNoCancelada = 0;
		
        foreach($ArrFacturas as $DatFactura){
			
			
		//	$DatFactura->FacSubTotal = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$DatFactura->FacSubTotal:($DatFactura->FacSubTotal/$DatFactura->FacTipoCambio));
//			$DatFactura->FacImpuesto = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$DatFactura->FacImpuesto:($DatFactura->FacImpuesto/$DatFactura->FacTipoCambio));
//			$DatFactura->FacTotal = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$DatFactura->FacTotal:($DatFactura->FacTotal/$DatFactura->FacTipoCambio));
			
			$DatFactura->FacSubTotal = round($DatFactura->FacSubTotal,2);
			$DatFactura->FacImpuesto = round($DatFactura->FacImpuesto,2);
			$DatFactura->FacTotal = round($DatFactura->FacTotal,2);
			
        ?>
        
        
        <tr   >
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="middle"   ><?php echo $c;?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >&nbsp;</td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatFactura->FacFechaEmision;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatFactura->FacFechaVencimiento;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >&nbsp;</td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatFactura->FtaNumero;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatFactura->FacId;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatFactura->TdoNombre;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatFactura->CliNumeroDocumento;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatFactura->CliNombre;  ?> <?php echo $DatFactura->CliApellidoPaterno;  ?> <?php echo $DatFactura->CliApellidoMaterno;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >&nbsp;</td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo number_format($DatFactura->FacSubTotal,2);?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >&nbsp;</td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >&nbsp;</td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo number_format($DatFactura->FacImpuesto,2);?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >&nbsp;</td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo number_format($DatFactura->FacTotal,2);?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatFactura->FacTipoCambio;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >&nbsp;</td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >&nbsp;</td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >&nbsp;</td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >&nbsp;</td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo  $DatFactura->FacEstadoDescripcion;?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >&nbsp;</td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >&nbsp;</td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatFactura->FacSunatUltimaAccion;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatFactura->FacSunatUltimaRespuesta;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatFactura->MonSimbolo;  ?></td>
          </tr>
        <?php	
			
			$FacturaSubTotal += $DatFactura->FacSubTotal;
			$FacturaImpuesto += $DatFactura->FacImpuesto;
			$FacturaTotal += $DatFactura->FacTotal;
			
			
			$FacturaAmortizadoTotal += $ClientePagoMontoTotal;
			$FacturaSaldoTotal += $FacturaSaldo;
			
		$c++;
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
            <td align="right"><span class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"><?php echo number_format($FacturaSubTotal,2);  ?></span></td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right"><span class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"><?php echo number_format($FacturaImpuesto,2);  ?></span></td>
            <td align="right">&nbsp;</td>
            <td align="right"><span class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"><?php echo number_format($FacturaTotal,2);  ?></span></td>
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
          </tr>
          </tbody>
		<tfoot class="EstTablaReporteFoot">
		</tfoot>
		</table>


<table class="EstTablaReporte" width="100%" border="0" cellpadding="2" cellspacing="2">
        <thead class="EstTablaReporteHead">
        <tr>
          <th>&nbsp;</th>
          <th width="10%" rowspan="2">Número correlativo del registro o código unico de la operación</th>
          <th width="10%" rowspan="2">Fecha de emisión del comprobante de pago o documento</th>
          <th width="10%" rowspan="2">Fecha de vencimiento y/o pago</th>
          <th colspan="3">COMROBANTE DE PAGO O DOCUMENTO</th>
          <th colspan="3">INFORMACION DEL CLIENTE</th>
          <th>&nbsp;</th>
          <th>&nbsp;</th>
          <th colspan="2">IMPORTE TOTAL DE LA OPERACION</th>
          <th rowspan="2">IGV Y/O IPM</th>
          <th rowspan="2">Otros tributos y cargos que no forman parte de la base imponible</th>
          <th rowspan="2">Importe total del comprobante de pago</th>
          <th rowspan="2">Tipo de cambio</th>
          <th colspan="4">Referencia del comprobante de pago o documento original que se modifica</th>
          <th width="7%" rowspan="2">estado</th>
          <th width="7%" rowspan="2">total Descuento</th>
          <th width="10%" rowspan="2">total Venta Gratuita</th>
          <th colspan="2">SUNAT</th>
          <th width="10%" rowspan="2">Moneda</th>
          </tr>
        <tr>
          <th width="2%">#</th>
          <th>tipo (Tabla 10)</th>
          <th>N° serie o N° de serie de la maquina registradora</th>
          <th>Número</th>
          <th>Tipo (Tabla12)</th>
          <th>Número</th>
          <th>Apellidos y nombres, denominación o razon social</th>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >Valor facturado de la exportación</td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >Base imponible de la operación gravada</td>
          <td align="right" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" >exonerada</td>
          <td align="right" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" >inafecta</td>
          <th>fecha</th>
          <th>Tipo (Tabla 10)</th>
          <th>Serie</th>
          <th>Nro. del comprobante de pago o documento</th>
          <th>Accion</th>
          <th>Rpta.</th>
          </tr>
  </thead>
        <tbody class="EstTablaReporteBody">
        
        
        <?php
		$c=1;
		$BoletaSubTotal = 0;
		$BoletaImpuesto= 0;
		$BoletaTotal = 0;
		
		$BoletaAmortizadoTotal = 0;
		$BoletaSaldoTotal = 0;
		
		$TotalCredito30 = 0;
		$TotalCredito30Mas = 0;
		$TotalContado = 0;
		$TotalBoletaNoCancelada = 0;
		
        foreach($ArrBoletas as $DatBoleta){
			
			//$DatBoleta->BolSubTotal = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$DatBoleta->BolSubTotal:($DatBoleta->BolSubTotal/$DatBoleta->BolTipoCambio));
//			$DatBoleta->BolImpuesto = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$DatBoleta->BolImpuesto:($DatBoleta->BolImpuesto/$DatBoleta->BolTipoCambio));
//			$DatBoleta->BolTotal = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$DatBoleta->BolTotal:($DatBoleta->BolTotal/$DatBoleta->BolTipoCambio));
//			
				
			$DatBoleta->BolSubTotal = round($DatBoleta->BolSubTotal,2);
			$DatBoleta->BolImpuesto = round($DatBoleta->BolImpuesto,2);
			$DatBoleta->BolTotal = round($DatBoleta->BolTotal,2);
			
        ?>
        
        
        <tr   >
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="middle"   ><?php echo $c;?></td>
          <th width="10%">&nbsp;</th>
          <th width="10%"><span class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"><?php echo $DatBoleta->BolFechaEmision;  ?></span></th>
          <th width="10%"><span class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"><?php echo $DatBoleta->BolFechaVencimiento;  ?></span></th>
          <th width="10%">&nbsp;</th>
          <th width="10%"><span class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"><?php echo $DatBoleta->BtaNumero;  ?></span></th>
          <th width="10%"><span class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"><?php echo $DatBoleta->BolId;  ?></span></th>
          <th width="10%"><span class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"><?php echo $DatBoleta->TdoNombre;  ?></span></th>
          <th width="10%"><span class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"><?php echo $DatBoleta->CliNumeroDocumento;  ?></span></th>
          <th width="10%"><span class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"><?php echo $DatBoleta->CliNombre;  ?> <?php echo $DatBoleta->CliApellidoPaterno;  ?> <?php echo $DatBoleta->CliApellidoMaterno;  ?></span></th>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >&nbsp;</td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo number_format($DatBoleta->BolSubTotal,2);?></td>
          <td width="10%" align="right" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" >&nbsp;</td>
          <td width="10%" align="right" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" >&nbsp;</td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo number_format($DatBoleta->BolImpuesto,2);?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >&nbsp;</td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo number_format($DatBoleta->BolTotal,2);?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatBoleta->BolTipoCambio;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >&nbsp;</td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >&nbsp;</td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >&nbsp;</td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >&nbsp;</td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo  $DatBoleta->BolEstadoDescripcion;?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >&nbsp;</td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >&nbsp;</td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatBoleta->BolSunatUltimaAccion;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatBoleta->BolSunatUltimaRespuesta;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatBoleta->MonSimbolo;  ?></td>
          </tr>
        <?php	
			
			$BoletaSubTotal += $DatBoleta->BolSubTotal;
			$BoletaImpuesto += $DatBoleta->BolImpuesto;
			$BoletaTotal += $DatBoleta->BolTotal;
			
			$BoletaAmortizadoTotal += $ClientePagoMontoTotal;
			$BoletaSaldoTotal += $BoletaSaldo;
			
		$c++;
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
            <td align="right"><span class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"><?php echo number_format($BoletaSubTotal,2);  ?></span></td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right"><span class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"><?php echo number_format($BoletaImpuesto,2);  ?></span></td>
            <td align="right">&nbsp;</td>
            <td align="right"><span class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"><?php echo number_format($BoletaTotal,2);  ?></span></td>
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
          </tr>
  </tbody>
		<tfoot class="EstTablaReporteFoot">
		</tfoot>
</table>
        
        
        <table class="EstTablaReporte" width="100%" border="0" cellpadding="2" cellspacing="2">
        <thead class="EstTablaReporteHead">
        <tr>
          <th width="2%" rowspan="2">#</th>
          <th width="10%" rowspan="2">SERIE</th>
          <th width="10%" rowspan="2">CORRELATIVO</th>
          <th width="5%" rowspan="2">FECHA</th>
          <th width="31%" rowspan="2">TIPO DOC.</th>
          <th width="31%" rowspan="2">NUM. DOC.</th>
          <th width="31%" rowspan="2">CLIENTE</th>
          <th width="7%" rowspan="2">MONEDA</th>
          <th width="3%" rowspan="2">T.C.</th>
          <th width="6%" rowspan="2">REF.</th>
          <th width="6%" rowspan="2">CRED. CANT. DIAS</th>
          <th width="6%" rowspan="2">FECHA VENC.</th>
          <th width="6%" rowspan="2">SUNAT</th>
          <th width="6%" rowspan="2">RPTA.</th>
          <th width="6%" rowspan="2">ESTADO</th>
          <th width="9%" rowspan="2">SUB TOTAL</th>
          <th width="9%" rowspan="2">IMPUESTO</th>
          <th width="8%" rowspan="2">TOTAL</th>
          <th width="8%" rowspan="2">MOTIVO</th>
          <th colspan="3">DOC. AFECTADO</th>
          </tr>
        <tr>
          <th width="8%">SERIE</th>
          <th width="8%">CORRELATIVO</th>
          <th width="8%">FECHA</th>
          </tr>
        </thead>
        <tbody class="EstTablaReporteBody">
        
        
        <?php
		$c=1;
		$NotaCreditoSubTotal = 0;
		$NotaCreditoImpuesto = 0;
		$NotaCreditoTotal = 0;
		
		$NotaCreditoAmortizadoTotal = 0;
		$NotaCreditoSaldoTotal = 0;
		
		$TotalCredito30 = 0;
		$TotalCredito30Mas = 0;
		$TotalContado = 0;
		$TotalNotaCreditoNoCancelada = 0;
		
        foreach($ArrNotaCreditos as $DatNotaCredito){
			
		//	
//			$DatNotaCredito->NcrTotal = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$DatNotaCredito->NcrTotal:($DatNotaCredito->NcrTotal/$DatNotaCredito->NcrTipoCambio));
//			$DatNotaCredito->NcrSubTotal = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$DatNotaCredito->NcrSubTotal:($DatNotaCredito->NcrSubTotal/$DatNotaCredito->NcrTipoCambio));
//			$DatNotaCredito->NcrImpuesto = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$DatNotaCredito->NcrImpuesto:($DatNotaCredito->NcrImpuesto/$DatNotaCredito->NcrTipoCambio));
//				
			$DatNotaCredito->NcrTotal = round($DatNotaCredito->NcrTotal,2);
			$DatNotaCredito->NcrSubTotal = round($DatNotaCredito->NcrSubTotal,2);
			$DatNotaCredito->NcrImpuesto = round($DatNotaCredito->NcrImpuesto,2);
			
        ?>
        
        
        <tr   >
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="middle"   ><?php echo $c;?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatNotaCredito->NctNumero;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatNotaCredito->NcrId;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatNotaCredito->NcrFechaEmision;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatNotaCredito->TdoNombre;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatNotaCredito->CliNumeroDocumento;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatNotaCredito->CliNombreCompleto;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatNotaCredito->MonSimbolo;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatNotaCredito->NcrTipoCambio;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >-</td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >-</td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >-</td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatNotaCredito->NcrSunatUltimaAccion;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatNotaCredito->NcrSunatUltimaRespuesta;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
          
          
          <?php echo  $DatNotaCredito->NcrEstadoDescripcion;?>
				
		  </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo number_format($DatNotaCredito->NcrSubTotal,2);?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo number_format($DatNotaCredito->NcrImpuesto,2);?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo number_format($DatNotaCredito->NcrTotal,2);?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatNotaCredito->NcrMotivo;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatNotaCredito->DtaNumero;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatNotaCredito->DocId;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatNotaCredito->DocFechaEmision;  ?></td>
          </tr>
        <?php	
			
			$NotaCreditoSubTotal += $DatNotaCredito->NcrSubTotal;
			$NotaCreditoImpuesto += $DatNotaCredito->NcrImpuesto;
			$NotaCreditoTotal += $DatNotaCredito->NcrTotal;
			
			$NotaCreditoAmortizadoTotal += $ClientePagoMontoTotal;
			$NotaCreditoSaldoTotal += $NotaCreditoSaldo;
			
		$c++;
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
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">TOTALES:</td>
            <td align="right"><span class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"><?php echo number_format($NotaCreditoSubTotal,2);  ?></span></td>
            <td align="right"><span class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"><?php echo number_format($NotaCreditoImpuesto,2);  ?></span></td>
            <td align="right"><span class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"><?php echo number_format($NotaCreditoTotal,2);  ?></span></td>
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
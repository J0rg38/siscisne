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
	header("Content-Disposition:  filename=\"REPORTE_CLIENTE_LINEA_CREDITO_".date('d-m-Y').".xls\";");
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

$POST_ClienteId = $_POST['CmpClienteId'];
$POST_ClienteNombre = $_POST['CmpClienteNombre'];

$POST_finicio = isset($_POST['CmpFechaInicio'])?$_POST['CmpFechaInicio']:"01/01/".date("Y");
$POST_ffin = isset($_POST['CmpFechaFin'])?$_POST['CmpFechaFin']:date("d/m/Y");

$POST_mon = ($_POST['CmpMoneda']);

//$POST_ord = isset($_POST['CmpOrden'])?$_POST['CmpOrden']:"FinFecha";
//$POST_sen = isset($_POST['CmpSentido'])?$_POST['CmpSentido']:"DESC";

require_once($InsPoo->MtdPaqContabilidad().'ClsFactura.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoleta.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

$InsFactura = new ClsFactura();
$InsBoleta = new ClsBoleta();
$InsCliente = new ClsCliente();
$InsMoneda = new ClsMoneda();

if(empty($POST_ClienteId)){
	
	$ResCliente = $InsCliente->MtdObtenerClientes("CliNombreCompleto","esigual",$POST_ClienteNombre,"CliTiempoCreacion","ASC",1,NULL,NULL);
	$ArrClientes = $ResCliente['Datos'];
	
	if(!empty($ArrClientes)){
		
		$InsCliente->CliId = $ArrClientes[0]->CliId;
		unset($ArrClientes);
		
		$InsCliente->MtdObtenerCliente();
		
	}	

}else{

	$InsCliente->CliId = $POST_ClienteId;
	$InsCliente->MtdObtenerCliente();
		
}



if(empty($InsCliente->CliId)){
	die("No se pudo identifiar al cliente");
}

//MtdObtenerFacturasValor($oFuncion="SUM",$oParametro="FacId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'FacId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oSucursal=NULL,$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oRegimen=NULL,$oCondicionPago=NULL,$oNotaCredito=NULL,$oMoneda=NULL,$oCliente=NULL,$oAlmacenMovimiento=NULL)  
$TotalFactura = $InsFactura->MtdObtenerFacturasValor("SUM","FacTotal",NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,"1,5",FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),NULL,NULL,"NPA-10001",NULL,NULL,$InsCliente->CliId,NULL);		

// MtdObtenerBoletasValor($oFuncion="SUM",$oParametro="BolId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'BolId',$oSentido = 'Desc',$oPaginacion = '0,10',$oSucursal=NULL,$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oRegimen=NULL,$oCondicionPago=NULL,$oMoneda=NULL,$oAlmacenMovimiento=NULL)
$TotalBoleta = $InsBoleta->MtdObtenerBoletasValor("SUM","BolTotal",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"1,5",FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),NULL,NULL,"NPA-10001",NULL,NULL,$InsCliente->CliId);

$TotalCredito = $TotalBoleta + $TotalFactura;

$TotalDisponible = $InsCliente->CliLineaCredito - $TotalCredito;


$InsMoneda->MonId = empty($POST_mon)?$EmpresaMonedaId:$POST_mon;
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
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">REPORTE DE LINEA DE CREDITO DE CLIENTE DEL
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
	
//	if($InsCliente->MonId<>$EmpresaMonedaId ){
//		
//		$InsCliente->CliLineaCredito = round($InsCliente->CliLineaCredito  / $InsCliente->CliTipoCambio,2);
//	
//	}
//	
	
?>

<table class="EstTablaReporte" width="30%" border="0" cellpadding="2" cellspacing="2">
<thead class="EstTablaReporteHead">

 <tr>
        <th colspan="3">
        <?php echo $InsCliente->CliNombreCompleto;?>
        </th>
        </tr>
</thead>
    <tbody class="EstTablaReporteBody">
     
     
      <tr>
        <td align="left"><span class="EtiquetaPrincipal">Linea de Credito</span></td>
        <td align="right">:</td>
        <td align="left">
		<?php echo $InsMoneda->MonSimbolo;?>
		<?php echo number_format($InsCliente->CliLineaCredito,2); ?></td>
      </tr>
      <tr>
        <td align="left"><span class="EtiquetaPrincipal">Facturacion</span></td>
        <td align="right">:</td>
        <td align="left"><?php echo $InsMoneda->MonSimbolo;?> <?php echo number_format($TotalCredito,2); ?></td>
      </tr>
      <tr>
        <td align="right"><span class="EtiquetaSecundaria">Boletas</span></td>
        <td align="right">:</td>
        <td align="right"> <?php echo $InsMoneda->MonSimbolo;?> <?php echo number_format($TotalBoleta,2); ?></td>
      </tr>
      <tr>
        <td align="right">Facturas</td>
        <td align="right">:</td>
        <td align="right"><?php echo $InsMoneda->MonSimbolo;?> <?php echo number_format($TotalFactura,2); ?></td>
      </tr>
      <tr>
        <td align="left"><span class="EtiquetaPrincipal">Disponible</span></td>
        <td align="right">:</td>
        <td align="left"> <?php echo $InsMoneda->MonSimbolo;?> <?php echo number_format($TotalDisponible,2); ?></td>
      </tr>
      <tr>
        <td width="47%" align="left">&nbsp;</td>
        <td width="4%" align="right">&nbsp;</td>
        <td width="49%" align="right">&nbsp;</td>
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
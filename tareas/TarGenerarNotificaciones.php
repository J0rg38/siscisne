<?php
session_start();
require_once('../proyecto/ClsProyecto.php');
require_once('../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../';
$InsPoo->Ruta = '../';

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


//require_once('../librerias/nusoap-0.9.5/lib/nusoap.php');
require_once($InsProyecto->MtdRutLibrerias().'nusoap-0.9.5/lib/nusoap.php');
//require_once('../librerias/JSON2.php');
require_once($InsProyecto->MtdRutLibrerias().'JSON2.php');
require_once($InsProyecto->MtdRutLibrerias().'JSON.php');

require_once($InsPoo->MtdPaqAcceso().'ClsAuditoria.php');


require_once($InsProyecto->MtdRutLibrerias().'fpdf17/fpdf.php');


/** Include PHPExcel */
//require_once dirname(__FILE__) . '/../Classes/PHPExcel.php';
require_once($InsProyecto->MtdRutLibrerias().'ZipArchive.php');
require_once($InsProyecto->MtdRutLibrerias().'PHPExcel_1.8.0_doc/Classes/PHPExcel.php');

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>

</head>

<body>

<?php

$fecha = date('Y-m-j');
$nuevafecha = strtotime ( '-30 day' , strtotime ( $fecha ) ) ;
$nuevafecha = date ( 'd/m/Y' , $nuevafecha );

$GET_FechaInicio = (empty($_GET['FechaInicio'])?$nuevafecha:$_GET['FechaInicio']);
$GET_FechaFin = (empty($_GET['FechaFin'])?date("d/m/Y"):$_GET['FechaFin']);

require_once($InsPoo->MtdPaqActividad().'ClsNotificacion.php');

require_once($InsPoo->MtdPaqReporte().'ClsReporteFichaIngreso.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoLlamada.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoModalidad.php');
require_once($InsPoo->MtdPaqLogistica().'ClsEncuesta.php');

require_once($InsPoo->MtdPaqReporte().'ClsReporteOrdenVentaVehiculo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoLlamada.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoModalidad.php');

require_once($InsPoo->MtdPaqLogistica().'ClsEncuesta.php');





/*
* NOTIFICACION POSTVENTA
*/

$InsReporteFichaIngreso = new ClsReporteFichaIngreso();

//MtdObtenerReporteFichaIngresoSeguimientoLlamadas($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oCliente=NULL,$oFichaIngreso=NULL,$oDiasTranscurridos=0,$oSucursal=NULL,$oModalidadIngreso=NULL,$oConLlamada=false,$oVehiculoMarca=NULL,$oIncluirCSI=NULL,$oDiasTranscurridosTipo="Mayor") {
$ResReporteFichaIngreso = $InsReporteFichaIngreso->MtdObtenerReporteFichaIngresoSeguimientoLlamadas(NULL,NULL,NULL,"FinFecha","DESC",NULL,FncCambiaFechaAMysql($GET_FechaInicio),FncCambiaFechaAMysql($GET_FechaFin),NULL,NULL,3,NULL,NULL,false,NULL,$POST_IncluirCSI,"Igual");		
$ArrReporteFichaIngresos = $ResReporteFichaIngreso['Datos'];

$TotalLlamadasPostVenta = 0;

if(!empty($ArrReporteFichaIngresos)){
	foreach($ArrReporteFichaIngresos as $DatReporteFichaIngreso){
		$TotalLlamadasPostVenta++;
	}
}


$InsNotificacion = new ClsNotificacion();
$InsNotificacion->UsuId = NULL;
$InsNotificacion->UsuIdOrigen = "";
$InsNotificacion->NfnUsuario = "";

$InsNotificacion->NfnModulo = "";
$InsNotificacion->NfnFormulario = "";
$InsNotificacion->NfnDescripcion = "El dia de hoy tienes (".$TotalLlamadasPostVenta.") clientes con 3 dias por llamar - POSTVENTA";
$InsNotificacion->NfnEnlace = "principal.php?Mod=TrabajoTerminado&Form=SeguimientoLlamada&DiasTranscurridos=3&FechaInicio=".$GET_FechaInicio."&FechaFin=".$GET_FechaFin."&Leido=1";
$InsNotificacion->NfnEnlaceNombre = "Mostrar";

$InsNotificacion->NfnPersonalNombreCompleto = "";
$InsNotificacion->NfnPersonalFoto = "";

$InsNotificacion->NfnTipo = 1;
$InsNotificacion->NfnEstado = 1;
$InsNotificacion->NfnTiempoCreacion =date("Y-m-d H:i:s");
$InsNotificacion->NfnTiempoModificacion =date("Y-m-d H:i:s");

$InsNotificacion->MtdRegistrarNotificacion();



/*
* NOTIFICACION VENTA
*/

$InsReporteOrdenVentaVehiculo = new ClsReporteOrdenVentaVehiculo();

//MtdObtenerReporteOrdenVentaVehiculoClientes($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'OvvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oVehiculoMarca=NULL,$oSucursal=NULL,$oIncluirCSI=NULL,$oDiasTranscurridosTipo="Mayor",$oDiasTranscurridos=0)
$ResReporteOrdenVentaVehiculo = $InsReporteOrdenVentaVehiculo->MtdObtenerReporteOrdenVentaVehiculoClientes(NULL,NULL,NULL ,"OvvFechaEntrega","DESC",NULL,FncCambiaFechaAMysql($GET_FechaInicio),FncCambiaFechaAMysql($GET_FechaFin),NULL,$POST_SucursalId,NULL,"igual",20);
$ArrReporteOrdenVentaVehiculos = $ResReporteOrdenVentaVehiculo['Datos'];


$TotalLlamadasVenta = 0;

if(!empty($ArrReporteOrdenVentaVehiculos)){
	foreach($ArrReporteOrdenVentaVehiculos as $DatReporteOrdenVentaVehiculos){
		$TotalLlamadasVenta++;
	}
}

$InsNotificacion = new ClsNotificacion();
$InsNotificacion->UsuId = NULL;
$InsNotificacion->UsuIdOrigen = "";
$InsNotificacion->NfnUsuario = "";

$InsNotificacion->NfnModulo = "";
$InsNotificacion->NfnFormulario = "";
$InsNotificacion->NfnDescripcion = "El dia de hoy tienes (".$TotalLlamadasVenta.") clientes con 20 dias por llamar - VENTA";
$InsNotificacion->NfnEnlace = "principal.php?Mod=OrdenVentaVehiculo&Form=SeguimientoLlamada&DiasTranscurridos=20&FechaInicio=".$GET_FechaInicio."&FechaFin=".$GET_FechaFin."&Leido=1";
$InsNotificacion->NfnEnlaceNombre = "Mostrar";

$InsNotificacion->NfnPersonalNombreCompleto = "";
$InsNotificacion->NfnPersonalFoto = "";

$InsNotificacion->NfnTipo = 1;
$InsNotificacion->NfnEstado = 1;
$InsNotificacion->NfnTiempoCreacion =date("Y-m-d H:i:s");
$InsNotificacion->NfnTiempoModificacion =date("Y-m-d H:i:s");

if($InsNotificacion->MtdRegistrarNotificacion()){
	
}
?>
</body>
</html>

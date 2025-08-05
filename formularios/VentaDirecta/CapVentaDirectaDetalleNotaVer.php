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


?>

<?php

$POST_VentaDirectaDetalleId = isset($_POST['VentaDirectaDetalleId'])?$_POST['VentaDirectaDetalleId']:"";

require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompra.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirecta.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirectaDetalle.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVentaConcretada.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFactura.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoleta.php');
require_once($InsPoo->MtdPaqReporte().'ClsReporteProductoVenta.php');

$InsVentaDirecta = new ClsVentaDirecta();
$InsVentaDirectaDetalle = new ClsVentaDirectaDetalle();
$InsCliente = new ClsCliente();
$InsMoneda = new ClsMoneda();
$InsReporteProductoVenta = new ClsReporteProductoVenta();

$InsVentaDirectaDetalle->VddId = $POST_VentaDirectaDetalleId;
$InsVentaDirectaDetalle->MtdObtenerVentaDirectaDetalle();

echo $InsVentaDirectaDetalle->VddNotaResumen;
?>

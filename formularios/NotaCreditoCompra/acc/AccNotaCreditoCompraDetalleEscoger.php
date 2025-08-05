<?php
require_once('../../../proyecto/ClsProyecto.php');

$InsProyecto->Ruta = '../../../';

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

//require_once($InsProyecto->MtdRutLibrerias().'JSON.php');
require_once($InsProyecto->MtdRutLibrerias().'JSON2.php');

$Identificador = $_POST['Identificador'];

session_start();
if (!isset($_SESSION['InsNotaCreditoCompraDetalle'.$Identificador])){
	$_SESSION['InsNotaCreditoCompraDetalle'.$Identificador] = new ClsSesionObjeto();
}

$InsNotaCreditoCompraDetalle1 = array();
$InsNotaCreditoCompraDetalle1 = $_SESSION['InsNotaCreditoCompraDetalle'.$Identificador]->MtdObtenerSesionObjeto($_POST['Item']);

/*
SesionObjeto-NotaCreditoCompraDetalleListado
Parametro1 = NodId
Parametro2 = NodDescripcion
Parametro4 = NodPrecio
Parametro5 = NodCantidad
Parametro6 = NodImporte
Parametro7 = NodTiempoCreacion
Parametro8 = NodTiempoModificacion
Parametro9 = VdeId
Parametro10 = VenId
Parametro11 = VtaNumero;
*/

$InsNotaCreditoCompraDetalle1->Parametro4 = round($InsNotaCreditoCompraDetalle1->Parametro4,2);
$InsNotaCreditoCompraDetalle1->Parametro5 = round($InsNotaCreditoCompraDetalle1->Parametro5,2);
$InsNotaCreditoCompraDetalle1->Parametro6 = round($InsNotaCreditoCompraDetalle1->Parametro6,2);

//$json = new JSON;
//$var = $json->serialize( $InsNotaCreditoCompraDetalle1 );
//
//$json->unserialize( $var );
//
//echo $var;

$json = new Services_JSON();
echo $json->encode($InsNotaCreditoCompraDetalle1);
?>
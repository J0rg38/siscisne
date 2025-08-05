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
if (!isset($_SESSION['InsComprobanteRetencionDetalle'.$Identificador])){
	$_SESSION['InsComprobanteRetencionDetalle'.$Identificador] = new ClsSesionObjeto();
}

$InsComprobanteRetencionDetalle1 = array();
$InsComprobanteRetencionDetalle1 = $_SESSION['InsComprobanteRetencionDetalle'.$Identificador]->MtdObtenerSesionObjeto($_POST['Item']);

/*
SesionObjeto-ComprobanteRetencionDetalleListado
Parametro1 = CedId
Parametro2 = CedDescripcion
Parametro4 = CedPrecio
Parametro5 = CedCantidad
Parametro6 = CedImporte
Parametro7 = CedTiempoCreacion
Parametro8 = CedTiempoModificacion
Parametro9 = VdeId
Parametro10 = VenId
Parametro11 = VtaNumero;
*/

$InsComprobanteRetencionDetalle1->Parametro4 = round($InsComprobanteRetencionDetalle1->Parametro4,2);
$InsComprobanteRetencionDetalle1->Parametro5 = round($InsComprobanteRetencionDetalle1->Parametro5,2);
$InsComprobanteRetencionDetalle1->Parametro6 = round($InsComprobanteRetencionDetalle1->Parametro6,2);
$InsComprobanteRetencionDetalle1->Parametro21 = round($InsComprobanteRetencionDetalle1->Parametro21,2);

//$json = new JSON;
//$var = $json->serialize( $InsComprobanteRetencionDetalle1 );
//
//$json->unserialize( $var );
//
//echo $var;

$json = new Services_JSON();
echo $json->encode($InsComprobanteRetencionDetalle1);
?>
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

$Identificador = $_POST['Identificador'];

$POST_Total = (empty($_POST['Total'])?0:$_POST['Total']);
$POST_Retenido = (empty($_POST['Retenido'])?0:$_POST['Retenido']);
$POST_Pagado = (empty($_POST['Pagado'])?0:$_POST['Pagado']);
$POST_PorcentajeRetencion = (empty($_POST['PorcentajeRetencion'])?0:$_POST['PorcentajeRetencion']);

$POST_FechaEmision = $_POST['FechaEmision'];
$POST_Serie = $_POST['Serie'];
$POST_Numero = $_POST['Numero'];
$POST_TipoDocumento = $_POST['TipoDocumento'];

session_start();
if (!isset($_SESSION['InsComprobanteRetencionDetalle'.$Identificador])){
	$_SESSION['InsComprobanteRetencionDetalle'.$Identificador] = new ClsSesionObjeto();
}


/*
SesionObjeto-ComprobanteRetencionDetalleListado
Parametro1 = CedId
Parametro2 = CedTipoDocumento
Parametro3 = 
Parametro4 = CedRetenido
Parametro5 = CedPagado
Parametro6 = CedTotal
Parametro7 = CedTiempoCreacion
Parametro8 = CedTiempoModificacion
Parametro9 = CedSerie
Parametro10 = CedNumero
Parametro11 = CedPorcentajeRetencion
Parametro12 = CedFechaEmision
Parametro13 = CedEstado
*/

$_SESSION['InsComprobanteRetencionDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
NULL,
$POST_TipoDocumento,
NULL,
$POST_Retenido,
$POST_Pagado,
$POST_Total,
date("d/m/Y H:i:s"),
date("d/m/Y H:i:s"),
$POST_Serie,
$POST_Numero,
$POST_PorcentajeRetencion,
$POST_FechaEmision,
3
);

?>
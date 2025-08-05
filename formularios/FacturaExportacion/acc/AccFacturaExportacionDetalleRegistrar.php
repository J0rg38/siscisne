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

session_start();
if (!isset($_SESSION['InsFacturaExportacionDetalle'.$Identificador])){
	$_SESSION['InsFacturaExportacionDetalle'.$Identificador] = new ClsSesionObjeto();
}
/*
SesionObjeto-FacturaDetalleListado
Parametro1 = FedId
Parametro2 = FedDescripcion
Parametro3
Parametro4 = FedPrecio
Parametro5 = FedCantidad
Parametro6 = FedImporte
Parametro7 = FedTiempoCreacion
Parametro8 = FedTiempoModificacion
Parametro9 = AmdId
Parametro10 = AmoId
Parametro11 =
Parametro12 = FedTipo
Parametro13 = FedUnidadMedida
*/

$Cantidad = round($_POST['Cantidad'],2);
$Importe = round($_POST['Importe'],2);
$Precio = round(($Importe/$Cantidad),2);
	
$_SESSION['InsFacturaExportacionDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
NULL,
stripslashes($_POST['Descripcion']),
NULL,
$Precio,
$Cantidad,
$Importe,
date("d/m/Y H:i:s"),
date("d/m/Y H:i:s"),
NULL,
NULL,
NULL,
$_POST['FacturaExportacionDetalleTipo'],
$_POST['UnidadMedida']
);


?>
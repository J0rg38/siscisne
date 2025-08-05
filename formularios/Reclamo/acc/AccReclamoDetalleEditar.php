<?php
require_once('../../../proyecto/ClsProyecto.php');
require_once('../../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../../';
$InsPoo->Ruta  = '../../../';

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

$POST_ReclamoDetalleCantidad = $_POST['ReclamoDetalleCantidad'];
$POST_ReclamoDetallePrecioUnitario = $_POST['ReclamoDetallePrecioUnitario'];
$POST_ReclamoDetalleImporte = $_POST['ReclamoDetalleImporte'];
$POST_ReclamoDetalleObservacion = $_POST['ReclamoDetalleObservacion'];

			
session_start();
if (!isset($_SESSION['InsReclamoDetalle'.$Identificador])){
	$_SESSION['InsReclamoDetalle'.$Identificador] = new ClsSesionObjeto();
}


//SesionObjeto-InsReclamoDetalle
//Parametro1 = RdeId
//Parametro2 = ProId
//Parametro3 = UmeId
//Parametro4 = ProCodigoOriginal
//Parametro5 = ProNombre
//Parametro6 = AmoComprobanteNumero
//Parametro7 = RdeEstado
//Parametro8 = AmdId
//Parametro9 = AmoComprobanteFecha
//Parametro10 = OcoTipo	
//Parametro11 = AmdCantidad	
//Parametro12 = RdeCantidad	
//Parametro13 = RdePrecioUnitario
//Parametro14 = RdeMonto
//Parametro15 = RdeObservacion
//Parametro16 = RdeTiempoCreacion
//Parametro17 = RdeTiempoModificacion
	
$InsReclamoDetalle1 = array();
$InsReclamoDetalle1 = $_SESSION['InsReclamoDetalle'.$Identificador]->MtdObtenerSesionObjeto($_POST['Item']);

$_SESSION['InsReclamoDetalle'.$Identificador]->MtdEditarSesionObjeto($_POST['Item'],1,
$InsReclamoDetalle1->Parametro1,
$InsReclamoDetalle1->Parametro2,
$InsReclamoDetalle1->Parametro3,
$InsReclamoDetalle1->Parametro4,
$InsReclamoDetalle1->Parametro5,
$InsReclamoDetalle1->Parametro6,
$InsReclamoDetalle1->Parametro7,
$InsReclamoDetalle1->Parametro8,
$InsReclamoDetalle1->Parametro9,
$InsReclamoDetalle1->Parametro10,
$POST_ReclamoDetalleCantidad,
$POST_ReclamoDetalleCantidad,
$POST_ReclamoDetallePrecioUnitario,
$POST_ReclamoDetalleImporte,
$POST_ReclamoDetalleObservacion,
$InsReclamoDetalle1->Parametro16,
date("d/m/Y H:i:s")
);

?>
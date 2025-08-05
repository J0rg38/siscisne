<?php
require_once('../../../proyecto/ClsProyecto.php');
require_once('../../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../../';
$InsPoo->Ruta = '../../../';

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

$Identificador = $_POST['Identificador'];
$ModalidadIngreso = $_POST['ModalidadIngreso'];
$POST_TallerPedidoDetalleEstado = $_POST['TallerPedidoDetalleEstado'];
$POST_TallerPedidoDetalleReingreso = $_POST['TallerPedidoDetalleReingreso'];

session_start();
if (!isset($_SESSION['InsTallerPedidoDetalle'.$ModalidadIngreso.$Identificador])){
	$_SESSION['InsTallerPedidoDetalle'.$ModalidadIngreso.$Identificador] = new ClsSesionObjeto();
}


//	SesionObjeto-TallerPedidoDetalle/InsTallerPedidoDetalle
//	Parametro1 = AmdId
//	Parametro2 = ProId
//	Parametro3 = ProNombre
//	Parametro4 = AmdPrecioVenta
//	Parametro5 = AmdCantidad
//	Parametro6 = AmdImporte
//	Parametro7 = AmdTiempoCreacion
//	Parametro8 = AmdTiempoModificacion
//	Parametro9 = UmeNombre
//	Parametro10 = UmeId
//	Parametro11 = RtiId
//	Parametro12 = AmdCantidadReal
//	Parametro13 = ProCodigoOriginal,
//	Parametro14 = ProCodigoAlternativo
//	Parametro15 = UmeIdOrigen
//	Parametro16 = VerificarStock

//	Parametro17 = AmdCosto
//	Parametro18 = Origen
//	Parametro19 = Verificar
//	Parametro20 = FaaId

//	Parametro21 = PmtId
//	Parametro22 = FaaAccion
//	Parametro23 = FaaNivel
//	Parametro24 = FaaVerificar1
//	Parametro25 = 
//	Parametro26 = FapId	
//	Parametro27 = AmdCantidadReal
//	Parametro28 = AmdEstado	
	
	
$InsTallerPedidoDetalle1 = array();
$InsTallerPedidoDetalle1 = $_SESSION['InsTallerPedidoDetalle'.$ModalidadIngreso.$Identificador]->MtdObtenerSesionObjeto($_POST['Item']);

$_SESSION['InsTallerPedidoDetalle'.$ModalidadIngreso.$Identificador]->MtdEditarSesionObjeto($_POST['Item'],1,
$InsTallerPedidoDetalle1->Parametro1,
$InsTallerPedidoDetalle1->Parametro2,
$InsTallerPedidoDetalle1->Parametro3,
$InsTallerPedidoDetalle1->Parametro4,
$InsTallerPedidoDetalle1->Parametro5,
$InsTallerPedidoDetalle1->Parametro6,
$InsTallerPedidoDetalle1->Parametro7,
$InsTallerPedidoDetalle1->Parametro8,
$InsTallerPedidoDetalle1->Parametro9,
$InsTallerPedidoDetalle1->Parametro10,
$InsTallerPedidoDetalle1->Parametro11,
$InsTallerPedidoDetalle1->Parametro12,
$InsTallerPedidoDetalle1->Parametro13,
$InsTallerPedidoDetalle1->Parametro14,
$InsTallerPedidoDetalle1->Parametro15,
$InsTallerPedidoDetalle1->Parametro16,
$InsTallerPedidoDetalle1->Parametro17,
$InsTallerPedidoDetalle1->Parametro18,
$InsTallerPedidoDetalle1->Parametro19,
$InsTallerPedidoDetalle1->Parametro20,
$InsTallerPedidoDetalle1->Parametro21,
$InsTallerPedidoDetalle1->Parametro22,
$InsTallerPedidoDetalle1->Parametro23,
$InsTallerPedidoDetalle1->Parametro24,
$InsTallerPedidoDetalle1->Parametro25,
$InsTallerPedidoDetalle1->Parametro26,
$InsTallerPedidoDetalle1->Parametro27,
$POST_TallerPedidoDetalleEstado,
$InsTallerPedidoDetalle1->Parametro29,
$InsTallerPedidoDetalle1->Parametro30,
$InsTallerPedidoDetalle1->Parametro31,
$InsTallerPedidoDetalle1->Parametro32,
$InsTallerPedidoDetalle1->Parametro33,
$InsTallerPedidoDetalle1->Parametro34,
$InsTallerPedidoDetalle1->Parametro35
);

echo json_encode($_POST);
?>
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

session_start();
if (!isset($_SESSION['InsCotizacionProductoDetalle'.$Identificador])){
	$_SESSION['InsCotizacionProductoDetalle'.$Identificador] = new ClsSesionObjeto();	
}


$CotizacionProductoDetalleEstado = ($_POST['CotizacionProductoDetalleEstado']);

//deb($Precio);
//deb($CotizacionProductoDetalleDescuento);
//deb($CotizacionProductoDetalleAdicional);


	
//						SesionObjeto-CotizacionProductoDetalle
//						Parametro1 = CpdId
//						Parametro2 = ProId
//						Parametro3 = ProNombre
//						Parametro4 = CrdPrecio
//						Parametro5 = CrdCantidad
//						Parametro6 = CrdImporte
//						Parametro7 = CrdTiempoCreacion
//						Parametro8 = CrdTiempoModificacion

//						Parametro9 = UmeNombre
//						Parametro10 = UmeId
//						Parametro11 = RtiId
//						Parametro12 = AmdCantidadReal
//						Parametro13 = ProCodigoOriginal
//						Parametro14 = ProCodigoAlternativo

//						Parametro15 = AmdPrecioVenta
//						Parametro16 = CrdDescripcion
//						Parametro17 = CrdCodigo
//						Parametro18 = CrdValorVenta

//						Parametro19 = UmeIdOrigen
//						Parametro20 = CrdCosto
//						Parametro21 = CrdEstado
//						Parametro22 = CrdTipoPedido
//						Parametro23 = CrdDescuento
//						Parametro24 = CrdPrecioBruto

//						Parametro25 = CrdPorcentajeUtilidad
//						Parametro26 = CrdPorcentajeOtroCosto
//						Parametro27 = CrdPorcentajeManoObra
//						Parametro28 = CrdPorcentajePedido

//						Parametro29 = CrdPorcentajeAdicional
//						Parametro30 = CrdPorcentajeDescuento
//						Parametro31 = CrdAdicional
//						Parametro32 = CrdDescuentoUnitario
//						Parametro33 = CrdImporteBruto
//						Parametro34 = CrdAdicionalUnitario



deb($_POST);

	$InsCotizacionProductoDetalle1 = array();
	$InsCotizacionProductoDetalle1 = $_SESSION['InsCotizacionProductoDetalle'.$Identificador]->MtdObtenerSesionObjeto($_POST['Item']);
	
	$_SESSION['InsCotizacionProductoDetalle'.$Identificador]->MtdEditarSesionObjeto($_POST['Item'],1,
	$InsCotizacionProductoDetalle1->Parametro1,
	$InsCotizacionProductoDetalle1->Parametro2,
	$InsCotizacionProductoDetalle1->Parametro3,
	$InsCotizacionProductoDetalle1->Parametro4,
	$InsCotizacionProductoDetalle1->Parametro5,
	$InsCotizacionProductoDetalle1->Parametro6,
	$InsCotizacionProductoDetalle1->Parametro7,
	date("d/m/Y H:i:s"),
	
	$InsCotizacionProductoDetalle1->Parametro9,
	$InsCotizacionProductoDetalle1->Parametro10,
	$InsCotizacionProductoDetalle1->Parametro11,
	$InsCotizacionProductoDetalle1->Parametro12,
		
	$InsCotizacionProductoDetalle1->Parametro13,
	$InsCotizacionProductoDetalle1->Parametro14,		
	$InsCotizacionProductoDetalle1->Parametro15,
	$InsCotizacionProductoDetalle1->Parametro16,
	$InsCotizacionProductoDetalle1->Parametro17,
	$InsCotizacionProductoDetalle1->Parametro18,
	$InsCotizacionProductoDetalle1->Parametro19,
	$InsCotizacionProductoDetalle1->Parametro20,	
	$CotizacionProductoDetalleEstado ,
	$InsCotizacionProductoDetalle1->Parametro22,	
	$InsCotizacionProductoDetalle1->Parametro23,	
	
	$InsCotizacionProductoDetalle1->Parametro24,	
	
	$InsCotizacionProductoDetalle1->Parametro25,	
	$InsCotizacionProductoDetalle1->Parametro26,	
	$InsCotizacionProductoDetalle1->Parametro27,	
	$InsCotizacionProductoDetalle1->Parametro28,	
	
	$InsCotizacionProductoDetalle1->Parametro29,	
	$InsCotizacionProductoDetalle1->Parametro30,	
	
	$InsCotizacionProductoDetalle1->Parametro31,	
	$InsCotizacionProductoDetalle1->Parametro32,	
	$InsCotizacionProductoDetalle1->Parametro33,	
	$InsCotizacionProductoDetalle1->Parametro34);


?>
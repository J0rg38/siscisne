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

$POST_AlmacenMovimientoId = (($_POST['AlmacenMovimientoId']=="undefined")?"":$_POST['AlmacenMovimientoId']);
$POST_VehiculoMovimientoId = (($_POST['VehiculoMovimientoId']=="undefined")?"":$_POST['VehiculoMovimientoId']);
$POST_FacturaAlmacenMovimientoId = $_POST['FacturaAlmacenMovimientoId'];



require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMovimientoSalida.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMovimientoSalidaDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoSalida.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoSalidaDetalle.php');

//$InsAlmacenMovimientoSalidaDetalle = new ClsAlmacenMovimientoSalidaDetalle();

session_start();
if (!isset($_SESSION['InsFacturaAlmacenMovimiento'.$Identificador])){
	$_SESSION['InsFacturaAlmacenMovimiento'.$Identificador] = new ClsSesionObjeto();
}

if (!isset($_SESSION['InsFacturaDetalle'.$Identificador])){
	$_SESSION['InsFacturaDetalle'.$Identificador] = new ClsSesionObjeto();
}


	//SesionObjeto-FacturaAlmacenMovimiento
	//Parametro1 = FamId
	//Parametro2 = AmoId
	//Parametro3 = 
	//Parametro4 = 
	//Parametro5 = FamEstado
	//Parametro6 = FamTiempoCreacion
	//Parametro7 = FamTiempoModificacion

	
$ResSesionObjeto = $_SESSION['InsFacturaAlmacenMovimiento'.$Identificador]->MtdVerificarExisteSesionObjeto($_POST['AlmacenMovimientoSalidaId']);
$ArrSesionObjeto = $ResSesionObjeto['Datos'];

if(!$ResSesionObjeto['Existe']){
	
	$_SESSION['InsFacturaAlmacenMovimiento'.$Identificador]->MtdAgregarSesionObjeto(1,
	$POST_FacturaAlmacenMovimientoId,
	$POST_AlmacenMovimientoId,
	NULL,
	NULL,
	3,
	date("d/m/Y H:i:s"),
	date("d/m/Y H:i:s")
	);	
	
//
//	$ResAlmacenMovimientoSalidaDetalle = $InsAlmacenMovimientoSalidaDetalle->MtdObtenerAlmacenMovimientoSalidaDetalles(NULL,NULL,NULL,'AmdId','Desc',NULL,$_POST['AlmacenMovimientoSalidaId']);
//	$ArrAlmacenMovimientoSalidaDetalles = $ResAlmacenMovimientoSalidaDetalle['Datos'];
//	
//	foreach($ArrAlmacenMovimientoSalidaDetalles  as $DatAlmacenMovimientoSalidaDetalle){
//	
///*
//SesionObjeto-FacturaDetalleListado
//Parametro1 = FdeId
//Parametro2 = FdeDescripcion
//Parametro5 = Cantidad
//Parametro6 = Importe
//Parametro7 = TiempoCreacion
//Parametro8 = TiempoModificacion
//Parametro9 = AmdId
//Parametro10 = AlmacenMovimientoSalidaId
//Parametro11 = VtaId;
//Parametro12 = FdeTipo
//*/
//
//		$_SESSION['InsFacturaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
//		NULL,
//		$DatAlmacenMovimientoSalidaDetalle->ProNombre,
//		NULL,
//		$DatAlmacenMovimientoSalidaDetalle->AmdCosto,
//		$DatAlmacenMovimientoSalidaDetalle->AmdCantidad,
//		$DatAlmacenMovimientoSalidaDetalle->AmdImporte,
//		date("d/m/Y H:i:s"),
//		date("d/m/Y H:i:s"),
//		$DatAlmacenMovimientoSalidaDetalle->AmdId,
//		$DatAlmacenMovimientoSalidaDetalle->AmoId
//		);
//		
//	}
}

?>
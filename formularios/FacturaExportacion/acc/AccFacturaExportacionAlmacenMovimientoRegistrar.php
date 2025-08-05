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

require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoSalidaDetalle.php');

$InsAlmacenMovimientoSalidaDetalle = new ClsAlmacenMovimientoSalidaDetalle();

session_start();
if (!isset($_SESSION['InsFacturaExportacionAlmacenMovimiento'.$Identificador])){
	$_SESSION['InsFacturaExportacionAlmacenMovimiento'.$Identificador] = new ClsSesionObjeto();
}

if (!isset($_SESSION['InsFacturaExportacionDetalle'.$Identificador])){
	$_SESSION['InsFacturaExportacionDetalle'.$Identificador] = new ClsSesionObjeto();
}

//list($VtaNumero,$VtaId,$AmoId) = explode("%",$_POST['AlmacenMovimientoSalida']);
/*
SesionObjeto-FacturaExportacionAlmacenMovimientoListado
Parametro1 = NevId
Parametro2 = VtaIdAmoId
Parametro3 = AmoId
Parametro4 = VtaId
Parametro5 = VtaNumero
*/

$ResSesionObjeto = $_SESSION['InsFacturaExportacionAlmacenMovimiento'.$Identificador]->MtdVerificarExisteSesionObjeto($_POST['AlmacenMovimientoId']);
$ArrSesionObjeto = $ResSesionObjeto['Datos'];

if(!$ResSesionObjeto['Existe']){
	
	$_SESSION['InsFacturaExportacionAlmacenMovimiento'.$Identificador]->MtdAgregarSesionObjeto(1,
	NULL,
	$_POST['AlmacenMovimientoId'],
	$_POST['AlmacenMovimientoId']
	);		
	
	$ResAlmacenMovimientoSalidaDetalle = $InsAlmacenMovimientoSalidaDetalle->MtdObtenerAlmacenMovimientoSalidaDetalles(NULL,NULL,NULL,'AmdId','Desc',NULL,$_POST['AlmacenMovimientoId']);
	$ArrAlmacenMovimientoSalidaDetalles = $ResAlmacenMovimientoSalidaDetalle['Datos'];

	foreach($ArrAlmacenMovimientoSalidaDetalles  as $DatAlmacenMovimientoSalidaDetalle){

		$_SESSION['InsFacturaExportacionDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
		NULL,
		$DatAlmacenMovimientoSalidaDetalle->ProNombre,
		NULL,
		$DatAlmacenMovimientoSalidaDetalle->AmdCosto,
		$DatAlmacenMovimientoSalidaDetalle->AmdCantidad,
		$DatAlmacenMovimientoSalidaDetalle->AmdImporte,
		(date("d/m/Y H:i:s")),
		(date("d/m/Y H:i:s")),
		$DatAlmacenMovimientoSalidaDetalle->AmdId,
		$DatAlmacenMovimientoSalidaDetalle->AmoId
		);	

	}
	
	
}



?>
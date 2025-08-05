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
$POST_BoletaAlmacenMovimientoId = $_POST['BoletaAlmacenMovimientoId'];


require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMovimientoSalida.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMovimientoSalidaDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoSalida.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoSalidaDetalle.php');

//$InsAlmacenMovimientoSalidaDetalle = new ClsAlmacenMovimientoSalidaDetalle();


session_start();
if (!isset($_SESSION['InsBoletaAlmacenMovimiento'.$Identificador])){
	$_SESSION['InsBoletaAlmacenMovimiento'.$Identificador] = new ClsSesionObjeto();
}

if (!isset($_SESSION['InsBoletaDetalle'.$Identificador])){
	$_SESSION['InsBoletaDetalle'.$Identificador] = new ClsSesionObjeto();
}

//list($VtaNumero,$VtaId,$AmoId) = explode("%",$_POST['AlmacenMovimientoSalida']);
if(!empty($POST_VehiculoMovimientoId)){
	
	$InsVehiculoMovimientoSalida = new ClsVehiculoMovimientoSalida();
	$InsVehiculoMovimientoSalida->VmvId = $POST_VehiculoMovimientoId;
	$InsVehiculoMovimientoSalida->MtdObtenerVehiculoMovimientoSalida(false);
	
	$ResSesionObjeto = $_SESSION['InsBoletaAlmacenMovimiento'.$Identificador]->MtdVerificarExisteSesionObjeto12($_POST['VehiculoMovimientoId']);
	$ArrSesionObjeto = $ResSesionObjeto['Datos'];
	
	if(!$ResSesionObjeto['Existe']){
		
		//SesionObjeto-BoletaAlmacenMovimiento
		//Parametro1 = BamId
		//Parametro2 = AmoId
		//Parametro3 = 
		//Parametro4 = 
		//Parametro5 = BamEstado
		//Parametro6 = BamTiempoCreacion
		//Parametro7 = BamTiempoModificacion
		//Parametro8 = FinId
		//Parametro9 = FccId
		//Parametro10 = AmoFecha
		//Parametro11 = AmoSubTipo
		//Parametro12 = VmvId
		//Parametro13 = VmvFecha
		//Parametro14 = VmvSubTipo
	
		$_SESSION['InsBoletaAlmacenMovimiento'.$Identificador]->MtdAgregarSesionObjeto(1,
		NULL,
		NULL,
		NULL,
		NULL,
		3,
		date("d/m/Y H:i:s"),
		date("d/m/Y H:i:s"),
		NULL,
		NULL,
		NULL,
		NULL,
		$POST_VehiculoMovimientoId,
		$InsAlmacenMovimientoSalida->VmvFecha,
		$InsAlmacenMovimientoSalida->VmvSubTipo		
		);		
		
	}

}else{
	
	$InsAlmacenMovimientoSalida = new ClsAlmacenMovimientoSalida();
	$InsAlmacenMovimientoSalida->AmoId = $POST_AlmacenMovimientoId;
	$InsAlmacenMovimientoSalida->MtdObtenerAlmacenMovimientoSalida(false);
	
	
	$ResSesionObjeto = $_SESSION['InsBoletaAlmacenMovimiento'.$Identificador]->MtdVerificarExisteSesionObjeto($_POST['AlmacenMovimientoId']);
	$ArrSesionObjeto = $ResSesionObjeto['Datos'];
	
	if(!$ResSesionObjeto['Existe']){
		
		//SesionObjeto-BoletaAlmacenMovimiento
		//Parametro1 = BamId
		//Parametro2 = AmoId
		//Parametro3 = 
		//Parametro4 = 
		//Parametro5 = BamEstado
		//Parametro6 = BamTiempoCreacion
		//Parametro7 = BamTiempoModificacion
		//Parametro8 = FinId
		//Parametro9 = FccId
		//Parametro10 = AmoFecha
		//Parametro11 = AmoSubTipo
		//Parametro12 = VmvId
		//Parametro13 = VmvFecha
		//Parametro14 = VmvSubTipo
	
		$_SESSION['InsBoletaAlmacenMovimiento'.$Identificador]->MtdAgregarSesionObjeto(1,
		NULL,
		$POST_AlmacenMovimientoId,
		NULL,
		NULL,
		3,
		date("d/m/Y H:i:s"),
		date("d/m/Y H:i:s"),
		$InsAlmacenMovimientoSalida->FinId,
		$InsAlmacenMovimientoSalida->FccId,
		$InsAlmacenMovimientoSalida->AmoFecha,
		$InsAlmacenMovimientoSalida->AmoSubTipo,
		NULL,
		NULL,
		NULL
		
		);		
		
	//	$ResAlmacenMovimientoSalidaDetalle = $InsAlmacenMovimientoSalidaDetalle->MtdObtenerAlmacenMovimientoSalidaDetalles(NULL,NULL,NULL,'AmdId','Desc',NULL,$_POST['AlmacenMovimientoId']);
	//	$ArrAlmacenMovimientoSalidaDetalles = $ResAlmacenMovimientoSalidaDetalle['Datos'];
	//
	//	foreach($ArrAlmacenMovimientoSalidaDetalles  as $DatAlmacenMovimientoSalidaDetalle){
	//
	//		$_SESSION['InsBoletaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
	//		NULL,
	//		$DatAlmacenMovimientoSalidaDetalle->ProNombre,
	//		NULL,
	//		$DatAlmacenMovimientoSalidaDetalle->AmdCosto,
	//		$DatAlmacenMovimientoSalidaDetalle->AmdCantidad,
	//		$DatAlmacenMovimientoSalidaDetalle->AmdImporte,
	//		(date("d/m/Y H:i:s")),
	//		(date("d/m/Y H:i:s")),
	//		$DatAlmacenMovimientoSalidaDetalle->AmdId,
	//		$DatAlmacenMovimientoSalidaDetalle->AmoId
	//		);	
	//
	//	}
		
		
	}

}






?>
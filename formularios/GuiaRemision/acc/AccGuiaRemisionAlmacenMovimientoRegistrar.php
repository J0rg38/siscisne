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


require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoSalidaDetalle.php');

$InsAlmacenMovimientoSalidaDetalle = new ClsAlmacenMovimientoSalidaDetalle();

$Identificador = $_POST['Identificador'];

$POST_GuiaRemisionAlmacenMovimientoId = $_POST['GuiaRemisionAlmacenMovimientoId'];
$POST_AlmacenMovimientoId = $_POST['AlmacenMovimientoId'];
$POST_VehiculoMovimientoId = $_POST['VehiculoMovimientoId'];
$POST_AlmacenMovimientoSubTipo = $_POST['AlmacenMovimientoSubTipo'];
$POST_VehiculoMovimientoSubTipo = $_POST['VehiculoMovimientoSubTipo'];

$POST_AlmacenMovimientoFecha = $_POST['AlmacenMovimientoFecha'];
$POST_VehiculoMovimientoFecha = $_POST['VehiculoMovimientoFecha'];


session_start();
if (!isset($_SESSION['InsGuiaRemisionAlmacenMovimiento'.$Identificador])){
	$_SESSION['InsGuiaRemisionAlmacenMovimiento'.$Identificador] = new ClsSesionObjeto();
}

if (!isset($_SESSION['InsGuiaRemisionDetalle'.$Identificador])){
	$_SESSION['InsGuiaRemisionDetalle'.$Identificador] = new ClsSesionObjeto();
}


	//SesionObjeto-GuiaRemisionAlmacenMovimiento
	//Parametro1 = GamId
	//Parametro2 = 
	//Parametro3 = 
	//Parametro4 = AmoId
	//Parametro5 = GamEstado
	//Parametro6 = GamTiempoCreacion
	//Parametro7 = GamTiempoModificacion
	//Parametro8 = VmvId
	//Parametro9 = VmvFecha
	//Parametro10 = AmoFecha
	//Parametro11 = AmoSubTipo
	//Parametro12 = VmvSubTipo

if(!empty($POST_AlmacenMovimientoId)){
		
	$ResSesionObjeto = $_SESSION['InsGuiaRemisionAlmacenMovimiento'.$Identificador]->MtdVerificarExisteSesionObjeto($POST_AlmacenMovimientoId);
	$ArrSesionObjeto = $ResSesionObjeto['Datos'];
	
	if(!$ResSesionObjeto['Existe']){
		
		$_SESSION['InsGuiaRemisionAlmacenMovimiento'.$Identificador]->MtdAgregarSesionObjeto(1,
		$POST_GuiaRemisionAlmacenMovimientoId,
		NULL,
		NULL,
		$POST_AlmacenMovimientoId,
		3,
		date("d/m/Y H:i:s"),
		date("d/m/Y H:i:s"),
		NULL,
		NULL,
		$POST_AlmacenMovimientoFecha,
		$POST_AlmacenMovimientoSubTipo,
		NULL
		);	
		
	}

}else{
	
	$ResSesionObjeto = $_SESSION['InsGuiaRemisionAlmacenMovimiento'.$Identificador]->MtdVerificarExisteSesionObjeto8($POST_VehiculoMovimientoId);
	$ArrSesionObjeto = $ResSesionObjeto['Datos'];
	
	if(!$ResSesionObjeto['Existe']){
		
		$_SESSION['InsGuiaRemisionAlmacenMovimiento'.$Identificador]->MtdAgregarSesionObjeto(1,
		$POST_GuiaRemisionAlmacenMovimientoId,
		NULL,
		NULL,
		NULL,
		3,
		date("d/m/Y H:i:s"),
		date("d/m/Y H:i:s"),
		$POST_VehiculoMovimientoId,
		$POST_VehiculoMovimientoFecha,
		NULL,
		NULL,
		$POST_VehiculoMovimientoSubTipo
		);	
		
	}
}


?>
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

session_start();
if (!isset($_SESSION['InsVehiculoProformaDetalle'.$Identificador])){
	$_SESSION['InsVehiculoProformaDetalle'.$Identificador] = new ClsSesionObjeto();
}

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngreso.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoModelo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersion.php');

$InsVehiculoIngreso = new ClsVehiculoIngreso();

$InsVehiculoMarca = new ClsVehiculoMarca();
$InsVehiculoModelo = new ClsVehiculoModelo();
$InsVehiculoVersion = new ClsVehiculoVersion();


$POST_VehiculoIngresoId = $_POST['VehiculoIngresoId'];
$POST_VehiculoIngresoVIN = $_POST['VehiculoIngresoVIN'];

$POST_VehiculoMarcaId = $_POST['VehiculoMarcaId'];
$POST_VehiculoModeloId = $_POST['VehiculoModeloId'];
$POST_VehiculoVersionId = $_POST['VehiculoVersionId'];

$POST_VehiculoIngresoAnoFabricacion = $_POST['VehiculoIngresoAnoFabricacion'];
$POST_VehiculoIngresoAnoModelo = $_POST['VehiculoIngresoAnoModelo'];
$POST_VehiculoIngresoNumeroMotor = $_POST['VehiculoIngresoNumeroMotor'];

$POST_VehiculoIngresoColor = $_POST['VehiculoIngresoColor'];

$POST_VehiculoProformaDetalleCosto = $_POST['VehiculoProformaDetalleCosto'];


//if(!empty($POST_VehiculoIngresoId)){

//	$InsVehiculoIngreso->MtdEditarVehiculoIngresoDato("VmaId",$POST_VehiculoMarcaId,$POST_VehiculoIngresoId);
//	$InsVehiculoIngreso->MtdEditarVehiculoIngresoDato("VmoId",$POST_VehiculoModeloId,$POST_VehiculoIngresoId);
//	$InsVehiculoIngreso->MtdEditarVehiculoIngresoDato("VveId",$POST_VehiculoVersionId,$POST_VehiculoIngresoId);
//	
//	$InsVehiculoIngreso->MtdEditarVehiculoIngresoDato("EinAnoFabricacion",$POST_VehiculoIngresoAnoFabricacion,$POST_VehiculoIngresoId);
//	$InsVehiculoIngreso->MtdEditarVehiculoIngresoDato("EinAnoModelo",$POST_VehiculoIngresoAnoModelo,$POST_VehiculoIngresoId);
//	$InsVehiculoIngreso->MtdEditarVehiculoIngresoDato("EinNumeroMotor",$POST_VehiculoIngresoNumeroMotor,$POST_VehiculoIngresoId);
//	
//	$InsVehiculoIngreso->MtdEditarVehiculoIngresoDato("EinColor",$POST_VehiculoIngresoColor,$POST_VehiculoIngresoId);

	$InsVehiculoIngreso->EinId = $POST_VehiculoIngresoId;
	$InsVehiculoIngreso->MtdObtenerVehiculoIngreso(false);
	
	$InsVehiculoMarca->VmaId = $POST_VehiculoMarcaId;
	$InsVehiculoMarca->MtdObtenerVehiculoMarca();
	
	$InsVehiculoModelo->VmoId = $POST_VehiculoModeloId;
	$InsVehiculoModelo->MtdObtenerVehiculoModelo();
	
	$InsVehiculoVersion->VveId = $POST_VehiculoVersionId;
	$InsVehiculoVersion->MtdObtenerVehiculoVersion(false);

	
	$InsVehiculoProformaDetalle1 = array();
	$InsVehiculoProformaDetalle1 = $_SESSION['InsVehiculoProformaDetalle'.$Identificador]->MtdObtenerSesionObjeto($_POST['Item']);
	
	/*
	SesionObjeto-VehiloListaPrecioDetalle
	Parametro1 = VpdId
	Parametro2 = EinId
	Parametro3 = 
	Parametro4 = VmaId
	Parametro5 = VmoId
	Parametro6 = VveId
	
	Parametro7 = VpdTiempoCreacion
	Parametro8 = VpdTiempoModificacion
	
	Parametro9 = VpdCosto
	Parametro10 = 
	Parametro11 = 
	
	Parametro12 = VmaNombre
	Parametro13 = VmoNombre
	Parametro14 = VveNombre
	Parametro15 = EinVIN
	Parametro16 = EinColor
	Parametro17 = EinAnoFabricacion
	Parametro18 = EinAnoModelo
	
	Parametro19 = EinNumeroMotor
	*/
	
	$_SESSION['InsVehiculoProformaDetalle'.$Identificador]->MtdEditarSesionObjeto($_POST['Item'],1,
	$InsVehiculoProformaDetalle1->Parametro1,
	$POST_VehiculoIngresoId,
	NULL,
	$InsVehiculoMarca->VmaId,
	$InsVehiculoModelo->VmoId,
	$InsVehiculoVersion->VveId,
	
	$InsVehiculoProformaDetalle1->Parametro7,
	date("d/m/Y H:i:s"),
	
	$POST_VehiculoProformaDetalleCosto,
	NULL,
	NULL,

	$InsVehiculoMarca->VmaNombre,
	$InsVehiculoModelo->VmoNombre,
	$InsVehiculoVersion->VveNombre,
	
	$POST_VehiculoIngresoVIN,
	$POST_VehiculoIngresoColor,
	
	$POST_VehiculoIngresoAnoFabricacion,
	$POST_VehiculoIngresoAnoModelo,
	
	$POST_VehiculoIngresoNumeroMotor
	);
	
	
//}


	
	

?>
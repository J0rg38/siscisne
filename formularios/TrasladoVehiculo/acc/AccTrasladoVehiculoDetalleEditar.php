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

$POST_Item = $_POST['Item'];
$Identificador = $_POST['Identificador'];
$POST_VehiculoId = $_POST['VehiculoId'];

$POST_VehiculoIngresoId = $_POST['VehiculoIngresoId'];
$POST_VehiculoIngresoVIN = $_POST['VehiculoIngresoVIN'];
$POST_VehiculoCodigoIdentificador = $_POST['VehiculoCodigoIdentificador'];

$POST_VehiculoIngresoNumeroMotor = $_POST['VehiculoIngresoNumeroMotor'];
$POST_VehiculoIngresoAnoFabricacion = $_POST['VehiculoIngresoAnoFabricacion'];
$POST_VehiculoIngresoAnoModelo = $_POST['VehiculoIngresoAnoModelo'];

$POST_VehiculoIngresoColor = $_POST['VehiculoIngresoColor'];
$POST_VehiculoIngresoColorInterior = $_POST['VehiculoIngresoColorInterior'];

$POST_Costo = $_POST['TrasladoVehiculoDetalleCosto'];
$POST_Cantidad = $_POST['TrasladoVehiculoDetalleCantidad'];
$POST_Importe = $_POST['TrasladoVehiculoDetalleImporte'];
$POST_Estado = $_POST['TrasladoVehiculoDetalleEstado'];
$POST_Observacion = addslashes($_POST['TrasladoVehiculoDetalleObservacion']);

$POST_CostoAnterior = $_POST['TrasladoVehiculoDetalleCostoAnterior'];
$POST_Utilidad = $_POST['TrasladoVehiculoDetalleUtilidad'];
$POST_UtilidadPorcentaje = $_POST['TrasladoVehiculoDetalleUtilidadPorcentaje'];

$POST_VehiculoIngresoMarca = $_POST['VehiculoIngresoMarca'];
$POST_VehiculoIngresoModelo = $_POST['VehiculoIngresoModelo'];
$POST_VehiculoIngresoVersion = $_POST['VehiculoIngresoVersion'];

$POST_VehiculoIngresoMarcaId = $_POST['VehiculoIngresoMarcaId'];
$POST_VehiculoIngresoModeloId = $_POST['VehiculoIngresoModeloId'];
$POST_VehiculoIngresoVersionId = $_POST['VehiculoIngresoVersionId'];

session_start();
if (!isset($_SESSION['InsTrasladoVehiculoDetalle'.$Identificador])){
	$_SESSION['InsTrasladoVehiculoDetalle'.$Identificador] = new ClsSesionObjeto();
}

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngreso.php');

$InsVehiculo = new ClsVehiculo();
$InsVehiculoIngreso = new ClsVehiculoIngreso();

$InsVehiculoIngreso->EinId = $POST_VehiculoIngresoId;
$InsVehiculoIngreso->MtdObtenerVehiculoIngreso(false);


//SesionObjeto-TrasladoVehiculoDetalle
//Parametro1 = TvdId
//Parametro2 = EinId
//Parametro3 = EinVIN

//Parametro4 = 
//Parametro5 = TvdCantidad
//Parametro6 = 
//Parametro7 = TvdTiempoCreacion
//Parametro8 = TvdTiempoModificacion

//Parametro9 = EinNumeroMotor
//Parametro10 = EinAnoFabricacion
//Parametro11 = EinAnoModelo
//Parametro12 = VehId

//Parametro13 = 
//Parametro14 = 
//Parametro15 = TvdObservacion
//Parametro16 = UmeId
//Parametro17 = EinColor
//Parametro18 = EinColorInterior
//Parametro19 = VmaNombre
//Parametro20 = VmoNombre
//Parametro21 = VveNombre
//Parametro22 = VmaId
//Parametro23 = VmoId
//Parametro24 = VveId
//Parametro25 = TvdEstado
//Parametro26 = VehCodigoIdentificador
	
	$InsTrasladoVehiculoDetalle1 = array();
	$InsTrasladoVehiculoDetalle1 = $_SESSION['InsTrasladoVehiculoDetalle'.$Identificador]->MtdObtenerSesionObjeto($POST_Item);
	

	$_SESSION['InsTrasladoVehiculoDetalle'.$Identificador]->MtdEditarSesionObjeto($POST_Item,1,
	$InsTrasladoVehiculoDetalle1->Parametro1,
	$InsTrasladoVehiculoDetalle1->Parametro2,
	$InsTrasladoVehiculoDetalle1->Parametro3,
	0,
	1,
	0,
	$InsTrasladoVehiculoDetalle1->Parametro7,
	date("d/m/Y H:i:s"),
	
	$InsTrasladoVehiculoDetalle1->Parametro9,
	$InsTrasladoVehiculoDetalle1->Parametro10,
	$InsTrasladoVehiculoDetalle1->Parametro11,
	$POST_VehiculoId,
	$InsTrasladoVehiculoDetalle1->Parametro13,
	$InsTrasladoVehiculoDetalle1->Parametro14,
	$POST_Observacion,
	$InsTrasladoVehiculoDetalle1->Parametro16,
	$InsTrasladoVehiculoDetalle1->Parametro17,
	
	$InsTrasladoVehiculoDetalle1->Parametro18,
	$InsTrasladoVehiculoDetalle1->Parametro19,
	$InsTrasladoVehiculoDetalle1->Parametro20,
	$InsTrasladoVehiculoDetalle1->Parametro21,
	$InsTrasladoVehiculoDetalle1->Parametro22,
	$InsTrasladoVehiculoDetalle1->Parametro23,
	$InsTrasladoVehiculoDetalle1->Parametro24,
	
	$POST_Estado,
	
	$POST_VehiculoCodigoIdentificador
	);

?>
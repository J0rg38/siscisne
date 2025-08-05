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
$POST_VehiculoId = $_POST['VehiculoId'];
$POST_VehiculoCodigoIdentificador = $_POST['VehiculoCodigoIdentificador'];

$POST_VehiculoIngresoId = $_POST['VehiculoIngresoId'];
$POST_VehiculoIngresoVIN = $_POST['VehiculoIngresoVIN'];
$POST_VehiculoIngresoNumeroMotor = $_POST['VehiculoIngresoNumeroMotor'];
$POST_VehiculoIngresoAnoFabricacion = $_POST['VehiculoIngresoAnoFabricacion'];
$POST_VehiculoIngresoAnoModelo = $_POST['VehiculoIngresoAnoModelo'];

$POST_VehiculoIngresoColor = $_POST['VehiculoIngresoColor'];
$POST_VehiculoIngresoColorInterior = $_POST['VehiculoIngresoColorInterior'];

$POST_Costo = $_POST['VehiculoMovimientoSalidaDetalleCosto'];
$POST_CostoIngreso = $_POST['VehiculoMovimientoSalidaDetalleCostoIngreso'];
$POST_Cantidad = $_POST['VehiculoMovimientoSalidaDetalleCantidad'];
$POST_Importe = $_POST['VehiculoMovimientoSalidaDetalleImporte'];
$POST_Estado = $_POST['VehiculoMovimientoSalidaDetalleEstado'];
$POST_Observacion = addslashes($_POST['VehiculoMovimientoSalidaDetalleObservacion']);
//$POST_UnidadMedida = "UME-10007";
$POST_VehiculoMovimientoSalidaDetalleUnidadMedida = $_POST['VehiculoMovimientoSalidaDetalleUnidadMedida'];

$POST_CostoAnterior = $_POST['VehiculoMovimientoSalidaDetalleCostoAnterior'];
$POST_Utilidad = $_POST['VehiculoMovimientoSalidaDetalleUtilidad'];
$POST_UtilidadPorcentaje = $_POST['VehiculoMovimientoSalidaDetalleUtilidadPorcentaje'];

$POST_VehiculoIngresoMarca = $_POST['VehiculoIngresoMarca'];
$POST_VehiculoIngresoModelo = $_POST['VehiculoIngresoModelo'];
$POST_VehiculoIngresoVersion = $_POST['VehiculoIngresoVersion'];

$POST_VehiculoIngresoMarcaId = $_POST['VehiculoIngresoMarcaId'];
$POST_VehiculoIngresoModeloId = $_POST['VehiculoIngresoModeloId'];
$POST_VehiculoIngresoVersionId = $_POST['VehiculoIngresoVersionId'];


session_start();
if (!isset($_SESSION['InsVehiculoMovimientoSalidaDetalle'.$Identificador])){
	$_SESSION['InsVehiculoMovimientoSalidaDetalle'.$Identificador] = new ClsSesionObjeto();
}

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngreso.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedida.php');

$InsVehiculo = new ClsVehiculo();
$InsVehiculoIngreso = new ClsVehiculoIngreso();
$InsUnidadMedida = new ClsUnidadMedida();

$InsVehiculoIngreso->EinId = $POST_VehiculoIngresoId ;
$InsVehiculoIngreso->MtdObtenerVehiculoIngreso(false);

$InsUnidadMedida->UmeId = $POST_VehiculoMovimientoSalidaDetalleUnidadMedida ;
$InsUnidadMedida->MtdObtenerUnidadMedida(false);



//SesionObjeto-VehiculoMovimientoEntradaDetalle
//Parametro1 = VmdId
//Parametro2 = EinId
//Parametro3 = EinVIN

//Parametro4 = VmdCosto
//Parametro5 = VmdCantidad
//Parametro6 = VmdImporte
//Parametro7 = VmdTiempoCreacion
//Parametro8 = VmdTiempoModificacion

//Parametro9 = EinNumeroMotor
//Parametro10 = EinAnoFabricacion
//Parametro11 = EinAnoModelo
//Parametro12 = VehId

//Parametro13 = VmdUtilidad
//Parametro14 = VmdUtilidadPorcentaje
//Parametro15 = VmdCostoAnterior
//Parametro16 = 
//Parametro17 = EinColor
//Parametro18 = EinColorInterior
//Parametro19 = VmaNombre
//Parametro20 = VmoNombre
//Parametro21 = VveNombre
//Parametro22 = VmaId
//Parametro23 = VmoId
//Parametro24 = VveId
//Parametro25 = VmdEstado
//Parametro26 = VehCodigoIdentificador
//Parametro27 = UmeId
//Parametro28 = UmeNombre
//Parametro29 = VmdCostoIngreso

	$Cantidad = round($POST_Cantidad,3);
	
	$Importe = round($POST_Importe,3);
	$Costo = round(($Importe/$Cantidad),3);
	$CostoAnterior = round($POST_CostoAnterior,3);
	
	$Utilidad = round($POST_Utilidad,3);
	$UtilidadPorcentaje = round($POST_UtilidadPorcentaje,3);
	
	$_SESSION['InsVehiculoMovimientoSalidaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
	NULL,
	$POST_VehiculoIngresoId,
	$POST_VehiculoIngresoVIN,
	$Costo,
	$Cantidad,
	$Importe,
	date("d/m/Y H:i:s"),
	date("d/m/Y H:i:s"),
	
	$POST_VehiculoIngresoNumeroMotor,
	$POST_VehiculoIngresoAnoFabricacion,
	$POST_VehiculoIngresoAnoModelo,
	$POST_VehiculoId,
	
	$Utilidad,
	$UtilidadPorcentaje,
	$CostoAnterior,
	$POST_Observacion,
	
	$POST_VehiculoIngresoColor,
	$POST_VehiculoIngresoColorInterior,
	$POST_VehiculoIngresoMarca,
	$POST_VehiculoIngresoModelo,
	$POST_VehiculoIngresoVersion,	
	$POST_VehiculoIngresoMarcaId,
	$POST_VehiculoIngresoModeloId,
	$POST_VehiculoIngresoVersionId,
	
	3,
	$POST_VehiculoCodigoIdentificador,
	
	$POST_VehiculoMovimientoSalidaDetalleUnidadMedida,
	$InsUnidadMedida->UmeNombre,
	$POST_CostoIngreso
	);


?>
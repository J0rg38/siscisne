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

$POST_VehiculoIngresoId = $_POST['VehiculoIngresoId'];
$POST_VehiculoIngresoVIN = $_POST['VehiculoIngresoVIN'];
$POST_VehiculoIngresoNumeroMotor = $_POST['VehiculoIngresoNumeroMotor'];
$POST_VehiculoIngresoAnoFabricacion = $_POST['VehiculoIngresoAnoFabricacion'];
$POST_VehiculoIngresoAnoModelo = $_POST['VehiculoIngresoAnoModelo'];

$POST_VehiculoIngresoColor = $_POST['VehiculoIngresoColor'];
$POST_VehiculoIngresoColorInterior = $_POST['VehiculoIngresoColorInterior'];

$POST_Costo = $_POST['CompraVehiculoDetalleCosto'];
$POST_Cantidad = $_POST['CompraVehiculoDetalleCantidad'];
$POST_Importe = $_POST['CompraVehiculoDetalleImporte'];
$POST_Estado = $_POST['CompraVehiculoDetalleEstado'];

$POST_CostoAnterior = $_POST['CompraVehiculoDetalleCostoAnterior'];
$POST_Utilidad = $_POST['CompraVehiculoDetalleUtilidad'];
$POST_UtilidadPorcentaje = $_POST['CompraVehiculoDetalleUtilidadPorcentaje'];

$POST_VehiculoIngresoMarca = $_POST['VehiculoIngresoMarca'];
$POST_VehiculoIngresoModelo = $_POST['VehiculoIngresoModelo'];
$POST_VehiculoIngresoVersion = $_POST['VehiculoIngresoVersion'];

$POST_VehiculoIngresoMarcaId = $_POST['VehiculoIngresoMarcaId'];
$POST_VehiculoIngresoModeloId = $_POST['VehiculoIngresoModeloId'];
$POST_VehiculoIngresoVersionId = $_POST['VehiculoIngresoVersionId'];

session_start();
if (!isset($_SESSION['InsCompraVehiculoDetalle'.$Identificador])){
	$_SESSION['InsCompraVehiculoDetalle'.$Identificador] = new ClsSesionObjeto();
}

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngreso.php');

$InsVehiculo = new ClsVehiculo();
$InsVehiculoIngreso = new ClsVehiculoIngreso();

$InsVehiculoIngreso->EinId = $POST_VehiculoIngresoId ;
$InsVehiculoIngreso->MtdObtenerVehiculoIngreso(false);

//SesionObjeto-CompraVehiculoDetalle
//Parametro1 = CvdId
//Parametro2 = EinId
//Parametro3 = EinVIN

//Parametro4 = CvdCosto
//Parametro5 = CvdCantidad
//Parametro6 = CvdImporte
//Parametro7 = CvdTiempoCreacion
//Parametro8 = CvdTiempoModificacion

//Parametro9 = EinNumeroMotor
//Parametro10 = EinAnoFabricacion
//Parametro11 = EinAnoModelo
//Parametro12 = VehId

//Parametro13 = CvdUtilidad
//Parametro14 = CvdUtilidadPorcentaje
//Parametro15 = CvdCostoAnterior
//Parametro16 = 
//Parametro17 = EinColor
//Parametro18 = EinColorInterior
//Parametro19 = VmaNombre
//Parametro20 = VmoNombre
//Parametro21 = VveNombre
//Parametro22 = VmaId
//Parametro23 = VmoId
//Parametro24 = VveId
//Parametro25 = CvdEstado

	$Cantidad = round($POST_Cantidad,3);
	
	$Importe = round($POST_Importe,3);
	$Costo = round(($Importe/$Cantidad),3);
	$CostoAnterior = round($POST_CostoAnterior,3);
	
	$Utilidad = round($POST_Utilidad,3);
	$UtilidadPorcentaje = round($POST_UtilidadPorcentaje,3);
	
	$_SESSION['InsCompraVehiculoDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
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
	NULL,
	
	$POST_VehiculoIngresoColor,
	$POST_VehiculoIngresoColorInterior,
	$POST_VehiculoIngresoMarca,
	$POST_VehiculoIngresoModelo,
	$POST_VehiculoIngresoVersion,	
	$POST_VehiculoIngresoMarcaId,
	$POST_VehiculoIngresoModeloId,
	$POST_VehiculoIngresoVersionId,
	
	$POST_Estado
	);


?>
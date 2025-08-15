<?php
session_start();
require_once('../../../proyecto/ClsProyecto.php');
require_once('../../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../../';
$InsPoo->Ruta = '../../../';

////CONFIGURACIONES GENERALES
require_once($InsProyecto->MtdRutConfiguraciones() . 'CnfSistema.php');
require_once($InsProyecto->MtdRutConfiguraciones() . 'CnfEmpresa.php');
require_once($InsProyecto->MtdRutConfiguraciones() . 'CnfConexion.php');
////MENSAJES GENERALES
require_once($InsProyecto->MtdRutMensajes() . 'MsjGeneral.php');
////CLASES GENERALES
require_once($InsProyecto->MtdRutClases() . 'ClsSesion.php');
require_once($InsProyecto->MtdRutClases() . 'ClsSesionObjeto.php');
require_once($InsProyecto->MtdRutClases() . 'ClsMensaje.php');
require_once($InsProyecto->MtdRutLibrerias() . 'PHPMailer_5.2.4/class.phpmailer.php');
require_once($InsProyecto->MtdRutClases() . 'ClsCorreo.php');

////CLASES GENERALES
require_once($InsProyecto->MtdRutConexiones() . 'ClsConexion.php');
require_once($InsProyecto->MtdRutClases() . 'ClsMysql.php');
////FUNCIONES GENERALES
require_once($InsProyecto->MtdRutFunciones() . 'FncGeneral.php');



require_once($InsProyecto->MtdRutLibrerias() . 'JSON.php');
require_once($InsProyecto->MtdRutLibrerias() . 'JSON2.php');

$POST_Campo = $_POST['Campo'] ?? '';
$POST_Dato = $_POST['Dato'] ?? '';
$POST_Fecha = $_POST['Fecha'] ?? '';
//$POST_Moneda = $_POST['Moneda'];

require_once($InsPoo->MtdPaqAlmacen() . 'ClsVehiculoIngreso.php');
require_once($InsPoo->MtdPaqAlmacen() . 'ClsVehiculoIngresoCliente.php');
require_once($InsPoo->MtdPaqAlmacen() . 'ClsVehiculoIngresoFoto.php');;

require_once($InsPoo->MtdPaqActividad() . 'ClsFichaIngreso.php');


require_once($InsPoo->MtdPaqActividad() . 'ClsPlanMantenimiento.php');
require_once($InsPoo->MtdPaqActividad() . 'ClsPlanMantenimientoDetalle.php');
require_once($InsPoo->MtdPaqActividad() . 'ClsPlanMantenimientoSeccion.php');
require_once($InsPoo->MtdPaqActividad() . 'ClsPlanMantenimientoTarea.php');
require_once($InsPoo->MtdPaqContabilidad() . 'ClsTipoCambio.php');



$InsFichaIngreso = new ClsFichaIngreso();
$InsVehiculoIngreso = new ClsVehiculoIngreso();

$ResVehiculoIngreso = $InsVehiculoIngreso->MtdObtenerVehiculoIngresos("ein.Ein" . $POST_Campo, "comienza", $POST_Dato, "Ein" . $POST_Campo, "ASC", NULL, NULL, NULL, NULL);
$ArrVehiculosIngresos = $ResVehiculoIngreso['Datos'];

// Verificar que se encontraron datos antes de procesar
if (!empty($ArrVehiculosIngresos) && isset($ArrVehiculosIngresos[0]->EinId)) {
	$InsVehiculoIngreso->EinId = $ArrVehiculosIngresos[0]->EinId;
	unset($ArrVehiculosIngresos);

	$InsVehiculoIngreso->MtdObtenerVehiculoIngreso(FALSE);
	$InsVehiculoIngreso->EinFechaVenta = FncCambiaFechaANormal($InsVehiculoIngreso->EinFechaVenta, true);
} else {
	// Si no hay datos, devolver respuesta vacía
	$json = new Services_JSON();
	echo $json->encode(null);
	exit;
}

//deb($InsVehiculoIngreso);

$InsVehiculoIngreso->InsMysql = NULL;

if (empty($InsVehiculoIngreso->CliId)) {

	if (!empty($InsVehiculoIngreso->VehiculoIngresoCliente)) {
		foreach ($InsVehiculoIngreso->VehiculoIngresoCliente as $DatVehiculoIngresoCliente) {

			$InsVehiculoIngreso->CliId = $DatVehiculoIngresoCliente->CliId;
		}
	}
}

$InsPlanMantenimiento = new ClsPlanMantenimiento();
$ResPlanMantenimiento = $InsPlanMantenimiento->MtdObtenerPlanMantenimientos(NULL, NULL, NULL, 'PmaId', 'ASC', 1, NULL, NULL, $InsVehiculoIngreso->VmoId);
$ArrPlanMantenimientos = $ResPlanMantenimiento['Datos'];

$InsPlanMantenimiento->PmaId = $ArrPlanMantenimientos[0]->PmaId;
unset($ArrPlanMantenimientos);
$InsPlanMantenimiento->MtdObtenerPlanMantenimiento();
$InsVehiculoIngreso->PmaId = $InsPlanMantenimiento->PmaId;




$InsVehiculoIngreso->EinCostoIngreso = (empty($InsVehiculoIngreso->VmdCostoIngreso) ? 0 : $InsVehiculoIngreso->EinCostoIngreso);

$TipoCambio = NULL;

if (!empty($InsVehiculoIngreso->MonIdIngreso)) {

	$InsTipoCambio = new ClsTipoCambio();
	$InsTipoCambio->MonId = $InsVehiculoIngreso->MonIdIngreso;
	$InsTipoCambio->TcaFecha = date("Y-m-d");
	$InsTipoCambio->MtdObtenerTipoCambioFecha();

	if (empty($InsTipoCambio->TcaId)) {

		$InsTipoCambio->MtdObtenerTipoCambioUltimo();
	}

	//deb($InsTipoCambio);

	$TipoCambio = $InsTipoCambio->TcaMontoVenta;
}


$InsVehiculoIngreso->EinTipoCambioIngreso = $TipoCambio;

//$_SESSION['SesVehiculoIngresoId'] = $InsVehiculoIngreso->EinId; 
$json = new Services_JSON();
$var = $json->encode($InsVehiculoIngreso);

echo $var;

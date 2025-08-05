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

$VehiculoIngresoId = $_POST['VehiculoIngresoId'];
$VehiculoIngresoVIN = $_POST['VehiculoIngresoVIN'];

$VehiculoMarcaId = $_POST['VehiculoMarcaId'];
$VehiculoModeloId = $_POST['VehiculoModeloId'];
$VehiculoVersionId = $_POST['VehiculoVersionId'];

$VehiculoIngresoColor = $_POST['VehiculoIngresoColor'];
$VehiculoProformaDetalleCosto = $_POST['VehiculoProformaDetalleCosto'];

$VehiculoIngresoAnoFabricacion = $_POST['VehiculoIngresoAnoFabricacion'];
$VehiculoIngresoAnoModelo = $_POST['VehiculoIngresoAnoModelo'];
$VehiculoIngresoNumeroMotor = $_POST['VehiculoIngresoNumeroMotor'];

$InsVehiculoIngreso->EinId = $VehiculoIngresoId;
$InsVehiculoIngreso->MtdObtenerVehiculoIngreso(false);

$InsVehiculoMarca->VmaId = $VehiculoMarcaId;
$InsVehiculoMarca->MtdObtenerVehiculoMarca();

$InsVehiculoModelo->VmoId = $VehiculoModeloId;
$InsVehiculoModelo->MtdObtenerVehiculoModelo();

$InsVehiculoVersion->VveId = $VehiculoVersionId;
$InsVehiculoVersion->MtdObtenerVehiculoVersion(false);

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
	
	$_SESSION['InsVehiculoProformaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
	NULL,
	$VehiculoIngresoId,
	NULL,
	$VehiculoMarcaId,
	$VehiculoModeloId,
	$VehiculoVersionId,

	date("d/m/Y H:i:s"),
	date("d/m/Y H:i:s"),
	
	$VehiculoProformaDetalleCosto,
	NULL,
	NULL,
	$InsVehiculoMarca->VmaNombre,
	$InsVehiculoModelo->VmoNombre,
	$InsVehiculoVersion->VveNombre,
	$VehiculoIngresoVIN,
	$VehiculoIngresoColor,
	
	$VehiculoIngresoAnoFabricacion,
	$VehiculoIngresoAnoModelo,
	$VehiculoIngresoNumeroMotor
	);


?>
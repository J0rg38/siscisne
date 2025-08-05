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
if (!isset($_SESSION['InsCompraVehiculoDetalle'.$Identificador])){
	$_SESSION['InsCompraVehiculoDetalle'.$Identificador] = new ClsSesionObjeto();
}

require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedidaConversion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedida.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculo.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVehiculoVersion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoAno.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsListaPrecio.php');
//require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoCosto.php');

$InsVehiculo = new ClsVehiculo();
$InsUnidadMedida = new ClsUnidadMedida();
$InsUnidadMedidaConversion = new ClsUnidadMedidaConversion();

$InsVehiculo->ProId = $_POST['VehiculoId'];
$InsVehiculo->MtdObtenerVehiculo(false);


//SesionObjeto-CompraVehiculoDetalle
//Parametro1 = CvdId
//Parametro2 = ProId
//Parametro3 = Nombre
//Parametro4 = Costo
//Parametro5 = Cantidad
//Parametro6 = Importe
//Parametro7 = TiempoCreacion
//Parametro8 = TiempoModificacion
//Parametro9 = UnidadMedidaNombreConvertir
//Parametro10 = UnidadMedidaConvertir
//Parametro11 = Tipo
//Parametro12 = CantidadReal
//Parametro13 = Utilidad
//Parametro14 = UtilidadPorcentaje
//Parametro15 = CostoAnterior
//Parametro16 = CostoTotal
//Parametro17 = ProCodigoOriginal
//Parametro18 = ProCodigoAlternativo
//Parametro19 = UmeIdOrigen
//Parametro20 = CvdIdOrigen
//Parametro21 = PcdId
//Parametro22 = PcoId
//Parametro23 = PcoFecha
//Parametro24 = CliNombreCompleto
//Parametro25 = CvdEstado
				
	
	$InsCompraVehiculoDetalle1 = array();
	$InsCompraVehiculoDetalle1 = $_SESSION['InsCompraVehiculoDetalle'.$Identificador]->MtdObtenerSesionObjeto($_POST['Item']);
	
	$_SESSION['InsCompraVehiculoDetalle'.$Identificador]->MtdEditarSesionObjeto($_POST['Item'],1,
	$InsCompraVehiculoDetalle1->Parametro1,
	$InsVehiculo->ProId,
	$InsVehiculo->ProNombre,
	$InsCompraVehiculoDetalle1->Parametro4,
	$InsCompraVehiculoDetalle1->Parametro5,
	$InsCompraVehiculoDetalle1->Parametro6,
	$InsCompraVehiculoDetalle1->Parametro7,
	date("d/m/Y H:i:s"),
	//$InsUnidadMedida->UmeNombre,
//	$InsUnidadMedida->UmeId,

$InsCompraVehiculoDetalle1->Parametro9,
$InsCompraVehiculoDetalle1->Parametro10,

	$InsCompraVehiculoDetalle1->Parametro11,
	$InsCompraVehiculoDetalle1->Parametro12,
	$InsCompraVehiculoDetalle1->Parametro13,
	$InsCompraVehiculoDetalle1->Parametro14,
	$InsCompraVehiculoDetalle1->Parametro15,
	NULL,
	$InsVehiculo->ProCodigoOriginal,
	$InsVehiculo->ProCodigoAlternativo,
	$InsCompraVehiculoDetalle1->Parametro19,
	$InsCompraVehiculoDetalle1->Parametro20,
	$InsCompraVehiculoDetalle1->Parametro21,
	$InsCompraVehiculoDetalle1->Parametro22,
	$InsCompraVehiculoDetalle1->Parametro23,
	$InsCompraVehiculoDetalle1->Parametro24,
	$InsCompraVehiculoDetalle1->Parametro25
	);

?>
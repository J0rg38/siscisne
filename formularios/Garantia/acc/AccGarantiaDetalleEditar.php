<?php
require_once('../../../proyecto/ClsProyecto.php');
require_once('../../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../../';
$InsPoo->Ruta  = '../../../';

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

session_start();
if (!isset($_SESSION['InsGarantiaDetalle'.$Identificador])){
	$_SESSION['InsGarantiaDetalle'.$Identificador] = new ClsSesionObjeto();
}

require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');


//SesionObjeto-InsGarantiaDetalle
//Parametro1 = GdeId
//Parametro2 = ProId
//Parametro3 = UmeId
//Parametro4 = GdeCodigo
//Parametro5 = GdeDescripcion
//Parametro6 = GdeCosto
//Parametro7 = GdeCantidad
//Parametro8 = GdeCostoTotal	
//Parametro9 = GdeEstado	
//Parametro10 = GdeTiempoCreacion		
//Parametro11 = GdeTiempoModificacion	
//Parametro12 = GdeMargen
//Parametro13 = GdeCostoMargen
//Parametro14 = AmdId

//Parametro15 = ProCodigoOriginal
//Parametro16 = ProNombre
//Parametro17 = UmeNombre
	
$InsGarantiaDetalle1 = array();
$InsGarantiaDetalle1 = $_SESSION['InsGarantiaDetalle'.$Identificador]->MtdObtenerSesionObjeto($_POST['Item']);

$ProductoId = ($_POST['ProductoId']);
$UnidadMedidaId = ($_POST['UnidadMedidaId']);

$GarantiaDetalleCantidad = ($_POST['GarantiaDetalleCantidad']);
$GarantiaDetalleCostoTotal = ($_POST['GarantiaDetalleCostoTotal']);
$GarantiaDetalleCosto = ($GarantiaDetalleCostoTotal/$GarantiaDetalleCantidad);

//$GarantiaDetalleMargen = ($_POST['GarantiaDetalleMargen']);
//$GarantiaDetalleCostoMargen = ($_POST['GarantiaDetalleCostoMargen']);
$GarantiaDetalleMargen = 0;
$GarantiaDetalleCostoMargen = 0;

$InsProducto = new ClsProducto();
$InsProducto->ProId = $ProductoId;
$InsProducto->MtdObtenerProducto(false);



$_SESSION['InsGarantiaDetalle'.$Identificador]->MtdEditarSesionObjeto($_POST['Item'],1,
$InsGarantiaDetalle1->Parametro1,
$InsGarantiaDetalle1->Parametro2,
$InsGarantiaDetalle1->Parametro3,
NULL,
NULL,
$GarantiaDetalleCosto,
$GarantiaDetalleCantidad,
$GarantiaDetalleCostoTotal,
1,
$InsGarantiaDetalle1->Parametro10,
date("d/m/Y H:i:s"),

$GarantiaDetalleMargen,
$GarantiaDetalleCostoMargen,
NULL,

$InsGarantiaDetalle1->Parametro15,
$InsGarantiaDetalle1->Parametro16,
$InsGarantiaDetalle1->Parametro17

);

?>
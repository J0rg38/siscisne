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
if (!isset($_SESSION['InsGarantiaRepuestoIsuzuDetalle'.$Identificador])){
	$_SESSION['InsGarantiaRepuestoIsuzuDetalle'.$Identificador] = new ClsSesionObjeto();
}

require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');


//SesionObjeto-InsGarantiaRepuestoIsuzuDetalle
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
	
$InsGarantiaRepuestoIsuzuDetalle1 = array();
$InsGarantiaRepuestoIsuzuDetalle1 = $_SESSION['InsGarantiaRepuestoIsuzuDetalle'.$Identificador]->MtdObtenerSesionObjeto($_POST['Item']);

$ProductoId = ($_POST['ProductoId']);
$UnidadMedidaId = ($_POST['UnidadMedidaId']);

$GarantiaRepuestoIsuzuDetalleCantidad = ($_POST['GarantiaRepuestoIsuzuDetalleCantidad']);
$GarantiaRepuestoIsuzuDetalleCostoTotal = ($_POST['GarantiaRepuestoIsuzuDetalleCostoTotal']);
$GarantiaRepuestoIsuzuDetalleCosto = ($GarantiaRepuestoIsuzuDetalleCostoTotal/$GarantiaRepuestoIsuzuDetalleCantidad);

//$GarantiaRepuestoIsuzuDetalleMargen = ($_POST['GarantiaRepuestoIsuzuDetalleMargen']);
//$GarantiaRepuestoIsuzuDetalleCostoMargen = ($_POST['GarantiaRepuestoIsuzuDetalleCostoMargen']);
$GarantiaRepuestoIsuzuDetalleMargen = 0;
$GarantiaRepuestoIsuzuDetalleCostoMargen = 0;

$InsProducto = new ClsProducto();
$InsProducto->ProId = $ProductoId;
$InsProducto->MtdObtenerProducto(false);



$_SESSION['InsGarantiaRepuestoIsuzuDetalle'.$Identificador]->MtdEditarSesionObjeto($_POST['Item'],1,
$InsGarantiaRepuestoIsuzuDetalle1->Parametro1,
$InsGarantiaRepuestoIsuzuDetalle1->Parametro2,
$InsGarantiaRepuestoIsuzuDetalle1->Parametro3,
NULL,
NULL,
$GarantiaRepuestoIsuzuDetalleCosto,
$GarantiaRepuestoIsuzuDetalleCantidad,
$GarantiaRepuestoIsuzuDetalleCostoTotal,
1,
$InsGarantiaRepuestoIsuzuDetalle1->Parametro10,
date("d/m/Y H:i:s"),

$GarantiaRepuestoIsuzuDetalleMargen,
$GarantiaRepuestoIsuzuDetalleCostoMargen,
NULL,

$InsGarantiaRepuestoIsuzuDetalle1->Parametro15,
$InsGarantiaRepuestoIsuzuDetalle1->Parametro16,
$InsGarantiaRepuestoIsuzuDetalle1->Parametro17

);

?>
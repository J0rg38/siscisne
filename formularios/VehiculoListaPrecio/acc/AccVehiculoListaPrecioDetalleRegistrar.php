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
if (!isset($_SESSION['InsVehiculoListaPrecioDetalle'.$Identificador])){
	$_SESSION['InsVehiculoListaPrecioDetalle'.$Identificador] = new ClsSesionObjeto();
}

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoModelo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersion.php');

$InsVehiculoMarca = new ClsVehiculoMarca();
$InsVehiculoModelo = new ClsVehiculoModelo();
$InsVehiculoVersion = new ClsVehiculoVersion();
/*
SesionObjeto-VehiloListaPrecioDetalle
Parametro1 = VldId
Parametro2 = 
Parametro3 = VldFuente
Parametro4 = VmaId
Parametro5 = VmoId
Parametro6 = VveId
Parametro7 = VldTiempoCreacion
Parametro8 = VldTiempoModificacion

Parametro9 = VldCosto
Parametro10 = VldPrecioCierre
Parametro11 = VldPrecioLista

Parametro12 = VmaNombre
Parametro13 = VmoNombre
Parametro14 = VveNombre
Parametro15 = VldTexto

Parametro16 = VldBonoGM
Parametro17 = VldBonoDealer
Parametro18 = VldDescuentoGerencia
*/
	
$VehiculoListaPrecioDetalleFuente = $_POST['VehiculoListaPrecioDetalleFuente'];
$VehiculoListaPrecioDetalleCosto = $_POST['VehiculoListaPrecioDetalleCosto'];
$VehiculoListaPrecioDetallePrecioCierre = $_POST['VehiculoListaPrecioDetallePrecioCierre'];
$VehiculoListaPrecioDetallePrecioLista = $_POST['VehiculoListaPrecioDetallePrecioLista'];

$VehiculoListaPrecioDetalleBonoGM = (empty($_POST['VehiculoListaPrecioDetalleBonoGM'])?0:$_POST['VehiculoListaPrecioDetalleBonoGM']);
$VehiculoListaPrecioDetalleBonoDealer = (empty($_POST['VehiculoListaPrecioDetalleBonoDealer'])?0:$_POST['VehiculoListaPrecioDetalleBonoDealer']);
$VehiculoListaPrecioDetalleDescuentoGerencia = (empty($_POST['VehiculoListaPrecioDetalleDescuentoGerencia'])?0:$_POST['VehiculoListaPrecioDetalleDescuentoGerencia']);


$VehiculoMarcaId = $_POST['VehiculoMarcaId'];
$VehiculoModeloId = $_POST['VehiculoModeloId'];
$VehiculoVersionId = $_POST['VehiculoVersionId'];

$InsVehiculoMarca->VmaId = $VehiculoMarcaId;
$InsVehiculoMarca->MtdObtenerVehiculoMarca();

$InsVehiculoModelo->VmoId = $VehiculoModeloId;
$InsVehiculoModelo->MtdObtenerVehiculoModelo();

$InsVehiculoVersion->VveId = $VehiculoVersionId;
$InsVehiculoVersion->MtdObtenerVehiculoVersion(false);




	$_SESSION['InsVehiculoListaPrecioDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
	NULL,
	NULL,
	($VehiculoListaPrecioDetalleFuente),
	$VehiculoMarcaId,
	$VehiculoModeloId,
	$VehiculoVersionId,
	
	date("d/m/Y H:i:s"),
	date("d/m/Y H:i:s"),
	
	$VehiculoListaPrecioDetalleCosto,
	$VehiculoListaPrecioDetallePrecioCierre,
	$VehiculoListaPrecioDetallePrecioLista,

	$InsVehiculoMarca->VmaNombre,
	$InsVehiculoModelo->VmoNombre,
	$InsVehiculoVersion->VveNombre,
	NULL,
	
	$VehiculoListaPrecioDetalleBonoGM,
	$VehiculoListaPrecioDetalleBonoDealer,
	$VehiculoListaPrecioDetalleDescuentoGerencia
	);
/*
SesionObjeto-VehiloListaPrecioDetalle
Parametro1 = VldId
Parametro2 = 
Parametro3 = VldFuente
Parametro4 = VmaId
Parametro5 = VmoId
Parametro6 = VveId
Parametro7 = VldTiempoCreacion
Parametro8 = VldTiempoModificacion

Parametro9 = VldCosto
Parametro10 = VldPrecioCierre
Parametro11 = VldPrecioLista

Parametro12 = VmaNombre
Parametro13 = VmoNombre
Parametro14 = VveNombre
Parametro15 = VldTexto

Parametro16 = VldBonoGM
Parametro17 = VldBonoDealer
Parametro18 = VldDescuentoGerencia
*/

?>
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
if (!isset($_SESSION['InsGarantiaOperacion'.$Identificador])){
	$_SESSION['InsGarantiaOperacion'.$Identificador] = new ClsSesionObjeto();
}

	//SesionObjeto-InsGarantiaOperacion
	//Parametro1 = GopId
	//Parametro2 = GopNumero
	//Parametro3 = GopTiempo
	//Parametro4 = GopValor
	//Parametro5 = GopCosto
	//Parametro6 = GopEstado
	//Parametro7 = GopTiempoCreacion
	//Parametro8 = GopTiempoModificacion
	
	//Parametro9 = GopTransaccionNumero
	//Parametro10 = GopTransaccionFecha
	//Parametro11 = GopFechaAprobacion
	//Parametro12 = GopFechaPago	

$GarantiaOperacionNumero = ($_POST['GarantiaOperacionNumero']);
$GarantiaOperacionTiempo = ($_POST['GarantiaOperacionTiempo']);
$GarantiaOperacionValor = ($_POST['GarantiaOperacionValor']);
$GarantiaOperacionCosto = ($_POST['GarantiaOperacionCosto']);

$GarantiaOperacionTransaccionNumero = ($_POST['GarantiaOperacionTransaccionNumero']);
$GarantiaOperacionTransaccionFecha = ($_POST['GarantiaOperacionTransaccionFecha']);
$GarantiaOperacionFechaAprobacion = ($_POST['GarantiaOperacionFechaAprobacion']);
$GarantiaOperacionFechaPago = ($_POST['GarantiaOperacionFechaPago']);
$GarantiaOperacionComprobanteNumero = ($_POST['GarantiaOperacionComprobanteNumero']);

//$GarantiaOperacionEstado = ($_POST['GarantiaOperacionEstado']);
$GarantiaOperacionEstado = 3;

$_SESSION['InsGarantiaOperacion'.$Identificador]->MtdAgregarSesionObjeto(1,
NULL,
$GarantiaOperacionNumero,
$GarantiaOperacionTiempo,
$GarantiaOperacionValor,
$GarantiaOperacionCosto,
$GarantiaOperacionEstado,
date("d/m/Y H:i:s"),
date("d/m/Y H:i:s"),

$GarantiaOperacionTransaccionNumero,
$GarantiaOperacionTransaccionFecha,
$GarantiaOperacionFechaAprobacion,
$GarantiaOperacionFechaPago,
$GarantiaOperacionComprobanteNumero
);

?>
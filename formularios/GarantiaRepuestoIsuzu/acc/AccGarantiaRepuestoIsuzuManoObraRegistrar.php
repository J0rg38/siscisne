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
if (!isset($_SESSION['InsGarantiaRepuestoIsuzuManoObra'.$Identificador])){
	$_SESSION['InsGarantiaRepuestoIsuzuManoObra'.$Identificador] = new ClsSesionObjeto();
}

	//SesionObjeto-InsGarantiaRepuestoIsuzuManoObra
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

$GarantiaRepuestoIsuzuManoObraNumero = ($_POST['GarantiaRepuestoIsuzuManoObraNumero']);
$GarantiaRepuestoIsuzuManoObraTiempo = ($_POST['GarantiaRepuestoIsuzuManoObraTiempo']);
$GarantiaRepuestoIsuzuManoObraValor = ($_POST['GarantiaRepuestoIsuzuManoObraValor']);
$GarantiaRepuestoIsuzuManoObraCosto = ($_POST['GarantiaRepuestoIsuzuManoObraCosto']);

$GarantiaRepuestoIsuzuManoObraTransaccionNumero = ($_POST['GarantiaRepuestoIsuzuManoObraTransaccionNumero']);
$GarantiaRepuestoIsuzuManoObraTransaccionFecha = ($_POST['GarantiaRepuestoIsuzuManoObraTransaccionFecha']);
$GarantiaRepuestoIsuzuManoObraFechaAprobacion = ($_POST['GarantiaRepuestoIsuzuManoObraFechaAprobacion']);
$GarantiaRepuestoIsuzuManoObraFechaPago = ($_POST['GarantiaRepuestoIsuzuManoObraFechaPago']);
$GarantiaRepuestoIsuzuManoObraComprobanteNumero = ($_POST['GarantiaRepuestoIsuzuManoObraComprobanteNumero']);

//$GarantiaRepuestoIsuzuManoObraEstado = ($_POST['GarantiaRepuestoIsuzuManoObraEstado']);
$GarantiaRepuestoIsuzuManoObraEstado = 3;

$_SESSION['InsGarantiaRepuestoIsuzuManoObra'.$Identificador]->MtdAgregarSesionObjeto(1,
NULL,
$GarantiaRepuestoIsuzuManoObraNumero,
$GarantiaRepuestoIsuzuManoObraTiempo,
$GarantiaRepuestoIsuzuManoObraValor,
$GarantiaRepuestoIsuzuManoObraCosto,
$GarantiaRepuestoIsuzuManoObraEstado,
date("d/m/Y H:i:s"),
date("d/m/Y H:i:s"),

$GarantiaRepuestoIsuzuManoObraTransaccionNumero,
$GarantiaRepuestoIsuzuManoObraTransaccionFecha,
$GarantiaRepuestoIsuzuManoObraFechaAprobacion,
$GarantiaRepuestoIsuzuManoObraFechaPago,
$GarantiaRepuestoIsuzuManoObraComprobanteNumero
);

?>
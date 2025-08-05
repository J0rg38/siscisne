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

$POST_ClienteId = $_POST['ClienteId'];
$POST_VehiculoIngresoClienteFecha = $_POST['VehiculoIngresoClienteFecha'];
$POST_VehiculoIngresoClienteEstado = $_POST['VehiculoIngresoClienteEstado'];


session_start();
if (!isset($_SESSION['InsVehiculoIngresoCliente'.$Identificador])){
	$_SESSION['InsVehiculoIngresoCliente'.$Identificador] = new ClsSesionObjeto();
}

require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');

$InsCliente = new ClsCliente();
$InsCliente->CliId = $POST_ClienteId;
$InsCliente->MtdObtenerCliente();

//SesionObjeto-VehiculoIngresoCliente
//Parametro1 = VicId
//Parametro2 = CliId
//Parametro3 = CliNombre
//Parametro4 = CliNumeroDocumento
//Parametro5 = TdoId
//Parametro6 = CliId
//Parametro7 = VicTiempoCreacion
//Parametro8 = VicTiempoModificacion
//Parametro9 = TdoNombre

//Parametro10 = VicEstado
//Parametro11 = VicFecha

$_SESSION['InsVehiculoIngresoCliente'.$Identificador]->MtdAgregarSesionObjeto(1,
NULL,
$InsCliente->CliId,
$InsCliente->CliNombre." ".$InsCliente->CliApellidoPaterno." ".$InsCliente->CliApellidoMaterno,
$InsCliente->CliNumeroDocumento,
$InsCliente->TdoId,
$InsCliente->CliId,
date("d/m/Y H:i:s"),
date("d/m/Y H:i:s"),
$InsCliente->TdoNombre,

$POST_VehiculoIngresoClienteEstado,
$POST_VehiculoIngresoClienteFecha
);

?>
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

$POST_Item = $_POST['Item'];
$Identificador = $_POST['Identificador'];
$POST_ClienteId = $_POST['PropietarioId'];
$POST_OrdenVentaVehiculoFirmaDJ = $_POST['OrdenVentaVehiculoFirmaDJ'];

session_start();
if (!isset($_SESSION['InsOrdenVentaVehiculoPropietario'.$Identificador])){
	$_SESSION['InsOrdenVentaVehiculoPropietario'.$Identificador] = new ClsSesionObjeto();
}

require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');

$InsCliente = new ClsCliente();
$InsCliente->CliId = $POST_ClienteId;
$InsCliente->MtdObtenerCliente(false);


	
//SesionObjeto-OrdenVentaVehiculoPropietario
//Parametro1 = CviId
//Parametro2 = 
//Parametro3 = CliNombre
//Parametro4 = CliNumeroDocumento
//Parametro5 = TdoId
//Parametro6 = CliId
//Parametro7 = CviTiempoCreacion
//Parametro8 = CviTiempoModificacion
//Parametro9 = TdoNombre

//Parametro10 = CliTelefono
//Parametro11 = CliCelular
//Parametro12 = CliEmail

//Parametro13 = CliNombre
//Parametro14 = CliApellidoPaterno
//Parametro15 = CliApellidoMaterno

	$InsOrdenVentaVehiculoPropietario1 = array();
	$InsOrdenVentaVehiculoPropietario1 = $_SESSION['InsOrdenVentaVehiculoPropietario'.$Identificador]->MtdObtenerSesionObjeto($POST_Item);
	
	$_SESSION['InsOrdenVentaVehiculoPropietario'.$Identificador]->MtdEditarSesionObjeto($POST_Item,1,
	$InsOrdenVentaVehiculoPropietario1->Parametro1,
	NULL,
	$InsCliente->CliNombre." ".$InsCliente->CliApellidoPaterno." ".$InsCliente->CliApellidoMaterno,
	$InsCliente->CliNumeroDocumento,
	$InsCliente->TdoId,
	$InsOrdenVentaVehiculoPropietario1->Parametro6,
	$InsOrdenVentaVehiculoPropietario1->Parametro7,
	date("d/m/Y H:i:s"),
	$InsCliente->TdoNombre,
	
	$InsCliente->CliTelefono,
	$InsCliente->CliCelular,
	$InsCliente->CliEmail,
	
	$InsCliente->CliNombre,
	$InsCliente->CliApellidoPaterno,
	$InsCliente->CliApellidoMaterno,
	$POST_OrdenVentaVehiculoFirmaDJ
	);

?>
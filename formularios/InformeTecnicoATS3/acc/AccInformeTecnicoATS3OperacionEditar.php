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
if (!isset($_SESSION['InsInformeTecnicoATS3Operacion'.$Identificador])){
	$_SESSION['InsInformeTecnicoATS3Operacion'.$Identificador] = new ClsSesionObjeto();
}


//SesionObjeto-InsInformeTecnicoATS3Operacion
//Parametro1 = ItoId
//Parametro2 = ItoNumero
//Parametro3 = ItoTiempo
//Parametro4 = ItoCostoHora
//Parametro5 = ItoValorTotal
//Parametro6 = ItoEstado
//Parametro7 = ItoTiempoCreacion
//Parametro8 = ItoTiempoModificacion
//Parametro9 = FaeId

$InsInformeTecnicoATS3Operacion1 = array();
$InsInformeTecnicoATS3Operacion1 = $_SESSION['InsInformeTecnicoATS3Operacion'.$Identificador]->MtdObtenerSesionObjeto($_POST['Item']);

$InformeTecnicoATS3OperacionNumero = ($_POST['InformeTecnicoATS3OperacionNumero']);
$InformeTecnicoATS3OperacionTiempo = ($_POST['InformeTecnicoATS3OperacionTiempo']);
$InformeTecnicoATS3OperacionCostoHora = ($_POST['InformeTecnicoATS3OperacionCostoHora']);
$InformeTecnicoATS3OperacionValorTotal = ($_POST['InformeTecnicoATS3OperacionValorTotal']);

$_SESSION['InsInformeTecnicoATS3Operacion'.$Identificador]->MtdEditarSesionObjeto($_POST['Item'],1,
$InsInformeTecnicoATS3Operacion1->Parametro1,
$InformeTecnicoATS3OperacionNumero,
$InformeTecnicoATS3OperacionTiempo,
$InformeTecnicoATS3OperacionCostoHora,
$InformeTecnicoATS3OperacionValorTotal,
$InsInformeTecnicoATS3Operacion1->Parametro6,
$InsInformeTecnicoATS3Operacion1->Parametro7,
date("d/m/Y H:i:s"),
$InsInformeTecnicoATS3Operacion1->Parametro9
);

?>
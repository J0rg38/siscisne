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
if (!isset($_SESSION['InsFichaIngresoLlamada'.$Identificador])){
	$_SESSION['InsFichaIngresoLlamada'.$Identificador] = new ClsSesionObjeto();
}

//SesionObjeto-InsFichaIngresoLlamada
//Parametro1 = GopId
//Parametro2 = GopNumero
//Parametro3 = GopFecha
//Parametro4 = GopValor
//Parametro5 = GopObservacion
//Parametro6 = GopEstado
//Parametro7 = GopFechaCreacion
//Parametro8 = GopFechaModificacion
	
$InsFichaIngresoLlamada1 = array();
$InsFichaIngresoLlamada1 = $_SESSION['InsFichaIngresoLlamada'.$Identificador]->MtdObtenerSesionObjeto($_POST['Item']);

$FichaIngresoLlamadaNumero = ($_POST['FichaIngresoLlamadaNumero']);
$FichaIngresoLlamadaFecha = ($_POST['FichaIngresoLlamadaFecha']);
$FichaIngresoLlamadaValor = ($_POST['FichaIngresoLlamadaValor']);
$FichaIngresoLlamadaObservacion = ($_POST['FichaIngresoLlamadaObservacion']);

$_SESSION['InsFichaIngresoLlamada'.$Identificador]->MtdEditarSesionObjeto($_POST['Item'],1,
$InsFichaIngresoLlamada1->Parametro1,
$FichaIngresoLlamadaNumero,
$FichaIngresoLlamadaFecha,
$FichaIngresoLlamadaValor,
$FichaIngresoLlamadaObservacion,
3,
$InsFichaIngresoLlamada1->Parametro7,
date("d/m/Y H:i:s")
);

?>
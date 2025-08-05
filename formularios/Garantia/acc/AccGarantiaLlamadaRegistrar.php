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
if (!isset($_SESSION['InsGarantiaLlamada'.$Identificador])){
	$_SESSION['InsGarantiaLlamada'.$Identificador] = new ClsSesionObjeto();
}


//SesionObjeto-InsGarantiaLlamada
//Parametro1 = GopId
//Parametro2 = GopNumero
//Parametro3 = GopFecha
//Parametro4 = GopValor
//Parametro5 = GopObservacion
//Parametro6 = GopEstado
//Parametro7 = GopFechaCreacion
//Parametro8 = GopFechaModificacion	

$GarantiaLlamadaNumero = ($_POST['GarantiaLlamadaNumero']);
$GarantiaLlamadaFecha = ($_POST['GarantiaLlamadaFecha']);
$GarantiaLlamadaValor = ($_POST['GarantiaLlamadaValor']);
$GarantiaLlamadaObservacion = ($_POST['GarantiaLlamadaObservacion']);

$_SESSION['InsGarantiaLlamada'.$Identificador]->MtdAgregarSesionObjeto(1,
NULL,
$GarantiaLlamadaNumero,
$GarantiaLlamadaFecha,
$GarantiaLlamadaValor,
$GarantiaLlamadaObservacion,
3,
date("d/m/Y H:i:s"),
date("d/m/Y H:i:s")
);

?>
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
if (!isset($_SESSION['InsCotizacionVehiculoLlamada'.$Identificador])){
	$_SESSION['InsCotizacionVehiculoLlamada'.$Identificador] = new ClsSesionObjeto();
}


//SesionObjeto-InsCotizacionVehiculoLlamada
//Parametro1 = CvlId
//Parametro2 = CvlNumero
//Parametro3 = CvlFecha
//Parametro4 = CvlValor
//Parametro5 = CvlObservacion
//Parametro6 = CvlEstado
//Parametro7 = CvlFechaCreacion
//Parametro8 = CvlFechaModificacion	
//Parametro8 = CvlFechaProgramada

$CotizacionVehiculoLlamadaNumero = ($_POST['CotizacionVehiculoLlamadaNumero']);
$CotizacionVehiculoLlamadaFecha = ($_POST['CotizacionVehiculoLlamadaFecha']);
$CotizacionVehiculoLlamadaFechaProgramada = ($_POST['CotizacionVehiculoLlamadaFechaProgramada']);
$CotizacionVehiculoLlamadaValor = ($_POST['CotizacionVehiculoLlamadaValor']);
$CotizacionVehiculoLlamadaObservacion = ($_POST['CotizacionVehiculoLlamadaObservacion']);

$_SESSION['InsCotizacionVehiculoLlamada'.$Identificador]->MtdAgregarSesionObjeto(1,
NULL,
$CotizacionVehiculoLlamadaNumero,
$CotizacionVehiculoLlamadaFecha,
$CotizacionVehiculoLlamadaValor,
$CotizacionVehiculoLlamadaObservacion,
3,
date("d/m/Y H:i:s"),
date("d/m/Y H:i:s"),
$CotizacionVehiculoLlamadaFechaProgramada
);

?>
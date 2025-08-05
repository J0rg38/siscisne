<?php
require_once('../../../proyecto/ClsProyecto.php');

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
require_once($InsProyecto->MtdRutClases().'ClsCorreo.php');
////CLASES GENERALES
require_once($InsProyecto->MtdRutConexiones().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');
////FUNCIONES GENERALES
require_once($InsProyecto->MtdRutFunciones().'FncGeneral.php');

$Identificador = $_POST['Identificador'];
$ModalidadIngreso = $_POST['ModalidadIngreso'];

$POST_TemparioCodigo = $_POST['TemparioCodigo'];
$POST_TemparioTiempo = $_POST['TemparioTiempo'];

session_start();
if (!isset($_SESSION['InsFichaAccionTempario'.$ModalidadIngreso.$Identificador])){
	$_SESSION['InsFichaAccionTempario'.$ModalidadIngreso.$Identificador] = new ClsSesionObjeto();
}

//SesionObjeto-FichaAccionTempario
//Parametro1 = FaeId
//Parametro2 =
//Parametro3 = FaeCodigo
//Parametro4 = FaeTiempo
//Parametro5 = 
//Parametro6 = FaeEstado
//Parametro7 = FaeTiempoCreacion
//Parametro8 = FaeTiempoModificacion

$InsFichaAccionTempario1 = array();
$InsFichaAccionTempario1 = $_SESSION['InsFichaAccionTempario'.$ModalidadIngreso.$Identificador]->MtdObtenerSesionObjeto($_POST['Item']);

$_SESSION['InsFichaAccionTempario'.$ModalidadIngreso.$Identificador]->MtdEditarSesionObjeto($_POST['Item'],1,
$InsFichaAccionTempario1->Parametro1,
NULL,
strtoupper($POST_TemparioCodigo),
round($POST_TemparioTiempo,2),
NULL,
1,
$InsFichaAccionTempario1->Parametro7,
date("d/m/Y H:i:s")
);
?>
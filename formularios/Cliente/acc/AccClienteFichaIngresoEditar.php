<?php
session_start();
 header("Content-type:application/json");
 
////PRINCIPALES
require_once('../../../proyecto/ClsProyecto.php');
require_once('../../../proyecto/ClsPoo.php');

$InsPoo->Ruta = '../../../';
$InsProyecto->Ruta = '../../../';

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
////AUDITORIA
require_once($InsPoo->MtdPaqAcceso().'ClsAuditoria.php');

$POST_FichaIngresoId = $_POST['FichaIngresoId'];
$POST_FichaIngresoObservacionCallcenter = $_POST['FichaIngresoObservacionCallcenter'];

require_once($InsPoo->MtdPaqActividad().'ClsFichaIngreso.php');

$resultado = 0;

$InsFichaIngreso = new ClsFichaIngreso();
$InsFichaIngreso->FinId = $POST_FichaIngresoId;
$InsFichaIngreso->FinObservacionCallcenter = $POST_FichaIngresoObservacionCallcenter;
$InsFichaIngreso->FinTiempoModificacion = date("Y-m-d H:i:s");

if($InsFichaIngreso->MtdEditarFichaIngresoObservacionCallcenter()){
	$resultado = 1;	
}else{
	$resultado = 2;	
}

$Respuesta = array();
$Respuesta['Resultado'] = $resultado;
$Respuesta['POST_FichaIngresoId'] = $POST_FichaIngresoId;
$Respuesta['POST_FichaIngresoObservacionCallcenter'] = $POST_FichaIngresoObservacionCallcenter;

echo json_encode($Respuesta);
?>
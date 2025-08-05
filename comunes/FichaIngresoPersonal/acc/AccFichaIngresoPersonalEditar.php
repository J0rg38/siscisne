<?php
session_start();
////PRINCIPALES
require_once('../../../proyecto/ClsProyecto.php');
require_once('../../../proyecto/ClsPoo.php');

$InsPoo->Ruta = '../../../';
$InsProyecto->Ruta = '../../../';

////CONFIGURACIONES GENERALES
require_once($InsProyecto->MtdRutConfiguraciones().'CnfSistema.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfEmpresa.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfConexion.php');
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


$POST_PersonalId = FncLimpiarVariable($_POST['PersonalId']);
$POST_FichaIngresoId = FncLimpiarVariable($_POST['FichaIngresoId']);

require_once($InsPoo->MtdPaqActividad().'ClsFichaIngreso.php');

$InsFichaIngreso = new ClsFichaIngreso();
$InsFichaIngreso->UsuId = $_SESSION['SesionId'];

if($InsFichaIngreso->MtdEditarFichaIngresoDato("PerId",$POST_PersonalId,$POST_FichaIngresoId)){
	
	$InsFichaIngreso->FinId = $POST_FichaIngresoId;
	$InsFichaIngreso->MtdObtenerFichaIngreso(false);
	
	if($InsFichaIngreso->FinEstado == 1){
		echo "003";
	}else{
		echo "001";
	}
	
}else{
	echo "002";
}
?>
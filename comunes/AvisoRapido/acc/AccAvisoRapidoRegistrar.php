<?php

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


$POST_VehiculoIngresoId = $_POST['VehiculoIngresoId'];
$POST_AvisoObservacion = $_POST['AvisoObservacion'];


require_once($InsPoo->MtdPaqLogistica().'ClsAviso.php');

$InsAviso = new ClsAviso();

$InsAviso->AviId = "";
$InsAviso->AviFecha = date("Y-m-d");
$InsAviso->EinId = $POST_VehiculoIngresoId;
$InsAviso->AviEstado = 3;
$InsAviso->AviObservacion = addslashes($POST_AvisoObservacion);
$InsAviso->AviTiempoCreacion = date("Y-m-d H:i:s");
$InsAviso->AviTiempoModificacion = date("Y-m-d H:i:s");
$InsAviso->AviEliminado = 1;
	
if($InsAviso->MtdRegistrarAviso()){
	echo "AVI001";
}else{
	echo "AVI002";
}
?>
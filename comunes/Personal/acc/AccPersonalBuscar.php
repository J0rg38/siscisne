<?php
session_start();
require_once('../../../proyecto/ClsProyecto.php');
require_once('../../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../../';
$InsPoo->Ruta = '../../../';

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

require_once($InsProyecto->MtdRutLibrerias().'JSON.php');
require_once($InsProyecto->MtdRutLibrerias().'JSON2.php');

require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');

$InsPersonal = new ClsPersonal();

$ResPersonal = $InsPersonal->MtdObtenerPersonales("Per".$_POST['Campo'],"comienza",$_POST['Dato'],"Per".$_POST['Campo'],"ASC",1,NULL,NULL,NULL);
$ArrPersonales = $ResPersonal['Datos'];

$InsPersonal->PerId = $ArrPersonales[0]->PerId;
unset($ArrPersonales);

$InsPersonal->MtdObtenerPersonal();
$InsPersonal->InsMysql=NULL;

//$var = json_encode ($InsPersonal);
//$json = new JSON;
//$var = $json->serialize( $InsPersonal );
//$json->unserialize( $var );

//$_SESSION['SesPersonalId'] = $InsPersonal->PerId; 

$json = new Services_JSON();
$var = $json->encode($InsPersonal);

echo $var;
?>
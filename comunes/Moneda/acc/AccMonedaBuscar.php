<?php
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

require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

$InsMoneda = new ClsMoneda();
$ResMoneda = $InsMoneda->MtdObtenerMonedas("Mon".$_POST['Campo'],"comienza",$_POST['Dato'],"Mon".$_POST['Campo'],"ASC",NULL);
$ArrMonedas = $ResMoneda['Datos'];

$InsMoneda->MonId = $ArrMonedas[0]->MonId;
unset($ArrMonedas);

$InsMoneda->MtdObtenerMoneda();

//$InsMoneda->TcaMontoCompra = $_SESSION[$InsMoneda->MonId]['SisTipoCambioCompra'];
//$InsMoneda->TcaMontoVenta = $_SESSION[$InsMoneda->MonId]['SisTipoCambioVenta'];

$InsMoneda->InsMysql=NULL;

$json = new JSON;
$var = $json->serialize( $InsMoneda );

$json->unserialize( $var );

echo $var;






?>
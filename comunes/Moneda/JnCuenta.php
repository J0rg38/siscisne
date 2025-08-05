<?php
header('Content-type: text/json');
header('Content-type: application/json');

session_start();
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../';
$InsPoo->Ruta = '../../';

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

require_once($InsPoo->MtdPaqContabilidad().'ClsCuenta.php');

$GET_CuentaId = $_GET['CuentaId'];

$InsCuenta = new ClsCuenta();

$ResCuenta = $InsCuenta->MtdObtenerCuentas("CueId","esigual",$GET_CuentaId,"CueId","ASC",NULL,NULL);
$ArrCuentas = $ResCuenta['Datos'];

$InsCuenta->CueId = $ArrCuentas[0]->CueId;
unset($ArrCuentas);
$InsCuenta->MtdObtenerCuenta();
$InsCuenta->InsMysql=NULL;

//$json = new Services_JSON();
//echo $json->encode($InsCuenta);


//$json = new JSON;
//$var = $json->serialize( $ArrCuentas );
//$var = $json->serialize( $InsCuenta );
//$json->unserialize( $var );
//echo $var;
echo json_encode($InsCuenta);

?>
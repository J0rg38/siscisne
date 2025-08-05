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




$GET_BancoId = $_GET['Banco'];
$GET_MonedaId = $_GET['Moneda'];
$GET_TarjetaId = $_GET['Tarjeta'];

require_once($InsPoo->MtdPaqContabilidad().'ClsCuenta.php');

$InsCuenta = new ClsCuenta();

//MtdObtenerCuentas($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'CueId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oMoneda=NULL,$oBanco = NULL)
$RepCuenta = $InsCuenta->MtdObtenerCuentas(NULL,NULL,NULL,"CueNumero","ASC",NULL,NULL,$GET_MonedaId,$GET_BancoId,$GET_TarjetaId);
$ArrCuentas = $RepCuenta['Datos'];

echo json_encode($ArrCuentas);

//$json = new JSON;
//$var = $json->serialize( $ArrCuentas );
//$json->unserialize( $var );
//
//echo $var;
?>
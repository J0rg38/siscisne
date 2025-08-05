<?php
//header('Content-type: text/json');
//header('Content-type: application/json');

session_start();
require_once('../../../proyecto/ClsProyecto.php');
require_once('../../../proyecto/ClsPoo.php');

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
require_once($InsProyecto->MtdRutLibrerias().'PHPMailer_5.2.4/class.phpmailer.php');
require_once($InsProyecto->MtdRutClases().'ClsCorreo.php');

////CLASES GENERALES
require_once($InsProyecto->MtdRutConexiones().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');
////FUNCIONES GENERALES
require_once($InsProyecto->MtdRutFunciones().'FncGeneral.php');

require_once($InsProyecto->MtdRutLibrerias().'JSON.php');
require_once($InsProyecto->MtdRutLibrerias().'JSON2.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoStock.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacen.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');

$POST_VehiculoId = $_POST['VehiculoId'];
$POST_Sucursal = $_POST['Sucursal'];
$POST_Ano = (empty($_POST['Ano'])?date("Y"):$_POST['Ano']);

$InsVehiculoStock = new ClsVehiculoStock();

//MtdObtenerVehiculoStocks($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'VstId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oVehiculoVersion=NULL,$oAnoFabricacion=NULL,$oAnoModelo=NULL,$oColor=NULL,$oSucursal=NULL,$oVehiculo=NULL,$oAno=NULL,$oFechaInicio=NULL,$oFechaFin=NULL) 
$ResVehiculoStock = $InsVehiculoStock->MtdObtenerVehiculoStocks(NULL,NULL,NULL,NULL,NULL,1,"1",NULL,NULL,NULL,    NULL,NULL,      NULL,    $POST_Sucursal,    $POST_VehiculoId,   $POST_Ano,  $POST_Ano."-01-01", $POST_Ano."-12-31" );
$ArrVehiculoStocks = $ResVehiculoStock['Datos'];

$InsVehiculoStock->VehId = $ArrVehiculoStocks[0]->VehId;
$InsVehiculoStock->VstStockReal = (empty($ArrVehiculoStocks[0]->VstStockReal)?0:$ArrVehiculoStocks[0]->VstStockReal);
$InsVehiculoStock->InsMysql=NULL;

//$json = new Services_JSON();
//echo $json->encode($InsCuenta);


$json = new JSON;
//$var = $json->serialize( $ArrCuentas );
$var = $json->serialize( $InsVehiculoStock );
$json->unserialize( $var );
echo $var;
	
?>
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


require_once($InsPoo->MtdPaqContabilidad().'ClsGasto.php');

$InsGasto = new ClsGasto();

////MtdObtenerGastos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'GasId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oFecha="GasFecha",$oCancelado=0,$oProveedor=NULL,$oCondicionPago=NULL)
$ResGasto = $InsGasto->MtdObtenerGastos("gas.Gas".$_POST['Campo'],"comienza",$_POST['Dato'],"Gas".$_POST['Campo'],"ASC","1",NULL,NULL,"3",NULL,"GasFecha",0,NULL,NULL);
$ArrGastos = $ResGasto['Datos'];

$InsGasto->GasId = $ArrGastos[0]->GasId;
unset($ArrGastos);

$InsGasto->MtdObtenerGasto(false);
$InsGasto->InsMysql=NULL;

$InsGasto->GasTotal = round($InsGasto->GasTotal,2);
//$var = json_encode ($InsFichaIngreso);
//$json = new JSON;
//$var = $json->serialize( $InsFichaIngreso );
//$json->unserialize( $var );

$json = new Services_JSON();
$var = $json->encode($InsGasto);

echo $var;
?>
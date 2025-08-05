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

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompra.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompraDetalle.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompraPedido.php');

$InsOrdenCompra = new ClsOrdenCompra();

$ResOrdenCompra = $InsOrdenCompra->MtdObtenerOrdenCompras("Oco".$_POST['Campo'],"comienza",$_POST['Dato'],"Oco".$_POST['Campo'],"ASC",NULL,NULL,NULL,NULL,NULL);
$ArrOrdenCompras = $ResOrdenCompra['Datos'];

$InsOrdenCompra->OcoId = $ArrOrdenCompras[0]->OcoId;
unset($ArrOrdenCompras);

$InsOrdenCompra->MtdObtenerOrdenCompra();
$InsOrdenCompra->InsMysql = NULL;

//$var = json_encode ($InsOrdenCompra);
//$json = new JSON;
//$var = $json->serialize( $InsOrdenCompra );
//$json->unserialize( $var );

$json = new Services_JSON();
$var = $json->encode($InsOrdenCompra);

echo $var;
?>
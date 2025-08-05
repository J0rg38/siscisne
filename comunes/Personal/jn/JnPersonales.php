<?php
session_start();
header('Content-Type: application/json');
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

$GET_Sucursal = $_GET['Sucursal'];
$GET_Area = $_GET['Area'];

$GET_Taller = $_GET['Taller'];
$GET_Almacen = $_GET['Almacen'];
$GET_Ventas = $_GET['Ventas'];
$GET_Recepcion = $_GET['Recepcion'];
$GET_Libres = $_GET['Libres'];

$InsPersonal = new ClsPersonal();


//MtdObtenerPersonales($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PerId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPersonalTipo=NULL,$oEstado=NULL,$oFechaNacimientoRango=NULL,$oTaller=NULL,$oRecepcion=NULL,$oVenta=NULL,$oArea=NULL,$oSucursal=NULL,$oAlmacen=NULL,$oFirmante=NULL,$oMultisucursal=false)

$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,NULL,NULL,$GET_Taller,$GET_Recepcion,$GET_Ventas,$GET_Area,$GET_Sucursal,$GET_Almacen,NULL,(($GET_Libres==1)?true:false));
$ArrPersonales = $ResPersonal['Datos'];

echo json_encode($ArrPersonales);
//$json = new JSON;
//$var = $json->serialize( $ArrPersonales );
//$json->unserialize( $var );
//
//echo $var;
?>
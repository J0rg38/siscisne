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


$GET_Departamento = $_GET['Departamento'];

require_once($InsPoo->MtdPaqLogistica().'ClsUbigeo.php');


$InsUbigeo = new ClsUbigeo();
//MtdObtenerUbigeoDepartamentos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'UbiId',$oSentido = 'Desc',$oPaginacion = '0,10') {
$RepUbigeo = $InsUbigeo->MtdObtenerUbigeoProvincias(NULL,NULL,"UbiProvincia","ASC",NULL,$GET_Departamento);
$ArrProvincias = $RepUbigeo['Datos'];

$json = new JSON;
$var = $json->serialize( $ArrProvincias );
$json->unserialize( $var );

echo $var;
?>
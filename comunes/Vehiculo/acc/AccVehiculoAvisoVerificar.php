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

$POST_VehiculoIngresoId = $_POST['VehiculoIngresoId'];

require_once($InsPoo->MtdPaqLogistica().'ClsAviso.php');

$InsAviso = new ClsAviso();

//MtdObtenerAvisos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AviId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oVehiculoIngresoId=NULL) {
$ResAviso = $InsAviso->MtdObtenerAvisos(NULL,NULL,NULL,"AviFecha","DESC","1","3",$POST_VehiculoIngresoId);
$ArrAvisos = $ResAviso['Datos'];

$InsAviso->AviId = $ArrAvisos[0]->AviId;
unset($ArrAvisos);

//MtdObtenerAviso
$InsAviso->MtdObtenerAviso(false);
$InsAviso->InsMysql=NULL;

$json = new Services_JSON();
$var = $json->encode($InsAviso);

echo $var;

?>
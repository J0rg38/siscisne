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

require_once($InsProyecto->MtdRutLibrerias().'JSON2.php');


require_once($InsPoo->MtdPaqLogistica().'ClsServicioRepuesto.php');


$InsServicioRepuesto = new ClsServicioRepuesto();

////MtdObtenerServicioRepuestos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'SreId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oTipoGasto=NUL) {

$ResServicioRepuesto = $InsServicioRepuesto->MtdObtenerServicioRepuestos("Sre".$_POST['Campo'],"contiene",$_POST['Dato'],"Sre".$_POST['Campo'],"ASC",NULL,NULL);
$ArrServicioRepuestos = $ResServicioRepuesto['Datos'];

$InsServicioRepuesto->SreId = $ArrServicioRepuestos[0]->SreId;
unset($ArrServicioRepuestos);
$InsServicioRepuesto->MtdObtenerServicioRepuesto(false);

$InsServicioRepuesto->InsMysql=NULL;

echo json_encode($InsServicioRepuesto);
?>
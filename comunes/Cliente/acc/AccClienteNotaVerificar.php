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

$POST_Limite = $_POST['Limite'] ?? '';
$POST_ClienteId = $_POST['ClienteId'] ?? '';
$POST_ClienteNumeroDocumento = $_POST['ClienteNumeroDocumento'] ?? '';

require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqLogistica().'ClsClienteNota.php');

$InsCliente = new ClsCliente();
$InsClienteNota = new ClsClienteNota();

$InsCliente->CliId = $POST_ClienteId;
$InsCliente->MtdObtenerCliente(false);

//MtdObtenerClienteNotas($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'CnoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oClienteId=NULL) {
	//    public function MtdObtenerClienteNotas($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'CnoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oClienteId=NULL) {
$ResClienteNota = $InsClienteNota->MtdObtenerClienteNotas(NULL,NULL,NULL,"CnoTiempoCreacion","DESC",$POST_Limite,NULL,$POST_ClienteId);
$ArrClienteNotas = $ResClienteNota['Datos'];

echo json_encode($ArrClienteNotas);

?>
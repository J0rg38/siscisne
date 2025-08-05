<?php
session_start();
////PRINCIPALES
require_once('../../../proyecto/ClsProyecto.php');
require_once('../../../proyecto/ClsPoo.php');

$InsPoo->Ruta = '../../../';
$InsProyecto->Ruta = '../../../';

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


$POST_AlmacenMovimientoEntradaId = $_POST['AlmacenMovimientoEntradaId'];
$POST_AlmacenMovimientoEntradaCancelado = $_POST['AlmacenMovimientoEntradaCancelado'];


require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoEntrada.php');

$InsAlmacenMovimientoEntrada = new ClsAlmacenMovimientoEntrada();

$InsAlmacenMovimientoEntrada->MtdEditarAlmacenMovimientoEntradaDato("AmoCancelado",$POST_AlmacenMovimientoEntradaCancelado,$POST_AlmacenMovimientoEntradaId);

//if($POST_AlmacenMovimientoEntradaCancelado == 2){
//	$InsCliente->MtdEditarClienteDato("CliCSIExcluirMotivo",(($POST_ClienteCSIExcluirMotivo=="undefined")?'':$POST_ClienteCSIExcluirMotivo),$POST_ClienteId);
//}else{
//	$InsCliente->MtdEditarClienteDato("CliCSIExcluirMotivo","",$POST_ClienteId);
//}
?>


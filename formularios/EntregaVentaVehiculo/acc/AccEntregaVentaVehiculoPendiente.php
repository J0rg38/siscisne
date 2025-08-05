<?php
//session_start();
header('Content-Type: application/json');

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
////require_once($InsProyecto->MtdRutLibrerias().'PHPMailer_5.2.4/class.phpmailer.php');
//require_once($InsProyecto->MtdRutClases().'ClsCorreo.php');

////CLASES GENERALES
require_once($InsProyecto->MtdRutConexiones().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');
////FUNCIONES GENERALES
require_once($InsProyecto->MtdRutFunciones().'FncGeneral.php');


require_once($InsProyecto->MtdRutLibrerias().'class.numeroaletras.php');
require_once($InsProyecto->MtdRutLibrerias().'nusoap-0.9.5/lib/nusoap.php');
require_once($InsProyecto->MtdRutLibrerias().'JSON.php');
require_once($InsProyecto->MtdRutLibrerias().'JSON2.php');


require_once($InsPoo->MtdPaqAcceso().'ClsAuditoria.php');

$GET_EntregaVentaVehiculoId = $_POST['EntregaVentaVehiculoId'];


//deb($GET_Nombre );
require_once($InsPoo->MtdPaqLogistica().'ClsEntregaVentaVehiculo.php');


$InsEntregaVentaVehiculo = new ClsEntregaVentaVehiculo();

$CodigoRespuesta = 0;
$MensajeRespuesta = "";

if($InsEntregaVentaVehiculo->MtdActualizarEstadoEntregaVentaVehiculo($GET_EntregaVentaVehiculoId,1)){
	$CodigoRespuesta = 1;
}else{
	$CodigoRespuesta = 2;
}
			

$Resultado["CodigoRespuesta"] = ($CodigoRespuesta);
$Resultado["MensajeRespuesta"] = ($MensajeRespuesta);

echo json_encode($Resultado);

//if(json_last_error()
?>
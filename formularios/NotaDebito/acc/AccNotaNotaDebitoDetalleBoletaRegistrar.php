<?php
require_once('../../../proyecto/ClsProyecto.php');
require_once('../../../proyecto/ClsPoo.php');
$InsProyecto->Ruta = '../../../';
$InsPoo->Ruta = '../../../';
////CONFIGURACIONES GENERALES
require_once($InsProyecto->MtdRutConfiguraciones().'CnfSistema.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfEmpresa.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfConexion.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfNotificacion.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfFormularioNota.php');
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


require_once($InsPoo->MtdPaqContabilidad().'ClsBoletaDetalle.php');

$Identificador = $_POST['Identificador'];

session_start();
if (!isset($_SESSION['InsNotaCreditoDetalle'.$Identificador])){
	$_SESSION['InsNotaCreditoDetalle'.$Identificador] = new ClsSesionObjeto();
}

$InsBoletaDetalle = new ClsBoletaDetalle();

$ResBoletaDetalle =  $InsBoletaDetalle->MtdObtenerBoletaDetalles(NULL,NULL,NULL,NULL,1,NULL,$_POST['BolId'],$_POST['BtaId']);
$ArrBoletaDetalles = $ResBoletaDetalle['Datos'];							
			
			
/*
SesionObjeto-NotaCreditoDetalleListado
Parametro1 = FdeId
Parametro2 = FdeDescripcion
Parametro5 = Cantidad
Parametro6 = Importe
Parametro7 = TiempoCreacion
Parametro8 = TiempoModificacion
Parametro9 = VdeId
Parametro10 = VenId
Parametro11 = VtaNumero;
*/

foreach($ArrBoletaDetalles as $DatBoletaDetalle){
	$_SESSION['InsNotaCreditoDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,NULL,$DatBoletaDetalle->BdeDescripcion,NULL,$DatBoletaDetalle->BdePrecio,$DatBoletaDetalle->BdeCantidad,$DatBoletaDetalle->BdeImporte,
date("d/m/Y H:i:s"),
date("d/m/Y H:i:s"));
}


?>
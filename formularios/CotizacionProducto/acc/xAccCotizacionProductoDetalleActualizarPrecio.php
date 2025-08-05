<?php
session_start();
require_once('../../../proyecto/ClsProyecto.php');
require_once('../../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../../';
$InsPoo->Ruta  = '../../../';

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


$POST_CotizacionProductoId = $_POST['CotizacionProductoId'];

require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionProductoDetalle.php');

if(!empty($POST_CotizacionProductoId)){

	$InsCotizacionProductoDetalle = new ClsCotizacionProductoDetalle();
	$ResCotizacionProductoDetalle =  $InsCotizacionProductoDetalle->MtdObtenerCotizacionProductoDetalles(NULL,NULL,NULL,NULL,NULL,$POST_CotizacionProductoId);
	$ArrCotizacionProductoDetalles = $ResCotizacionProductoDetalle['Datos'];

	if(!empty($ArrCotizacionProductoDetalles)){
		foreach($ArrCotizacionProductoDetalles as $DatCotizacioProductoDetalle){
	
			$InsCotizacionProductoDetalle->MtdEliminarCotizacionProductoDetalle($DatCotizacioProductoDetalle->CrdId);
	
		}
	}

}


?>

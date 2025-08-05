<?php
session_start();
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../';
$InsPoo->Ruta = '../../';

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

require_once($InsPoo->MtdPaqAlmacen().'ClsProductoTipoUnidadMedida.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedidaConversion.php');

$GET_tipo = $_GET['Tipo'];
$GET_ptipo = $_GET['RtiId'];
$GET_UnidadMedidaId = $_GET['UnidadMedidaId'];

$InsProductoTipoUnidadMedida = new ClsProductoTipoUnidadMedida();
$InsUnidadMedidaConversion = new ClsUnidadMedidaConversion();

$ResProductoTipoUnidadMedida = $InsProductoTipoUnidadMedida->MtdObtenerProductoTipoUnidadMedidas(NULL,NULL,NULL,"UmeId","ASC",NULL,$GET_tipo,$GET_ptipo);	
$ArrProductoTipoUnidadMedidas = $ResProductoTipoUnidadMedida['Datos'];

$ArrProductoTipoUnidadMedidas2 = array();

foreach($ArrProductoTipoUnidadMedidas as $DatProductoTipoUnidadMedida){

	$UnidadMedidaEquivalente = 0;
	
	if($GET_UnidadMedidaId == $DatProductoTipoUnidadMedida->UmeId){
		$UnidadMedidaEquivalente = 1;
	}else{
		$RepUnidadMedidaConversion = $InsUnidadMedidaConversion->MtdObtenerUnidadMedidaConversiones(NULL,NULL,NULL,"UmeId1","DESC","1",$DatProductoTipoUnidadMedida->UmeId,$GET_UnidadMedidaId);
		$ArrUnidadMedidaConversiones = $RepUnidadMedidaConversion['Datos'];
		
		foreach($ArrUnidadMedidaConversiones as $DatUnidadMedidaConversion){
			$UnidadMedidaEquivalente = $DatUnidadMedidaConversion->UmcEquivalente;
		}
	}

	if(!empty($UnidadMedidaEquivalente)){
		$ArrProductoTipoUnidadMedidas2[] = $DatProductoTipoUnidadMedida;
	}
}
            
            
$json = new JSON;
$var = $json->serialize( $ArrProductoTipoUnidadMedidas2 );

$json->unserialize( $var );

echo $var;
	
?>
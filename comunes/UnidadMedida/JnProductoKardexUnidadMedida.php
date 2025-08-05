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

require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCodigoReemplazo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoVehiculoVersion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoAno.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsListaPrecio.php');
//require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCosto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedida.php');

$GET_ProductoId = $_GET['ProductoId'];


$InsProducto = new ClsProducto();
$InsProducto->ProId = $GET_ProductoId;
$InsProducto->MtdObtenerProducto(false);

$ArrProductoKardexUnidadMedida = array();

//
//if($InsProducto->UmeId == $InsProducto->UmeIdIngreso){
//	
//		
//	$InsUnidadMedida = new ClsUnidadMedida();
//	$InsUnidadMedida->UmeId = $InsProducto->UmeId;
//	
//	$InsUnidadMedida->MtdObtenerUnidadMedida();
//	$InsUnidadMedida->UmeUso = 1;
//	$InsUnidadMedida->InsMysql = NULL;     
//	
//	$ArrProductoKardexUnidadMedida[] = $InsUnidadMedida;
//	
//}else{
	
$InsUnidadMedida = new ClsUnidadMedida();
	$InsUnidadMedida->UmeId = $InsProducto->UmeId;
	
	$InsUnidadMedida->MtdObtenerUnidadMedida();
	$InsUnidadMedida->UmeUso = 3;
	$InsUnidadMedida->InsMysql = NULL;     
	
	$ArrProductoKardexUnidadMedida[] = $InsUnidadMedida;
	
		
	if($InsProducto->UmeId <> $InsProducto->UmeIdIngreso){
		
		$InsUnidadMedida = new ClsUnidadMedida();
		$InsUnidadMedida->UmeId = $InsProducto->UmeIdIngreso;
		
		$InsUnidadMedida->MtdObtenerUnidadMedida();
		$InsUnidadMedida->UmeUso = 1;
		$InsUnidadMedida->InsMysql = NULL;       
		 
		$ArrProductoKardexUnidadMedida[] = $InsUnidadMedida;
	
	}
	
	
	//$ArrProductoKardexUnidadMedida[0]['UmeId'] = $InsUnidadMedida->UmeId;
	//$ArrProductoKardexUnidadMedida[0]['UmeNombre'] = $InsUnidadMedida->UmeNombre;
	
	

//}

//$ArrProductoKardexUnidadMedida[1]['UmeId'] = $InsUnidadMedida->UmeId;
//$ArrProductoKardexUnidadMedida[1]['UmeNombre'] = $InsUnidadMedida->UmeNombre;

$json = new JSON;
$var = $json->serialize( $ArrProductoKardexUnidadMedida );

$json->unserialize( $var );

echo $var;
	
?>
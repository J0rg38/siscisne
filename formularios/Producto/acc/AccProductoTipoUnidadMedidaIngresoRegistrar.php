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

require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedida.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoTipoUnidadMedida.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedidaConversion.php');

$POST_ProductoTipoUnidadMedidaIngreso = $_POST['ProductoTipoUnidadMedidaIngreso'];
$POST_ProductoTipoId = $_POST['ProductoTipoId'];
$POST_ProductoUnidadMedidaId = $_POST['ProductoUnidadMedidaId'];

$InsUnidadMedida = new ClsUnidadMedida();
$InsProductoTipoUnidadMedida = new ClsProductoTipoUnidadMedida();
$InsUnidadMedidaConversion = new ClsUnidadMedidaConversion();
		
		
$InsUnidadMedida->UmeNombre = "UNIDAD ".$POST_ProductoTipoUnidadMedidaIngreso.'';
$InsUnidadMedida->UmeAbreviacion = "UND ".$POST_ProductoTipoUnidadMedidaIngreso.'';
$InsUnidadMedida->UmeUso = 2;

if($InsUnidadMedida->MtdRegistrarUnidadMedida()){
	
	$InsProductoTipoUnidadMedida->RtiId = $POST_ProductoTipoId;
	$InsProductoTipoUnidadMedida->UmeId = $InsUnidadMedida->UmeId;
	$InsProductoTipoUnidadMedida->PtuTipo = 2;
	
	if($InsProductoTipoUnidadMedida->MtdRegistrarProductoTipoUnidadMedida()){

		$InsProductoTipoUnidadMedida->RtiId = $POST_ProductoTipoId;
		$InsProductoTipoUnidadMedida->UmeId = $InsUnidadMedida->UmeId;
		$InsProductoTipoUnidadMedida->PtuTipo = 1;
	
		if($InsProductoTipoUnidadMedida->MtdRegistrarProductoTipoUnidadMedida()){
			$InsUnidadMedidaConversion->UmeId2 = $POST_ProductoUnidadMedidaId;
			$InsUnidadMedidaConversion->UmeId1 = $InsUnidadMedida->UmeId;
			$InsUnidadMedidaConversion->UmcEquivalente = $POST_ProductoTipoUnidadMedidaIngreso;
			
			if($InsUnidadMedidaConversion->MtdRegistrarUnidadMedidaConversion()){
				
			}else{
				echo "AAA";	
			}		
		}else{
			echo "BBB";	
		}
	}else{
			echo "CCC";			
	}
	
}else{
	echo "DDD";
}


?>
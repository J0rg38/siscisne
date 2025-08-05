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

$Identificador = $_POST['Identificador'];

session_start();
if (!isset($_SESSION['InsTrasladoAlmacenSalidaDetalle'.$Identificador])){
	$_SESSION['InsTrasladoAlmacenSalidaDetalle'.$Identificador] = new ClsSesionObjeto();
}

require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedidaConversion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedida.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCodigoReemplazo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoVehiculoVersion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoAno.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsListaPrecio.php');
//require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCosto.php');

$InsProducto = new ClsProducto();
$InsUnidadMedida = new ClsUnidadMedida();
$InsUnidadMedidaConversion = new ClsUnidadMedidaConversion();

$InsProducto->ProId = $_POST['ProductoId'];
$InsProducto->MtdObtenerProducto(false);

$InsUnidadMedida->UmeId = $_POST['ProductoUnidadMedidaConvertir'];
$InsUnidadMedida->MtdObtenerUnidadMedida();

$VerificarStock = 2;

//if(!empty($InsProducto->ProId)){
	
	//if(!empty($InsUnidadMedida->UmeId)){
				
		if($InsUnidadMedida->UmeId == $InsProducto->UmeId){
			$InsUnidadMedidaConversion->UmcEquivalente = 1;
		}else{
			$RepUnidadMedidaConversion = $InsUnidadMedidaConversion->MtdObtenerUnidadMedidaConversiones(NULL,NULL,NULL,"UmeId1","DESC","1",$InsUnidadMedida->UmeId,$InsProducto->UmeId);
			$ArrUnidadMedidaConversiones = $RepUnidadMedidaConversion['Datos'];
			
			foreach($ArrUnidadMedidaConversiones as $DatUnidadMedidaConversion){
				$InsUnidadMedidaConversion->UmcEquivalente = $DatUnidadMedidaConversion->UmcEquivalente;
			}
		}
		
	//	if(!empty($InsUnidadMedidaConversion->UmcEquivalente)){
	//	
//	SesionObjeto-TrasladoAlmacenSalidaDetalle
//	Parametro1 = AmdId
//	Parametro2 = ProId
//	Parametro3 = ProNombre
//	Parametro4 = AmdPrecio
//	Parametro5 = AmdCantidad
//	Parametro6 = AmdImporte
//	Parametro7 = AmdTiempoCreacion
//	Parametro8 = AmdTiempoModificacion
//	Parametro9 = UmeNombre
//	Parametro10 = UmeId
//	Parametro11 = RtiId
//	Parametro12 = AmdCantidadReal
//	Parametro13 = ProCodigoOriginal,
//	Parametro14 = ProCodigoAlternativo
//	Parametro15 = UmeIdOrigen
//	Parametro16 = VerificarStock
//	Parametro17 = AmdCosto
//	Parametro18 = AmdCantidadRealAnterior
//	Parametro19 = AmdEstado
				
			$Cantidad = round($_POST['ProductoCantidad'],3);
			//$Importe = round($_POST['ProductoImporte'],3);
			//$Precio = round(($Importe/$Cantidad),3);
			$CantidadReal = round($Cantidad * $InsUnidadMedidaConversion->UmcEquivalente,6);
			
			//$InsProducto->ProStockReal = $InsProducto->ProStockReal + 1 - 1;
			//$CantidadReal = $CantidadReal + 1 - 1;
			
			//if($InsProducto->ProStockReal < $CantidadReal){
			//if($InsProducto->ProStock < $Cantidad){
			//	$VerificarStock = 1;
			//}
			
			if($InsProducto->ProStockReal < $CantidadReal){
				$VerificarStock = 1;
			}
	
			//deb($VerificarStock);
			
			$_SESSION['InsTrasladoAlmacenSalidaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
			NULL,
			$InsProducto->ProId,
			($InsProducto->ProNombre),
			0,
			$Cantidad,
			0,
			date("d/m/Y H:i:s"),
			date("d/m/Y H:i:s"),
			$InsUnidadMedida->UmeNombre,
			$InsUnidadMedida->UmeId,
			$InsProducto->RtiId,
			$CantidadReal,
			$InsProducto->ProCodigoOriginal,
			$InsProducto->ProCodigoAlternativo,
			$_POST['ProductoUnidadMedida'],
			$VerificarStock,
			0,
			$CantidadReal,
			3
			);
//		
//		}else{
//			echo "No se encontro la UNIDAD DE MEDIDA equivalente, revise la tabla de CONVERSIONES, y si esta correctamente llenado en el PADRON de PRODUCTOS.";	
//		}	
//
//	}else{
//		echo "No ingreso una UNIDAD DE MEDIDA.";	
//	}
//	
//}else{
//	echo "No se identifico el PRODUCTO";
//}


?>
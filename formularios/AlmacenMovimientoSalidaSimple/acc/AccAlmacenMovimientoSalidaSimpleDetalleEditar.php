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

$Identificador = $_POST['Identificador'];

session_start();
if (!isset($_SESSION['InsAlmacenMovimientoSalidaDetalle'.$Identificador])){
	$_SESSION['InsAlmacenMovimientoSalidaDetalle'.$Identificador] = new ClsSesionObjeto();
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

$InsUnidadMedida->UmeId = $_POST['ProductoUnidadMedidaConvertir'];
$InsUnidadMedida->MtdObtenerUnidadMedida();

$InsProducto->ProId = $_POST['ProductoId'];
$InsProducto->MtdObtenerProducto(false);

$VerificarStock = 2;

//if(!empty($InsProducto->ProId)){//
	
//	if(!empty($InsUnidadMedida->UmeId)){
		
		
		if($InsUnidadMedida->UmeId == $InsProducto->UmeId){
			$InsUnidadMedidaConversion->UmcEquivalente = 1;	
		}else{
			$RepUnidadMedidaConversion = $InsUnidadMedidaConversion->MtdObtenerUnidadMedidaConversiones(NULL,NULL,NULL,"UmeId1","DESC","1",$InsUnidadMedida->UmeId,$InsProducto->UmeId);
			$ArrUnidadMedidaConversiones = $RepUnidadMedidaConversion['Datos'];
			
			foreach($ArrUnidadMedidaConversiones as $DatUnidadMedidaConversion){
				$InsUnidadMedidaConversion->UmcEquivalente = $DatUnidadMedidaConversion->UmcEquivalente;
			}	
		}
		
		//if(!empty($InsUnidadMedidaConversion->UmcEquivalente)){
			
//	SesionObjeto-AlmacenMovimientoSalidaDetalle
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
//	Parametro18 = AmdCantidadRealAnterior
//  Parametro19 = AmdEstado
				
			
			
			$InsAlmacenMovimientoSalidaDetalle1 = array();
			$InsAlmacenMovimientoSalidaDetalle1 = $_SESSION['InsAlmacenMovimientoSalidaDetalle'.$Identificador]->MtdObtenerSesionObjeto($_POST['Item']);
			
			$Cantidad = round($_POST['ProductoCantidad'],3);
			$Importe = round($_POST['ProductoImporte'],2);
			$Precio = round(($Importe/$Cantidad),2);		
			$CantidadReal = round($Cantidad * $InsUnidadMedidaConversion->UmcEquivalente,6);
				
			//if(($InsProducto->ProStockReal + $InsAlmacenMovimientoSalidaDetalle1->Parametro12)<$CantidadReal){
			if($InsProducto->ProStock < $Cantidad){
				$VerificarStock = 1;
			}
			
			$_SESSION['InsAlmacenMovimientoSalidaDetalle'.$Identificador]->MtdEditarSesionObjeto($_POST['Item'],1,
			$InsAlmacenMovimientoSalidaDetalle1->Parametro1,
			$InsAlmacenMovimientoSalidaDetalle1->Parametro2,
			$InsAlmacenMovimientoSalidaDetalle1->Parametro3,
			$Precio,
			$Cantidad,
			$Importe,
			$InsAlmacenMovimientoSalidaDetalle1->Parametro7,
			date("d/m/Y H:i:s"),
			$InsUnidadMedida->UmeNombre,
			$InsUnidadMedida->UmeId,
			$InsAlmacenMovimientoSalidaDetalle1->Parametro11,
			$CantidadReal,
			$InsAlmacenMovimientoSalidaDetalle1->Parametro13,
			$InsAlmacenMovimientoSalidaDetalle1->Parametro14,
			$InsAlmacenMovimientoSalidaDetalle1->Parametro15,
			$VerificarStock,
			$InsAlmacenMovimientoSalidaDetalle1->Parametro17,
			$InsAlmacenMovimientoSalidaDetalle1->Parametro18,
			$InsAlmacenMovimientoSalidaDetalle1->Parametro19
			);
		
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
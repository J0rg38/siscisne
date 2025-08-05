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
$ModalidadIngreso = $_POST['ModalidadIngreso'];

session_start();
if (!isset($_SESSION['InsFichaAccionProducto'.$ModalidadIngreso.$Identificador])){
	$_SESSION['InsFichaAccionProducto'.$ModalidadIngreso.$Identificador] = new ClsSesionObjeto();
}



require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedidaConversion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedida.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoFoto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCodigoReemplazo.php');require_once($InsPoo->MtdPaqAlmacen().'ClsProductoVehiculoVersion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoAno.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoFoto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsListaPrecio.php');
//require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCosto.php');

$InsProducto = new ClsProducto();
$InsUnidadMedida = new ClsUnidadMedida();
$InsUnidadMedidaConversion = new ClsUnidadMedidaConversion();

$InsUnidadMedida->UmeId = $_POST['ProductoUnidadMedidaConvertir'];
$InsUnidadMedida->MtdObtenerUnidadMedida();

$InsProducto->ProId = $_POST['ProductoId'];
$InsProducto->MtdObtenerProducto(false);

$VerificarStock = 1;

//
//if(!empty($InsProducto->ProId)){
//	
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
			
//			if(!empty($InsUnidadMedidaConversion->UmcEquivalente)){
				
				$Cantidad = round($_POST['ProductoCantidad'],3);
				$Importe = round($_POST['ProductoImporte'],2);
				$Precio = round(($Importe/$Cantidad),2);		
				$CantidadReal = round($Cantidad * $InsUnidadMedidaConversion->UmcEquivalente,6);
					
//	
//				$ProductoId = $_POST['ProductoId'];
//				$ProductoNombre = $_POST['ProductoNombre'];
//				$ProductoCodigoOriginal = $_POST['ProductoCodigoOriginal'];
//				$ProductoCodigoAlternativo = $_POST['ProductoCodigoAlternativo'];
//				$ProductoUnidadMedida = $_POST['ProductoUnidadMedida'];
//			
			
			
//SesionObjeto-FichaAccionProducto
//Parametro1 = FapId
//Parametro2 = ProId
//Parametro3 = ProNombre
//Parametro4 = FapVerificar1
//Parametro5 = FapVerificar2
//Parametro6 = UmeId
//Parametro7 = FapTiempoCreacion
//Parametro8 = FapTiempoModificacion
//Parametro9 = FapCantidad
//Parametro10 = FapCantidadReal	
//Parametro11 = RtiId
//Parametro12 = UmeNombre
//Parametro13 = UmeIdOrigen
//Parametro14 = FapEstado
//Parametro15 = Tipo
//Parametro16 = FapAccion
//Parmaetro17 = ProCodigoOriginal,
//Parmaetro18 = ProCodigoAlternativo
				
				$InsFichaAccionProducto1 = array();
				$InsFichaAccionProducto1 = $_SESSION['InsFichaAccionProducto'.$ModalidadIngreso.$Identificador]->MtdObtenerSesionObjeto($_POST['Item']);
				
				$_SESSION['InsFichaAccionProducto'.$ModalidadIngreso.$Identificador]->MtdEditarSesionObjeto($_POST['Item'],1,
				$InsFichaAccionProducto1->Parametro1,
				$ProductoId,
				(stripslashes($ProductoNombre)),
				1,
				2,
				$InsUnidadMedida->UmeId,
				$InsFichaAccionProducto1->Parametro7,
				date("d/m/Y H:i:s"),
				$Cantidad,
				$CantidadReal,
				$InsFichaAccionProducto1->Parametro11,
				$InsUnidadMedida->UmeNombre,
				$InsFichaAccionProducto1->Parametro13,
				$InsFichaAccionProducto1->Parametro14,
				$InsFichaAccionProducto1->Parametro15,
				$InsFichaAccionProducto1->Parametro16,
				$InsFichaAccionProducto1->Parametro17,
				$InsFichaAccionProducto1->Parametro18
				);
			
//			}else{
//				echo "No se encontro la UNIDAD DE MEDIDA equivalente, revise la tabla de CONVERSIONES, y si esta correctamente llenado en el PADRON de PRODUCTOS.";	
//			}
//
//		
//	}else{
//		echo "No ingreso una UNIDAD DE MEDIDA.";	
//	}
//	
//}else{
//	
//	echo "No se identifico el PRODUCTO";
//}



?>
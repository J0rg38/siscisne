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
if (!isset($_SESSION['InsFichaIngresoProducto'.$ModalidadIngreso.$Identificador])){
	$_SESSION['InsFichaIngresoProducto'.$ModalidadIngreso.$Identificador] = new ClsSesionObjeto();
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

$InsProducto->ProId = $_POST['ProductoId'];
$InsProducto->MtdObtenerProducto(false);

$InsUnidadMedida->UmeId = $_POST['ProductoUnidadMedidaConvertir'];
$InsUnidadMedida->MtdObtenerUnidadMedida();

$VerificarStock = 1;

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
		
		//if(!empty($InsUnidadMedidaConversion->UmcEquivalente)){
			$Cantidad = round($_POST['ProductoCantidad'],3);
			$Importe = round($_POST['ProductoImporte'],3);
			$Precio = round(($Importe/$Cantidad),3);
			$CantidadReal = round($Cantidad * $InsUnidadMedidaConversion->UmcEquivalente,6);
			
//		$ProductoId = $_POST['ProductoId'];
//			$ProductoNombre = $_POST['ProductoNombre'];
//			$ProductoCodigoOriginal = $_POST['ProductoCodigoOriginal'];
//			$ProductoCodigoAlternativo = $_POST['ProductoCodigoAlternativo'];
//			$ProductoUnidadMedida = $_POST['ProductoUnidadMedida'];
			
			
//SesionObjeto-FichaIngresoProducto
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
			
				$_SESSION['InsFichaIngresoProducto'.$ModalidadIngreso.$Identificador]->MtdAgregarSesionObjeto(1,
				NULL,
				$InsProducto->ProId,
				(stripslashes($ProductoNombre)),
				1,
				2,
				$InsUnidadMedida->UmeId,
				date("d/m/Y H:i:s"),
				date("d/m/Y H:i:s"),
				$Cantidad,
				$CantidadReal,
				$InsProducto->RtiId,
				$InsUnidadMedida->UmeNombre,
				$InsProducto->UmeId,
				1,
				NULL,
				NULL,
				$InsProducto->ProCodigoOriginal,
				$InsProducto->ProCodigoAlternativo
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
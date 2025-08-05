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

$POST_Item = $_POST['Item'];

$POST_ProductoId = $_POST['ProductoId'];

$POST_PedidoCompraLlegadaId = $_POST['PedidoCompraLlegadaId'];

$POST_PedidoCompraLlegadaDetalleId = $_POST['PedidoCompraLlegadaDetalleId'];
$POST_PedidoCompraLlegadaDetalleCantidad = $_POST['PedidoCompraLlegadaDetalleCantidad'];
$POST_PedidoCompraLlegadaDetalleCantidadEntregada = $_POST['PedidoCompraLlegadaDetalleCantidadEntregada'];

$POST_PedidoCompraLlegadaDetalleEstado = $_POST['PedidoCompraLlegadaDetalleEstado'];
$POST_PedidoCompraLlegadaDetalleObservacion = $_POST['PedidoCompraLlegadaDetalleObservacion'];

$POST_ProductoUnidadMedida = $_POST['ProductoUnidadMedida'];
$POST_ProductoNombre = $_POST['ProductoNombre'];
$POST_ProductoCodigoOriginal = $_POST['ProductoCodigoOriginal'];
$POST_OrdenCompraId = $_POST['OrdenCompraId'];

require_once($InsPoo->MtdPaqAlmacen().'ClsPedidoCompraLlegadaDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompra.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompraPedido.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompraDetalle.php');

require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompra.php');
require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompraDetalle.php');

if(!empty($POST_PedidoCompraLlegadaDetalleId)){
	
	
	if($POST_PedidoCompraLlegadaDetalleEstado == "10" ){

		$InsPedidoCompraLlegadaDetalle1 = new ClsPedidoCompraLlegadaDetalle();	
		$InsPedidoCompraLlegadaDetalle1->MtdEliminarPedidoCompraLlegadaDetalle($PedidoCompraLlegadaDetalleId);
		echo "6";
		
	}else{
			
										
		$InsPedidoCompraLlegadaDetalle = new ClsPedidoCompraLlegadaDetalle();
		$InsPedidoCompraLlegadaDetalle->MtdEditarPedidoCompraLlegadaDetalleDato("PldEstado",$POST_PedidoCompraLlegadaDetalleEstado,$POST_PedidoCompraLlegadaDetalleId);
		$InsPedidoCompraLlegadaDetalle->MtdEditarPedidoCompraLlegadaDetalleDato("PldObservacion",$POST_PedidoCompraLlegadaDetalleObservacion,$POST_PedidoCompraLlegadaDetalleId);
		$InsPedidoCompraLlegadaDetalle->MtdEditarPedidoCompraLlegadaDetalleDato("PldCantidadEntregada",$POST_PedidoCompraLlegadaDetalleCantidadEntregada,$POST_PedidoCompraLlegadaDetalleId);
		$InsPedidoCompraLlegadaDetalle->MtdEditarPedidoCompraLlegadaDetalleDato("PldCantidad",$POST_PedidoCompraLlegadaDetalleCantidad,$POST_PedidoCompraLlegadaDetalleId);
	
		echo "5";
		
	}
				  

	
}else{

	if(empty($POST_ProductoId)){

		$InsProducto = new ClsProducto();
		$InsProducto->ProCodigoAlternativo = "";
		$InsProducto->ProCodigoOriginal = $POST_ProductoCodigoOriginal;
		$InsProducto->ProNombre = $POST_ProductoNombre;
		$InsProducto->ProUbicacion = "-";
		$InsProducto->ProReferencia = "Producto registrado automaticamente por despacho ".date("d/m/Y");
		$InsProducto->ProEspecificacion = "";
		
		$InsProducto->UmeId = "UME-10007";
		$InsProducto->UmeIdIngreso = "UME-10007";
		
		$InsProducto->ProCodigoBarra = $POST_ProductoCodigoOriginal;
		$InsProducto->ProStockMinimo = 1;
		$InsProducto->ProValidarUso = 1;
		
		$InsProducto->ProPeso = 0;
		$InsProducto->ProLargo= 0;
		$InsProducto->ProAncho = 0;
		$InsProducto->ProAlto = 0;
		$InsProducto->ProVolumen = 0;
		
		$InsProducto->RtiId = "RTI-10000";	
		$InsProducto->ProFoto = "";
		$InsProducto->ProValidarStock = 1;	
		
		$InsProducto->ProTienePromocion = 2;	
										$InsProducto->ProCalcularPrecio = 2;	
										
										
		$InsProducto->ProEstado = 1;	
		$InsProducto->ProTiempoCreacion = date("Y-m-d H:i:s");
		$InsProducto->ProTiempoModificacion = date("Y-m-d H:i:s");
		$InsProducto->ProEliminado = 1;
		
		$InsProducto->MtdRegistrarProducto();
		
	}
		
	$EncontroCodigo = false;
	$PedidoCompraDetalleId = "";
	
	$InsOrdenCompra = new ClsOrdenCompra();
	$InsOrdenCompra->OcoId = $POST_OrdenCompraId;
	$InsOrdenCompra->MtdObtenerOrdenCompra();
	
	if(!empty($InsOrdenCompra->OcoEstado)){
	
		if(!empty($InsOrdenCompra->OrdenCompraPedido)){
			foreach($InsOrdenCompra->OrdenCompraPedido as $DatOrdenCompraPedido){
		
				$InsPedidoCompra = new ClsPedidoCompra();
				$InsPedidoCompra->PcoId = $DatOrdenCompraPedido->PcoId;
				$InsPedidoCompra->MtdObtenerPedidoCompra();
				
				
				
				if(!empty($InsPedidoCompra->PedidoCompraDetalle)){
					foreach($InsPedidoCompra->PedidoCompraDetalle as $DatPedidoCompraDetalle){
						
						
						$PedidoCompraDetalleId = "";
						$PedidoCompraLlegadaDetalleId = "";
						
//						if($POST_ProductoCodigoOriginal == trim($DatPedidoCompraDetalle->ProCodigoOriginal) and $DatPedidoCompraDetalle->PcdCantidadPendiente>0){
						//deb($POST_ProductoCodigoOriginal." - ".$DatPedidoCompraDetalle->ProCodigoOriginal);
						if($POST_ProductoCodigoOriginal == trim($DatPedidoCompraDetalle->ProCodigoOriginal) ){
							
						
							
							$InsPedidoCompraLlegadaDetalle1 = new ClsPedidoCompraLlegadaDetalle();	

							$InsPedidoCompraLlegadaDetalle1->PleId = $POST_PedidoCompraLlegadaId;

							$InsPedidoCompraLlegadaDetalle1->PcdId = $DatPedidoCompraDetalle->PcdId;
							$InsPedidoCompraLlegadaDetalle1->ProId = $DatPedidoCompraDetalle->ProId;

							$InsPedidoCompraLlegadaDetalle1->PldOrdenCompraId = $POST_OrdenCompraId;
							$InsPedidoCompraLlegadaDetalle1->PldOrdenCompraFecha = NULL;

							$InsPedidoCompraLlegadaDetalle1->PldCantidad = $POST_PedidoCompraLlegadaDetalleCantidad;	
							$InsPedidoCompraLlegadaDetalle1->PldCantidadEntregada = $POST_PedidoCompraLlegadaDetalleCantidad;		
							$InsPedidoCompraLlegadaDetalle1->PldComprobanteNumero = "";			
							$InsPedidoCompraLlegadaDetalle1->PldComprobanteFecha = "";						
							$InsPedidoCompraLlegadaDetalle1->PldImporte = 0;									

							$InsPedidoCompraLlegadaDetalle1->PldEstado = 1;									
							$InsPedidoCompraLlegadaDetalle1->PldTiempoCreacion = date("Y-m-d H:i:s");
							$InsPedidoCompraLlegadaDetalle1->PldTiempoModificacion = date("Y-m-d H:i:s");					
							$InsPedidoCompraLlegadaDetalle1->PldEliminado = 1;

							$InsPedidoCompraLlegadaDetalle1->MtdRegistrarPedidoCompraLlegadaDetalle();

							$PedidoCompraDetalleId = $DatPedidoCompraDetalle->PcdId;
							$PedidoCompraLlegadaDetalleId = $InsPedidoCompraLlegadaDetalle1->PldId;
							
							$EncontroCodigo = true;

							break;
							
						}
		
					} 
				}
				
				if(!$EncontroCodigo){
					
					echo "3";

				}else{
					
					echo "4:::".$PedidoCompraDetalleId.":::".$PedidoCompraLlegadaDetalleId;
					
				}
				
			}
		
		}else{

			echo "2";

		}

	}else{

		echo "1";

	}
	
	
	
	
	
								
	
}

?>
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


$POST_FichaIngresoId = $_POST['FichaIngresoId'];
$POST_AlmacenId = $_POST['AlmacenId'];
$POST_TallerPedidoDetalleFecha = $_POST['TallerPedidoDetalleFecha'];

$POST_CotizacionProductoId = $_POST['CotizacionProductoId'];
$Identificador = $_POST['Identificador'];
$ModalidadIngreso = $_POST['ModalidadIngreso'];

session_start();
if (!isset($_SESSION['InsTallerPedidoDetalle'.$ModalidadIngreso.$Identificador])){
	$_SESSION['InsTallerPedidoDetalle'.$ModalidadIngreso.$Identificador] = new ClsSesionObjeto();
}

require_once($InsPoo->MtdPaqActividad().'ClsFichaIngreso.php');

require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionProducto.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionProductoDetalle.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionProductoFoto.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionProductoPlanchadoPintado.php');


require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirecta.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirectaDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirectaTarea.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirectaFoto.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedidaConversion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedida.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoFoto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCodigoReemplazo.php');require_once($InsPoo->MtdPaqAlmacen().'ClsProductoVehiculoVersion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoAno.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoFoto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsListaPrecio.php');


$InsFichaIngreso = new ClsFichaIngreso();
$InsCotizacionProducto = new ClsCotizacionProducto();
$InsVentaDirecta = new ClsVentaDirecta();

$InsProducto = new ClsProducto();
$InsUnidadMedida = new ClsUnidadMedida();
$InsUnidadMedidaConversion = new ClsUnidadMedidaConversion();

//$InsCotizacionProducto->CprId = $POST_CotizacionProductoId;
//$InsCotizacionProducto->MtdObtenerCotizacionProducto();	
//
//MtdObtenerVentaDirectas($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'VdiId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oConCotizacionRepuesto=0,$oCotizacionRepuestoEstado=NULL,$oCotizacionRepuesto=NULL,$oMoneda=NULL,$oCliente=NULL,$oConOrdenCompraReferencia=NULL,$oPedidoCompra=NULL,$oVentaConcretada=NULL,$oClienteClasificacion=NULL,$oOrigen=NULL,$oObservado=NULL,$oEstricto=false,$oOrdenCompraReferencia=NULL,$oProductoCodigoOriginal=NULL,$oOrdenCompraTipo=NULL,$oExonerar=NULL,$oFichaIngreso=NULL,$oTieneGenerarVentaConcretada=false) 




$ResCotizacionProducto = $InsCotizacionProducto->MtdObtenerCotizacionProductos(NULL,NULL,NULL,"CprFecha","ASC",NULL,NULL,NULL,NULL,NULL,$POST_FichaIngresoId);
$ArrCotizacionProductos = $ResCotizacionProducto['Datos'];

//if(!empty($ArrCotizacionProductos)){
//	foreach($ArrCotizacionProductos as $DatCotizacionProducto){
		
		//MtdObtenerVentaDirectas($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'VdiId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oConCotizacionRepuesto=0,$oCotizacionRepuestoEstado=NULL,$oCotizacionRepuesto=NULL,$oMoneda=NULL,$oCliente=NULL,$oConOrdenCompraReferencia=NULL,$oPedidoCompra=NULL,$oVentaConcretada=NULL,$oClienteClasificacion=NULL,$oOrigen=NULL,$oObservado=NULL,$oEstricto=false,$oOrdenCompraReferencia=NULL,$oProductoCodigoOriginal=NULL,$oOrdenCompraTipo=NULL,$oExonerar=NULL,$oFichaIngreso=NULL,$oTieneGenerarVentaConcretada=false,$oPersonal=NULL) {
//		$ResVentaDirecta = $InsVentaDirecta->MtdObtenerVentaDirectas(NULL,NULL,NULL,"VdiTiempoCreacion","ASC",NULL,NULL,NULL,3,0,NULL,$DatCotizacionProducto->CprId,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,false,NULL,NULL,NULL,NULL,$POST_FichaIngresoId);
		$ResVentaDirecta = $InsVentaDirecta->MtdObtenerVentaDirectas(NULL,NULL,NULL,"VdiTiempoCreacion","ASC",NULL,NULL,NULL,3,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,false,NULL,NULL,NULL,NULL,$POST_FichaIngresoId);
		$ArrVentaDirectas = $ResVentaDirecta['Datos'];
	
	
		if(!empty($ArrVentaDirectas)){
			foreach($ArrVentaDirectas as $DatVentaDirecta){
				
				$InsVentaDirectaDetalle = new ClsVentaDirectaDetalle();
				$ResVentaDirectaDetalle = $InsVentaDirectaDetalle->MtdObtenerVentaDirectaDetalles(NULL,NULL,NULL,'VddId','ASC',NULL,$DatVentaDirecta->VdiId,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
				$ArrVentaDirectaDetalles = $ResVentaDirectaDetalle['Datos'];
				
				
				if(!empty($ArrVentaDirectaDetalles)){
					foreach($ArrVentaDirectaDetalles as $DatVentaDirectaDetalle){
						
					
						if($DatVentaDirectaDetalle->VddEstado == 1){
							
							//$GuardarDetalle = true;
							$VerificarStock = 2;

	
							  
			//	SesionObjeto-TallerPedidoDetalle/InsTallerPedidoDetalle
				//	Parametro1 = AmdId
				//	Parametro2 = ProId
				//	Parametro3 = ProNombre
				//	Parametro4 = AmdPrecioVenta
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
				//	Parametro18 = Origen
				//	Parametro19 = Verificar
				//	Parametro20 = FaaId
				
				//	Parametro21 = PmtId
				//	Parametro22 = FaaAccion
				//	Parametro23 = FaaNivel
				//	Parametro24 = FaaVerificar1
				//	Parametro25 = 
				//	Parametro26 = FapId	
				//	Parametro27 = AmdCantidadRealAnterior
				//	Parametro28 = AmdEstado
				//	Parametro29 = AmdReingreso
				//	Parametro30 = VddId
				
				//	Parametro31 = AlmId
				//	Parametro32 = AmdFecha
								//	Parametro33 = AmdFacturado
				//	Parametro34 = AmdCierre
				
								if($DatVentaDirectaDetalle->VddCantidadPendiente2>0){
									
									
									if($DatVentaDirectaDetalle->VddReemplazo == "Si"){
										$InsProducto->ProId = $DatVentaDirectaDetalle->ProIdPedido;
										$InsProducto->MtdObtenerProducto(false);
									}else{
										$InsProducto->ProId = $DatVentaDirectaDetalle->ProId;
										$InsProducto->MtdObtenerProducto(false);
									}
						
									  //$InsProducto->ProId = $DatVentaDirectaDetalle->ProId;
									 // $InsProducto->MtdObtenerProducto(false);
									  
									  $InsUnidadMedida->UmeId = $DatVentaDirectaDetalle->UmeId;
									  $InsUnidadMedida->MtdObtenerUnidadMedida();
									  
									  if($InsUnidadMedida->UmeId == $InsProducto->UmeId){
										  $InsUnidadMedidaConversion->UmcEquivalente = 1;
									  }else{
										  $RepUnidadMedidaConversion = $InsUnidadMedidaConversion->MtdObtenerUnidadMedidaConversiones(NULL,NULL,NULL,"UmeId1","DESC","1",$InsUnidadMedida->UmeId,$InsProducto->UmeId);
										  $ArrUnidadMedidaConversiones = $RepUnidadMedidaConversion['Datos'];
										  
										  foreach($ArrUnidadMedidaConversiones as $DatUnidadMedidaConversion){
											  $InsUnidadMedidaConversion->UmcEquivalente = $DatUnidadMedidaConversion->UmcEquivalente;
										  }
									  }
									  
									
									$CantidadReal = $DatVentaDirectaDetalle->VddCantidadPendiente2 * $InsUnidadMedidaConversion->UmcEquivalente;
							
									//deb($InsProducto->ProStockReal." - ". $DatVentaDirectaDetalle->VddCantidadReal);
									if($InsProducto->ProStockReal < $CantidadReal){
										$VerificarStock = 1;
									}
								  
									//ACTUALIZANDO NUEVA CANTIDAD
									$DatVentaDirectaDetalle->VddImporte = $DatVentaDirectaDetalle->VddPrecioVenta * $DatVentaDirectaDetalle->VddCantidadPendiente2;
	
									if($DatVentaDirecta->MonId<>$EmpresaMonedaId ){
									
										$DatVentaDirectaDetalle->VddImporte = round($DatVentaDirectaDetalle->VddImporte / $DatVentaDirecta->VdiTipoCambio,6);
										$DatVentaDirectaDetalle->VddPrecio = round($DatVentaDirectaDetalle->VddPrecio  / $DatVentaDirecta->VdiTipoCambio,6);
									
									}
	
								
									  $_SESSION['InsTallerPedidoDetalle'.$ModalidadIngreso.$Identificador]->MtdAgregarSesionObjeto(1,
									  NULL,
									  $InsProducto->ProId,
									  ($InsProducto->ProNombre),
									  $DatVentaDirectaDetalle->VddPrecioVenta,
									  $DatVentaDirectaDetalle->VddCantidadPendiente2,
									  $DatVentaDirectaDetalle->VddImporte,
									  date("d/m/Y H:i:s"),
									  date("d/m/Y H:i:s"),
									  $InsUnidadMedida->UmeNombre,
									  $InsUnidadMedida->UmeId,
									  $InsProducto->RtiId,
									  $CantidadReal,
									  $InsProducto->ProCodigoOriginal,
									  $InsProducto->ProCodigoAlternativo,
									  $InsProducto->UmeId,
									  $VerificarStock,
									  0,
									  1,
									  
									  NULL,
									  NULL,
									  
									  NULL,
									  NULL,
									  NULL,
									  NULL,
									  NULL,
									  NULL,
									  $CantidadReal,
									  3,
									  2,
									  $DatVentaDirectaDetalle->VddId,
									  
										$POST_AlmacenId,
										date("d/m/Y"),
										2,
										2
									  );		
				
							  }
				
						}
						
						
					}
				}
	
				
			}
		}
	
		



//	}
//}

	
?>
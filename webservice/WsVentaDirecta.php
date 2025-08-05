<?php
session_start();
//session_destroy();
if(empty($_SESSION['MysqlDeb'])){$_SESSION['MysqlDeb'] = false;}
if(empty($_SESSION['MysqlDeb'])){$_SESSION['MysqlDebLevel'] = 0;}
if(!empty($_GET['d']) and !empty($_GET['v'])){if(($_GET['d']==1)){$_SESSION['MysqlDeb']=true;}else{$_SESSION['MysqlDeb']=false;}$_SESSION['MysqlDebLevel']=$_GET['v'];}
////ARCHIVOS PRINCIPALES
require_once('../proyecto/ClsProyecto.php');
require_once('../proyecto/ClsPoo.php');


$InsProyecto->Ruta = '../';
$InsPoo->Ruta = '../';

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
require_once($InsProyecto->MtdRutClases().'ClsCorreo.php');
////CLASES GENERALES
require_once($InsProyecto->MtdRutConexiones().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');
////FUNCIONES GENERALES
require_once($InsProyecto->MtdRutFunciones().'FncGeneral.php');

require_once($InsProyecto->MtdRutLibrerias().'nusoap-0.9.5/lib/nusoap.php');


require_once($InsProyecto->MtdRutLibrerias().'JSON2.php');




require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirecta.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirectaDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirectaTarea.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirectaFoto.php');

require_once($InsPoo->MtdPaqLogistica().'ClsTipoOperacion.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqLogistica().'ClsClienteTipo.php');

require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionProducto.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionProductoDetalle.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionProductoFoto.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionProductoPlanchadoPintado.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedidaConversion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedida.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCodigoReemplazo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoVehiculoVersion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoAno.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsListaPrecio.php');
//require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCosto.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngreso.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersion.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCondicionPago.php');

require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');

$InsVentaDirecta = new ClsVentaDirecta();
$InsCliente = new ClsCliente();
$InsPersonal = new ClsPersonal();

$server = new soap_server();
$server->configureWSDL('WsVentaDirecta', 'urn:WsVentaDirecta');

//MtdEditarOrdenCompraDato($oId,$oCampo,$oDato)
$server->register('MtdRegistrarVentaDirecta',           // method name
	array(
	'oVentaDirectaDatos' => 'xsd:string',
	'oVentaDirectaDetalleDatos' => 'xsd:string'
	), // input parameters
    array('return' => 'xsd:string'),          // output parameters
    'urn:MtdRegistarVentaDirectawsdl',             // namespace
    'urn:MtdRegistarVentaDirectawsdl#MtdRegistrarVentaDirecta',         // soapaction
    'rpc',                 // style
    'encoded',                // use
    'Retorna el datos'              // documentation
);

function MtdRegistrarVentaDirecta($oVentaDirectaDatos,$oVentaDirectaDetalleDatos) {
	
	global $InsVentaDirecta;
	global $InsCliente;	
	global $InsPersonal;
	
	$Registrar = true;
	$Respuesta = 0;
	
	$ClienteId = "";
	$PersonalId = "";
	$VentaDirectaId = "";
	
	$JnVentaDirecta = array();
	$JnVentaDirectaDetalle = array();
	
	$JnVentaDirecta = json_decode($oVentaDirectaDatos);
	$JnVentaDirectaDetalle = json_decode($oVentaDirectaDetalleDatos);

	$InsCliente = new ClsCliente();
	$ClienteId = $InsCliente->MtdVerificarClienteExiste("CliNumeroDocumento",$JnVentaDirecta['CliNumeroDocumento']);

	$InsPersonal = new ClsPersonal();
	$PersonalId = $InsPersonal->MtdVerificarPersonalExiste("PerNumeroDocumento",$JnVentaDirecta['PerNumeroDocumento']);
	
	$Respuesta = json_encode($JnVentaDirecta);
	
	if(empty($ClienteId)){
		$Registrar = true;
	}

	if(empty($PersonalId)){		
		$Registrar = true;
	}
	
	if(empty($JnVentaDirectaDetalle)){		
		$Registrar = false;
	}

//	$Respuesta = $JnVentaDirecta['VdiId'];
//	if($Registrar){
//		
//		$InsVentaDirecta = new ClsVentaDirecta();
//	
//		$InsVentaDirecta->UsuId = NULL;	
//		
//		$InsVentaDirecta->VdiId =NULL;
//		$InsVentaDirecta->CliId = $ClienteId;
//		$InsVentaDirecta->PerId = $PersonalId;
//		
//		$InsVentaDirecta->FinId = NULL;
//		
//		$InsVentaDirecta->EinId = NULL;
//		$InsVentaDirecta->EinVIN = NULL;
//		$InsVentaDirecta->EinPlaca = NULL;
//		
//		$InsVentaDirecta->NpaId = $JnVentaDirecta['NpaId'];
//		
//		$InsVentaDirecta->VdiOrdenCompraNumero = "";
//		$InsVentaDirecta->VdiOrdenCompraFecha = "";
//		
//		$InsVentaDirecta->VdiMarca = $JnVentaDirecta['VdiMarca'];
//		$InsVentaDirecta->VdiModelo = $JnVentaDirecta['VdiModelo'];
//		$InsVentaDirecta->VdiPlaca = $JnVentaDirecta['VdiPlaca'];
//		$InsVentaDirecta->VdiAnoModelo = $JnVentaDirecta['VdiAnoModelo'];
//		$InsVentaDirecta->VdiAnoFabricacion = $JnVentaDirecta['VdiAnoFabricacion'];
//
//		$InsVentaDirecta->TopId = "TOP-10000";	
//
//		$InsVentaDirecta->VdiFecha = FncCambiaFechaAMysql($JnVentaDirecta['VdiFecha']);
//		list($InsVentaDirecta->VdiAno,$Mes,$Dia) = explode("-",$InsVentaDirecta->VdiFecha);
//	
//		$InsVentaDirecta->MonId = $JnVentaDirecta['MonId'];
//		$InsVentaDirecta->VdiTipoCambio = $JnVentaDirecta['VdiTipoCambio'];
//	
//		$InsVentaDirecta->VdiObservacion = $JnVentaDirecta['VdiObservacion'];
//		$InsVentaDirecta->VdiObservacionImpresa = $JnVentaDirecta['VdiObservacionImpresa'];
//		$InsVentaDirecta->VdiResultado = "";
//		$InsVentaDirecta->VdiOrigen =  "EXT";
//		
//		$InsVentaDirecta->VdiAbono = 0;
//		$InsVentaDirecta->VdiManoObra =0;
//		$InsVentaDirecta->VdiPorcentajeDescuento = $JnVentaDirecta['VdiPorcentajeDescuento'];
//
//		$InsVentaDirecta->VdiIncluyeImpuesto = $JnVentaDirecta['VdiIncluyeImpuesto'];
//		$InsVentaDirecta->VdiNotificar = 2;
//		
//		$InsVentaDirecta->VdiArchivo = $JnVentaDirecta['VdiArchivo'];
//		$InsVentaDirecta->VdiArchivoEntrega = NULL;
//		$InsVentaDirecta->VdiArchivoEntrega2 = NULL;
//		
//		$InsVentaDirecta->VdiEstado =3;
//		$InsVentaDirecta->VdiTiempoCreacion = date("Y-m-d H:i:s");
//		$InsVentaDirecta->VdiTiempoModificacion = date("Y-m-d H:i:s");
//	
//		$InsVentaDirecta->VdiPorcentajeImpuestoVenta = $JnVentaDirecta['VdiPorcentajeImpuestoVenta'];
//		$InsVentaDirecta->VdiMargenUtilidad = $JnVentaDirecta['VdiMargenUtilidad'];
//		$InsVentaDirecta->VdiFlete = 0;
//		
//		$InsVentaDirecta->VdiDireccion = $JnVentaDirecta['VdiDireccion'];
//	
//		$InsVentaDirecta->CprId = NULL;
//	
//		$InsVentaDirecta->JnVentaDirectaDetalle = array();
//		$InsVentaDirecta->VentaDirectaPlanchado = array();
//		$InsVentaDirecta->VentaDirectaPintado = array();
//		$InsVentaDirecta->VentaDirectaCentrado = array();
//		$InsVentaDirecta->VentaDirectaTarea = array();
//	
//		$InsVentaDirecta->VdiPlanchadoTotal = 0;
//		$InsVentaDirecta->VdiPintadoTotal = 0;
//		$InsVentaDirecta->VdiCentradoTotal = 0;
//		$InsVentaDirecta->VdiTareaTotal = 0;
//		
//		$InsVentaDirecta->VdiDescuento = 0;
//		$InsVentaDirecta->VdiSubTotal = 0;
//		$InsVentaDirecta->VdiImpuesto = 0;
//		$InsVentaDirecta->VdiTotal = 0;
//		$InsVentaDirecta->VdiObservado = 2;
//		
//		
//		if(!empty($JnVentaDirectaDetalle)){
//			foreach($JnVentaDirectaDetalle as $DatVentaDirectaDetalle){
//				
//				$InsVentaDirectaDetalle1 = new ClsVentaDirectaDetalle();
//
//				$DetallePrecioBruto = 0;
//				$DetalleDescuento = 0;
//				$DetallePrecio = 0;
//				$DetalleImporte = 0;
//			
//				if(!empty($InsVentaDirecta->VdiPorcentajeDescuento)){
//					
//					$DetallePrecioBruto = ($DatVentaDirectaDetalle->VddPrecioBruto);
//					$DetallePrecio = $DetallePrecioBruto;
//					$DetalleImporte = ($DetallePrecio * $DatVentaDirectaDetalle->VddCantidad);
//						
//					$DetallePrecioDescuento =  $DetallePrecio - ($DetallePrecio * ($InsVentaDirecta->VdiPorcentajeDescuento/100));
//					
//					$DetalleDescuento = ($DetalleImporte * ($InsVentaDirecta->VdiPorcentajeDescuento/100));
//					$DetalleImporteFinal = $DetalleImporte - $DetalleDescuento;
//				
//				}else{
//				
//					$DetallePrecioBruto = ($DatVentaDirectaDetalle->VddPrecioBruto);
//					$DetallePrecio = $DetallePrecioBruto;
//					$DetalleImporte = ($DetallePrecio * $DatVentaDirectaDetalle->VddCantidad);
//					
//					$DetallePrecioDescuento =  $DetallePrecio;
//					
//					$DetalleDescuento = 0;
//					$DetalleImporteFinal = $DetalleImporte - $DetalleDescuento;
//				
//				}
//			
//				$InsVentaDirectaDetalle1->ProId = $DatVentaDirectaDetalle->ProId;
//				$InsVentaDirectaDetalle1->UmeId = $DatVentaDirectaDetalle->UmeId;
//				$InsVentaDirectaDetalle1->UmeIdOrigen = $DatVentaDirectaDetalle->UmeIdOrigen;
//				
//				$InsVentaDirectaDetalle1->VddCantidadPedir = 0;
//				$InsVentaDirectaDetalle1->VddCantidadPedirFecha = NULL;
//				
//				$InsVentaDirectaDetalle1->VerificarStock = 0;
//				$InsVentaDirectaDetalle1->VddCosto = 0;
//				$InsVentaDirectaDetalle1->VddValorTotal = 0;
//				$InsVentaDirectaDetalle1->VddUtilidad = 0;		 	
//				$InsVentaDirectaDetalle1->VddCostoExtraTotal = 0;	
//			
//				$InsVentaDirectaDetalle1->VddPrecioBruto =  $DetallePrecioBruto;
//				$InsVentaDirectaDetalle1->VddPrecioVenta =  $DetallePrecioDescuento;
//				$InsVentaDirectaDetalle1->VddDescuento = $DetalleDescuento;
//				$InsVentaDirectaDetalle1->VddImporte = $DetalleImporteFinal;
//			
//				$InsVentaDirectaDetalle1->VddCantidadReal = $DatVentaDirectaDetalle->VddCantidadReal;
//				$InsVentaDirectaDetalle1->VddCantidad = $DatVentaDirectaDetalle->VddCantidad;
//				
//				$InsVentaDirectaDetalle1->VddTipoPedido = $DatVentaDirectaDetalle->VddTipoPedido;
//				$InsVentaDirectaDetalle1->VddEstado = $DatVentaDirectaDetalle->VddEstado;
//				$InsVentaDirectaDetalle1->VddTiempoCreacion = date("Y-m-d H:i:s");
//				$InsVentaDirectaDetalle1->VddTiempoModificacion = date("Y-m-d H:i:s");
//	
//				$InsVentaDirectaDetalle1->CrdId = NULL;
//	
//				$InsVentaDirectaDetalle1->VddEliminado = $DatVentaDirectaDetalle->Eliminado;
//				$InsVentaDirectaDetalle1->InsMysql = NULL;
//	
//				if($InsVentaDirectaDetalle1->VddEliminado==1){					
//					$InsVentaDirecta->VentaDirectaDetalle[] = $InsVentaDirectaDetalle1;		
//				
//				}
//	
//				if($InsVentaDirectaDetalle1->VddEliminado==1 and ($DatVentaDirectaDetalle->VddEstado == 1 or $DatVentaDirectaDetalle->VddEstado == 7)){
//					
//					$InsVentaDirecta->VdiProductoTotal += $InsVentaDirectaDetalle1->VddImporte;	
//					$InsVentaDirecta->VdiDescuento += $InsCotizacionProductoDetalle1->VddDescuento;	
//	
//				}
//				
//				
//			}
//		}
//		
//
//	
//		if($InsVentaDirecta->VdiIncluyeImpuesto==2){
//			
//			$InsVentaDirecta->VdiSubTotal = round($InsVentaDirecta->VdiTotalBruto - $InsVentaDirecta->VdiDescuento ,6);
//			$InsVentaDirecta->VdiImpuesto = round(($InsVentaDirecta->VdiSubTotal * ($InsVentaDirecta->VdiPorcentajeImpuestoVenta/100)),6);
//			$InsVentaDirecta->VdiTotal = round($InsVentaDirecta->VdiSubTotal + $InsVentaDirecta->VdiImpuesto,6);
//			
//		}else{
//			
//			$InsVentaDirecta->VdiTotal = round($InsVentaDirecta->VdiTotalBruto - $InsVentaDirecta->VdiDescuento,6);	
//			$InsVentaDirecta->VdiSubTotal = round($InsVentaDirecta->VdiTotal / (($InsVentaDirecta->VdiPorcentajeImpuestoVenta/100)+1),6);
//			$InsVentaDirecta->VdiImpuesto = round(($InsVentaDirecta->VdiTotal - $InsVentaDirecta->VdiSubTotal),6);
//			
//		}
//	
//	
//		
//		if($InsVentaDirecta->MtdRegistrarVentaDirecta()){	
//			$Respuesta = 1;
//		} else{
//			$Respuesta = 2;
//		}	
//		
//		
//		
//	}

	return $Respuesta;
}



$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$server->service($HTTP_RAW_POST_DATA);

?>
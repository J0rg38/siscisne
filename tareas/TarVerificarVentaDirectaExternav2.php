<?php
session_start();
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
require_once($InsProyecto->MtdRutLibrerias().'PHPMailer_5.2.4/class.phpmailer.php');
require_once($InsProyecto->MtdRutClases().'ClsCorreo.php');

////CLASES GENERALES
require_once($InsProyecto->MtdRutConexiones().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');
////FUNCIONES GENERALES
require_once($InsProyecto->MtdRutFunciones().'FncGeneral.php');


//require_once('../librerias/nusoap-0.9.5/lib/nusoap.php');
require_once($InsProyecto->MtdRutLibrerias().'nusoap-0.9.5/lib/nusoap.php');
//require_once('../librerias/JSON2.php');
require_once($InsProyecto->MtdRutLibrerias().'JSON2.php');
require_once($InsProyecto->MtdRutLibrerias().'JSON.php');

require_once($InsPoo->MtdPaqAcceso().'ClsAuditoria.php');


require_once($InsProyecto->MtdRutLibrerias().'fpdf17/fpdf.php');

define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

/** Include PHPExcel */
//require_once dirname(__FILE__) . '/../Classes/PHPExcel.php';
require_once($InsProyecto->MtdRutLibrerias().'ZipArchive.php');
require_once($InsProyecto->MtdRutLibrerias().'PHPExcel_1.8.0_doc/Classes/PHPExcel.php');

//50.62.8.12
$client = new nusoap_client('http://50.62.8.123/ventas/webservice/WsVentaDirecta.php?wsdl','wsdl');

$err = $client->getError();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>

</head>

<body>
<?php

$GET_Accion = $_GET['Accion'];

$DestinatariosCorreo = "chevrolet.carperu@gm.com, pcondori@cyc.com.pe, jblanco@cyc.com.pe, aliendo@cyc.com.pe, iquezada@cyc.com.pe, scanepam@cyc.com.pe, bernardo.marcos@gm.com, richard.duenas@gm.com, dvercelone@cyc.com.pe, anace@cyc.com.pe, jean.anca@gm.com";
//$DestinatariosCorreo = "jblanco@cyc.com.pe";
$DestinatariosNotificacion = "jblanco@cyc.com.pe,pcondori@cyc.com.pe,scanepam@cyc.com.pe,aliendo@cyc.com.pe";
//$DestinatariosNotificacion = "jblanco@cyc.com.pe";

//$GET_GenerarPedidoCompra = (empty($_GET['GenerarPedidoCompra'])?1:2);
//$GET_GenerarOrdenCompra = (empty($_GET['GenerarOrdenCompra'])?1:2);
$GET_GenerarPedidoCompra = 2;//1
$GET_GenerarOrdenCompra = 2;//1
$GET_EnviarOrdenCompra = 2;//1

include($InsProyecto->MtdFormulariosMsj("VentaDirecta").'MsjVentaDirecta.php');
include($InsProyecto->MtdFormulariosMsj("Producto").'MsjProducto.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirecta.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirecta.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirectaDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirectaTarea.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirectaFoto.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsTipoCambio.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedida.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenStock.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsProductoDisponibilidad.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoListaPrecio.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoReemplazo.php');

require_once($InsPoo->MtdPaqExterno().'ClsVentaDirectaExterno.php');

require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqLogistica().'ClsClienteTipo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsTipoCambio.php');

require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompra.php');
require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompraDetalle.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompra.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompraDetalle.php');
require_once($InsPoo->MtdPaqLogistica().'ClsProveedor.php');
require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');

if ($err) {
	echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
}

$param = array(	'oEstado' => "3",
				'oVigente' => "",
				'oLimite' => "10",
				'oFechaInicio' => date("Y")."-01-01",
				'oFechaFin' => date("Y-m-d")
				);
$ArrVentaDirectaExternas = $client->call('MtdObtenerVentaDirectas', $param);


$json = new Services_JSON();
$ArrVentaDirectaExternas = $json->decode($ArrVentaDirectaExternas);


$TotalOrdenes = count($ArrVentaDirectaExternas);
$TotalOrdenNoRegistrada = 0;

$TotalProductoNuevo = 0;
$TotalProductoNuevoNoRegistrada = 0;
$TotalOrdenNoPermitida = 0;
$TotalOrdenRepetida = 0;
//deb($ArrVentaDirectaExternas);

$fila = 1;
if(!empty($ArrVentaDirectaExternas)){
	foreach($ArrVentaDirectaExternas as $DatVentaDirectaExterna){
		
		$Resultado = "";
		$GuardarOrden = true;
		$ObservarOrden = false;

			echo "[Fila ".$fila."]>";		
			echo "Id Externo: ".$DatVentaDirectaExterna->VdiId."<br />";
			echo "Fecha Externa: ".$DatVentaDirectaExterna->VdiFecha."<br />";

			$InsCliente = new ClsCliente();	
			$InsCliente->CliNombre = $DatVentaDirectaExterna->CliNombre." ".$DatVentaDirectaExterna->CliApellidoPaterno." ".$DatVentaDirectaExterna->CliApellidoMaterno;			
			$InsCliente->CliNumeroDocumento = $DatVentaDirectaExterna->CliNumeroDocumento;
			
			$ClienteId = $InsCliente->MtdVerificarExisteCliente();

			echo "DNI Personal a buscar: ".$DatVentaDirectaExterna->PerNumeroDocumento;
			echo "<br>";
			
			$InsPersonal = new ClsPersonal();
			//public function MtdObtenerPersonales($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PerId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPersonalTipo=NULL,$oEstado=NULL,$oFechaNacimientoRango=NULL,$oTaller=NULL,$oRecepcion=NULL,$oVenta=NULL) {
			$ResPersonal = $InsPersonal->MtdObtenerPersonales("PerNumeroDocumento","esigual",$DatVentaDirectaExterna->PerNumeroDocumento,'PerId','DESC','1',NULL,NULL,NULL,NULL,NULL,NULL);
			$ArrPersonales = $ResPersonal['Datos'];
			
			$PersonalId = "";
			$PersonalEmail = "";
			$PersonalAbreviatura = "";

			if(!empty($ArrPersonales)){
				foreach($ArrPersonales as $DatPersonal){
						
					$PersonalId = $DatPersonal->PerId;
					$PersonalEmail = $DatPersonal->PerEmail;
					$PersonalAbreviatura = $DatPersonal->PerAbreviatura;	
						
				}
			}
			
			echo "PersonalId: ".$PersonalId;
			echo "<br>";
			echo "PersonalEmail: ".$PersonalEmail;
			echo "<br>";
			echo "PersonalAbreviatura: ".$PersonalAbreviatura;
			echo "<br>";
			
				echo "Identificando cliente ".$DatVentaDirectaExterna->CliNombre." ".$DatVentaDirectaExterna->CliApellidoPaterno." ".$DatVentaDirectaExterna->CliApellidoMaterno."...<br>";
				
				if(empty($ClienteId)){
						
					echo "Cliente NO IDENTIFICADO, se procedera a registrar uno nuevo...<br />";
					
					$InsCliente = new ClsCliente();	
					$InsCliente->CliId = NULL;
					$InsCliente->LtiId = "LTI-10011";		
					$InsCliente->TdoId = $DatVentaDirectaExterna->TdoId;					
					$InsCliente->CliNombre = $DatVentaDirectaExterna->CliNombre;
					$InsCliente->CliApellidoPaterno = $DatVentaDirectaExterna->CliApellidoPaterno;
					$InsCliente->CliApellidoMaterno = $DatVentaDirectaExterna->CliApellidoMaterno;
					
					$InsCliente->CliDireccion = $DatVentaDirectaExterna->CliDireccion;
					$InsCliente->CliDepartamento = $DatVentaDirectaExterna->CliDepartamento;
					$InsCliente->CliProvincia = $DatVentaDirectaExterna->CliProvincia;
					$InsCliente->CliDistrito = $DatVentaDirectaExterna->CliDistrito;
					
					$InsCliente->CliNumeroDocumento = $DatVentaDirectaExterna->CliNumeroDocumento;
					
					$InsCliente->CliLineaCredito = 0;
					$InsCliente->CliCSIIncluir = 1;
						
					$InsCliente->CliCSIVentaIncluir = 1;
					$InsCliente->CliClasificacion = 1;
					$InsCliente->CliEstado = 1;
					$InsCliente->CliTiempoCreacion = date("Y-m-d H:i:s");
					$InsCliente->CliTiempoModificacion = date("Y-m-d H:i:s");
										
					if(!$InsCliente->MtdRegistrarCliente()){
						
						echo "El Cliente no se pudo registrar. PROCESO CANCELADO<br />";
						
						$GuardarOrden  = false;
					}else{
						
						echo "El Cliente ha sido registrado correctamente<br />";
						
						$ClienteId = $InsCliente->CliId;	
					}
	
				}else{
					echo "Cliente IDENTIFICADO<br />";
				}

			$VentaDirectaArchivo = "";
			
			if(!empty($DatVentaDirectaExterna->VdiArchivo)){
				
				//$Subido = file_put_contents("../subidos/venta_directa/".$DatVentaDirectaExterna->VdiArchivo, fopen("http://50.62.8.123/ventas/subidos/venta_directa_fotos/".$DatVentaDirectaExterna->VdiArchivo, 'r'));
				$ArchivoRemoto = file_url("http://50.62.8.123/ventas/subidos/venta_directa_fotos/".($DatVentaDirectaExterna->VdiArchivo));
				$ArchivoLocal = "../subidos/venta_directa/".str_replace(' ', '_', $DatVentaDirectaExterna->VdiArchivo);
				$ArchivoDescargado = file_get_contents($ArchivoRemoto);							

				$Subido = file_put_contents($ArchivoLocal, $ArchivoDescargado);
							
				if($Subido){
					$VentaDirectaArchivo = str_replace(' ', '_', $DatVentaDirectaExterna->VdiArchivo);
				}
				
			}

			
			$ClienteAbreviatura = "";

			if(!empty($ClienteId)){

				$InsCliente = new ClsCliente();
				$InsCliente->CliId = $ClienteId;
				$InsCliente->MtdObtenerCliente(false);
				$Abreviatura = $InsCliente->CliAbreviatura;
				
			}

			$InsVentaDirecta = new ClsVentaDirecta();
			$InsVentaDirecta->UsuId = "USU-10000";	
			
			$InsVentaDirecta->VdiId = NULL;
			$InsVentaDirecta->CliId = $ClienteId;
			$InsVentaDirecta->PerId = $PersonalId;
				
			$InsVentaDirecta->EinId = NULL;
			$InsVentaDirecta->EinVIN = NULL;
			$InsVentaDirecta->EinPlaca = NULL;
			$InsVentaDirecta->NpaId = $DatVentaDirectaExterna->NpaId;

			$InsVentaDirecta->VdiOrdenCompraNumero = $PersonalAbreviatura."-".$Abreviatura."/OC ".$DatVentaDirectaExterna->VdiOrdenCompraNumero;
			$InsVentaDirecta->VdiOrdenCompraFecha = FncCambiaFechaAMysql($DatVentaDirectaExterna->VdiFecha);
			
			$InsVentaDirecta->VdiMarca = $DatVentaDirectaExterna->VdiMarca;
			$InsVentaDirecta->VdiModelo = $DatVentaDirectaExterna->VdiModelo;
			$InsVentaDirecta->VdiPlaca = $DatVentaDirectaExterna->VdiPlaca;
			$InsVentaDirecta->VdiAnoModelo = $DatVentaDirectaExterna->VdiAnoModelo;
			$InsVentaDirecta->VdiAnoFabricacion = $DatVentaDirectaExterna->VdiAnoFabricacion;
			$InsVentaDirecta->TopId = "TOP-10000";

			$InsVentaDirecta->VdiFecha = date("Y-m-d");
			list($InsVentaDirecta->VdiAno,$Mes,$Dia) = explode("-",$InsVentaDirecta->VdiFecha);
		
			$InsVentaDirecta->MonId = $DatVentaDirectaExterna->MonId;
			$InsVentaDirecta->VdiTipoCambio = $DatVentaDirectaExterna->VdiTipoCambio;
	
			$InsVentaDirecta->VdiObservacion = "Generado automaticamente por sistema el ".date("d/m/Y H:i:s")." / Tipo Pedido: ".$DatVentaDirectaExterna->VdiTipoPedido;
			$InsVentaDirecta->VdiObservacionImpresa = "Generado automaticamente por sistema el ".date("d/m/Y H:i:s");
			$InsVentaDirecta->VdiOrigen =  "VEX";			
			$InsVentaDirecta->VdiManoObra = 0;
			$InsVentaDirecta->VdiDescuento = 0;			
			$InsVentaDirecta->VdiPorcentajeImpuestoVenta = $DatVentaDirectaExterna->VdiPorcentajeImpuestoVenta;
			$InsVentaDirecta->VdiIncluyeImpuesto = $DatVentaDirectaExterna->VdiIncluyeImpuesto;		
				
			$InsVentaDirecta->VdiPorcentajeDescuento = $DatVentaDirectaExterna->VdiPorcentajeDescuento;
			$InsVentaDirecta->VdiPorcentajeMargenUtilidad = 0;//VdiPorcentajeDescuento
			$InsVentaDirecta->VdiPorcentajeOtroCosto = 0;//VdiPorcentajeDescuento
			$InsVentaDirecta->VdiPorcentajeManoObra = 0;//VdiPorcentajeDescuento
			$InsVentaDirecta->VdiObservado = 2;	
			
			$InsVentaDirecta->VdiArchivo = $VentaDirectaArchivo;	
			
			$InsVentaDirecta->VdiNotificar = 1;		
//			$InsVentaDirecta->VdiArchivo = NULL;			
			$InsVentaDirecta->VdiCodigoExterno = $DatVentaDirectaExterna->VdiId;
			$InsVentaDirecta->VdiTipoPedido = NULL;
			$InsVentaDirecta->VdiEstado = 1;
			$InsVentaDirecta->VdiTiempoCreacion = date("Y-m-d H:i:s");
			$InsVentaDirecta->VdiTiempoModificacion = date("Y-m-d H:i:s");
		
			$InsVentaDirecta->VdiMargenUtilidad = 0;
			$InsVentaDirecta->VdiFlete = 0;
			$InsVentaDirecta->VdiPorcentajeDescuento = 0;
			$InsVentaDirecta->LtiId = "LTI-10011";//VERIFICAR
			$InsVentaDirecta->VdiDireccion = $DatVentaDirectaExterna->VdiDireccion;
			$InsVentaDirecta->CprId = NULL;	
			
			$InsVentaDirecta->VentaDirectaDetalle = array();
		
			$InsVentaDirecta->VdiPlanchadoTotal = 0;
			$InsVentaDirecta->VdiPintadoTotal = 0;
			$InsVentaDirecta->VdiCentradoTotal = 0;
			$InsVentaDirecta->VdiTareaTotal = 0;
			
			$InsVentaDirecta->VdiSubTotal = 0;
			$InsVentaDirecta->VdiImpuesto = 0;
			$InsVentaDirecta->VdiTotal = 0;

			if($InsVentaDirecta->MonId<>$EmpresaMonedaId){
				
				if(empty($InsVentaDirecta->VdiTipoCambio)){
					$GuardarOrden = false;
					$Resultado .= date("d/m/Y H:i:s")." - Ha ocurrido un error interno TCANOREG".chr(13);
					
					echo "No ha ingresado el tipo de cambio.<br />";
					
				}
				
			}
			
			if(!empty($InsVentaDirecta->VdiCodigoExterno)){
				if($InsVentaDirecta->MtdVerificarExisteVentaDirectaDato("VdiCodigoExterno",$InsVentaDirecta->VdiCodigoExterno,$InsVentaDirecta->CliId)){
					$GuardarOrden = false;
					$Resultado .= date("d/m/Y H:i:s")." - EL numero de Orden de Venta esta repetido".chr(13);
					
					echo "El Numero de Orden de Venta ya se encuentra registrado.<br />";
					
					$TotalOrdenRepetida++;

				};
			}


			$item = 1;	
			if($GuardarOrden){
				
	            $param = array('oId' => $DatVentaDirectaExterna->VdiId);
    	        $ArrVentaDirectaDetalleExternos  = $client->call('MtdObtenerVentaDirectaDetalles', $param);
            
        	    $json = new Services_JSON();
            	$ArrVentaDirectaDetalleExternos = $json->decode($ArrVentaDirectaDetalleExternos);

				if(!empty($ArrVentaDirectaDetalleExternos)){
					foreach($ArrVentaDirectaDetalleExternos as $DatVentaDirectaDetalleExterno){
					
						if(!empty($DatVentaDirectaDetalleExterno->ProCodigoOriginal)){
										
							if($GuardarOrden){
								
								//$VentaDirectaDetalleImporteFinal = 0;	
//								$VentaDirectaDetallePrecioVenta = 0;	
//													
//								$VentaDirectaDetalleDescuento = $DatVentaDirectaDetalleExterno->VddImporte * ($DatVentaDirectaExterna->VdiPorcentajeDescuento/100);					
//
//								$VentaDirectaDetalleImporteFinal = ($DatVentaDirectaDetalleExterno->VddImporte - $VentaDirectaDetalleDescuento);
//								$VentaDirectaDetallePrecioVenta = $VentaDirectaDetalleImporteFinal / $DatVentaDirectaDetalleExterno->VddCantidad;
								$VentaDirectaDetallePrecioVenta = $DatVentaDirectaDetalleExterno->VddImporte / $DatVentaDirectaDetalleExterno->VddCantidad;
//								
								$InsVentaDirectaDetalle1 = new ClsVentaDirectaDetalle();
								
								echo "Identificando producto ".$DatVentaDirectaDetalleExterno->ProCodigoOriginal."".$DatVentaDirectaDetalleExterno->ProNombre."...<br>";
										
								$InsProducto = new ClsProducto();
								$ResProducto = $InsProducto->MtdObtenerProductos("ProCodigoOriginal","esigual",trim($DatVentaDirectaDetalleExterno->ProCodigoOriginal),'ProId','Desc','1',NULL,NULL,1,NULL,NULL,NULL,NULL,false);
								$ArrProductos = $ResProducto['Datos'];
						
								$ProductoId = "";
								$ProductoNombre = "";
								$ProductoCodigoOriginal = "";
								$UnidadMedidaId = "";
								$ProductoCosto = 0;
										
								if(!empty($ArrProductos)){
									foreach($ArrProductos as $DatProducto){
										
										$ProductoId = $DatProducto->ProId;
										$ProductoNombre = $DatProducto->ProNombre;
										$ProductoCodigoOriginal = $DatProducto->ProCodigoOriginal;
										$UnidadMedidaId = $DatProducto->UmeId;
										$ProductoCosto = $DatProducto->ProCosto;
										
									}
									
									//echo "Producto identificado <b>".$ProductoCodigoOriginal." - ".$ProductoNombre."</b><br />";			
									echo "Producto IDENTIFICADO<br />";			

								}else{
						
									$TotalProductoNuevo++;
									
									echo "Producto NO IDENTIFICADO, se procedera a registrar uno nuevo...<br />";
				
									$ProductoCodigoOriginal = $DatVentaDirectaDetalleExterno->ProCodigoOriginal;	
									$ProductoNombre = $DatVentaDirectaDetalleExterno->ProNombre;
									$UnidadMedidaId = $DatVentaDirectaDetalleExterno->UmeId;
				
									$InsProducto = new ClsProducto();
									$InsProducto->ProId = NULL;
									$InsProducto->ProCodigoAlternativo = "";
									$InsProducto->ProCodigoOriginal = addslashes($ProductoCodigoOriginal);
									$InsProducto->ProNombre = addslashes($ProductoNombre);
									$InsProducto->ProUbicacion = "-";
									$InsProducto->ProReferencia = $DatVentaDirectaExterna->VdiModelo." / Agregado automaticamente por sistema el ".date("d/m/Y");
									$InsProducto->ProEspecificacion = "";
									
									$InsProducto->UmeId = $UnidadMedidaId;
									$InsProducto->UmeIdIngreso = $UnidadMedidaId;	
								
									$InsProducto->ProCodigoBarra = $InsProducto->ProCodigoOriginal;
									$InsProducto->ProStockMinimo = 1;
								
									$InsProducto->RtiId = "RTI-10000";	
									$InsProducto->ProFoto = "";
									$InsProducto->ProValidarStock = 1;	
									
									$InsProducto->ProValidarUso = 1;

									$InsProducto->ProPeso = 0;
									$InsProducto->ProLargo = 0;
									$InsProducto->ProAncho = 0;
									$InsProducto->ProAlto = 0;
									
									$InsProducto->ProVolumen = 0;
									$InsProducto->ProTieneDisponibilidadGM = 0;
									$InsProducto->ProDisponibilidadCantidadGM = 0;
									
									$InsProducto->ProPorcentajeDescuento = 0;
									$InsProducto->ProPorcentajeAdicional = 0;
									
									$InsProducto->ProTienePromocion = 2;
									$InsProducto->ProCalcularPrecio = 2;
									
									$InsProducto->ProCritico = 2;		
									$InsProducto->ProDescontinuado = 2;
		
									$InsProducto->ProEstado = 1;	
									$InsProducto->ProTiempoCreacion = date("Y-m-d H:i:s");
									$InsProducto->ProTiempoModificacion = date("Y-m-d H:i:s");
									$InsProducto->ProEliminado = 1;
								
									$InsProducto->ProductoVehiculoVersion = array();
									$InsProducto->ProductoAno = array();
									$InsProducto->ProductoCodigoReemplazo = array();
											
									if(!empty($ProductoCodigoOriginal)){
				
										if($InsProducto->MtdRegistrarProducto()){
											
											$ProductoId = $InsProducto->ProId;
											$UnidadMedidaId = $InsProducto->UmeId;
											$ProductoCosto = $InsProducto->ProCosto;
											
											echo "Se registro correctamente el producto.<br />";

										}else{
		  
											$GuardarOrden = false;
											$Resultado .= date("d/m/Y H:i:s")." - ".$ProductoCodigoOriginal." Ha ocurrido un error interno PRONOREG".chr(13);
											
											echo "No se pudo registrar el producto. PROCESO CANCELADO<br />";
		  
											$TotalProductoNuevoNoRegistrada++;
					
										}
										
									}
											
								}
								
									$InsVentaDirectaDetalle1->ProId = $ProductoId;
									$InsVentaDirectaDetalle1->UmeId = $UnidadMedidaId;
						
									$InsVentaDirectaDetalle1->VddCantidadPedir = 0;
									$InsVentaDirectaDetalle1->VddCantidadPedirFecha = NULL;
									$InsVentaDirectaDetalle1->VerificarStock = 2;
	
									$InsVentaDirectaDetalle1->VddValorTotal = 0;
									$InsVentaDirectaDetalle1->VddUtilidad = 0;
									
									$InsVentaDirectaDetalle1->VddTipoPedido = $DatVentaDirectaDetalleExterno->VddTipoPedido;
									$InsVentaDirectaDetalle1->VddCostoExtraTotal = 0;			
									$InsVentaDirectaDetalle1->VddCantidadReal = $DatVentaDirectaDetalleExterno->VddCantidad;
									$InsVentaDirectaDetalle1->VddCantidad = $DatVentaDirectaDetalleExterno->VddCantidad;
									
									$InsVentaDirectaDetalle1->VddCosto = $DatVentaDirectaDetalleExterno->VddCosto;
									//$InsVentaDirectaDetalle1->VddPrecioBruto = 0;	
									$InsVentaDirectaDetalle1->VddPrecioBruto = $VentaDirectaDetallePrecioVenta;		
									$InsVentaDirectaDetalle1->VddPrecioVenta = $VentaDirectaDetallePrecioVenta;					
									$InsVentaDirectaDetalle1->VddDescuento = 0;
									//$InsVentaDirectaDetalle1->VddImporte = $VentaDirectaDetalleImporteFinal;
									$InsVentaDirectaDetalle1->VddImporte = $DatVentaDirectaDetalleExterno->VddImporte;
									
									$InsVentaDirectaDetalle1->VddCodigoExterno = $DatVentaDirectaDetalleExterno->VddId;
									$InsVentaDirectaDetalle1->VddEstado = 1;
									$InsVentaDirectaDetalle1->VddTiempoCreacion = date("Y-m-d H:i:s");
									$InsVentaDirectaDetalle1->VddTiempoModificacion = date("Y-m-d H:i:s");
						
									$InsVentaDirectaDetalle1->VddEliminado = 1;
									$InsVentaDirectaDetalle1->InsMysql = NULL;
									
									if($InsVentaDirectaDetalle1->VddEliminado==1){		
											
										$InsVentaDirecta->VentaDirectaDetalle[] = $InsVentaDirectaDetalle1;	
										$InsVentaDirecta->VdiTotalBruto += $InsVentaDirectaDetalle1->VddImporte;	
	
									
									}
								
								}
	
						}else{

							$GuardarOrden = false;
							$Resultado .= date("d/m/Y H:i:s")." - Ha ocurrido un error interno PRONOCOD".chr(13);
							
							break;
						}

						$item++;	
					}
						
				}else{
				
					$GuardarOrden = false;
					$Resultado .= date("d/m/Y H:i:s")." - La Orden de Venta no tiene items".chr(13);
					
					echo "La Orden de Venta no tiene items <br />";

				}
		
			}
			
			if($InsVentaDirecta->VdiIncluyeImpuesto==2){
				$InsVentaDirecta->VdiSubTotal = round($InsVentaDirecta->VdiTotalBruto - $InsVentaDirecta->VdiDescuento  + $InsVentaDirecta->VdiManoObra + $InsVentaDirecta->VdiPlanchadoTotal + $InsVentaDirecta->VdiPintadoTotal + $InsVentaDirecta->VdiCentradoTotal + $InsVentaDirecta->VdiTareaTotal,6);
				$InsVentaDirecta->VdiImpuesto = round(($InsVentaDirecta->VdiSubTotal * ($InsVentaDirecta->VdiPorcentajeImpuestoVenta/100)),6);
				$InsVentaDirecta->VdiTotal = round($InsVentaDirecta->VdiSubTotal + $InsVentaDirecta->VdiImpuesto,6);
			}else{
				$InsVentaDirecta->VdiTotal = round($InsVentaDirecta->VdiTotalBruto - $InsVentaDirecta->VdiDescuento + $InsVentaDirecta->VdiManoObra + $InsVentaDirecta->VdiPlanchadoTotal + $InsVentaDirecta->VdiPintadoTotal + $InsVentaDirecta->VdiCentradoTotal + $InsVentaDirecta->VdiTareaTotal,6);	
				$InsVentaDirecta->VdiSubTotal = round($InsVentaDirecta->VdiTotal / (($InsVentaDirecta->VdiPorcentajeImpuestoVenta/100)+1),6);
				$InsVentaDirecta->VdiImpuesto = round(($InsVentaDirecta->VdiTotal - $InsVentaDirecta->VdiSubTotal),6);
			}
	
			if($GuardarOrden){
				
				if($InsVentaDirecta->MtdRegistrarVentaDirecta()){
		
//					$Destinatarios = "jblanco@cyc.com.pe,scanepam@cyc.com.pe,pcondori@cyc.com.pe";
					
					if(!empty($PersonalEmail)){
					
						$ArrCorreos = explode(",",$DestinatariosNotificacion);
					
						if(!in_array($PersonalEmail,$ArrCorreos)){
							$DestinatariosNotificacion .= ",".$PersonalEmail;
						}
					
					}

					if(!empty($PersonalEmail)){
					
						$ArrCorreos = explode(",",$DestinatariosCorreo);
					
						if(!in_array($PersonalEmail,$ArrCorreos)){
							$DestinatariosCorreo .= ",".$PersonalEmail;
						}
					
					}

					$InsVentaDirecta->MtdNotificarVentaDirectaRegistro($InsVentaDirecta->VdiId,$DestinatariosNotificacion,false);
					
					$param = array(
					'oId' => $DatVentaDirectaExterna->VdiId,
					'oCampo' => "VdiEstado",
					'oDato' => "7");
					$EditoVentaDirectaDato  = $client->call('MtdEditarVentaDirectaDato', $param);
					
					if($GET_GenerarPedidoCompra=="1"){
						
						
						//PEDIDO STK/STX
						//MtdVentaDirectaGenerarPedidoCompra($oVentaDirectaId,$oGenerarOrdenCompra=false,$oIgnorarStock=false){
						if($InsVentaDirecta->MtdVentaDirectaGenerarPedidoCompra($InsVentaDirecta->VdiId,true,true,"NORMAL")){
							 
							 echo "El Pedido de Compra se registro correctamente.<br />";
							 
							 $InsPedidoCompra = new ClsPedidoCompra();
							 //public function MtdObtenerPedidoCompras($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'PcoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oConOrdenCompra=0,$oVentaDirecta=NULL,$oOrdenCompra=NULL,$oFichaAccion=NULL,$oFichaIngreso=NULL,$oOrigen=array()) {
							$ResPedidoCompra = $InsPedidoCompra->MtdObtenerPedidoCompras(NULL,NULL,NULL,'PcoId','Desc','1',NULL,NULL,NULL,NULL,0,$InsVentaDirecta->VdiId,NULL,NULL,NULL,array());							 
							$ArrPedidoCompras = $ResPedidoCompra['Datos'];
							
							$PedidoCompraId = "";
							
							if(!empty($ArrPedidoCompras)){
								foreach($ArrPedidoCompras as $DatPedidoCompra){
									
									$PedidoCompraId = $DatPedidoCompra->PcoId;		
									
								}
							}
							
							if(!empty($PedidoCompraId)){
//								MtdEditarPedidoCompraDato
								if($GET_GenerarOrdenCompra=="1"){
									
									if($InsPedidoCompra->FncGenerarOrdenCompraPedidoCompra($PedidoCompraId,"STX")){
										
										echo "La Orden de Compra se registro correctamente. <br />";
																				
										if($InsPedidoCompra->MtdGenerarExcelPedidoCompra($PedidoCompraId,"../")){
											
											if($GET_EnviarOrdenCompra == "1"){
												
												if($InsPedidoCompra->MtdEnviarCorreoPedidoCompra($InsPedidoCompra->PcoId,$DestinatariosCorreo,"../","SISTEMA")){
													echo "La Orden de Compra se envio por correo. <br />";
												}else{
													echo "La Orden de Compra no se pudo enviar por correo <br />";	
												}
												
											}
											
										}else{
											
											echo "La Orden de Compra no se pudo generar excel<br />";	
											
										}
										
									}else{
										
										echo "La Orden de Compra no se pudo registrar. PROCESO CANCELADO (1)<br />";
											
									}
									
								}else{
									
									echo "Generar Orden de Compra DESCATIVADO <br>";	
									
								}
							
							}
	
						}else{
							
							echo "El Pedido de Compra no se pudo registrar. PROCESO CANCELADO (1)<br />";
								
						}

						//PEDIDO STK
						if($InsVentaDirecta->MtdVentaDirectaGenerarPedidoCompra($InsVentaDirecta->VdiId,true,true,"IMPORTACION")){
							 
							 echo "El Pedido de Compra se registro correctamente.<br />";
							 
							$InsPedidoCompra = new ClsPedidoCompra();
							//public function MtdObtenerPedidoCompras($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'PcoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oConOrdenCompra=0,$oVentaDirecta=NULL,$oOrdenCompra=NULL,$oFichaAccion=NULL,$oFichaIngreso=NULL,$oOrigen=array()) {
							$ResPedidoCompra = $InsPedidoCompra->MtdObtenerPedidoCompras(NULL,NULL,NULL,'PcoId','Desc','1',NULL,NULL,NULL,NULL,0,$InsVentaDirecta->VdiId,NULL,NULL,NULL,array());							 
							$ArrPedidoCompras = $ResPedidoCompra['Datos'];
							
							$PedidoCompraId = "";
							
							if(!empty($ArrPedidoCompras)){
								foreach($ArrPedidoCompras as $DatPedidoCompra){
									
									$PedidoCompraId = $DatPedidoCompra->PcoId;		
									
								}
							}
							
							if(!empty($PedidoCompraId)){
//								MtdEditarPedidoCompraDato
								if($GET_GenerarOrdenCompra=="1"){
									
									if($InsPedidoCompra->FncGenerarOrdenCompraPedidoCompra($PedidoCompraId,"STK")){
										
										echo "La Orden de Compra se registro correctamente. <br />";
																				
										if($InsPedidoCompra->MtdGenerarExcelPedidoCompra($PedidoCompraId,"../")){
											
											if($GET_EnviarOrdenCompra == "1"){
												
												if($InsPedidoCompra->MtdEnviarCorreoPedidoCompra($InsPedidoCompra->PcoId,$DestinatariosCorreo,"../","SISTEMA")){
													echo "La Orden de Compra se envio por correo. <br />";
												}else{
													echo "La Orden de Compra no se pudo enviar por correo <br />";	
												}
													
											}
											
										}else{
											
											echo "La Orden de Compra no se pudo generar excel<br />";	
											
										}
										
									}else{
										
										echo "La Orden de Compra no se pudo registrar. PROCESO CANCELADO (1)<br />";
											
									}
									
								}else{
									
									echo "Generar Orden de Compra DESCATIVADO <br>";	
									
								}
							
							}
							
							
							
							
							
							
	
						}else{
							
							echo "El Pedido de Compra no se pudo registrar. PROCESO CANCELADO (1)<br />";
								
						}
						
						
						
					}else{
						echo "Generar Pedido de Compra DESCATIVADO <br>";	
					}
					
				}else{
					$TotalOrdenNoRegistrada++;
					
					echo "La Orden de Venta no se pudo registrar. PROCESO CANCELADO (1)<br />";

				}		
	
			}else{
				
				echo "La Orden de Venta no se pudo registrar. PROCESO CANCELADO (2)<br />";
	
				$TotalOrdenNoPermitida++;	
				
//				$TiempoLimite = strtotime ( '+30 minute' , strtotime ( date("Y-m-d H:i:s")) ) ;
//				
//				$TiempoLimite = date ('Y-m-d H:i:s' , $TiempoLimite );
//				$param = array(
//				'oId' => $DatVentaDirectaExterna->VdiId,
//				'oCampo' => "VdiTiempoLimite",
//				'oDato' => $TiempoLimite);
//				$EditoVentaDirectaDato  = $client->call('MtdEditarVentaDirectaDato', $param);					
//				
//					
//				$param = array(
//				'oId' => $DatVentaDirectaExterna->VdiId,
//				'oCampo' => "VdiResultado",
//				'oDato' => $Resultado);
//				$EditoVentaDirectaDato  = $client->call('MtdEditarVentaDirectaDato', $param);
						
			}

	
	
?>
<hr />
	
<?php	
$fila++;
	}
}else{
?>
No se encontraron ordenes<br />
<?php	
}
?>


------------------------------------------<br />
Ordenes de Venta: <?php echo $TotalOrdenes;?><br />
Ordenes de Venta no registradas: <?php echo $TotalOrdenNoRegistrada;?><br />
<br />
Productos Nuevos: <?php echo $TotalProductoNuevo;?><br />
Productos Nuevos No Registrados: <?php echo $TotalProductoNuevoNoRegistrada;?><br />
<br />
Ordenes de Venta No Permitida: <?php echo $TotalOrdenNoPermitida;?><br />
Ordenes de Venta Repetidas: <?php echo $TotalOrdenRepetida;?><br />

------------------------------------------<br />
Proceso Terminado<br />
<?php echo date("d/m/Y H:i:s")?><br />
------------------------------------------<br />


</body>
</html>

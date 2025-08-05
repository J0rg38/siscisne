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

deb($ArrVentaDirectaExternas);

$fila = 1;
if(!empty($ArrVentaDirectaExternas)){
	foreach($ArrVentaDirectaExternas as $DatVentaDirectaExterna){
		
		$Resultado = "";
		$GuardarOrden = true;
		$ObservarOrden = false;
		
		echo "[Fila ".$fila."]>";		
		echo "Codigo CYC: ".$DatVentaDirectaExterna->VdiId."<br />";
		echo "Codigo Externo: ".$DatVentaDirectaExterna->VdiVentaDirectaNumero."<br />";
		echo "Fecha: ".$DatVentaDirectaExterna->VdiFecha."<br />";

			$InsCliente = new ClsCliente();	
			$InsCliente->CliNombre = $DatVentaDirectaExterna->CliNombre." ".$DatVentaDirectaExterna->CliApellidoPaterno." ".$DatVentaDirectaExterna->CliApellidoMaterno;
			
			$InsCliente->CliNumeroDocumento = $DatVentaDirectaExterna->CliNumeroDocumento;
			$ClienteId = $InsCliente->MtdVerificarExisteCliente();
			
			if(empty($ClienteId)){
					
				$InsCliente = new ClsCliente();	
				$InsCliente->CliId = NULL;
				$InsCliente->LtiId = $DatVentaDirectaExterna->LtiId;		
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
					$GuardarOrden  = false;
				}else{
					$ClienteId = $InsCliente->CliId;	
				}

			}		
				
			$InsVentaDirecta = new ClsVentaDirecta();
			$InsVentaDirecta->UsuId = "USU-10000";	
			
			$InsVentaDirecta->VdiId = NULL;
			$InsVentaDirecta->CliId = $ClienteId;
			
			$InsVentaDirecta->EinId = NULL;
			$InsVentaDirecta->EinVIN = NULL;
			$InsVentaDirecta->EinPlaca = NULL;
			$InsVentaDirecta->NpaId = "NPA-10001";

			$InsVentaDirecta->VdiOrdenCompraNumero = $DatVentaDirectaExterna->VdiOrdenCompraNumero;
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
			$InsVentaDirecta->VdiPorcentajeDescuento = $DatVentaDirectaExterna->VdiPorcentajeDescuento;//VdiPorcentajeDescuento
			
			deb($InsVentaDirecta->VdiPorcentajeDescuento);
			
			$InsVentaDirecta->VdiNotificar = 1;		
			$InsVentaDirecta->VdiArchivo = NULL;			
			$InsVentaDirecta->VdiCodigoExterno = $DatVentaDirectaExterna->VdiId;
			$InsVentaDirecta->VdiTipoPedido = $DatVentaDirectaExterna->VdiTipoPedido;
			$InsVentaDirecta->VdiEstado = 1;
			$InsVentaDirecta->VdiTiempoCreacion = date("Y-m-d H:i:s");
			$InsVentaDirecta->VdiTiempoModificacion = date("Y-m-d H:i:s");
		
			$InsVentaDirecta->VdiMargenUtilidad = 0;
			$InsVentaDirecta->VdiFlete = 0;
			$InsVentaDirecta->VdiPorcentajeDescuento = 0;
			$InsVentaDirecta->LtiId = "LTI-10011";
		
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
		
			
//			deb($InsVentaDirecta->MonId);
			if($InsVentaDirecta->MonId<>$EmpresaMonedaId){
				
				if(empty($InsVentaDirecta->VdiTipoCambio)){
					$GuardarOrden = false;
					$Resultado .= date("d/m/Y H:i:s")." - Ha ocurrido un error interno TCANOREG".chr(13);
					
					echo "No ha ingresado el tipo de cambio.<br />";
					
				}
				
			}
			
			if(!empty($InsVentaDirecta->VdiVentaDirectaNumero)){
				if($InsVentaDirecta->MtdVerificarExisteVentaDirectaDato("VdiVentaDirectaNumero",$InsVentaDirecta->VdiVentaDirectaNumero,$InsVentaDirecta->CliId)){
					$GuardarOrden = false;
					$Resultado .= date("d/m/Y H:i:s")." - EL numero de Orden de Compra esta repetido".chr(13);
					
					echo "El Numero de Referencia ya se encuentra registrado.<br />";

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
							
//							deb($DatVentaDirectaDetalleExterno->VddPrecioVenta." - ".$InsVentaDirecta->VdiTipoCambio);

//							if($InsVentaDirecta->MonId<>$EmpresaMonedaId ){
//
//								$DatVentaDirectaDetalleExterno->VddPrecioVenta = $DatVentaDirectaDetalleExterno->VddPrecioVenta * $InsVentaDirecta->VdiTipoCambio;
//								$DatVentaDirectaDetalleExterno->VddImporte = $DatVentaDirectaDetalleExterno->VddImporte * $InsVentaDirecta->VdiTipoCambio;
//								$DatVentaDirectaDetalleExterno->VddCosto = $DatVentaDirectaDetalleExterno->VddCosto * $InsVentaDirecta->VdiTipoCambio;
//									
//							}
								
								
							/*$InsProductoDisponibilidad = new ClsProductoDisponibilidad();
							$ResProductoDisponibilidad = $InsProductoDisponibilidad->MtdObtenerProductoDisponibilidades("PdiCodigo","esigual",$DatVentaDirectaDetalleExterno->ProCodigoOriginal ,"PdiId","ASC","1",1);
							$ArrProductoDisponibilidades = $ResProductoDisponibilidad['Datos'];

							$Disponibilidad = "NO";
							$DisponibilidadCantidad = 0;
						  
							if(!empty($ArrProductoDisponibilidades)){
								foreach($ArrProductoDisponibilidades as $DatProductoDisponibilidad){
									
									$Disponibilidad =  ($DatProductoDisponibilidad->PdiDisponible==1)?'SI':'NO';
									$DisponibilidadCantidad =  (empty($DatProductoDisponibilidad->PdiCantidad)?0:$DatProductoDisponibilidad->PdiCantidad);
								
								}
							}
							
//							if(($Disponibilidad == "NO" or $DisponibilidadCantidad == 0) and ($InsVentaDirecta->VdiTipoPedido=="NORMAL" or $InsVentaDirecta->VdiTipoPedido == "URGENTE") ){
							if(($Disponibilidad == "NO") and ($InsVentaDirecta->VdiTipoPedido=="NORMAL" or $InsVentaDirecta->VdiTipoPedido == "URGENTE") ){								
								$Resultado .= date("d/m/Y H:i:s")." - ".$DatVentaDirectaDetalleExterno->ProCodigoOriginal." Repuesto no disponible".chr(13);
							?>	
                            	<?php echo $DatVentaDirectaDetalleExterno->ProCodigoOriginal;?> - Repuesto no disponible<br />
								
							<?php
								$GuardarOrden = false;
								break;
								
							}*/
						  
															
							if($GuardarOrden){
		
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
									
									echo "Producto identificado <b>".$ProductoCodigoOriginal." - ".$ProductoNombre."</b><br />";			

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
									$InsProducto->ProReferencia = "Agregado automaticamente por sistema el ".date("d/m/Y");
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
								
								$InsVentaDirectaDetalle1->VddCostoExtraTotal = 0;			
								$InsVentaDirectaDetalle1->VddCantidadReal = $DatVentaDirectaDetalleExterno->VddCantidad;
								$InsVentaDirectaDetalle1->VddCantidad = $DatVentaDirectaDetalleExterno->VddCantidad;
								
								$InsVentaDirectaDetalle1->VddCosto = $DatVentaDirectaDetalleExterno->VddCosto;
								$InsVentaDirectaDetalle1->VddPrecioBruto = $DatVentaDirectaDetalleExterno->VddPrecioVenta;		
								$InsVentaDirectaDetalle1->VddPrecioVenta = $DatVentaDirectaDetalleExterno->VddPrecioVenta;					
								$InsVentaDirectaDetalle1->VddDescuento = 0;
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
									
									//if(!empty($InsVentaDirectaDetalle1->ProId)){
//									
//										$InsAlmacenStock = new ClsAlmacenStock();
//										$InsAlmacenStock->ProId = $InsVentaDirectaDetalle1->ProId;
//										$InsAlmacenStock->MtdObtenerAlmacenStock();
//		
//										if($InsAlmacenStock->AstStockReal>0){
//											$ObservarOrden = true;
//										}
//	
//									}
								
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
					$Resultado .= date("d/m/Y H:i:s")." - La Orden de Compra no tiene items".chr(13);
					
					echo "La Orden de Compra no tiene items <br />";

				}
		
			}
			
			if($InsVentaDirecta->VdiIncluyeImpuesto==2){
				
				$InsVentaDirecta->VdiSubTotal = round($InsVentaDirecta->VdiTotalBruto - $InsVentaDirecta->VdiDescuento  + $InsVentaDirecta->VdiManoObra + $InsVentaDirecta->VdiPlanchadoTotal + $InsVentaDirecta->VdiPintadoTotal + $InsVentaDirecta->VdiCentradoTotal + $InsVentaDirecta->VdiTareaTotal,6);
				//$InsVentaDirecta->VdiSubTotal = round($InsVentaDirecta->VdiTotalBruto,6);
				$InsVentaDirecta->VdiImpuesto = round(($InsVentaDirecta->VdiSubTotal * ($InsVentaDirecta->VdiPorcentajeImpuestoVenta/100)),6);
				$InsVentaDirecta->VdiTotal = round($InsVentaDirecta->VdiSubTotal + $InsVentaDirecta->VdiImpuesto,6);
				
				
			}else{
				
				//$InsVentaDirecta->VdiTotal = round($InsVentaDirecta->VdiTotalBruto,6);
				$InsVentaDirecta->VdiTotal = round($InsVentaDirecta->VdiTotalBruto - $InsVentaDirecta->VdiDescuento + $InsVentaDirecta->VdiManoObra + $InsVentaDirecta->VdiPlanchadoTotal + $InsVentaDirecta->VdiPintadoTotal + $InsVentaDirecta->VdiCentradoTotal + $InsVentaDirecta->VdiTareaTotal,6);	
				$InsVentaDirecta->VdiSubTotal = round($InsVentaDirecta->VdiTotal / (($InsVentaDirecta->VdiPorcentajeImpuestoVenta/100)+1),6);
				$InsVentaDirecta->VdiImpuesto = round(($InsVentaDirecta->VdiTotal - $InsVentaDirecta->VdiSubTotal),6);
				
			}

	
			if($GuardarOrden){
				
				if($ObservarOrden){
					$InsVentaDirecta->VdiObservado = 1;
				}else{
					$InsVentaDirecta->VdiObservado = 2;
				}
				
				if($InsVentaDirecta->MtdRegistrarVentaDirecta()){
		
					$Resultado .= date("d/m/Y H:i:s")." - La Orden de Compra ha sido recibida".chr(13);

					$InsVentaDirecta->MtdVentaDirectaActualizarProductoUso($InsVentaDirecta->VdiId);
										
					$InsVentaDirectaExterno = new ClsVentaDirectaExterno();

					if($InsVentaDirectaExterno->MtdGenerarVentaDirectaExternoPDF( $DatVentaDirectaExterna->VdiId,"../subidos/venta_directa/")){

						$InsVentaDirecta->MtdEditarVentaDirectaDato("VdiArchivo",$DatVentaDirectaExterna->VdiId."_".$DatVentaDirectaExterna->VdiVentaDirectaNumero.".pdf",$InsVentaDirecta->VdiId);
								
					}
//
//					$InsCliente = new ClsCliente();
//					$InsCliente->CliId = $InsVentaDirecta->CliId;
//					$InsCliente->MtdObtenerCliente();
//					
//					$Destinatarios = (!empty($InsCliente->CliEmail)?','.$InsCliente->CliEmail:'').(!empty($InsCliente->CliContactoEmail1)?','.$InsCliente->CliContactoEmail1:'').(!empty($InsCliente->CliContactoEmail2)?','.$InsCliente->CliContactoEmail2:'').(!empty($InsCliente->CliContactoEmail3)?','.$InsCliente->CliContactoEmail3:'');
//					
//					$InsVentaDirecta->MtdNotificarVentaDirectaRegistro($InsVentaDirecta->VdiId,$Destinatarios,true);

					$InsCliente = new ClsCliente();
					$InsCliente->CliId = $InsVentaDirecta->CliId;
					$InsCliente->MtdObtenerCliente();
					
					$Destinatarios = (!empty($InsCliente->CliEmail)?','.$InsCliente->CliEmail:'').(!empty($InsCliente->CliContactoEmail1)?','.$InsCliente->CliContactoEmail1:'').(!empty($InsCliente->CliContactoEmail2)?','.$InsCliente->CliContactoEmail2:'').(!empty($InsCliente->CliContactoEmail3)?','.$InsCliente->CliContactoEmail3:'');
	
					$InsVentaDirecta->MtdNotificarVentaDirectaRegistro($InsVentaDirecta->VdiId,$Destinatarios.",jblanco@cyc.com.pe",true);
					
					//$InsVentaDirecta->MtdNotificarVentaDirectaRegistro($InsVentaDirecta->VdiId,"jblanco@cyc.com.pe",true);

					$InsVentaDirecta->MtdNotificarVentaDirectaStockAlmacen($InsVentaDirecta->VdiId,"jblanco@cyc.com.pe,iquezada@cyc.com.pe,aliendo@cyc.com.pe,scanepam@cyc.com.pe");

//					if($ObservarOrden){
//
//						$param = array(
//						'oId' => $DatVentaDirectaExterna->VdiId,
//						'oCampo' => "VdiEstado",
//						'oDato' => "41");
//						$EditoVentaDirectaDato  = $client->call('MtdEditarVentaDirectaDato', $param);
//						
//						$InsVentaDirecta->MtdEditarVentaDirectaDato("VdiResultado",$InsVentaDirecta->VdiObservacion.chr(13)."".$Resultado,$InsVentaDirecta->VdiId);
//						$InsVentaDirecta->MtdEditarVentaDirectaDato("VdiObservado",1,$InsVentaDirecta->VdiId);
//
//					}else{
//
//						$param = array(
//						'oId' => $DatVentaDirectaExterna->VdiId,
//						'oCampo' => "VdiEstado",
//						'oDato' => "4");
//						$EditoVentaDirectaDato  = $client->call('MtdEditarVentaDirectaDato', $param);
//
//					}
//
//					$param = array(
//					'oId' => $DatVentaDirectaExterna->VdiId,
//					'oCampo' => "VdiResultado",
//					'oDato' => $Resultado);
//					$EditoVentaDirectaDato  = $client->call('MtdEditarVentaDirectaDato', $param);
					
					echo "La Orden de Compra ha sido registrada correctamente<br />";

				}else{
					$TotalOrdenNoRegistrada++;
					
					echo "La Orden de Compra no se pudo registrar. PROCESO CANCELADO (1)<br />";

				}		
	
			}else{
				
				echo "La Orden de Compra no se pudo registrar. PROCESO CANCELADO (2)<br />";
	
				$TotalOrdenNoPermitida++;	
				
				$param = array(
				'oId' => $DatVentaDirectaExterna->VdiId,
				'oCampo' => "VdiEstado",
				'oDato' => "5");
				$EditoVentaDirectaDato  = $client->call('MtdEditarVentaDirectaDato', $param);
					
				$TiempoLimite = strtotime ( '+30 minute' , strtotime ( date("Y-m-d H:i:s")) ) ;
				
				$TiempoLimite = date ('Y-m-d H:i:s' , $TiempoLimite );
				$param = array(
				'oId' => $DatVentaDirectaExterna->VdiId,
				'oCampo' => "VdiTiempoLimite",
				'oDato' => $TiempoLimite);
				$EditoVentaDirectaDato  = $client->call('MtdEditarVentaDirectaDato', $param);					
				
					
				$param = array(
				'oId' => $DatVentaDirectaExterna->VdiId,
				'oCampo' => "VdiResultado",
				'oDato' => $Resultado);
				$EditoVentaDirectaDato  = $client->call('MtdEditarVentaDirectaDato', $param);
						
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
Total de Ordenes: <?php echo $TotalOrdenes;?><br />
Ordenes no registradas: <?php echo $TotalOrdenNoRegistrada;?><br />

Productos Nuevos: <?php echo $TotalProductoNuevo;?><br />
Productos Nuevos No Registrados: <?php echo $TotalProductoNuevoNoRegistrada;?><br />
Total No Permitida <?php echo $TotalOrdenNoPermitida;?><br />

------------------------------------------<br />
Proceso Terminado<br />
<?php echo date("d/m/Y H:i:s")?><br />
------------------------------------------<br />


</body>
</html>
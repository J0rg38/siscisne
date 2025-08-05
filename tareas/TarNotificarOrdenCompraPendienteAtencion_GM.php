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


require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompra.php');
//require_once($InsPoo->MtdPaqLogistica().'ClsReporteOrdenCompraPendiente.php');
require_once($InsPoo->MtdPaqLogistica().'ClsProveedor.php');
require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompraDetalle.php');
require_once($InsPoo->MtdPaqReporte().'ClsReporteOrdenCompraPendiente.php');



$ProveedorNombre = "";
$ProveedorNumeroDocumento = "";
$ProveedorTipoDocumento = "";
$ProveedorId = "PRV-10548";

$InsProveedor = new ClsProveedor();
$InsProveedor->PrvId = $ProveedorId;
$InsProveedor->MtdObtenerProveedor();


$ProveedorNombre = $InsProveedor->PrvNombre." ".$InsProveedor->PrvApellidoPaterno." ".$InsProveedor->PrvApellidoMaterno;
$ProveedorNumeroDocumento = $InsProveedor->PrvNumeroDocumento;
$ProveedorTipoDocumento = $InsProveedor->TdoNombre;



			$Enviar = false;
			
			$mensaje .= "AVISO DE ORDENES PENDIENTES DE ATENCION:";	
			$mensaje .= "<br>";	
			$mensaje .= "<br>";	


			$mensaje .= "Proveedor: <b>".$ProveedorNombre."</b>";	
			$mensaje .= "<br>";	
			$mensaje .= "Año <b>".date("Y")."</b>";	
			$mensaje .= "<br>";	
			$mensaje .= "Fecha de aviso: <b>".date("d/m/Y")."</b>";	
			$mensaje .= "<br>";	
			
			
			$mensaje .= "<hr>";
			$mensaje .= "<br>";
			
			$mensaje .= "<br>";

				$InsReporteOrdenCompraPendiente = new ClsReporteOrdenCompraPendiente();
				
//MtdObtenerOrdenCompraDetallePendiente($oCampo=NULL,$oFiltro=NULL,$oOrden = 'PcdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPedidoCompra=NULL,$oEstado=NULL,$oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oOrdenCompra=NULL,$oCliente=NULL,$oConOrdenCompra=NULL,$oVentaDirectaDetalleId=NULL,$oPedidoCompraEstado=NULL,$oFecha="PcoFecha",$oValidarRecibido=false,$oConFichaIngreso=false,$oOrdenCompraEstado=NULL,$oAno=NULL,$oMes=NULL)
//				$ResPedidoCompraDetalle = $InsReporteOrdenCompraPendiente->MtdObtenerOrdenCompraDetallePendiente(NULL,NULL,"PcdTiempoCreacion","ASC",NULL,NULL,3,NULL,(date("Y")."-".date("m")."-01"),(date("Y")."-".date("m")."-".date("d")),NULL,NULL,NULL,NULL,NULL,"PcoFecha",true,false,"31",date("Y"),date("m"));
//MtdObtenerOrdenCompraDetallePendiente($oCampo=NULL,$oFiltro=NULL,$oOrden = 'PcdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPedidoCompra=NULL,$oEstado=NULL,$oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oOrdenCompra=NULL,$oCliente=NULL,$oConOrdenCompra=NULL,$oVentaDirectaDetalleId=NULL,$oPedidoCompraEstado=NULL,$oFecha="PcoFecha",$oValidarRecibido=false,$oConFichaIngreso=false,$oOrdenCompraEstado=NULL,$oAno=NULL,$oMes=NULL,$oProveedor=NULL)
				$ResPedidoCompraDetalle = $InsReporteOrdenCompraPendiente->MtdObtenerOrdenCompraDetallePendiente(NULL,NULL,"PcdTiempoCreacion","ASC",NULL,NULL,3,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"PcoFecha",true,false,"31",date("Y"),NULL,$ProveedorId);

				$ArrPedidoCompraDetalles = $ResPedidoCompraDetalle['Datos'];

				if(!empty($ArrPedidoCompraDetalles)){
				
					
					$mensaje .= "<table cellpadding='2' cellspacing='0' width='100%' border='1'>";
					
					$mensaje .= "<tr>";
					
						$mensaje .= "<td width='2%'  align='center'>";
						$mensaje .= "<b>#</b>";
						$mensaje .= "</td>";

						$mensaje .= "<td width='150px'  align='center'>";
						$mensaje .= "<b>ORD. COMPRA</b>";
						$mensaje .= "</td>";
						
						$mensaje .= "<td width='50px' align='center'>";
						$mensaje .= "<b>FECHA</b>";
						$mensaje .= "</td>";

						$mensaje .= "<td width='80px' align='center'>";
						$mensaje .= "<b>FECHA LLEGADA APROX.</b>";
						$mensaje .= "</td>";
						
						$mensaje .= "<td width='30px' align='center'>";
						$mensaje .= "<b>DIAS TRANSC.</b>";
						$mensaje .= "</td>";

						$mensaje .= "<td width='50px' align='center'>";
						$mensaje .= "<b>COD. ORIG.</b>";
						$mensaje .= "</td>";

						$mensaje .= "<td width='50px' align='center'>";
						$mensaje .= "<b>CANT. SOLIC.</b>";
						$mensaje .= "</td>";
						
						$mensaje .= "<td width='50px' align='center'>";
						$mensaje .= "<b>CANT. PEND.</b>";
						$mensaje .= "</td>";
						
						$mensaje .= "<td width='50px' align='center'>";
						$mensaje .= "<b>IMPORTE</b>";
						$mensaje .= "</td>";
						
						$mensaje .= "<td width='200px' align='center'>";
						$mensaje .= "<b>NOMBRE</b>";
						$mensaje .= "</td>";
						
						$mensaje .= "<td width='50px' align='center'>";
						$mensaje .= "<b>REF.</b>";
						$mensaje .= "</td>";

						$mensaje .= "<td width='50px' align='center'>";
						$mensaje .= "<b>ESTADO</b>";
						$mensaje .= "</td>";

						$mensaje .= "<td width='200px' align='center'>";
						$mensaje .= "<b>CLIENTE</b>";
						$mensaje .= "</td>";
						
						
						$mensaje .= "<td width='20px' align='center'>";
						$mensaje .= "<b>DISP.</b>";
						$mensaje .= "</td>";
						
						//$mensaje .= "<td width='20px' align='center'>";
//						$mensaje .= "<b>DESPACHO</b>";
//						$mensaje .= "</td>";
//						
//						$mensaje .= "<td width='20px' align='center'>";
//						$mensaje .= "<b>FACTURA</b>";
//						$mensaje .= "</td>";
						
					$mensaje .= "</tr>";
					
					
							
						$c = 1;	
						$Total  = 0;
						foreach($ArrPedidoCompraDetalles as $DatPedidoCompraDetalle){
		
//							if($DatPedidoCompraDetalle->PcdCantidadNoDespachada>0){
							if($DatPedidoCompraDetalle->PcdCantidadPendiente>0){
							
								if($DatPedidoCompraDetalle->VddEstado==1){
						
								
								$mensaje .= "<tr>";
											
									$mensaje .= "<td>";
									$mensaje .= $c;
									$mensaje .= "</td>";
					
									$mensaje .= "<td><small>";
									$mensaje .= $DatPedidoCompraDetalle->OcoId;
									$mensaje .= "</small></td>";
									
									$mensaje .= "<td><small>";
									$mensaje .= $DatPedidoCompraDetalle->OcoFecha;
									$mensaje .= "</small></td>";
				
									$mensaje .= "<td><small>";
									$mensaje .= $DatPedidoCompraDetalle->OcoFechaLlegadaEstimada;
									$mensaje .= "</small></td>";
									
									$mensaje .= "<td><small>";
									$mensaje .= $DatPedidoCompraDetalle->OcoDiaTranscurrido." dias";
									$mensaje .= "</small></td>";
				
									
									$mensaje .= "<td><small>";
									$mensaje .= $DatPedidoCompraDetalle->ProCodigoOriginal;
									$mensaje .= "</small></td>";
				
									$mensaje .= "<td><small>";
									$mensaje .= number_format($DatPedidoCompraDetalle->PcdCantidad,2);
									$mensaje .= "</small></td>";
									
									$mensaje .= "<td><small>";
									$mensaje .= number_format($DatPedidoCompraDetalle->PcdCantidadNoRecibida,2);
									$mensaje .= "</small></td>";
												
									if($DatPedidoCompraDetalle->MonId<>$EmpresaMonedaId){
										$DatPedidoCompraDetalle->PcdPrecio = $DatPedidoCompraDetalle->PcdPrecio / $DatPedidoCompraDetalle->PcoTipoCambio;
									}else{
										$DatPedidoCompraDetalle->PcdPrecio = $DatPedidoCompraDetalle->PcdPrecio;
									}
									
									$DatPedidoCompraDetalle->PcdImporte = $DatPedidoCompraDetalle->PcdPrecio*$DatPedidoCompraDetalle->PcdCantidadNoRecibida;
					
									$mensaje .= "<td><small>";
									$mensaje .= number_format($DatPedidoCompraDetalle->PcdImporte,2);
									$mensaje .= "</small></td>";
									
									
									$mensaje .= "<td><small>";
									$mensaje .= $DatPedidoCompraDetalle->ProNombre;
									$mensaje .= "</small></td>";
											
									$mensaje .= "<td><small>";
									$mensaje .= $DatPedidoCompraDetalle->VdiOrdenCompraNumero;
									$mensaje .= "</small></td>";
									
									$mensaje .= "<td><small>";
									
									switch($DatPedidoCompraDetalle->VddEstado){
										case 1:
											$mensaje .= "CONSIDERAR";
										break;
										
										case 2:
											$mensaje .= "ANULADO";
										break;
									
										case 3:
											$mensaje .= "INTERNO";
										break;
										
										case 4:
											$mensaje .= "DEVOLUCION";
										break;
									
										case 5:
											$mensaje .= "DAÑADO";
										break;
											
										default:
											$mensaje .= "-";
										break;
									}
			
									
									$mensaje .= "</small></td>";
												
									$mensaje .= "<td><small>";
									$mensaje .= $DatPedidoCompraDetalle->CliNombre." ".$DatPedidoCompraDetalle->CliApellidoPaterno." ".$DatPedidoCompraDetalle->CliApellidoMaterno;
									$mensaje .= "</small></td>";
									
										$mensaje .= "<td><small>";
									$mensaje .= $DatPedidoCompraDetalle->ProTieneDisponibilidadGM;
									$mensaje .= "</small></td>";
									
									
								//		$mensaje .= "<td><small>";
//									$mensaje .= $DatPedidoCompraDetalle->PleFecha;
//									$mensaje .= "</small></td>";
//										
//										
//										
//										$mensaje .= "<td><small>";
//									$mensaje .= $DatPedidoCompraDetalle->PldComprobanteNumero;
//									$mensaje .= "</small></td>";
										
										
								$mensaje .= "</tr>";
		
								$c++;			
								
								$Enviar = true;
								
								$Total += $DatPedidoCompraDetalle->PcdImporte;
							
								}
							}		
							
						}
				
						$mensaje .= "<tr>";
									
							$mensaje .= "<td>";
							$mensaje .= "</td>";
			
							$mensaje .= "<td><small>";
							$mensaje .= "</small></td>";
							
							$mensaje .= "<td><small>";
							$mensaje .= "</small></td>";
		
							$mensaje .= "<td><small>";
							$mensaje .= "</small></td>";
							
							$mensaje .= "<td><small>";
							$mensaje .= "</small></td>";
		
							
							$mensaje .= "<td><small>";
							$mensaje .= "</small></td>";
		
							$mensaje .= "<td><small>";
							$mensaje .= "</small></td>";
							
							$mensaje .= "<td><small>";
							$mensaje .= "</small></td>";
				
							$mensaje .= "<td><small>";
							$mensaje .= number_format($Total ,2);
							$mensaje .= "</small></td>";
							
							$mensaje .= "<td><small>";
							$mensaje .= "</small></td>";
									
							$mensaje .= "<td><small>";
							$mensaje .= "</small></td>";
							
							$mensaje .= "<td><small>";
							$mensaje .= "</small></td>";
										
							$mensaje .= "<td><small>";
							$mensaje .= "</small></td>";
								
						$mensaje .= "</tr>";
						
					$mensaje .= "</table>";
					
				}
				
				
			
			$mensaje .= "<br>";
			$mensaje .= "<br>";
			$mensaje .= "Mensaje autogenerado por SISTEMA CYC a las ".date('d/m/Y H:i:s');
			
			
			echo $mensaje;

		//deb($Enviar);
		if($Enviar){
			
			$InsCorreo = new ClsCorreo();	
			$InsCorreo->MtdEnviarCorreo("pcondori@cyc.com.pe,liman@cyc.com.pe,iquezada@cyc.com.pe,scanepam@cyc.com.pe,aliendo@cyc.com.pe,jblanco@cyc.com.pe,epilco@cyc.com.pe","sistema@cyc.com.pe","C&C S.A.C.","AVISO: ORDENES DE COMPRA PENDIENTES DE ATENCION - ".$ProveedorNombre,$mensaje);
			//$InsCorreo->MtdEnviarCorreo("jblanco@cyc.com.pe","sistema@cyc.com.pe","C&C S.A.C.","AVISO: ORDENES DE COMPRA PENDIENTES DE ATENCION - ".$ProveedorNombre,$mensaje);
			
		}
			
				
				
//		}

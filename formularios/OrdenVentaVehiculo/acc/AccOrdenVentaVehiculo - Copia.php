<?php
switch($POST_acc){

		case 'Eliminar':

			if($InsOrdenVentaVehiculo->MtdEliminarOrdenVentaVehiculo($POST_seleccionados)){
				$Resultado .= "#SAS_OVV_105";
			}else{
				$Resultado .= "#ERR_OVV_105";
			}
		
		
		break;
		
		
		case 'OrdenVentaVehiculoActualizarPendiente':

			if($InsOrdenVentaVehiculo->MtdActualizarEstadoOrdenVentaVehiculo($POST_seleccionados,1)){
				$Resultado .= "#SAS_OVV_108";
			}else{
				$Resultado .= "#ERR_OVV_108";
			}
		
		break;
		
		case 'OrdenVentaVehiculoActualizarEmitido':

			if($InsOrdenVentaVehiculo->MtdActualizarEstadoOrdenVentaVehiculo($POST_seleccionados,3)){
				
				
				$Elementos = explode("#",$POST_seleccionados);
				//	deb($POST_seleccionados);
					//deb($Elementos);
					if(!empty($Elementos)){
						foreach($Elementos as $elemento){
							
							if(!empty($elemento)){
								
								$Id = $elemento;	
								
								if(!empty($Id)){
									
									$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();
									$InsOrdenVentaVehiculo->OvvId = $Id;
									$InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculo();
									
									if(!empty($InsOrdenVentaVehiculo->PerId)){
										
										$InsPersonal = new ClsPersonal();
										$InsPersonal->PerId = $InsOrdenVentaVehiculo->PerId;
										$InsPersonal->MtdObtenerPersonal();
									
									}
									
									
									$EmailPersonal = "";
									
									if(!empty($InsPersonal->PerEmail)){
										
										$EmailPersonal .= trim($InsPersonal->PerEmail).",";
										
									}	
									
									if(!empty($InsPersonal->PerEmailVendedor)){
										
										$EmailPersonal .= trim($InsPersonal->PerEmailVendedor).",";
										
									}	
									
									//$InsOrdenVentaVehiculo->MtdNotificarOrdenVentaVehiculoRegistro($InsOrdenVentaVehiculo->OvvId,$InsPersonal->PerEmail.",".$CorreosNotificacionOrdenVentaVehiculo);										
									$InsOrdenVentaVehiculo->MtdNotificarOrdenVentaVehiculoAprobacionAsignacionVIN($InsOrdenVentaVehiculo->OvvId,$EmailPersonal.",".$CorreosNotificacionOrdenVentaVehiculoAprobacionVIN);
										
									
								}
								
								
								
								
								
															
							}
						
						}
					}
				
				
				
				
				$Resultado .= "#SAS_OVV_108";
			}else{
				$Resultado .= "#ERR_OVV_108";
			}
		
		break;
	
		case 'OrdenVentaVehiculoActualizarAnulado':

			if($InsOrdenVentaVehiculo->MtdActualizarEstadoOrdenVentaVehiculo($POST_seleccionados,6)){
				$Resultado .= "#SAS_OVV_108";
			}else{
				$Resultado .= "#ERR_OVV_108";
			}
		
		break;

		case 'OrdenVentaVehiculoEnviarFacturacion':
				
			$GuardarOrdenVentaVehiculo = false;
			$GuardarVehiculoMovimientoSalida = true;
			
			$Id = "";
					
					$Elementos = explode("#",$POST_seleccionados);
				//	deb($POST_seleccionados);
					//deb($Elementos);
					if(!empty($Elementos)){
						foreach($Elementos as $elemento){
							
							if(!empty($elemento)){
								$Id = $elemento;								
								
								if(!empty($Id)){
			
									if($InsOrdenVentaVehiculo->MtdGenerarVehiculoMovimientoSalida($Id)){
			
										$GuardarOrdenVentaVehiculo = true;
										
									}
									
								}
								
							}
						
						}
					}
					
					//deb($Id);
					
	
	
		//	$GuardarOrdenVentaVehiculo = false;
			
			if($GuardarOrdenVentaVehiculo){
				
				if($InsOrdenVentaVehiculo->MtdActualizarEstadoOrdenVentaVehiculo($POST_seleccionados,4)){
				
					//FncNotificarFacturarOrdenVentaVehiculo($oOrdenVentaVehiculoId,$oTipoComprobante,$oUsuarioId,$oUsuario,$oDescripcionAdicional=NULL,$oPersonalNombre=NULL,$oPersonalFoto=NULL){								
					$InsOrdenVentaVehiculo->FncNotificarFacturarOrdenVentaVehiculo($POST_seleccionados,$oTipoComprobante,$_SESSION['SesionId'],$_SESSION['SesionUsuario'],NULL,NULL,NULL);
					
					
					//$InsNotificacion = new ClsNotificacion();
	//				$InsNotificacion->UsuId = "USU-10001";
	//				$InsNotificacion->UsuIdOrigen = $_SESSION['SesionId'];
	//								
	//				$InsNotificacion->NfnModulo = "ComprobanteVenta";
	//				$InsNotificacion->NfnFormulario = "MonitoreoOrdenVentaVehiculo";
	//				$InsNotificacion->NfnDescripcion = "<b>".$_SESSION['SesionUsuario']."</b> te ha enviado una orden de venta de vehiculo para facturar";
	//				$InsNotificacion->NfnEnlace = "principal.php?Mod=ComprobanteVenta&Form=MonitoreoOrdenVentaVehiculo";
	//				$InsNotificacion->NfnEnlaceNombre = "Mostrar";
	//																						
	//				$InsNotificacion->NfnTipo = 1;
	//				$InsNotificacion->NfnEstado = 1;
	//				$InsNotificacion->NfnTiempoCreacion =date("Y-m-d H:i:s");
	//				$InsNotificacion->NfnTiempoModificacion =date("Y-m-d H:i:s");
	//	
	//				$InsNotificacion->MtdRegistrarNotificacion();
		
						
		
		
					$Resultado .= "#SAS_OVV_107";
				}else{
					$Resultado .= "#ERR_OVV_107";
				}
				
			}else{
				$Resultado .= "#ERR_OVV_107";
			}
			
		
		break;

		
		case 'OrdenVentaVehiculoSolicitarAsignacionVIN':

			if($InsOrdenVentaVehiculo->MtdActualizarAprobacion1OrdenVentaVehiculo($POST_seleccionados,3)){
				$Resultado .= "#SAS_OVV_111";
			}else{
				$Resultado .= "#ERR_OVV_111";
			}
		
		break;
		
		
	/*	case 'OrdenVentaVehiculoVentaAnularEnvioFacturacion':

			if($InsOrdenVentaVehiculo->MtdActualizarEstadoOrdenVentaVehiculo($POST_seleccionados,3)){
				$Resultado .= "#SAS_OVV_108";
			}else{
				$Resultado .= "#ERR_OVV_108";
			}
		
		break;*/
		
		
	/*		case 'OrdenVentaVehiculoActualizarEmitido':

			if($InsOrdenVentaVehiculo->MtdActualizarEstadoOrdenVentaVehiculo($POST_seleccionados,3)){
				$Resultado .= "#SAS_OVV_108";
			}else{
				$Resultado .= "#ERR_OVV_108";
			}
		
		break;*/


	}
?>
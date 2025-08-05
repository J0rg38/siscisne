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
				
			$Actualizado = true;
			$GuardarOrdenVentaVehiculo = false;
			$GuardarVehiculoMovimientoSalida = true;
			
					$Id = "";
					
					$Elementos = explode("#",$POST_seleccionados);
					
							if(!empty($Elementos)){
								foreach($Elementos as $elemento){
									
									if(!empty($elemento)){
										$Id = $elemento;								
										
										if(!empty($Id)){
					
											if($InsOrdenVentaVehiculo->MtdGenerarVehiculoMovimientoSalida($Id)){
					
												$GuardarOrdenVentaVehiculo = true;
												
												$InsOrdenVentaVehiculo->FncNotificarFacturarOrdenVentaVehiculo($Id,NULL,$_SESSION['SesionId'],$_SESSION['SesionUsuario'],NULL,NULL,NULL);
												
												if($GuardarOrdenVentaVehiculo){
						
													if($InsOrdenVentaVehiculo->MtdActualizarEstadoOrdenVentaVehiculo($Id,4)){
													
														$Resultado .= "#SAS_OVV_107";
													}else{
														$Actualizado = false;
														$Resultado .= "#ERR_OVV_107";
													}
													
												}else{
														$Actualizado = false;
													$Resultado .= "#ERR_OVV_107";
												}
												
												
							
											}else{
												$Actualizado = false;
											}
											
										}
										
										
									}
								
								}
							}
							
							//deb($Id);
							
			
			if($Actualizado){
				$Resultado = "#SAS_OVV_107";
			}else{
				$Resultado = "#ERR_OVV_107";
			}
			
				//	$GuardarOrdenVentaVehiculo = false;
					
					
				//	deb($POST_seleccionados);
					//deb($Elementos);
					
		
		break;

		
		case 'OrdenVentaVehiculoSolicitarAsignacionVIN':

			if($InsOrdenVentaVehiculo->MtdActualizarAprobacion1OrdenVentaVehiculo($POST_seleccionados,3)){
				$Resultado .= "#SAS_OVV_111";
			}else{
				$Resultado .= "#ERR_OVV_111";
			}
		
		break;
		
			case 'OrdenVentaVehiculoSolicitarAprobacionVIN':

			if($InsOrdenVentaVehiculo->MtdActualizarAprobacion2OrdenVentaVehiculo($POST_seleccionados,3)){
				$Resultado .= "#SAS_OVV_112";
			}else{
				$Resultado .= "#ERR_OVV_112";
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
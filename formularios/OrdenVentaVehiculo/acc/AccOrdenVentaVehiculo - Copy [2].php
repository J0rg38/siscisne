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
	
					$Id = "";
					
					$Elementos = explode("#",$POST_seleccionados);
				//	deb($POST_seleccionados);
					//deb($Elementos);
					if(!empty($Elementos)){
						foreach($Elementos as $elemento){
							
							if(!empty($elemento)){
								$Id = $elemento;								
							}
						
						}
					}
					
					//deb($Id);
					
					if(!empty($Id)){

						$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();					
						$InsOrdenVentaVehiculo->OvvId = $Id;
						$InsOrdenVentaVehiculo->MtdObtenerVentaVehiculo();
						
						
						$InsVehiculoMovimientoSalida = new ClsVehiculoMovimientoSalida();
						$InsVehiculoMovimientoSalida->UsuId = $_SESSION['SesionId'];	
						
						$ComprobanteTipoId = "";
						
						if($InsOrdenVentaVehiculo->OvvComprobanteVenta=="B"){
							$ComprobanteTipoId = "CTI-10001";
						}else if($InsOrdenVentaVehiculo->OvvComprobanteVenta=="F"){
							$ComprobanteTipoId = "CTI-10000";
						}
						
						$InsVehiculoMovimientoSalida->VmvId = NULL;
						$InsVehiculoMovimientoSalida->CliId = $InsOrdenVentaVehiculo->CliId;
						$InsVehiculoMovimientoSalida->CtiId = $ComprobanteTipoId;	
						$InsVehiculoMovimientoSalida->TopId = "TOP-10000";	
						$InsVehiculoMovimientoSalida->OcoId = NULL;	
						$InsVehiculoMovimientoSalida->AlmId = NULL;	
						
						$InsVehiculoMovimientoSalida->SucId = $_SESSION['SesionSucursal'];	
						$InsVehiculoMovimientoSalida->SucIdDestino = NULL;	
			
						$InsVehiculoMovimientoSalida->VmvPorcentajeImpuestoVenta = $EmpresaImpuestoVenta;	
						$InsVehiculoMovimientoSalida->VmvFecha = date("Y-m-d");
						$InsVehiculoMovimientoSalida->VmvObservacion = "";
						$InsVehiculoMovimientoSalida->VmvObservacion = $InsOrdenVentaVehiculo->OvvObservacion.chr(13).date("d/m/Y H:i:s")." - Salida Vehicular autogenerada de Ord. Ven. Veh.: ".$InsOrdenVentaVehiculo->OvvId." / Cot.: ".$InsOrdenVentaVehiculo->CveId;
						
						$InsVehiculoMovimientoSalida->VmvDocumentoOrigen = NULL;
						
						$InsVehiculoMovimientoSalida->VmvComprobanteNumeroSerie = NULL;
						$InsVehiculoMovimientoSalida->VmvComprobanteNumeroNumero = NULL;
						$InsVehiculoMovimientoSalida->VmvComprobanteNumero = $InsVehiculoMovimientoSalida->VmvComprobanteNumeroSerie."-".$InsVehiculoMovimientoSalida->VmvComprobanteNumeroNumero;
						
						$InsVehiculoMovimientoSalida->VmvComprobanteFecha = NULL;
					
						$InsVehiculoMovimientoSalida->VmvGuiaRemisionNumeroSerie = NULL;
						$InsVehiculoMovimientoSalida->VmvGuiaRemisionNumeroNumero = NULL;
						$InsVehiculoMovimientoSalida->VmvGuiaRemisionNumero = $InsVehiculoMovimientoSalida->VmvGuiaRemisionNumeroSerie."-".$InsVehiculoMovimientoSalida->VmvGuiaRemisionNumeroNumero;	
						
						$InsVehiculoMovimientoSalida->VmvGuiaRemisionFecha = NULL;
						$InsVehiculoMovimientoSalida->VmvGuiaRemisionFoto = NULL;
					
						$InsVehiculoMovimientoSalida->MonId = $InsOrdenVentaVehiculo->MonId;
						$InsVehiculoMovimientoSalida->VmvTipoCambio = $InsOrdenVentaVehiculo->OvvTipoCambio;
						$InsVehiculoMovimientoSalida->VmvTipoCambioComercial = $InsOrdenVentaVehiculo->OvvTipoCambio;
						
						$InsVehiculoMovimientoSalida->VmvIncluyeImpuesto = 2;
					
						$InsVehiculoMovimientoSalida->VmvMargenUtilidad = 0.00;
						$InsVehiculoMovimientoSalida->VmvTipo = 2;
						$InsVehiculoMovimientoSalida->VmvSubTipo = 1;
					
						$InsVehiculoMovimientoSalida->NpaId = "NPA-10002";
						$InsVehiculoMovimientoSalida->VmvCantidadDia = 0;
						
						$InsVehiculoMovimientoSalida->VmvEstado = 1;
						
						$InsVehiculoMovimientoSalida->VmvTiempoCreacion = date("Y-m-d H:i:s");
						$InsVehiculoMovimientoSalida->VmvTiempoModificacion = date("Y-m-d H:i:s");
						$InsVehiculoMovimientoSalida->VmvEliminado = 1;
						
						$InsVehiculoMovimientoSalida->VehiculoMovimientoSalidaDetalle = array();
						
						//if($InsVehiculoMovimientoSalida->MonId<>$EmpresaMonedaId){
//							if(empty($InsVehiculoMovimientoSalida->VmvTipoCambio)){
//								$Guardar = false;
//								//$Resultado.='#ERR_VMS_600';
//							}
//						}
//						
//						if(empty($InsVehiculoMovimientoSalida->SucId)){
//							$Guardar = false;
//							$Resultado.='#ERR_VMS_602';
//						}
						
						
						$InsVehiculoMovimientoSalida->VmvTotalBruto = 0;
						$InsVehiculoMovimientoSalida->VmvSubTotal = 0;
						$InsVehiculoMovimientoSalida->VmvImpuesto = 0;
						$InsVehiculoMovimientoSalida->VmvTotal = 0;
						$InsVehiculoMovimientoSalida->VmvValorTotal = 0;
						
				
						
					
						$InsVehiculoMovimientoSalidaDetalle1 = new ClsVehiculoMovimientoSalidaDetalle();
						$InsVehiculoMovimientoSalidaDetalle1->VmdId = NULL;
						$InsVehiculoMovimientoSalidaDetalle1->EinId = $InsOrdenVentaVehiculo->EinId;
						$InsVehiculoMovimientoSalidaDetalle1->VehId = $InsOrdenVentaVehiculo->VehId;
						$InsVehiculoMovimientoSalidaDetalle1->UmeId = $InsOrdenVentaVehiculo->UmeId;
						
						$InsVehiculoMovimientoSalidaDetalle1->VmdIdAnterior = $InsVehiculoMovimientoSalidaDetalle1->MtdObtenerUltimoVehiculoMovimientoSalidaDetalleId($InsVehiculoMovimientoSalidaDetalle1->VehId,$InsVehiculoMovimientoSalida->VmvFecha);
					
						$InsVehiculoMovimientoSalidaDetalle1->VmdCosto = $InsOrdenVentaVehiculo->OvvSubTotal;
						$InsVehiculoMovimientoSalidaDetalle1->VmdCostoIngreso = $InsOrdenVentaVehiculo->EinCostoIngreso;
						$InsVehiculoMovimientoSalidaDetalle1->VmdCantidad = 1;
						$InsVehiculoMovimientoSalidaDetalle1->VmdImporte = $InsOrdenVentaVehiculo->OvvSubTotal;;
						$InsVehiculoMovimientoSalidaDetalle1->VmdObservacion = "";
			
						$InsVehiculoMovimientoSalidaDetalle1->VmdFecha = 	$InsVehiculoMovimientoSalida->VmvFecha;
					
						$InsVehiculoMovimientoSalidaDetalle1->VmdCostoAnterior = 0;		
						$InsVehiculoMovimientoSalidaDetalle1->VmdUtilidad = 0;
						$InsVehiculoMovimientoSalidaDetalle1->VmdUtilidadPorcentaje = 0;
						
						$InsVehiculoMovimientoSalidaDetalle1->VmdCostoExtraTotal = 0;
						$InsVehiculoMovimientoSalidaDetalle1->VmdCostoExtraUnitario = 0;
						
						
						$InsVehiculoMovimientoSalidaDetalle1->VmdCaracteristica1 = (empty( $InsOrdenVentaVehiculo->EinCaracteristica1)?0: $InsOrdenVentaVehiculo->EinCaracteristica1);
						$InsVehiculoMovimientoSalidaDetalle1->VmdCaracteristica2 = (empty( $InsOrdenVentaVehiculo->EinCaracteristica2)?0: $InsOrdenVentaVehiculo->EinCaracteristica2);
						$InsVehiculoMovimientoSalidaDetalle1->VmdCaracteristica3 = (empty( $InsOrdenVentaVehiculo->EinCaracteristica3)?0: $InsOrdenVentaVehiculo->EinCaracteristica3);
						$InsVehiculoMovimientoSalidaDetalle1->VmdCaracteristica4 = (empty( $InsOrdenVentaVehiculo->EinCaracteristica4)?0: $InsOrdenVentaVehiculo->EinCaracteristica4);
						$InsVehiculoMovimientoSalidaDetalle1->VmdCaracteristica5 = (empty( $InsOrdenVentaVehiculo->EinCaracteristica5)?0: $InsOrdenVentaVehiculo->EinCaracteristica5);
						$InsVehiculoMovimientoSalidaDetalle1->VmdCaracteristica6 = (empty( $InsOrdenVentaVehiculo->EinCaracteristica6)?0: $InsOrdenVentaVehiculo->EinCaracteristica6);
						$InsVehiculoMovimientoSalidaDetalle1->VmdCaracteristica7 = (empty( $InsOrdenVentaVehiculo->EinCaracteristica7)?0: $InsOrdenVentaVehiculo->EinCaracteristica7);
						$InsVehiculoMovimientoSalidaDetalle1->VmdCaracteristica8 = (empty( $InsOrdenVentaVehiculo->EinCaracteristica8)?0: $InsOrdenVentaVehiculo->EinCaracteristica8);
						$InsVehiculoMovimientoSalidaDetalle1->VmdCaracteristica9 = (empty( $InsOrdenVentaVehiculo->EinCaracteristica9)?0: $InsOrdenVentaVehiculo->EinCaracteristica9);
						$InsVehiculoMovimientoSalidaDetalle1->VmdCaracteristica10 = (empty( $InsOrdenVentaVehiculo->EinCaracteristica10)?0: $InsOrdenVentaVehiculo->EinCaracteristica10);
						$InsVehiculoMovimientoSalidaDetalle1->VmdCaracteristica11 = (empty( $InsOrdenVentaVehiculo->EinCaracteristica11)?0: $InsOrdenVentaVehiculo->EinCaracteristica11);
						$InsVehiculoMovimientoSalidaDetalle1->VmdCaracteristica12 = (empty( $InsOrdenVentaVehiculo->EinCaracteristica12)?0: $InsOrdenVentaVehiculo->EinCaracteristica12);
						$InsVehiculoMovimientoSalidaDetalle1->VmdCaracteristica13 = (empty( $InsOrdenVentaVehiculo->EinCaracteristica13)?0: $InsOrdenVentaVehiculo->EinCaracteristica13);
						$InsVehiculoMovimientoSalidaDetalle1->VmdCaracteristica14 = (empty( $InsOrdenVentaVehiculo->EinCaracteristica14)?0: $InsOrdenVentaVehiculo->EinCaracteristica14);
						$InsVehiculoMovimientoSalidaDetalle1->VmdCaracteristica15 = (empty( $InsOrdenVentaVehiculo->EinCaracteristica14)?0: $InsOrdenVentaVehiculo->EinCaracteristica14);
						$InsVehiculoMovimientoSalidaDetalle1->VmdCaracteristica16 = (empty( $InsOrdenVentaVehiculo->EinCaracteristica15)?0: $InsOrdenVentaVehiculo->EinCaracteristica15);
						$InsVehiculoMovimientoSalidaDetalle1->VmdCaracteristica17 = (empty( $InsOrdenVentaVehiculo->EinCaracteristica16)?0: $InsOrdenVentaVehiculo->EinCaracteristica16);
						$InsVehiculoMovimientoSalidaDetalle1->VmdCaracteristica18 = (empty( $InsOrdenVentaVehiculo->EinCaracteristica17)?0: $InsOrdenVentaVehiculo->EinCaracteristica17);
						$InsVehiculoMovimientoSalidaDetalle1->VmdCaracteristica19 = (empty( $InsOrdenVentaVehiculo->EinCaracteristica18)?0: $InsOrdenVentaVehiculo->EinCaracteristica18);
						$InsVehiculoMovimientoSalidaDetalle1->VmdCaracteristica20 = (empty( $InsOrdenVentaVehiculo->EinCaracteristica19)?0: $InsOrdenVentaVehiculo->EinCaracteristica19);
			
						
						
						//$InsVehiculoMovimientoSalidaDetalle1->VmdEstado = $InsOrdenVentaVehiculo->Parametro25;
						$InsVehiculoMovimientoSalidaDetalle1->VmdEstado = 1;		
						$InsVehiculoMovimientoSalidaDetalle1->VmdTiempoCreacion = date("Y-m-d H:i:s");
						$InsVehiculoMovimientoSalidaDetalle1->VmdTiempoModificacion = date("Y-m-d H:i:s");
						$InsVehiculoMovimientoSalidaDetalle1->VmdEliminado = 1;				
						$InsVehiculoMovimientoSalidaDetalle1->InsMysql = NULL;
			
						$InsVehiculoMovimientoSalidaDetalle1->VmdValorTotal =  round($InsVehiculoMovimientoSalidaDetalle1->VmdCosto + ($InsVehiculoMovimientoSalidaDetalle1->VmdCostoExtraUnitario/(($InsVehiculoMovimientoSalida->VmvPorcentajeImpuestoVenta/100)+1)),6);
			
						settype($InsVehiculoMovimientoSalidaDetalle1->VmdCostoAnterior,"float");
			
						if(empty($InsVehiculoMovimientoSalidaDetalle1->VmdCostoAnterior)){
							$InsVehiculoMovimientoSalidaDetalle1->VmdCostoPromedio =  round(($InsVehiculoMovimientoSalidaDetalle1->VmdValorTotal),6);				
						}else{
							$InsVehiculoMovimientoSalidaDetalle1->VmdCostoPromedio =  round(($InsVehiculoMovimientoSalidaDetalle1->VmdValorTotal + $InsVehiculoMovimientoSalidaDetalle1->VmdCostoAnterior)/2,6);				
						}		
									
						$InsVehiculoMovimientoSalida->VehiculoMovimientoSalidaDetalle[] = $InsVehiculoMovimientoSalidaDetalle1;		
						$InsVehiculoMovimientoSalida->VmvTotalBruto += $InsVehiculoMovimientoSalidaDetalle1->VmdImporte;
					
						$InsVehiculoMovimientoSalida->VmvSubTotal = $InsVehiculoMovimientoSalida->VmvTotalBruto;
						$InsVehiculoMovimientoSalida->VmvImpuesto = round( ($InsVehiculoMovimientoSalida->VmvSubTotal + $InsVehiculoMovimientoSalida->VmvNacionalTotalRecargo) * ($InsVehiculoMovimientoSalida->VmvPorcentajeImpuestoVenta/100),3);
						
						$InsVehiculoMovimientoSalida->VmvTotal = $InsVehiculoMovimientoSalida->VmvSubTotal + $InsVehiculoMovimientoSalida->VmvImpuesto;
					
						if($Guardar){
					
							if($InsVehiculoMovimientoSalida->MtdRegistrarVehiculoMovimientoSalida()){
					
							}else{
								
							}
								
						}else{
							
						}
						
						
					}

	
	
	
	

				$Resultado .= "#SAS_OVV_107";
			}else{
				$Resultado .= "#ERR_OVV_107";
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
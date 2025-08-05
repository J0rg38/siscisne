<?php
switch($POST_acc){


		
		case 'Eliminar':

			if($InsAprobacionVentaVehiculo->MtdEliminarAprobacionVentaVehiculo($POST_seleccionados)){
				$Resultado .= "#SAS_AOV_105";
			}else{
				$Resultado .= "#ERR_AOV_105";
			}
		
		
		break;
		
		
			case 'AprobacionVentaVehiculoActualizarEmitido':

			if($InsAprobacionVentaVehiculo->MtdActualizarEstadoAprobacionVentaVehiculo($POST_seleccionados,3)){
				$Resultado .= "#SAS_AOV_108";
			}else{
				$Resultado .= "#ERR_AOV_108";
			}
		
		break;
	
		case 'AprobacionVentaVehiculoActualizarAnulado':

			if($InsAprobacionVentaVehiculo->MtdActualizarEstadoAprobacionVentaVehiculo($POST_seleccionados,6)){
				$Resultado .= "#SAS_AOV_109";
			}else{
				$Resultado .= "#ERR_AOV_109";
			}
		
		break;

		case 'AprobacionVentaVehiculoEnviarFacturacion':

			if($InsAprobacionVentaVehiculo->MtdActualizarEstadoAprobacionVentaVehiculo($POST_seleccionados,4)){
				
							//FncNotificarFacturarAprobacionVentaVehiculo($oAprobacionVentaVehiculoId,$oTipoComprobante,$oUsuarioId,$oUsuario,$oDescripcionAdicional=NULL,$oPersonalNombre=NULL,$oPersonalFoto=NULL){
				$InsAprobacionVentaVehiculo->FncNotificarFacturarAprobacionVentaVehiculo($POST_seleccionados,$oTipoComprobante,$_SESSION['SesionId'],$_SESSION['SesionUsuario'],NULL,NULL,NULL);
				
				
				//$InsNotificacion = new ClsNotificacion();
//				$InsNotificacion->UsuId = "USU-10001";
//				$InsNotificacion->UsuIdOrigen = $_SESSION['SesionId'];
//								
//				$InsNotificacion->NfnModulo = "ComprobanteVenta";
//				$InsNotificacion->NfnFormulario = "MonitoreoAprobacionVentaVehiculo";
//				$InsNotificacion->NfnDescripcion = "<b>".$_SESSION['SesionUsuario']."</b> te ha enviado una orden de venta de vehiculo para facturar";
//				$InsNotificacion->NfnEnlace = "principal.php?Mod=ComprobanteVenta&Form=MonitoreoAprobacionVentaVehiculo";
//				$InsNotificacion->NfnEnlaceNombre = "Mostrar";
//																						
//				$InsNotificacion->NfnTipo = 1;
//				$InsNotificacion->NfnEstado = 1;
//				$InsNotificacion->NfnTiempoCreacion =date("Y-m-d H:i:s");
//				$InsNotificacion->NfnTiempoModificacion =date("Y-m-d H:i:s");
//	
//				$InsNotificacion->MtdRegistrarNotificacion();

				$Resultado .= "#SAS_AOV_107";
			}else{
				$Resultado .= "#ERR_AOV_107";
			}
		
		break;


	/*	case 'AprobacionVentaVehiculoVentaAnularEnvioFacturacion':

			if($InsAprobacionVentaVehiculo->MtdActualizarEstadoAprobacionVentaVehiculo($POST_seleccionados,3)){
				$Resultado .= "#SAS_AOV_108";
			}else{
				$Resultado .= "#ERR_AOV_108";
			}
		
		break;*/
		
		
	/*		case 'AprobacionVentaVehiculoActualizarEmitido':

			if($InsAprobacionVentaVehiculo->MtdActualizarEstadoAprobacionVentaVehiculo($POST_seleccionados,3)){
				$Resultado .= "#SAS_AOV_108";
			}else{
				$Resultado .= "#ERR_AOV_108";
			}
		
		break;*/


	}
?>
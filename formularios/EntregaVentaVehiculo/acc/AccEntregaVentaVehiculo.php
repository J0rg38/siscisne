<?php
switch($POST_acc){


		
		case 'Eliminar':

			if($InsEntregaVentaVehiculo->MtdEliminarEntregaVentaVehiculo($POST_seleccionados)){
				$Resultado .= "#SAS_EVV_105";
			}else{
				$Resultado .= "#ERR_EVV_105";
			}
		
		
		break;
		
		case 'EntregaVentaVehiculoActualizarPendiente':

			if($InsEntregaVentaVehiculo->MtdActualizarEstadoEntregaVentaVehiculo($POST_seleccionados,1)){
				$Resultado .= "#SAS_EVV_107";
			}else{
				$Resultado .= "#ERR_EVV_107";
			}
		
		break;
		
		case 'EntregaVentaVehiculoActualizarEmitido':

			if($InsEntregaVentaVehiculo->MtdActualizarEstadoEntregaVentaVehiculo($POST_seleccionados,3)){
				$Resultado .= "#SAS_EVV_108";
			}else{
				$Resultado .= "#ERR_EVV_108";
			}
		
		break;
	
		case 'EntregaVentaVehiculoActualizarAnulado':

			if($InsEntregaVentaVehiculo->MtdActualizarEstadoEntregaVentaVehiculo($POST_seleccionados,6)){
				$Resultado .= "#SAS_EVV_109";
			}else{
				$Resultado .= "#ERR_EVV_109";
			}
		
		break;

	

	}
?>
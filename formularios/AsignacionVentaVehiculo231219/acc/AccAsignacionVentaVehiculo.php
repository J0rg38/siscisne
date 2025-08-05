<?php
switch($POST_acc){


		
		case 'Eliminar':

			if($InsAsignacionVentaVehiculo->MtdEliminarAsignacionVentaVehiculo($POST_seleccionados)){
				$Resultado .= "#SAS_AVV_105";
			}else{
				$Resultado .= "#ERR_AVV_105";
			}
		
		
		break;
		
		
			case 'AsignacionVentaVehiculoActualizarEmitido':

			if($InsAsignacionVentaVehiculo->MtdActualizarEstadoAsignacionVentaVehiculo($POST_seleccionados,3)){
				$Resultado .= "#SAS_AVV_108";
			}else{
				$Resultado .= "#ERR_AVV_108";
			}
		
		break;
	
		case 'AsignacionVentaVehiculoActualizarAnulado':

			if($InsAsignacionVentaVehiculo->MtdActualizarEstadoAsignacionVentaVehiculo($POST_seleccionados,6)){
				$Resultado .= "#SAS_AVV_109";
			}else{
				$Resultado .= "#ERR_AVV_109";
			}
		
		break;

		


	}
?>
<?php
switch($POST_acc){

		case 'Eliminar':

			if($InsVehiculoIngresoEvento->MtdEliminarVehiculoIngresoEvento($POST_seleccionados)){
				$Resultado .= "#SAS_VIE_105";
			}else{
				$Resultado .= "#ERR_VIE_105";
			}
		
		break;
		
			case 'ActualizarEstadoPendiente':

			if($InsVehiculoIngresoEvento->MtdActualizarEstadoVehiculoIngresoEvento($POST_seleccionados,1)){
				$Resultado .= "#SAS_VIE_107";
			}else{
				$Resultado .= "#ERR_VIE_107";
			}
		
		break;
		
		
		case 'ActualizarEstadoRealizado':

			if($InsVehiculoIngresoEvento->MtdActualizarEstadoVehiculoIngresoEvento($POST_seleccionados,3)){
				$Resultado .= "#SAS_VIE_108";
			}else{
				$Resultado .= "#ERR_VIE_108";
			}
		
		break;
		
		case 'ActualizarEstadoAnulado':

			if($InsVehiculoIngresoEvento->MtdActualizarEstadoVehiculoIngresoEvento($POST_seleccionados,6)){
				$Resultado .= "#SAS_VIE_109";
			}else{
				$Resultado .= "#ERR_VIE_109";
			}
		
		break;
		
	}
?>
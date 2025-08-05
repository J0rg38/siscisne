<?php
switch($POST_acc){

		case 'Eliminar':

			if($InsVehiculoInstalar->MtdEliminarVehiculoInstalar($POST_seleccionados)){
				$Resultado .= "#SAS_VIS_105";
			}else{
				$Resultado .= "#ERR_VIS_105";
			}
		
		break;
		
			case 'ActualizarEstadoPendiente':

			if($InsVehiculoInstalar->MtdActualizarEstadoVehiculoInstalar($POST_seleccionados,1)){
				$Resultado .= "#SAS_VIS_107";
			}else{
				$Resultado .= "#ERR_VIS_107";
			}
		
		break;
		
		
		case 'ActualizarEstadoRealizado':

			if($InsVehiculoInstalar->MtdActualizarEstadoVehiculoInstalar($POST_seleccionados,3)){
				$Resultado .= "#SAS_VIS_108";
			}else{
				$Resultado .= "#ERR_VIS_108";
			}
		
		break;
		
		case 'ActualizarEstadoAnulado':

			if($InsVehiculoInstalar->MtdActualizarEstadoVehiculoInstalar($POST_seleccionados,6)){
				$Resultado .= "#SAS_VIS_109";
			}else{
				$Resultado .= "#ERR_VIS_109";
			}
		
		break;
		
	}
?>
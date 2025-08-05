<?php
switch($POST_acc){

		case 'Eliminar':

			if($InsObsequio->MtdEliminarObsequio($POST_seleccionados)){
				$Resultado .= "#SAS_OBS_105";
			}else{
				$Resultado .= "#ERR_OBS_105";
			}
		
		break;
		
			case 'ActualizarEstadoPendiente':

			if($InsObsequio->MtdActualizarEstadoObsequio($POST_seleccionados,1)){
				$Resultado .= "#SAS_OBS_107";
			}else{
				$Resultado .= "#ERR_OBS_107";
			}
		
		break;
		
		
		case 'ActualizarEstadoRealizado':

			if($InsObsequio->MtdActualizarEstadoObsequio($POST_seleccionados,3)){
				$Resultado .= "#SAS_OBS_108";
			}else{
				$Resultado .= "#ERR_OBS_108";
			}
		
		break;
		
		case 'ActualizarEstadoAnulado':

			if($InsObsequio->MtdActualizarEstadoObsequio($POST_seleccionados,6)){
				$Resultado .= "#SAS_OBS_109";
			}else{
				$Resultado .= "#ERR_OBS_109";
			}
		
		break;
		
	}
?>
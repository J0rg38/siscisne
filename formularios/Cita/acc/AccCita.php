<?php
switch($POST_acc){

		case 'Eliminar':

			if($InsCita->MtdEliminarCita($POST_seleccionados)){
				$Resultado .= "#SAS_CIT_105";
			}else{
				$Resultado .= "#ERR_CIT_105";
			}
		
		break;
		
			case 'ActualizarEstadoPendiente':

			if($InsCita->MtdActualizarEstadoCita($POST_seleccionados,1)){
				$Resultado .= "#SAS_CIT_107";
			}else{
				$Resultado .= "#ERR_CIT_107";
			}
		
		break;
		
		
		case 'ActualizarEstadoRealizado':

			if($InsCita->MtdActualizarEstadoCita($POST_seleccionados,3)){
				$Resultado .= "#SAS_CIT_108";
			}else{
				$Resultado .= "#ERR_CIT_108";
			}
		
		break;
		
		case 'ActualizarEstadoAnulado':

			if($InsCita->MtdActualizarEstadoCita($POST_seleccionados,6)){
				$Resultado .= "#SAS_CIT_109";
			}else{
				$Resultado .= "#ERR_CIT_109";
			}
		
		break;
		
	}
?>
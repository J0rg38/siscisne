<?php
switch($POST_acc){


		
		case 'Eliminar':

			if($InsVehiculoMovimientoSalida->MtdEliminarVehiculoMovimientoSalida($POST_seleccionados)){
				$Resultado .= "#SAS_VMS_105";
			}else{
				$Resultado .= "#ERR_VMS_105";
			}
		
		break;
		
		
		/*case 'RevisadoSi':
		
			if($InsVehiculoMovimientoSalida->MtdActualizarRevisadoVehiculoMovimientoSalida($POST_seleccionados,1)){
				$Resultado .= "#SAS_VMS_106";
			}else{
				$Resultado .= "#ERR_VMS_106";
			}		
		
		break;
		
		case 'RevisadoNo':

			if($InsVehiculoMovimientoSalida->MtdActualizarRevisadoVehiculoMovimientoSalida($POST_seleccionados,2)){
				$Resultado .= "#SAS_VMS_107";
			}else{
				$Resultado .= "#ERR_VMS_107";
			}
			
			
		break;*/
		
		
			
		case 'VehiculoMovimientoSalidaSimpleActualizarRealizado':

			if($InsVehiculoMovimientoSalida->MtdActualizarEstadoVehiculoMovimientoSalida($POST_seleccionados,3)){
				$Resultado .= "#SAS_VMS_108";
			}else{
				$Resultado .= "#ERR_VMS_108";
			}
			
			
		break;
		
			
		case 'VehiculoMovimientoSalidaSimpleActualizarPendiente':

			if($InsVehiculoMovimientoSalida->MtdActualizarEstadoVehiculoMovimientoSalida($POST_seleccionados,1)){
				$Resultado .= "#SAS_VMS_109";
			}else{
				$Resultado .= "#ERR_VMS_109";
			}
			
			
		break;
		
			
		case 'VehiculoMovimientoSalidaSimpleActualizarAnulado':

			if($InsVehiculoMovimientoSalida->MtdActualizarEstadoVehiculoMovimientoSalida($POST_seleccionados,6)){
				$Resultado .= "#SAS_VMS_110";
			}else{
				$Resultado .= "#ERR_VMS_110";
			}
			
			
		break;
	

	}
?>
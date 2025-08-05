<?php
switch($POST_acc){


		
		case 'Eliminar':

			if($InsVehiculoMovimientoEntrada->MtdEliminarVehiculoMovimientoEntrada($POST_seleccionados)){
				$Resultado .= "#SAS_VME_105";
			}else{
				$Resultado .= "#ERR_VME_105";
			}
		
		break;
		
		
		case 'RevisadoSi':
		
			if($InsVehiculoMovimientoEntrada->MtdActualizarRevisadoVehiculoMovimientoEntrada($POST_seleccionados,1)){
				$Resultado .= "#SAS_VME_106";
			}else{
				$Resultado .= "#ERR_VME_106";
			}		
		
		break;
		
		case 'RevisadoNo':

			if($InsVehiculoMovimientoEntrada->MtdActualizarRevisadoVehiculoMovimientoEntrada($POST_seleccionados,2)){
				$Resultado .= "#SAS_VME_107";
			}else{
				$Resultado .= "#ERR_VME_107";
			}
			
			
		break;
	
	
		case 'ActualizarEstadoPendiente':
		
			if($InsVehiculoMovimientoEntrada->MtdActualizarEstadoVehiculoMovimientoEntrada($POST_seleccionados,1)){
				$Resultado .= "#SAS_VME_108";
			}else{
				$Resultado .= "#ERR_VME_108";
			}
		
		break;
		
			case 'ActualizarEstadoRealizado':
		
			if($InsVehiculoMovimientoEntrada->MtdActualizarEstadoVehiculoMovimientoEntrada($POST_seleccionados,3)){
				$Resultado .= "#SAS_VME_109";
			}else{
				$Resultado .= "#ERR_VME_109";
			}
		
		break;
		
			case 'ActualizarEstadoAnulado':
		
			if($InsVehiculoMovimientoEntrada->MtdActualizarEstadoVehiculoMovimientoEntrada($POST_seleccionados,6)){
				$Resultado .= "#SAS_VME_110";
			}else{
				$Resultado .= "#ERR_VME_110";
			}
		
		break;

	}
?>
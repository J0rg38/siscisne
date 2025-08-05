<?php
switch($POST_acc){

		case 'Eliminar':

			if($InsVehiculoIngresoBono->MtdEliminarVehiculoIngresoBono($POST_seleccionados)){
				$Resultado .= "#SAS_VIB_105";
			}else{
				$Resultado .= "#ERR_VIB_105";
			}
		
		break;
		
			case 'ActualizarEstadoPendiente':

			if($InsVehiculoIngresoBono->MtdActualizarEstadoVehiculoIngresoBono($POST_seleccionados,1)){
				$Resultado .= "#SAS_VIB_107";
			}else{
				$Resultado .= "#ERR_VIB_107";
			}
		
		break;
		
		
		case 'ActualizarEstadoRealizado':

			if($InsVehiculoIngresoBono->MtdActualizarEstadoVehiculoIngresoBono($POST_seleccionados,3)){
				$Resultado .= "#SAS_VIB_108";
			}else{
				$Resultado .= "#ERR_VIB_108";
			}
		
		break;
		
		case 'ActualizarEstadoAnulado':

			if($InsVehiculoIngresoBono->MtdActualizarEstadoVehiculoIngresoBono($POST_seleccionados,6)){
				$Resultado .= "#SAS_VIB_109";
			}else{
				$Resultado .= "#ERR_VIB_109";
			}
		
		break;
		
	}
?>
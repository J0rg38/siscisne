<?php
switch($POST_acc){


		
		case 'Eliminar':

			if($InsPagoVehiculoIngreso->MtdEliminarPagoVehiculoIngreso($POST_seleccionados)){
				$Resultado .= "#SAS_PVI_105";
			}else{
				$Resultado .= "#ERR_PVI_105";
			}
		
		break;
		
		
		case 'RevisadoSi':
		
			if($InsPagoVehiculoIngreso->MtdActualizarRevisadoPagoVehiculoIngreso($POST_seleccionados,1)){
				$Resultado .= "#SAS_PVI_106";
			}else{
				$Resultado .= "#ERR_PVI_106";
			}		
		
		break;
		
		case 'RevisadoNo':

			if($InsPagoVehiculoIngreso->MtdActualizarRevisadoPagoVehiculoIngreso($POST_seleccionados,2)){
				$Resultado .= "#SAS_PVI_107";
			}else{
				$Resultado .= "#ERR_PVI_107";
			}
			
			
		break;
	
	
		case 'ActualizarEstadoPendiente':
		
			if($InsPagoVehiculoIngreso->MtdActualizarEstadoPagoVehiculoIngreso($POST_seleccionados,1)){
				$Resultado .= "#SAS_PVI_108";
			}else{
				$Resultado .= "#ERR_PVI_108";
			}
		
		break;
		
			case 'ActualizarEstadoRealizado':
		
			if($InsPagoVehiculoIngreso->MtdActualizarEstadoPagoVehiculoIngreso($POST_seleccionados,3)){
				$Resultado .= "#SAS_PVI_109";
			}else{
				$Resultado .= "#ERR_PVI_109";
			}
		
		break;
		
			case 'ActualizarEstadoAnulado':
		
			if($InsPagoVehiculoIngreso->MtdActualizarEstadoPagoVehiculoIngreso($POST_seleccionados,6)){
				$Resultado .= "#SAS_PVI_110";
			}else{
				$Resultado .= "#ERR_PVI_110";
			}
		
		break;

	}
?>
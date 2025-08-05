<?php
switch($POST_acc){


		
		case 'Anular':

			if($InsOrdenVentaVehiculo->MtdActualizarEstadoOrdenVentaVehiculo($POST_seleccionados,6)){
				$Resultado .= "#SAS_AVV_111";
			}else{
				$Resultado .= "#ERR_AVV_111";
			}
		
		break;
		
			
		case 'Rechazar':

			/*if($InsOrdenVentaVehiculo->MtdActualizarEstadoOrdenVentaVehiculo($POST_seleccionados,1)){
				$Resultado .= "#SAS_AVV_110";
			}else{
				$Resultado .= "#ERR_AVV_110";
			}*/
			
			if($InsAsignacionVentaVehiculo->MtdRechazarAsignacionVentaVehiculo($POST_seleccionados,1)){
				$Resultado .= "#SAS_AVV_110";
			}else{
				$Resultado .= "#ERR_AVV_110";
			}
		
		break;
		
		
		


	}
?>
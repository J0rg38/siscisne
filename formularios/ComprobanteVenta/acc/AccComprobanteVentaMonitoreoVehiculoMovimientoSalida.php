<?php

switch($POST_acc){
		
		case 'ActualizarFacturable':

			if($InsVehiculoMovimientoSalida->MtdActualizarFacturableVehiculoMovimientoSalida($POST_seleccionados,1)){
				$Resultado .= "#SAS_CEN_304";
			}else{
				$Resultado .= "#ERR_CEN_304";
			}
		
		break;
		
		
		case 'ActualizarNoFacturable':

			if($InsVehiculoMovimientoSalida->MtdActualizarFacturableVehiculoMovimientoSalida($POST_seleccionados,2)){
				$Resultado .= "#SAS_CEN_305";
			}else{
				$Resultado .= "#ERR_CEN_305";
			}
		
		break;
			

	}
?>
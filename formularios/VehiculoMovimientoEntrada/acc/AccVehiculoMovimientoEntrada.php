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
	

	}
?>
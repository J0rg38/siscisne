<?php
switch($POST_acc){


		
		case 'Eliminar':

			if($InsAlmacenMovimientoSalida->MtdEliminarAlmacenMovimientoSalida($POST_seleccionados)){
				$Resultado .= "#SAS_AMO_105";
			}else{
				$Resultado .= "#ERR_AMO_105";
			}
		
		break;
		
		
				
		case 'ActualizarAlmacenMovimientoSalidaEstadoPendiente':

			if($InsAlmacenMovimientoSalida->MtdActualizarEstadoAlmacenMovimientoSalida($POST_seleccionados,1)){
				$Resultado .= "#SAS_AMO_108";
			}else{
				$Resultado .= "#ERR_AMO_108";
			}
		
		break;
		
		
		
				
		case 'ActualizarAlmacenMovimientoSalidaEstadoRealizado':

			if($InsAlmacenMovimientoSalida->MtdActualizarEstadoAlmacenMovimientoSalida($POST_seleccionados,3)){
				$Resultado .= "#SAS_AMO_109";
			}else{
				$Resultado .= "#ERR_AMO_109";
			}
		
		break;
		
		
		
		
		
	

	}
?>
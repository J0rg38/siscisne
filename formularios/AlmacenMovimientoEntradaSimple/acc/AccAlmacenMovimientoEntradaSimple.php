<?php
switch($POST_acc){


		
		case 'Eliminar':

			if($InsAlmacenMovimientoEntrada->MtdEliminarAlmacenMovimientoEntrada($POST_seleccionados)){
				$Resultado .= "#SAS_AMO_105";
			}else{
				$Resultado .= "#ERR_AMO_105";
			}
		
		break;
		
		
		case 'RevisadoSi':
		
			if($InsAlmacenMovimientoEntrada->MtdActualizarRevisadoAlmacenMovimientoEntrada($POST_seleccionados,1)){
				$Resultado .= "#SAS_AMO_106";
			}else{
				$Resultado .= "#ERR_AMO_106";
			}		
		
		break;
		
		case 'RevisadoNo':

			if($InsAlmacenMovimientoEntrada->MtdActualizarRevisadoAlmacenMovimientoEntrada($POST_seleccionados,2)){
				$Resultado .= "#SAS_AMO_107";
			}else{
				$Resultado .= "#ERR_AMO_107";
			}
			
			
		break;
	
	
		case 'ActualizarAlmacenMovimientoEntradaEstadoPendiente':

			if($InsAlmacenMovimientoEntrada->MtdActualizarEstadoAlmacenMovimientoEntrada($POST_seleccionados,1)){
				$Resultado .= "#SAS_AMO_108";
			}else{
				$Resultado .= "#ERR_AMO_108";
			}
		
		break;
		
		
		
				
		case 'ActualizarAlmacenMovimientoEntradaEstadoRealizado':

			if($InsAlmacenMovimientoEntrada->MtdActualizarEstadoAlmacenMovimientoEntrada($POST_seleccionados,3)){
				$Resultado .= "#SAS_AMO_109";
			}else{
				$Resultado .= "#ERR_AMO_109";
			}
		
		break;

	}
?>
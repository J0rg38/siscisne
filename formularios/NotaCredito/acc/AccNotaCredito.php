<?php
switch($POST_acc){
		
		case 'Eliminar':

			if($InsNotaCredito->MtdEliminarNotaCredito($POST_seleccionados)){
				$Resultado .= "#SAS_NCR_105";
			}else{
				$Resultado .= "#ERR_NCR_105";
			}
		
		break;
		
		case 'ActualizarEstadoPendiente':

			if($InsNotaCredito->MtdActualizarEstadoNotaCredito($POST_seleccionados,1)){
				$Resultado .= "#SAS_NCR_107";
			}else{
				$Resultado .= "#ERR_NCR_107";
			}
		
		break;
		
		
		case 'ActualizarEstadoEntregado':

			if($InsNotaCredito->MtdActualizarEstadoNotaCredito($POST_seleccionados,5)){
				$Resultado .= "#SAS_NCR_108";
			}else{
				$Resultado .= "#ERR_NCR_108";
			}
		
		break;
		
		case 'ActualizarEstadoAnulado':

			if($InsNotaCredito->MtdActualizarEstadoNotaCredito($POST_seleccionados,6)){
				$Resultado .= "#SAS_NCR_109";
			}else{
				$Resultado .= "#ERR_NCR_109";
			}
		
		break;
			

	}
?>
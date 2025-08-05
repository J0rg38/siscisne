<?php
switch($POST_acc){
		
		case 'Eliminar':

			if($InsNotaDebito->MtdEliminarNotaDebito($POST_seleccionados)){
				$Resultado .= "#SAS_NDB_105";
			}else{
				$Resultado .= "#ERR_NDB_105";
			}
		
		break;
		
		case 'ActualizarEstadoPendiente':

			if($InsNotaDebito->MtdActualizarEstadoNotaDebito($POST_seleccionados,1)){
				$Resultado .= "#SAS_NDB_107";
			}else{
				$Resultado .= "#ERR_NDB_107";
			}
		
		break;
		
		
		case 'ActualizarEstadoEntregado':

			if($InsNotaDebito->MtdActualizarEstadoNotaDebito($POST_seleccionados,5)){
				$Resultado .= "#SAS_NDB_108";
			}else{
				$Resultado .= "#ERR_NDB_108";
			}
		
		break;
		
		case 'ActualizarEstadoAnulado':

			if($InsNotaDebito->MtdActualizarEstadoNotaDebito($POST_seleccionados,6)){
				$Resultado .= "#SAS_NDB_109";
			}else{
				$Resultado .= "#ERR_NDB_109";
			}
		
		break;
			

	}
?>
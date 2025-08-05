<?php
switch($POST_acc){

		case 'Eliminar':

			if($InsTipoReferido->MtdEliminarTipoReferido($POST_seleccionados)){
				$Resultado .= "#SAS_TRF_105";
			}else{
				$Resultado .= "#ERR_TRF_105";
			}
		
		break;
		
			case 'ActualizarEstadoPendiente':

			if($InsTipoReferido->MtdActualizarEstadoTipoReferido($POST_seleccionados,1)){
				$Resultado .= "#SAS_TRF_107";
			}else{
				$Resultado .= "#ERR_TRF_107";
			}
		
		break;
		
		
		case 'ActualizarEstadoRealizado':

			if($InsTipoReferido->MtdActualizarEstadoTipoReferido($POST_seleccionados,3)){
				$Resultado .= "#SAS_TRF_108";
			}else{
				$Resultado .= "#ERR_TRF_108";
			}
		
		break;
		
		case 'ActualizarEstadoAnulado':

			if($InsTipoReferido->MtdActualizarEstadoTipoReferido($POST_seleccionados,6)){
				$Resultado .= "#SAS_TRF_109";
			}else{
				$Resultado .= "#ERR_TRF_109";
			}
		
		break;
		
	}
?>
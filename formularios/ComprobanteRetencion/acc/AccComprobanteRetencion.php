<?php
switch($POST_acc){
		
		case 'Eliminar':

			if($InsComprobanteRetencion->MtdEliminarComprobanteRetencion($POST_seleccionados)){
				$Resultado .= "#SAS_CRN_105";
			}else{
				$Resultado .= "#ERR_CRN_105";
			}
		
		break;
		
		case 'ActualizarEstadoPendiente':

			if($InsComprobanteRetencion->MtdActualizarEstadoComprobanteRetencion($POST_seleccionados,1)){
				$Resultado .= "#SAS_CRN_107";
			}else{
				$Resultado .= "#ERR_CRN_107";
			}
		
		break;
		
		
		case 'ActualizarEstadoEntregado':

			if($InsComprobanteRetencion->MtdActualizarEstadoComprobanteRetencion($POST_seleccionados,5)){
				$Resultado .= "#SAS_CRN_108";
			}else{
				$Resultado .= "#ERR_CRN_108";
			}
		
		break;
		
		case 'ActualizarEstadoAnulado':

			if($InsComprobanteRetencion->MtdActualizarEstadoComprobanteRetencion($POST_seleccionados,6)){
				$Resultado .= "#SAS_CRN_109";
			}else{
				$Resultado .= "#ERR_CRN_109";
			}
		
		break;
		
		
		case 'ActualizarEstadoReservado':

			if($InsComprobanteRetencion->MtdActualizarEstadoComprobanteRetencion($POST_seleccionados,7)){
				$Resultado .= "#SAS_CRN_110";
			}else{
				$Resultado .= "#ERR_CRN_110";
			}
		
		break;
			

	}
?>
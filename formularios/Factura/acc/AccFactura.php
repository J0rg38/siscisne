<?php
switch($POST_acc){
		
		case 'Eliminar':

			if($InsFactura->MtdEliminarFactura($POST_seleccionados)){
				$Resultado .= "#SAS_FAC_105";
			}else{
				$Resultado .= "#ERR_FAC_105";
			}
		
		break;
		
		case 'ActualizarEstadoPendiente':

			if($InsFactura->MtdActualizarEstadoFactura($POST_seleccionados,1)){
				$Resultado .= "#SAS_FAC_107";
			}else{
				$Resultado .= "#ERR_FAC_107";
			}
		
		break;
		
		
		case 'ActualizarEstadoEntregado':

			if($InsFactura->MtdActualizarEstadoFactura($POST_seleccionados,5)){
				$Resultado .= "#SAS_FAC_108";
			}else{
				$Resultado .= "#ERR_FAC_108";
			}
		
		break;
		
		case 'ActualizarEstadoAnulado':

			if($InsFactura->MtdActualizarEstadoFactura($POST_seleccionados,6)){
				$Resultado .= "#SAS_FAC_109";
			}else{
				$Resultado .= "#ERR_FAC_109";
			}
		
		break;
		
		
		case 'ActualizarEstadoReservado':

			if($InsFactura->MtdActualizarEstadoFactura($POST_seleccionados,7)){
				$Resultado .= "#SAS_FAC_110";
			}else{
				$Resultado .= "#ERR_FAC_110";
			}
		
		break;
			

	}
?>
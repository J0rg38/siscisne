<?php
switch($POST_acc){
		
		case 'Eliminar':

			if($InsNotaCreditoCompra->MtdEliminarNotaCreditoCompra($POST_seleccionados)){
				$Resultado .= "#SAS_NCC_105";
			}else{
				$Resultado .= "#ERR_NCC_105";
			}
		
		break;
		
		case 'ActualizarEstadoPendiente':

			if($InsNotaCreditoCompra->MtdActualizarEstadoNotaCreditoCompra($POST_seleccionados,1)){
				$Resultado .= "#SAS_NCC_107";
			}else{
				$Resultado .= "#ERR_NCC_107";
			}
		
		break;
		
		
		case 'ActualizarEstadoEntregado':

			if($InsNotaCreditoCompra->MtdActualizarEstadoNotaCreditoCompra($POST_seleccionados,5)){
				$Resultado .= "#SAS_NCC_108";
			}else{
				$Resultado .= "#ERR_NCC_108";
			}
		
		break;
		
		case 'ActualizarEstadoAnulado':

			if($InsNotaCreditoCompra->MtdActualizarEstadoNotaCreditoCompra($POST_seleccionados,6)){
				$Resultado .= "#SAS_NCC_109";
			}else{
				$Resultado .= "#ERR_NCC_109";
			}
		
		break;
		
		
		case 'ActualizarEstadoReservado':

			if($InsNotaCreditoCompra->MtdActualizarEstadoNotaCreditoCompra($POST_seleccionados,7)){
				$Resultado .= "#SAS_NCC_110";
			}else{
				$Resultado .= "#ERR_NCC_110";
			}
		
		break;
			

	}
?>
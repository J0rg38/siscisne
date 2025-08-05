<?php

	$InsBoleta->UsuId = $_SESSION['SesionId'];

switch($POST_acc){
		
		case 'Eliminar':

			if($InsBoleta->MtdEliminarBoleta($POST_seleccionados)){
				$Resultado .= "#SAS_BOL_105";
			}else{
				$Resultado .= "#ERR_BOL_105";
			}
		
		break;
		
		
		case 'ActualizarEstadoPendiente':

			if($InsBoleta->MtdActualizarEstadoBoleta($POST_seleccionados,1)){
				$Resultado .= "#SAS_BOL_107";
			}else{
				$Resultado .= "#ERR_BOL_107";
			}
		
		break;
		
		
		case 'ActualizarEstadoEntregado':

			if($InsBoleta->MtdActualizarEstadoBoleta($POST_seleccionados,5)){
				$Resultado .= "#SAS_BOL_108";
			}else{
				$Resultado .= "#ERR_BOL_108";
			}
		
		break;
		
		case 'ActualizarEstadoAnulado':

			if($InsBoleta->MtdActualizarEstadoBoleta($POST_seleccionados,6)){
				$Resultado .= "#SAS_BOL_109";
			}else{
				$Resultado .= "#ERR_BOL_109";
			}
		
		break;
		
		case 'ActualizarEstadoReservado':

			if($InsBoleta->MtdActualizarEstadoBoleta($POST_seleccionados,7)){
				$Resultado .= "#SAS_BOL_110";
			}else{
				$Resultado .= "#ERR_BOL_110";
			}
		
		break;
			

	}
?>
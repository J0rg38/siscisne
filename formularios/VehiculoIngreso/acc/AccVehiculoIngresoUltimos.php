<?php

$InsVehiculoIngreso->UsuId = $_SESSION['SesionId'];	

switch($POST_acc){


		case 'ActualizarObservadoLibre':

			if($InsVehiculoIngreso->MtdEditarObservadoVehiculoIngreso($POST_seleccionados,"2","LIBRE")){
				$Resultado .= "#SAS_EIN_107";
			}else{
				$Resultado .= "#ERR_EIN_107";
			}
		
		break;
		
			case 'ActualizarObservadoPedido':

			if($InsVehiculoIngreso->MtdEditarObservadoVehiculoIngreso($POST_seleccionados,"1","PEDIDO")){
				$Resultado .= "#SAS_EIN_107";
			}else{
				$Resultado .= "#ERR_EIN_107";
			}
		
		break;
		
			case 'ActualizarObservadoFlota':

			if($InsVehiculoIngreso->MtdEditarObservadoVehiculoIngreso($POST_seleccionados,"1","FLOTA")){
				$Resultado .= "#SAS_EIN_107";
			}else{
				$Resultado .= "#ERR_EIN_107";
			}
		
		break;
		


	}
?>
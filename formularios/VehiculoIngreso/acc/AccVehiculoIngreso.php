<?php

$InsVehiculoIngreso->UsuId = $_SESSION['SesionId'];	

switch($POST_acc){

	/*	case 'Duplicar':

			if($InsVehiculoIngreso->MtdDuplicarVehiculoIngreso($POST_seleccionados)){
				$Resultado .= "#SAS_EIN_110";
			}else{
				$Resultado .= "#ERR_EIN_110";
			}

		break;
*/
		case 'Eliminar':

			if($InsVehiculoIngreso->MtdEliminarVehiculoIngreso($POST_seleccionados)){
				$Resultado .= "#SAS_EIN_105";
			}else{
				$Resultado .= "#ERR_EIN_105";
			}
		
		break;
		
		
		case 'ActualizarEstadoVehicularSTOCK':

			if($InsVehiculoIngreso->MtdEditarEstadoVehicularVehiculoIngreso($POST_seleccionados,"STOCK")){
				$Resultado .= "#SAS_EIN_106";
			}else{
				$Resultado .= "#ERR_EIN_106";
			}
		
		break;
		
		case 'ActualizarEstadoVehicularVENDIDO':

			if($InsVehiculoIngreso->MtdEditarEstadoVehicularVehiculoIngreso($POST_seleccionados,"VENDIDO")){
				$Resultado .= "#SAS_EIN_106";
			}else{
				$Resultado .= "#ERR_EIN_106";
			}
		
		break;
		
		case 'ActualizarEstadoVehicularRESERVADO':

			if($InsVehiculoIngreso->MtdEditarEstadoVehicularVehiculoIngreso($POST_seleccionados,"RESERVADO")){
				$Resultado .= "#SAS_EIN_106";
			}else{
				$Resultado .= "#ERR_EIN_106";
			}
		
		break;


		case 'ActualizarEstadoVehicularCINCIDENCIA':

			if($InsVehiculoIngreso->MtdEditarEstadoVehicularVehiculoIngreso($POST_seleccionados,"C/INCIDENCIA")){
				$Resultado .= "#SAS_EIN_106";
			}else{
				$Resultado .= "#ERR_EIN_106";
			}
		
		break;
		
		case 'ActualizarEstadoVehicularTRAMITE':

			if($InsVehiculoIngreso->MtdEditarEstadoVehicularVehiculoIngreso($POST_seleccionados,"TRAMITE")){
				$Resultado .= "#SAS_EIN_106";
			}else{
				$Resultado .= "#ERR_EIN_106";
			}
		
		break;
		
		case 'ActualizarEstadoVehicularENTREGADO':

			if($InsVehiculoIngreso->MtdEditarEstadoVehicularVehiculoIngreso($POST_seleccionados,"ENTREGADO")){
				$Resultado .= "#SAS_EIN_106";
			}else{
				$Resultado .= "#ERR_EIN_106";
			}
		
		break;
		
		
		
		case 'ActualizarObservadoLibre':

			if($InsVehiculoIngreso->MtdEditarObservadoVehiculoIngreso($POST_seleccionados,"0","LIBRE")){
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
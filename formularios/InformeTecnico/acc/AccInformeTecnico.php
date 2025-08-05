<?php
switch($POST_acc){


		
		case 'Eliminar':

			if($InsInformeTecnico->MtdEliminarInformeTecnico($POST_seleccionados)){
				$Resultado .= "#SAS_ITE_105";
			}else{
				$Resultado .= "#ERR_ITE_105";
			}
		
		break;
		
		
		case 'ActualizarPendiente':

			if($InsInformeTecnico->MtdActualizarEstadoInformeTecnico($POST_seleccionados,1)){
				$Resultado .= "#SAS_ITE_106";
			}else{
				$Resultado .= "#ERR_ITE_106";
			}
		
		break;
	
	
		case 'ActualizarRealizado':

			if($InsInformeTecnico->MtdActualizarEstadoInformeTecnico($POST_seleccionados,3)){
				$Resultado .= "#SAS_ITE_107";
			}else{
				$Resultado .= "#ERR_ITE_107";
			}
		
		break;
	

	}
?>
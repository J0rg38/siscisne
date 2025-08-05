<?php
switch($POST_acc){


		
		case 'Eliminar':

			if($InsIngreso->MtdEliminarIngreso($POST_seleccionados)){
				$Resultado .= "#SAS_ING_105";
			}else{
				$Resultado .= "#ERR_ING_105";
			}
		
		break;
		
				
		case 'AnuladoIngreso':
		
			if($InsIngreso->MtdActualizarEstadoIngreso($POST_seleccionados,6)){
				$Resultado .= "#SAS_ING_108";
			}else{
				$Resultado .= "#ERR_ING_108";
			}
		
		break;
		
		
		case 'RealizadoIngreso':
		
			if($InsIngreso->MtdActualizarEstadoIngreso($POST_seleccionados,3)){
				$Resultado .= "#SAS_ING_109";
			}else{
				$Resultado .= "#ERR_ING_109";
			}
		
		break;
		
	

	}
?>
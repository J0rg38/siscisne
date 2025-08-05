<?php
switch($POST_acc){


		
		case 'Eliminar':

			if($InsGasto->MtdEliminarGasto($POST_seleccionados)){
				$Resultado .= "#SAS_GAS_105";
			}else{
				$Resultado .= "#ERR_GAS_105";
			}
		
		break;
		
		
		case 'RevisadoSi':
		
			if($InsGasto->MtdActualizarRevisadoGasto($POST_seleccionados,1)){
				$Resultado .= "#SAS_GAS_106";
			}else{
				$Resultado .= "#ERR_GAS_106";
			}		
		
		break;
		
		case 'RevisadoNo':

			if($InsGasto->MtdActualizarRevisadoGasto($POST_seleccionados,2)){
				$Resultado .= "#SAS_GAS_107";
			}else{
				$Resultado .= "#ERR_GAS_107";
			}
			
			
		break;
	

	}
?>
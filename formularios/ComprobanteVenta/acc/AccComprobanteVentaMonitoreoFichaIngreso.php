<?php

switch($POST_acc){
		
		case 'ActualizarFacturable':

			if($InsFichaAccion->MtdActualizarFacturableFichaAccion($POST_seleccionados,1)){
				$Resultado .= "#SAS_CEN_104";
			}else{
				$Resultado .= "#ERR_CEN_104";
			}
		
		break;
		
		
		case 'ActualizarNoFacturable':

			if($InsFichaAccion->MtdActualizarFacturableFichaAccion($POST_seleccionados,2)){
				$Resultado .= "#SAS_CEN_105";
			}else{
				$Resultado .= "#ERR_CEN_105";
			}
		
		break;
			

	}
?>
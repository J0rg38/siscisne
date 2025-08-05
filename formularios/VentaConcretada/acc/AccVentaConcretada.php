<?php
switch($POST_acc){


		
		case 'Eliminar':

			if($InsVentaConcretada->MtdEliminarVentaConcretada($POST_seleccionados)){
				$Resultado .= "#SAS_VCO_105";
			}else{
				$Resultado .= "#ERR_VCO_105";
			}
		
		break;
		
//		case 'EnviarVentaConcretadaContabilidad':
//
//			if($InsVentaConcretada->MtdEnviarContabilidadVentaConcretada($POST_seleccionados)){
//				$Resultado .= "#SAS_VCO_106";
//			}else{
//				$Resultado .= "#ERR_VCO_106";
//			}
//		
//		break;
//				
		
		
			
		case 'AnularVentaConcretada':
		
			if($InsVentaConcretada->MtdActualizarEstadoVentaConcretada($POST_seleccionados,1)){
				$Resultado .= "#SAS_VCO_108";
			}else{
				$Resultado .= "#ERR_VCO_108";
			}
		
		break;
		
		
		case 'DesanularVentaConcretada':
		
			if($InsVentaConcretada->MtdActualizarEstadoVentaConcretada($POST_seleccionados,3)){
				$Resultado .= "#SAS_VCO_109";
			}else{
				$Resultado .= "#ERR_VCO_109";
			}
		
		break;
		
	

	}
?>
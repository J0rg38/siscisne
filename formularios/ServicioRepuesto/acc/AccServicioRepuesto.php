<?php
switch($POST_acc){


		
		case 'Eliminar':

			if($InsServicioRepuesto->MtdEliminarServicioRepuesto($POST_seleccionados)){
				$Resultado .= "#SAS_SRE_105";
			}else{
				$Resultado .= "#ERR_SRE_105";
			}
		
		break;
		
		
		case 'RevisadoSi':
		
			if($InsServicioRepuesto->MtdActualizarRevisadoServicioRepuesto($POST_seleccionados,1)){
				$Resultado .= "#SAS_SRE_106";
			}else{
				$Resultado .= "#ERR_SRE_106";
			}		
		
		break;
		
		case 'RevisadoNo':

			if($InsServicioRepuesto->MtdActualizarRevisadoServicioRepuesto($POST_seleccionados,2)){
				$Resultado .= "#SAS_SRE_107";
			}else{
				$Resultado .= "#ERR_SRE_107";
			}
			
			
		break;
	

	}
?>
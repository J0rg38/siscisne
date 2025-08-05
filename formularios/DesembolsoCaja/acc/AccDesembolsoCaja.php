<?php
switch($POST_acc){


		
		case 'Eliminar':

			if($InsDesembolso->MtdEliminarDesembolso($POST_seleccionados)){
				$Resultado .= "#SAS_DES_105";
			}else{
				$Resultado .= "#ERR_DES_105";
			}
		
		break;
		
				
		case 'AnuladoDesembolso':
		
			if($InsDesembolso->MtdActualizarEstadoDesembolso($POST_seleccionados,6)){
				$Resultado .= "#SAS_DES_108";
			}else{
				$Resultado .= "#ERR_DES_108";
			}
		
		break;
		
		
		case 'RealizadoDesembolso':
		
			if($InsDesembolso->MtdActualizarEstadoDesembolso($POST_seleccionados,3)){
				$Resultado .= "#SAS_DES_109";
			}else{
				$Resultado .= "#ERR_DES_109";
			}
		
		break;
		
	

	}
?>
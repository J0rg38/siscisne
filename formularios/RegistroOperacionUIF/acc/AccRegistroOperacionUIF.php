<?php
switch($POST_acc){


		
		case 'Eliminar':

			if($InsRegistroOperacionUIF->MtdEliminarRegistroOperacionUIF($POST_seleccionados)){
				$Resultado .= "#SAS_ROU_105";
			}else{
				$Resultado .= "#ERR_ROU_105";
			}
		
		break;
		
		case 'GenerarOrdenCompra':
		
		break;
		
		/*case 'EnviarRegistroOperacionUIFContabilidad':

			if($InsRegistroOperacionUIF->MtdEnviarContabilidadRegistroOperacionUIF($POST_seleccionados)){
				$Resultado .= "#SAS_ROU_106";
			}else{
				$Resultado .= "#ERR_ROU_106";
			}
		
		break;*/
				
		
		
	

	}
?>
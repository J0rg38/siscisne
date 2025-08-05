<?php
switch($POST_acc){


		
		case 'Eliminar':

			if($InsProduccionProducto->MtdEliminarProduccionProducto($POST_seleccionados)){
				$Resultado .= "#SAS_PPR_105";
			}else{
				$Resultado .= "#ERR_PPR_105";
			}
		
		break;
		
		case 'GenerarOrdenCompra':
		
		break;
		
		/*case 'EnviarProduccionProductoContabilidad':

			if($InsProduccionProducto->MtdEnviarContabilidadProduccionProducto($POST_seleccionados)){
				$Resultado .= "#SAS_PPR_106";
			}else{
				$Resultado .= "#ERR_PPR_106";
			}
		
		break;*/
				
		
		
	

	}
?>
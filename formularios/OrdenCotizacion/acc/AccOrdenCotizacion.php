<?php
switch($POST_acc){


		
		case 'Eliminar':

			if($InsOrdenCotizacion->MtdEliminarOrdenCotizacion($POST_seleccionados)){
				$Resultado .= "#SAS_OOT_105";
			}else{
				$Resultado .= "#ERR_OOT_105";
			}
		
		break;
		
		case 'GenerarOrdenCompra':
		
		break;
		
		/*case 'EnviarOrdenCotizacionContabilidad':

			if($InsOrdenCotizacion->MtdEnviarContabilidadOrdenCotizacion($POST_seleccionados)){
				$Resultado .= "#SAS_OOT_106";
			}else{
				$Resultado .= "#ERR_OOT_106";
			}
		
		break;*/
				
		
		
	

	}
?>
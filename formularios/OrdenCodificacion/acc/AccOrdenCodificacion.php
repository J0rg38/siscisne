<?php
switch($POST_acc){


		
		case 'Eliminar':

			if($InsOrdenCodificacion->MtdEliminarOrdenCodificacion($POST_seleccionados)){
				$Resultado .= "#SAS_OCI_105";
			}else{
				$Resultado .= "#ERR_OCI_105";
			}
		
		break;
		
		case 'GenerarOrdenCompra':
		
		break;
		
		/*case 'EnviarOrdenCodificacionContabilidad':

			if($InsOrdenCodificacion->MtdEnviarContabilidadOrdenCodificacion($POST_seleccionados)){
				$Resultado .= "#SAS_OCI_106";
			}else{
				$Resultado .= "#ERR_OCI_106";
			}
		
		break;*/
				
		
		
	

	}
?>
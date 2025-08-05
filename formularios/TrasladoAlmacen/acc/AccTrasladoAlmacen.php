<?php
switch($POST_acc){


		
		case 'Eliminar':

			if($InsTrasladoAlmacen->MtdEliminarTrasladoAlmacen($POST_seleccionados)){
				$Resultado .= "#SAS_TAL_105";
			}else{
				$Resultado .= "#ERR_TAL_105";
			}
		
		break;
		
		case 'GenerarOrdenCompra':
		
		break;
		
		/*case 'EnviarTrasladoAlmacenContabilidad':

			if($InsTrasladoAlmacen->MtdEnviarContabilidadTrasladoAlmacen($POST_seleccionados)){
				$Resultado .= "#SAS_TAL_106";
			}else{
				$Resultado .= "#ERR_TAL_106";
			}
		
		break;*/
				
		
		
	

	}
?>
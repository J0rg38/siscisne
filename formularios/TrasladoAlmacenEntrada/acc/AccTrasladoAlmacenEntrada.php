<?php
switch($POST_acc){


		
		case 'Eliminar':

			if($InsTrasladoAlmacenEntrada->MtdEliminarTrasladoAlmacenEntrada($POST_seleccionados)){
				$Resultado .= "#SAS_TAE_105";
			}else{
				$Resultado .= "#ERR_TAE_105";
			}
		
		break;
		
		
		case 'RevisadoSi':
		
			if($InsTrasladoAlmacenEntrada->MtdActualizarRevisadoTrasladoAlmacenEntrada($POST_seleccionados,1)){
				$Resultado .= "#SAS_TAE_106";
			}else{
				$Resultado .= "#ERR_TAE_106";
			}		
		
		break;
		
		case 'RevisadoNo':

			if($InsTrasladoAlmacenEntrada->MtdActualizarRevisadoTrasladoAlmacenEntrada($POST_seleccionados,2)){
				$Resultado .= "#SAS_TAE_107";
			}else{
				$Resultado .= "#ERR_TAE_107";
			}
			
			
		break;
	

	}
?>
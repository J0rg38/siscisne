<?php
switch($POST_acc){


		
		case 'Eliminar':

			if($InsOrdenCompra->MtdEliminarOrdenCompra($POST_seleccionados)){
				$Resultado .= "#SAS_OCO_105";
			}else{
				$Resultado .= "#ERR_OCO_105";
			}
		
		break;
		

		case 'MarcarEnviado':

			if($InsOrdenCompra->MtdActualizarEstadoOrdenCompra($POST_seleccionados,3)){
				$Resultado .= "#SAS_OCO_106";
			}else{
				$Resultado .= "#ERR_OCO_106";
			}
		
		break;		
		
	

	}
?>
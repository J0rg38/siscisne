<?php
switch($POST_acc){

	
		
		case 'Eliminar':

			if($InsVehiculoMarca->MtdEliminarVehiculoMarca($POST_seleccionados)){
				$Resultado .= "#SAS_VMA_105";
			}else{
				$Resultado .= "#ERR_VMA_105";
			}
		
		break;
		
	

	}
?>
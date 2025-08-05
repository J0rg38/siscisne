<?php
switch($POST_acc){

	
		
		case 'Eliminar':

			if($InsVehiculoCategoria->MtdEliminarVehiculoCategoria($POST_seleccionados)){
				$Resultado .= "#SAS_PCA_105";
			}else{
				$Resultado .= "#ERR_PCA_105";
			}
		
		break;
		
	

	}
?>
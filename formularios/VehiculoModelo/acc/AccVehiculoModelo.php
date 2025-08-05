<?php
switch($POST_acc){

	
		
		case 'Eliminar':

			if($InsVehiculoModelo->MtdEliminarVehiculoModelo($POST_seleccionados)){
				$Resultado .= "#SAS_VMO_105";
			}else{
				$Resultado .= "#ERR_VMO_105";
			}
		
		break;
		
	

	}
?>
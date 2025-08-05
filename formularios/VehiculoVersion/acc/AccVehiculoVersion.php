<?php
switch($POST_acc){

	
		
		case 'Eliminar':

			if($InsVehiculoVersion->MtdEliminarVehiculoVersion($POST_seleccionados)){
				$Resultado .= "#SAS_VVE_105";
			}else{
				$Resultado .= "#ERR_VVE_105";
			}
		
		break;
		
	

	}
?>
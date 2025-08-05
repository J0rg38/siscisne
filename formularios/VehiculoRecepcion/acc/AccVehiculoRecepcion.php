<?php
switch($POST_acc){

		case 'Eliminar':

			if($InsVehiculoRecepcion->MtdEliminarVehiculoRecepcion($POST_seleccionados)){
				$Resultado .= "#SAS_VRE_105";
			}else{
				$Resultado .= "#ERR_VRE_105";
			}
		
		break;
		
	
	

	}
?>
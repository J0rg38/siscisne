<?php
switch($POST_acc){


		case 'Eliminar':

			if($InsVehiculo->MtdEliminarVehiculo($POST_seleccionados)){
				$Resultado .= "#SAS_VEH_105";
			}else{
				$Resultado .= "#ERR_VEH_105";
			}
		
		break;
		
		

	}
?>
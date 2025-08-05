<?php
switch($POST_acc){


		
		case 'Eliminar':

			if($InsTrasladoVehiculo->MtdEliminarTrasladoVehiculo($POST_seleccionados)){
				$Resultado .= "#SAS_TVE_105";
			}else{
				$Resultado .= "#ERR_TVE_105";
			}
		
		break;
		
		
		case 'RevisadoSi':
		
			if($InsTrasladoVehiculo->MtdActualizarRevisadoTrasladoVehiculo($POST_seleccionados,1)){
				$Resultado .= "#SAS_TVE_106";
			}else{
				$Resultado .= "#ERR_TVE_106";
			}		
		
		break;
		
		case 'RevisadoNo':

			if($InsTrasladoVehiculo->MtdActualizarRevisadoTrasladoVehiculo($POST_seleccionados,2)){
				$Resultado .= "#SAS_TVE_107";
			}else{
				$Resultado .= "#ERR_TVE_107";
			}
			
			
		break;
	

	}
?>
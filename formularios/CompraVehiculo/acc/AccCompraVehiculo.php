<?php
switch($POST_acc){


		
		case 'Eliminar':

			if($InsCompraVehiculo->MtdEliminarCompraVehiculo($POST_seleccionados)){
				$Resultado .= "#SAS_CVH_105";
			}else{
				$Resultado .= "#ERR_CVH_105";
			}
		
		break;
		
		
		case 'RevisadoSi':
		
			if($InsCompraVehiculo->MtdActualizarRevisadoCompraVehiculo($POST_seleccionados,1)){
				$Resultado .= "#SAS_CVH_106";
			}else{
				$Resultado .= "#ERR_CVH_106";
			}		
		
		break;
		
		case 'RevisadoNo':

			if($InsCompraVehiculo->MtdActualizarRevisadoCompraVehiculo($POST_seleccionados,2)){
				$Resultado .= "#SAS_CVH_107";
			}else{
				$Resultado .= "#ERR_CVH_107";
			}
			
			
		break;
	

	}
?>
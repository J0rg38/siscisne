<?php
switch($POST_acc){

		case 'Eliminar':

			if($InsPago->MtdEliminarPago($POST_seleccionados)){
				$Resultado .= "#SAS_PAG_105";
			}else{
				$Resultado .= "#ERR_PAG_105";
			}
		
		break;
		
		
		case 'AplicadoSi':
		
	

			if($InsPago->MtdActualizarUtilizadoPago($POST_seleccionados,1)){
				$Resultado .= "#SAS_PAG_106";
			}else{
				$Resultado .= "#ERR_PAG_106";
			}
		
		break;
		
		case 'AplicadoNo':

			if($InsPago->MtdActualizarUtilizadoPago($POST_seleccionados,2)){
				$Resultado .= "#SAS_PAG_107";
			}else{
				$Resultado .= "#ERR_PAG_107";
			}

		break;
		
		
		case 'PagoActualizarEmitido':

			if($InsPago->MtdActualizarEstadoPago($POST_seleccionados,3)){
				$Resultado .= "#SAS_PAG_108";
			}else{
				$Resultado .= "#ERR_PAG_108";
			}
		
		break;
		
		case 'PagoActualizarAnulado':

			if($InsPago->MtdActualizarEstadoPago($POST_seleccionados,6)){
				$Resultado .= "#SAS_PAG_109";
			}else{
				$Resultado .= "#ERR_PAG_109";
			}
		
		break;
	
	
		
		
	}
?>
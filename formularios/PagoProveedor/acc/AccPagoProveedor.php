<?php
switch($POST_acc){


		
		case 'Eliminar':

			if($InsPagoProveedor->MtdEliminarPagoProveedor($POST_seleccionados)){
				$Resultado .= "#SAS_POV_105";
			}else{
				$Resultado .= "#ERR_POV_105";
			}
		
		break;
		
				
		case 'AnuladoPagoProveedor':
		
			if($InsPagoProveedor->MtdActualizarEstadoPagoProveedor($POST_seleccionados,6)){
				$Resultado .= "#SAS_POV_108";
			}else{
				$Resultado .= "#ERR_POV_108";
			}
		
		break;
		
		
		case 'RealizadoPagoProveedor':
		
			if($InsPagoProveedor->MtdActualizarEstadoPagoProveedor($POST_seleccionados,3)){
				$Resultado .= "#SAS_POV_109";
			}else{
				$Resultado .= "#ERR_POV_109";
			}
		
		break;
		
	

	}
?>
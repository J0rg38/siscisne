<?php
switch($POST_acc){


		
		case 'Eliminar':

			if($InsCotizacionVehiculo->MtdEliminarCotizacionVehiculo($POST_seleccionados)){
				$Resultado .= "#SAS_CVE_105";
			}else{
				$Resultado .= "#ERR_CVE_105";
			}
		
		break;
		
		
		
		case 'CotizacionVehiculoActualizarPendiente':

			if($InsCotizacionVehiculo->MtdActualizarEstadoCotizacionVehiculo($POST_seleccionados,1)){
				$Resultado .= "#SAS_CVE_108";
			}else{
				$Resultado .= "#ERR_CVE_108";
			}
		
		break;
		
		case 'CotizacionVehiculoActualizarEmitido':

			if($InsCotizacionVehiculo->MtdActualizarEstadoCotizacionVehiculo($POST_seleccionados,3)){
				$Resultado .= "#SAS_CVE_108";
			}else{
				$Resultado .= "#ERR_CVE_108";
			}
		
		break;
	
		case 'CotizacionVehiculoActualizarAnulado':

			if($InsCotizacionVehiculo->MtdActualizarEstadoCotizacionVehiculo($POST_seleccionados,6)){
				$Resultado .= "#SAS_CVE_108";
			}else{
				$Resultado .= "#ERR_CVE_108";
			}
		
		break;
		
		
		
		
		case 'ActualizarNivelInteres1':

			if($InsCotizacionVehiculo->MtdActualizarNivelInteresCotizacionVehiculo($POST_seleccionados,1)){
				$Resultado .= "#SAS_CVE_107";
			}else{
				$Resultado .= "#ERR_CVE_107";
			}
		
		break;
		
		case 'ActualizarNivelInteres11':

			if($InsCotizacionVehiculo->MtdActualizarNivelInteresCotizacionVehiculo($POST_seleccionados,11)){
				$Resultado .= "#SAS_CVE_107";
			}else{
				$Resultado .= "#ERR_CVE_107";
			}
		
		break;
		
		case 'ActualizarNivelInteres12':

			if($InsCotizacionVehiculo->MtdActualizarNivelInteresCotizacionVehiculo($POST_seleccionados,12)){
				$Resultado .= "#SAS_CVE_107";
			}else{
				$Resultado .= "#ERR_CVE_107";
			}
		
		break;
		
		case 'ActualizarNivelInteres2':

			if($InsCotizacionVehiculo->MtdActualizarNivelInteresCotizacionVehiculo($POST_seleccionados,2)){
				$Resultado .= "#SAS_CVE_107";
			}else{
				$Resultado .= "#ERR_CVE_107";
			}
		
		break;
		
		case 'ActualizarNivelInteres3':

			if($InsCotizacionVehiculo->MtdActualizarNivelInteresCotizacionVehiculo($POST_seleccionados,3)){
				$Resultado .= "#SAS_CVE_107";
			}else{
				$Resultado .= "#ERR_CVE_107";
			}
		
		break;
		

	}
?>
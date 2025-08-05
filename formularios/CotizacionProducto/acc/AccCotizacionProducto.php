<?php
switch($POST_acc){

		case 'Eliminar':

			if($InsCotizacionProducto->MtdEliminarCotizacionProducto($POST_seleccionados)){
				$Resultado .= "#SAS_CPR_105";
			}else{
				$Resultado .= "#ERR_CPR_105";
			}
		
		break;
		
		case 'EnviarCotizacionProductoAlmacen':
		
			if($InsCotizacionProducto->MtdActualizarEstadoCotizacionProducto($POST_seleccionados,2,true)){
				$Resultado .= "#SAS_CPR_106";
			}else{
				$Resultado .= "#ERR_CPR_106";
			}

		
		break;
		
		case 'EnviarCotizacionProductoVentas':
		
			if($InsCotizacionProducto->MtdActualizarEstadoCotizacionProducto($POST_seleccionados,1,true)){
				$Resultado .= "#SAS_CPR_111";
			}else{
				$Resultado .= "#ERR_CPR_111";
			}
		
		break;
		
		
		case 'AnularCotizacionProducto':

			if($InsCotizacionProducto->MtdActualizarEstadoCotizacionProducto($POST_seleccionados,6,true)){
				$Resultado .= "#SAS_CPR_108";
			}else{
				$Resultado .= "#ERR_CPR_108";
			}

		break;
		
		
		case 'DesanularCotizacionProducto':
		
			if($InsCotizacionProducto->MtdActualizarEstadoCotizacionProducto($POST_seleccionados,1,true)){
				$Resultado .= "#SAS_CPR_109";
			}else{
				$Resultado .= "#ERR_CPR_109";
			}
		
		break;
		
		
		
		
		
			case 'ActualizarObservadoNormal':

			if($InsCotizacionProducto->MtdActualizarVentaPerdidaCotizacionProducto($POST_seleccionados,"2","",true)){
				$Resultado .= "#SAS_CPR_110";
			}else{
				$Resultado .= "#ERR_CPR_110";
			}
		
		break;
		
			case 'ActualizarObservadoPrecio':

			if($InsCotizacionProducto->MtdActualizarVentaPerdidaCotizacionProducto($POST_seleccionados,"1","PEDIDO",true)){
				$Resultado .= "#SAS_CPR_110";
			}else{
				$Resultado .= "#ERR_CPR_110";
			}
		
		break;
		
			case 'ActualizarObservadoDisponibilidad':

			if($InsCotizacionProducto->MtdActualizarVentaPerdidaCotizacionProducto($POST_seleccionados,"1","DISPONIBILIDAD",true)){
				$Resultado .= "#SAS_CPR_110";
			}else{
				$Resultado .= "#ERR_CPR_110";
			}
		
		break;
		case 'ActualizarObservadoImportacion':

			if($InsCotizacionProducto->MtdActualizarVentaPerdidaCotizacionProducto($POST_seleccionados,"1","IMPORTACION",true)){
				$Resultado .= "#SAS_CPR_110";
			}else{
				$Resultado .= "#ERR_CPR_110";
			}
		
		break;
	
	
	
	
	
	
	
	
		
		case 'ActualizarNivelInteres1':

			if($InsCotizacionProducto->MtdActualizarNivelInteresCotizacionProducto($POST_seleccionados,1)){
				$Resultado .= "#SAS_CPR_111";
			}else{
				$Resultado .= "#ERR_CPR_111";
			}
		
		break;
		
		case 'ActualizarNivelInteres2':

			if($InsCotizacionProducto->MtdActualizarNivelInteresCotizacionProducto($POST_seleccionados,2)){
				$Resultado .= "#SAS_CPR_111";
			}else{
				$Resultado .= "#ERR_CPR_111";
			}
		
		break;
		
		case 'ActualizarNivelInteres3':

			if($InsCotizacionProducto->MtdActualizarNivelInteresCotizacionProducto($POST_seleccionados,3)){
				$Resultado .= "#SAS_CPR_111";
			}else{
				$Resultado .= "#ERR_CPR_111";
			}
		
		break;
		
		case 'ActualizarNivelInteres4':

			if($InsCotizacionProducto->MtdActualizarNivelInteresCotizacionProducto($POST_seleccionados,4)){
				$Resultado .= "#SAS_CPR_111";
			}else{
				$Resultado .= "#ERR_CPR_111";
			}
		
		break;
	
	
	
	

	}
?>
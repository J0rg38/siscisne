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
				$Resultado .= "#SAS_CPR_107";
			}else{
				$Resultado .= "#ERR_CPR_107";
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
	

	}
?>
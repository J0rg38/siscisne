<?php
	$InsProducto->UsuId = $_SESSION['SesionId'];
	
switch($POST_acc){
	
		
		case 'Eliminar':

			if($InsProducto->MtdEliminarProducto($POST_seleccionados)){
				$Resultado .= "#SAS_PRO_105";
			}else{
				$Resultado .= "#ERR_PRO_105";
			}
		
		break;
		
		
			
		case 'ActualizarCriticoSi':

			if($InsProducto->MtdActualizarProductoCritico($POST_seleccionados,"1")){
				$Resultado .= "#SAS_PRO_111";
			}else{
				$Resultado .= "#ERR_PRO_111";
			}
		
		break;
		
		
			
		case 'ActualizarCriticoNo':

			if($InsProducto->MtdActualizarProductoCritico($POST_seleccionados,"2")){
				$Resultado .= "#SAS_PRO_112";
			}else{
				$Resultado .= "#ERR_PRO_112";
			}
		
		break;
		
		
			
		case 'ActualizarDescontinuadoSi':

			if($InsProducto->MtdActualizarProductoDescontinuado($POST_seleccionados,"1")){
				$Resultado .= "#SAS_PRO_113";
			}else{
				$Resultado .= "#ERR_PRO_113";
			}
		
		break;
		
			
		case 'ActualizarDescontinuadoNo':

			if($InsProducto->MtdActualizarProductoDescontinuado($POST_seleccionados,"2")){
				$Resultado .= "#SAS_PRO_114";
			}else{
				$Resultado .= "#ERR_PRO_114";
			}
		
		break;
		
		
		
		case 'ActualizarActivo':

			if($InsProducto->MtdActualizarProductoEstado($POST_seleccionados,"1")){
				$Resultado .= "#SAS_PRO_109";
			}else{
				$Resultado .= "#ERR_PRO_109";
			}
		
		break;

		case 'ActualizarInactivo':

			if($InsProducto->MtdActualizarProductoEstado($POST_seleccionados,"2")){
				$Resultado .= "#SAS_PRO_110";
			}else{
				$Resultado .= "#ERR_PRO_110";
			}
		
		break;
		
				
		case 'CalculoPrecioSi':

			if($InsProducto->MtdActualizarProductoCalcularPrecio($POST_seleccionados,"1")){
				$Resultado .= "#SAS_PRO_116";
			}else{
				$Resultado .= "#ERR_PRO_116";
			}
		
		break;

		case 'CalculoPrecioNo':

			if($InsProducto->MtdActualizarProductoCalcularPrecio($POST_seleccionados,"2")){
				$Resultado .= "#SAS_PRO_117";
			}else{
				$Resultado .= "#ERR_PRO_117";
			}
		
		break;
				

	}
?>
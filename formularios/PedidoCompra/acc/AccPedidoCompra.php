<?php
switch($POST_acc){


		
		case 'Eliminar':

			if($InsPedidoCompra->MtdEliminarPedidoCompra($POST_seleccionados)){
				$Resultado .= "#SAS_PCO_105";
			}else{
				$Resultado .= "#ERR_PCO_105";
			}
		
		break;
		
		case 'GenerarOrdenCompra':
		
		break;
		
		case 'ActualizarAprobado':

			if($InsPedidoCompra->MtdActualizarAprobadoPedidoCompra($POST_seleccionados,1)){
				$Resultado .= "#SAS_PCO_112";
			}else{
				$Resultado .= "#ERR_PCO_112";
			}
		
		break;
		
		case 'ActualizarDesaprobado':

			if($InsPedidoCompra->MtdActualizarAprobadoPedidoCompra($POST_seleccionados,2)){
				$Resultado .= "#SAS_PCO_113";
			}else{
				$Resultado .= "#ERR_PCO_113";
			}
		
		break;
		
		
		/*case 'EnviarPedidoCompraContabilidad':

			if($InsPedidoCompra->MtdEnviarContabilidadPedidoCompra($POST_seleccionados)){
				$Resultado .= "#SAS_PCO_106";
			}else{
				$Resultado .= "#ERR_PCO_106";
			}
		
		break;*/
				
		
		
	

	}
?>
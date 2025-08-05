<?php
switch($POST_acc){


		
		case 'Eliminar':

			if($InsTrasladoProducto->MtdEliminarTrasladoProducto($POST_seleccionados)){
				$Resultado .= "#SAS_TPT_105";
			}else{
				$Resultado .= "#ERR_TPT_105";
			}
		
		break;
		
		
				
		case 'ActualizarTrasladoProductoEstadoPendiente':

			if($InsTrasladoProducto->MtdActualizarEstadoTrasladoProducto($POST_seleccionados,1)){
				$Resultado .= "#SAS_TPT_108";
			}else{
				$Resultado .= "#ERR_TPT_108";
			}
		
		break;
		
		
		
				
		case 'ActualizarTrasladoProductoEstadoRealizado':

			if($InsTrasladoProducto->MtdActualizarEstadoTrasladoProducto($POST_seleccionados,3)){
				$Resultado .= "#SAS_TPT_109";
			}else{
				$Resultado .= "#ERR_TPT_109";
			}
		
		break;
		
		
		
		
		
	

	}
?>
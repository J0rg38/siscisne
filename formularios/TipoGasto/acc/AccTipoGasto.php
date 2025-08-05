<?php
switch($POST_acc){

		case 'Eliminar':

			if($InsTipoGasto->MtdEliminarTipoGasto($POST_seleccionados)){
				$Resultado .= "#SAS_TGA_105";
			}else{
				$Resultado .= "#ERR_TGA_105";
			}
		
		break;
		
			case 'ActualizarEstadoPendiente':

			if($InsTipoGasto->MtdActualizarEstadoTipoGasto($POST_seleccionados,1)){
				$Resultado .= "#SAS_TGA_107";
			}else{
				$Resultado .= "#ERR_TGA_107";
			}
		
		break;
		
		
		case 'ActualizarEstadoRealizado':

			if($InsTipoGasto->MtdActualizarEstadoTipoGasto($POST_seleccionados,3)){
				$Resultado .= "#SAS_TGA_108";
			}else{
				$Resultado .= "#ERR_TGA_108";
			}
		
		break;
		
		case 'ActualizarEstadoAnulado':

			if($InsTipoGasto->MtdActualizarEstadoTipoGasto($POST_seleccionados,6)){
				$Resultado .= "#SAS_TGA_109";
			}else{
				$Resultado .= "#ERR_TGA_109";
			}
		
		break;
		
	}
?>
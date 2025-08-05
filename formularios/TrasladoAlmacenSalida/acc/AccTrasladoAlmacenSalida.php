<?php
switch($POST_acc){


		
		case 'Eliminar':

			if($InsTrasladoAlmacenSalida->MtdEliminarTrasladoAlmacenSalida($POST_seleccionados)){
				$Resultado .= "#SAS_TAS_105";
			}else{
				$Resultado .= "#ERR_TAS_105";
			}
		
		break;
		
		
				
		case 'ActualizarTrasladoAlmacenSalidaEstadoPendiente':

			if($InsTrasladoAlmacenSalida->MtdActualizarEstadoTrasladoAlmacenSalida($POST_seleccionados,1)){
				$Resultado .= "#SAS_TAS_108";
			}else{
				$Resultado .= "#ERR_TAS_108";
			}
		
		break;
		
		
		
				
		case 'ActualizarTrasladoAlmacenSalidaEstadoRealizado':

			if($InsTrasladoAlmacenSalida->MtdActualizarEstadoTrasladoAlmacenSalida($POST_seleccionados,3)){
				$Resultado .= "#SAS_TAS_109";
			}else{
				$Resultado .= "#ERR_TAS_109";
			}
		
		break;
		
		
		
		
		
	

	}
?>
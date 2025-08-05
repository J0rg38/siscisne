<?php
switch($POST_acc){
		
		case 'Eliminar':

			if($InsFacturaExportacion->MtdEliminarFacturaExportacion($POST_seleccionados)){
				$Resultado .= "#SAS_FEX_105";
			}else{
				$Resultado .= "#ERR_FEX_105";
			}
		
		break;
		
		
		case 'ActualizarEstadoPendiente':

			if($InsFacturaExportacion->MtdActualizarEstadoFacturaExportacion($POST_seleccionados,1)){
				$Resultado .= "#SAS_FEX_107";
			}else{
				$Resultado .= "#ERR_FEX_107";
			}
		
		break;
		
		
		case 'ActualizarEstadoEntregado':

			if($InsFacturaExportacion->MtdActualizarEstadoFacturaExportacion($POST_seleccionados,5)){
				$Resultado .= "#SAS_FEX_108";
			}else{
				$Resultado .= "#ERR_FEX_108";
			}
		
		break;
		
		case 'ActualizarEstadoAnulado':

			if($InsFacturaExportacion->MtdActualizarEstadoFacturaExportacion($POST_seleccionados,6)){
				$Resultado .= "#SAS_FEX_109";
			}else{
				$Resultado .= "#ERR_FEX_109";
			}
		
		break;
		
		case 'ActualizarEstadoReservado':

			if($InsFacturaExportacion->MtdActualizarEstadoFacturaExportacion($POST_seleccionados,7)){
				$Resultado .= "#SAS_FEX_110";
			}else{
				$Resultado .= "#ERR_FEX_110";
			}
		
		break;
			

	}
?>
<?php
switch($POST_acc){


		
		case 'Eliminar':

			if($InsVentaDirecta->MtdEliminarVentaDirecta($POST_seleccionados)){
				$Resultado .= "#SAS_VDI_105";
			}else{
				$Resultado .= "#ERR_VDI_105";
			}
		
		break;
		
		/*case 'EnviarVentaDirectaContabilidad':

			if($InsVentaDirecta->MtdEnviarContabilidadVentaDirecta($POST_seleccionados)){
				$Resultado .= "#SAS_VDI_106";
			}else{
				$Resultado .= "#ERR_VDI_106";
			}
		
		break;*/
				
		case 'VentaDirectaPendiente':
		
			if($InsVentaDirecta->MtdActualizarEstadoVentaDirecta($POST_seleccionados,1)){
				$Resultado .= "#SAS_VDI_108";
			}else{
				$Resultado .= "#ERR_VDI_108";
			}
		
		break;
		
		
		case 'VentaDirectaRealizado':
		
			if($InsVentaDirecta->MtdActualizarEstadoVentaDirecta($POST_seleccionados,3)){
				$Resultado .= "#SAS_VDI_109";
			}else{
				$Resultado .= "#ERR_VDI_109";
			}
		
		break;
		
		
		case 'VentaDirectaAnulado':
		
			if($InsVentaDirecta->MtdActualizarEstadoVentaDirecta($POST_seleccionados,6)){
				$Resultado .= "#SAS_VDI_110";
			}else{
				$Resultado .= "#ERR_VDI_110";
			}
		
		break;	
	

	}
?>
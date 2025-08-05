<?php
switch($POST_acc){
		
		case 'Eliminar':

			if($InsGuiaRemision->MtdEliminarGuiaRemision($POST_seleccionados)){
				$Resultado .= "#SAS_GRE_105";
			}else{
				$Resultado .= "#ERR_GRE_105";
			}
		
		break;
		
		
		case 'ActualizarEstadoPendiente':

			if($InsGuiaRemision->MtdActualizarEstadoGuiaRemision($POST_seleccionados,1)){
				$Resultado .= "#SAS_GRE_107";
			}else{
				$Resultado .= "#ERR_GRE_107";
			}
		
		break;
		
		
		case 'ActualizarEstadoEntregado':

			if($InsGuiaRemision->MtdActualizarEstadoGuiaRemision($POST_seleccionados,5)){
				$Resultado .= "#SAS_GRE_108";
			}else{
				$Resultado .= "#ERR_GRE_108";
			}
		
		break;
		
		case 'ActualizarEstadoAnulado':

			if($InsGuiaRemision->MtdActualizarEstadoGuiaRemision($POST_seleccionados,6)){
				$Resultado .= "#SAS_GRE_109";
			}else{
				$Resultado .= "#ERR_GRE_109";
			}
		
		break;

		case 'Cortar':
			
			$Guias = explode("#",$POST_seleccionados);
			list($Id,$Talonario) = explode("%",$Guias[1]);;
			
			if($InsGuiaRemision->FncCortarGuiaRemision($Id,$Talonario,$POST_can,$_SESSION['SesionId'])){
				$Resultado .= "#SAS_GRE_111";
			}else{
				$Resultado .= "#ERR_GRE_111";
			}
		
		break;
			

	}
?>
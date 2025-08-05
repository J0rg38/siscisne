<?php
switch($POST_acc){


		
		case 'Eliminar':

			if($InsSolicitudDesembolso->MtdEliminarSolicitudDesembolso($POST_seleccionados)){
				$Resultado .= "#SAS_SDS_105";
			}else{
				$Resultado .= "#ERR_SDS_105";
			}
		
		break;
		
		case 'GenerarOrdenCompra':
		
		break;
		
		/*case 'EnviarSolicitudDesembolsoContabilidad':

			if($InsSolicitudDesembolso->MtdEnviarContabilidadSolicitudDesembolso($POST_seleccionados)){
				$Resultado .= "#SAS_SDS_106";
			}else{
				$Resultado .= "#ERR_SDS_106";
			}
		
		break;*/
				
		
			case 'ActualizarAprobado':

			if($InsSolicitudDesembolso->MtdActualizarAprobadoSolicitudDesembolso($POST_seleccionados,1)){
				$Resultado .= "#SAS_SDS_112";
			}else{
				$Resultado .= "#ERR_SDS_112";
			}
		
		break;
		
		case 'ActualizarDesaprobado':

			if($InsSolicitudDesembolso->MtdActualizarAprobadoSolicitudDesembolso($POST_seleccionados,2)){
				$Resultado .= "#SAS_SDS_113";
			}else{
				$Resultado .= "#ERR_SDS_113";
			}
		
		break;
			
	

	}
?>
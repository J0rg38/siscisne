<?php
switch($POST_acc){

		case 'Habilitar':

			//MtdEditarConductorEstados($oElementos,$oEstado)
			if($InsConductor->MtdEditarConductorEstados($POST_seleccionados,1)){
				$Resultado .= "#SAS_CON_106";
			}else{
				$Resultado .= "#ERR_CON_106";
			}
		
		break;
		
		
		case 'Deshabilitar':

			if($InsConductor->MtdEditarConductorEstados($POST_seleccionados,2)){
				$Resultado .= "#SAS_CON_107";
			}else{
				$Resultado .= "#ERR_CON_107";
			}
		
		break;
		
		case 'Eliminar':

			if($InsConductor->MtdEliminarConductor($POST_seleccionados)){
				$Resultado .= "#SAS_CON_105";
			}else{
				$Resultado .= "#ERR_CON_105";
			}
		
		break;

		

	}
?>
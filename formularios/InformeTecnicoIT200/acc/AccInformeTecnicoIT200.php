<?php
switch($POST_acc){


		
		case 'Eliminar':

			if($InsInformeTecnico->MtdActualizarEstadoInformeTecnico($POST_seleccionados)){
				$Resultado .= "#SAS_FIN_105";
			}else{
				$Resultado .= "#ERR_FIN_105";
			}
		
		break;
	

	}
?>
<?php
switch($POST_acc){

		case 'Eliminar':

			if($InsMensajeTexto->MtdEliminarMensajeTexto($POST_seleccionados)){
				$Resultado .= "#SAS_CMT_105";
			}else{
				$Resultado .= "#ERR_CMT_105";
			}
		
		break;
		
	}
?>
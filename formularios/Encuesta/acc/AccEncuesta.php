<?php
switch($POST_acc){

		case 'Eliminar':

			if($InsEncuesta->MtdEliminarEncuesta($POST_seleccionados)){
				$Resultado .= "#SAS_ENC_105";
			}else{
				$Resultado .= "#ERR_ENC_105";
			}
		
		break;
		
	}
?>
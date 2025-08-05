<?php
switch($POST_acc){

		case 'Eliminar':

			if($InsConcesionario->MtdEliminarConcesionario($POST_seleccionados)){
				$Resultado .= "#SAS_ONC_105";
			}else{
				$Resultado .= "#ERR_ONC_105";
			}
		
		break;
		
	}
?>
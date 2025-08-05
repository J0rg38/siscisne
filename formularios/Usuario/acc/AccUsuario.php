<?php
switch($POST_acc){

	
		
		case 'Eliminar':

			if($InsUsuario->MtdEliminarUsuario($POST_seleccionados)){
				$Resultado .= "#SAS_USU_105";
			}else{
				$Resultado .= "#ERR_USU_105";
			}
		
		break;
		
		

	}
?>
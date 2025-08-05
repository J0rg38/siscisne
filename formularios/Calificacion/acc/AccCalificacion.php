<?php
switch($POST_acc){

		case 'Eliminar':

			if($InsCalificacion->MtdEliminarCalificacion($POST_seleccionados)){
				$Resultado .= "#SAS_CAL_105";
			}else{
				$Resultado .= "#ERR_CAL_105";
			}
		
		break;
		
	}
?>
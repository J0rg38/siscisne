<?php
switch($POST_acc){

		case 'Eliminar':

			if($InsNotaDebitoTalonario->MtdEliminarNotaDebitoTalonario($POST_seleccionados)){
				$Resultado .= "#SAS_NDT_105";
			}else{
				$Resultado .= "#ERR_NDT_105";
			}
		
		break;
		

	}
?>
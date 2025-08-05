<?php
switch($POST_acc){

		case 'Eliminar':

			if($InsNotaCreditoTalonario->MtdEliminarNotaCreditoTalonario($POST_seleccionados)){
				$Resultado .= "#SAS_NCT_105";
			}else{
				$Resultado .= "#ERR_NCT_105";
			}
		
		break;
		

	}
?>
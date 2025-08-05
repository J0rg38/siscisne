<?php
switch($POST_acc){

		case 'Eliminar':

			if($InsFacturaTalonario->MtdEliminarFacturaTalonario($POST_seleccionados)){
				$Resultado .= "#SAS_FTA_105";
			}else{
				$Resultado .= "#ERR_FTA_105";
			}
		
		break;
		

	}
?>
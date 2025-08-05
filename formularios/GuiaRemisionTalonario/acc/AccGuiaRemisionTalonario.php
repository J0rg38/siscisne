<?php
switch($POST_acc){

		case 'Eliminar':

			if($InsGuiaRemisionTalonario->MtdEliminarGuiaRemisionTalonario($POST_seleccionados)){
				$Resultado .= "#SAS_GRT_105";
			}else{
				$Resultado .= "#ERR_GRT_105";
			}
		
		break;
		

	}
?>
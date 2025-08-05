<?php
switch($POST_acc){

		case 'Eliminar':

			if($InsZona->MtdEliminarZona($POST_seleccionados)){
				$Resultado .= "#SAS_ZON_105";
			}else{
				$Resultado .= "#ERR_ZON_105";
			}
		
		break;
		
		
	}
?>
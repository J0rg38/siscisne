<?php
switch($POST_acc){

		case 'Eliminar':

			if($InsBoletaTalonario->MtdEliminarBoletaTalonario($POST_seleccionados)){
				$Resultado .= "#SAS_BTA_105";
			}else{
				$Resultado .= "#ERR_BTA_105";
			}
		
		break;
		

	}
?>
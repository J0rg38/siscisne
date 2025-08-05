<?php
switch($POST_acc){

		
		case 'Eliminar':

			if($InsProducto->MtdEliminarProducto($POST_seleccionados)){
				$Resultado .= "#SAS_PRO_105";
			}else{
				$Resultado .= "#ERR_PRO_105";
			}
		
		break;
		
		

	}
?>
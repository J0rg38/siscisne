<?php
switch($POST_acc){


		
		case 'Eliminar':

			if($InsProveedor->MtdEliminarProveedor($POST_seleccionados)){
				$Resultado .= "#SAS_PRV_105";
			}else{
				$Resultado .= "#ERR_PRV_105";
			}
		
		break;
	

	}
?>
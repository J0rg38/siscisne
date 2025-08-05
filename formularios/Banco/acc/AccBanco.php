<?php
switch($POST_acc){

		case 'Eliminar':

			if($InsBanco->MtdEliminarBanco($POST_seleccionados)){
				$Resultado .= "#SAS_BAN_105";
			}else{
				$Resultado .= "#ERR_BAN_105";
			}
		
		break;
		
	}
?>
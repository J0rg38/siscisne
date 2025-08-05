<?php
switch($POST_acc){

		case 'Eliminar':

			if($InsCampana->MtdEliminarCampana($POST_seleccionados)){
				$Resultado .= "#SAS_CAM_105";
			}else{
				$Resultado .= "#ERR_CAM_105";
			}
		
		break;
		
	}
?>
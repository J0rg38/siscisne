<?php
switch($POST_acc){


		
		case 'Eliminar':

			if($InsAviso->MtdEliminarAviso($POST_seleccionados)){
				$Resultado .= "#SAS_AVI_105";
			}else{
				$Resultado .= "#ERR_AVI_105";
			}
		
		break;
	

	}
?>
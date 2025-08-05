<?php
switch($POST_acc){


		
		case 'Eliminar':

			if($InsClienteTipo->MtdEliminarClienteTipo($POST_seleccionados)){
				$Resultado .= "#SAS_LTI_105";
			}else{
				$Resultado .= "#ERR_LTI_105";
			}
		
		break;
		
	

	}
?>
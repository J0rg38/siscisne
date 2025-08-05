<?php
switch($POST_acc){


		
		case 'Eliminar':

			if($InsPersonal->MtdEliminarPersonal($POST_seleccionados)){
				$Resultado .= "#SAS_PER_105";
			}else{
				$Resultado .= "#ERR_PER_105";
			}
		
		break;
		
		

	}
?>
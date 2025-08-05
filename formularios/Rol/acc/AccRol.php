<?php
switch($POST_acc){
	
		case 'Eliminar':

			if($InsRol->MtdEliminarRol($POST_seleccionados)){
				$Resultado .= "#SAS_ROL_105";
			}else{
				$Resultado .= "#ERR_ROL_105";
			}
		
		break;	

	}
?>
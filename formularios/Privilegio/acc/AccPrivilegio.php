<?php
switch($POST_acc){

		case 'Eliminar':

			if($InsPrivilegio->MtdEliminarPrivilegio($POST_seleccionados)){
				$Resultado .= "#SAS_PRI_105";
			}else{
				$Resultado .= "#ERR_PRI_105";
			}
		
		break;
		
		

	}
?>
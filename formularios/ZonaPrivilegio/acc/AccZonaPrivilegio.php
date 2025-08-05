<?php
switch($POST_acc){

		case 'Eliminar':

			if($InsZonaPrivilegio->MtdEliminarZonaPrivilegio($POST_seleccionados)){
				$Resultado .= "#SAS_ZPR_105";
			}else{
				$Resultado .= "#ERR_ZPR_105";
			}
		
		break;
		
		
	}
?>
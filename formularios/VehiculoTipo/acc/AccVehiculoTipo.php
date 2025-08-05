<?php
switch($POST_acc){

	
		
		case 'Eliminar':

			if($InsVehiculoTipo->MtdEliminarVehiculoTipo($POST_seleccionados)){
				$Resultado .= "#SAS_VTI_105";
			}else{
				$Resultado .= "#ERR_VTI_105";
			}
		
		break;
		
	

	}
?>
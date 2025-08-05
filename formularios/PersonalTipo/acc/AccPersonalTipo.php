<?php
switch($POST_acc){


		
		case 'Eliminar':

			if($InsPersonalTipo->MtdEliminarPersonalTipo($POST_seleccionados)){
				$Resultado .= "#SAS_PTI_105";
			}else{
				$Resultado .= "#ERR_PTI_105";
			}
		
		break;
	

	}
?>
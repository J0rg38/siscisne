<?php
switch($POST_acc){

		case 'Eliminar':

			if($InsFacturaExportacionTalonario->MtdEliminarFacturaExportacionTalonario($POST_seleccionados)){
				$Resultado .= "#SAS_FET_105";
			}else{
				$Resultado .= "#ERR_FET_105";
			}
		
		break;
		

	}
?>
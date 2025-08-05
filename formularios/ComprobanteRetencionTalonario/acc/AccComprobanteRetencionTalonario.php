<?php
switch($POST_acc){

		case 'Eliminar':

			if($InsComprobanteRetencionTalonario->MtdEliminarComprobanteRetencionTalonario($POST_seleccionados)){
				$Resultado .= "#SAS_FTA_105";
			}else{
				$Resultado .= "#ERR_FTA_105";
			}
		
		break;
		

	}
?>
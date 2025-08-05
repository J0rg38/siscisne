<?php
switch($POST_acc){

		case 'Eliminar':

			if($InsOrdenCobro->MtdEliminarOrdenCobro($POST_seleccionados)){
				$Resultado .= "#SAS_OCB_105";
			}else{
				$Resultado .= "#ERR_OCB_105";
			}
		
		break;
		
	}
?>
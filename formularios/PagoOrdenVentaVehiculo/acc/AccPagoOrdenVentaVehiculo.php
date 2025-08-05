<?php
switch($POST_acc){

		case 'Eliminar':

			if($InsPago->MtdEliminarPago($POST_seleccionados)){
				$Resultado .= "#SAS_PAG_105";
			}else{
				$Resultado .= "#ERR_PAG_105";
			}
		
		break;
		
	}
?>
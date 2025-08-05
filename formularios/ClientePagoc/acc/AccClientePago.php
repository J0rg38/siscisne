<?php
switch($POST_acc){


		case 'Eliminar':

			if($InsClientePago->MtdEliminarClientePago($POST_seleccionados)){
				$Resultado .= "#SAS_CPA_105";
			}else{
				$Resultado .= "#ERR_CPA_105";
			}
		
		break;
	

	}
?>
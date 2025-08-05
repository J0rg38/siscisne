<?php
switch($POST_acc){

		case 'Eliminar':

			if($InsClienteNota->MtdEliminarClienteNota($POST_seleccionados)){
				$Resultado .= "#SAS_CNO_105";
			}else{
				$Resultado .= "#ERR_CNO_105";
			}
		
		break;
		
	}
?>
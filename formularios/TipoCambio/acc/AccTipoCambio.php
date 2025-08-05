<?php
switch($POST_acc){

		case 'Eliminar':

			if($InsTipoCambio->MtdEliminarTipoCambio($POST_seleccionados)){
				$Resultado .= "#SAS_TCA_105";
			}else{
				$Resultado .= "#ERR_TCA_105";
			}
		
		break;
		
		

	}
?>
<?php
switch($POST_acc){


		
		case 'Eliminar':

			if($InsOrdenCompraEntrada->MtdEliminarOrdenCompraEntrada($POST_seleccionados)){
				$Resultado .= "#SAS_OCE_105";
			}else{
				$Resultado .= "#ERR_OCE_105";
			}
		
		break;
	

	}
?>
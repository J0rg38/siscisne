<?php
switch($POST_acc){


		case 'Eliminar':

			if($InsVehiculoListaPrecio->MtdEliminarVehiculoListaPrecio($POST_seleccionados)){
				$Resultado .= "#SAS_VLP_105";
			}else{
				$Resultado .= "#ERR_VLP_105";
			}
		
		break;
		
		

	}
?>
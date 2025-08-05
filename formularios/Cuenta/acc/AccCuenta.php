<?php
switch($POST_acc){


		
		case 'Eliminar':

			if($InsCuenta->MtdEliminarCuenta($POST_seleccionados)){
				$Resultado .= "#SAS_CUE_105";
			}else{
				$Resultado .= "#ERR_CUE_105";
			}
		
		break;
	

	}
?>
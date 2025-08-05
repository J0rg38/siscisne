<?php
switch($POST_acc){

	
		
		case 'Eliminar':

			if($InsAlmacen->MtdEliminarAlmacen($POST_seleccionados)){
				$Resultado .= "#SAS_ALM_105";
			}else{
				$Resultado .= "#ERR_ALM_105";
			}
		
		break;
		
	

	}
?>
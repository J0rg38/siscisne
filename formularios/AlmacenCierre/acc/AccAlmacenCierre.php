<?php
switch($POST_acc){


		
		case 'Eliminar':

			if($InsAlmacenCierre->MtdEliminarAlmacenCierre($POST_seleccionados)){
				$Resultado .= "#SAS_ACI_105";
			}else{
				$Resultado .= "#ERR_ACI_105";
			}
		
		break;
	

	}
?>
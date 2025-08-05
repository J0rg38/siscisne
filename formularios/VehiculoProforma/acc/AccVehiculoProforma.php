<?php
switch($POST_acc){


		case 'Eliminar':

			if($InsVehiculoProforma->MtdEliminarVehiculoProforma($POST_seleccionados)){
				$Resultado .= "#SAS_VPR_105";
			}else{
				$Resultado .= "#ERR_VPR_105";
			}
		
		break;
		
		

	}
?>
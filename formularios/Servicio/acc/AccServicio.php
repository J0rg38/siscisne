<?php

$InsServicio->UsuId = $_SESSION['SesionId'];	

switch($POST_acc){

		case 'Duplicar':

			if($InsServicio->MtdDuplicarServicio($POST_seleccionados)){
				$Resultado .= "#SAS_SER_110";
			}else{
				$Resultado .= "#ERR_SER_110";
			}

		break;

		case 'Eliminar':

			if($InsServicio->MtdEliminarServicio($POST_seleccionados)){
				$Resultado .= "#SAS_SER_105";
			}else{
				$Resultado .= "#ERR_SER_105";
			}
		
		break;
		
		

	}
?>
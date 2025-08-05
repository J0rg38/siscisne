<?php

$InsVehiculoIngreso->UsuId = $_SESSION['SesionId'];	

switch($POST_acc){

		case 'Duplicar':

			if($InsVehiculoIngreso->MtdDuplicarVehiculoIngreso($POST_seleccionados)){
				$Resultado .= "#SAS_EIN_110";
			}else{
				$Resultado .= "#ERR_EIN_110";
			}

		break;

		case 'Eliminar':

			if($InsVehiculoIngreso->MtdEliminarVehiculoIngreso($POST_seleccionados)){
				$Resultado .= "#SAS_EIN_105";
			}else{
				$Resultado .= "#ERR_EIN_105";
			}
		
		break;
		
		

	}
?>
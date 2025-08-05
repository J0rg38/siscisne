<?php
$InsCliente->UsuId = $_SESSION['SesionId'];	


switch($POST_acc){

		
		
		case 'Eliminar':

			if($InsCliente->MtdEliminarCliente($POST_seleccionados)){
				$Resultado .= "#SAS_CLI_105";
			}else{
				$Resultado .= "#ERR_CLI_105";
			}
		
		break;
		
		case 'ActualizarBloquearSi':

			if($InsCliente->MtdActualizarBloquearCliente($POST_seleccionados,"1")){
				$Resultado .= "#SAS_CLI_106";
			}else{
				$Resultado .= "#ERR_CLI_106";
			}
		
		break;
		
		case 'ActualizarBloquearNo':

			if($InsCliente->MtdActualizarBloquearCliente($POST_seleccionados,"2")){
				$Resultado .= "#SAS_CLI_107";
			}else{
				$Resultado .= "#ERR_CLI_107";
			}
		
		break;
	

	}
?>
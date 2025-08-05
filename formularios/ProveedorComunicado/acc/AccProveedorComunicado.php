<?php
	$InsProveedorComunicado->UsuId = $_SESSION['SesionId'];
	
switch($POST_acc){
	
		
		case 'Eliminar':

			if($InsProveedorComunicado->MtdEliminarProveedorComunicado($POST_seleccionados)){
				$Resultado .= "#SAS_POM_105";
			}else{
				$Resultado .= "#ERR_POM_105";
			}
		
		break;
		
		

	}
?>
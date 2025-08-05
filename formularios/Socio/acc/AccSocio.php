<?php
switch($POST_acc){


		
		case 'Eliminar':

			if($InsSocio->MtdEliminarSocio($POST_seleccionados)){
				$Resultado .= "#SAS_SOC_105";
			}else{
				$Resultado .= "#ERR_SOC_105";
			}
		
		break;
		
		

	}
?>
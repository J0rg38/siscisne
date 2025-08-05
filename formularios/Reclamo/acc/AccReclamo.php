<?php
switch($POST_acc){

	case 'Eliminar':
	
		if($InsReclamo->MtdEliminarReclamo($POST_seleccionados)){
		  $Resultado .= "#SAS_REC_105";
		}else{
		  $Resultado .= "#ERR_REC_105";
		}
	
	break;
}
?>
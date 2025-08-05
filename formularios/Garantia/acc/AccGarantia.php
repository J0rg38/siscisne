<?php
switch($POST_acc){

	case 'Eliminar':
	
		if($InsGarantia->MtdEliminarGarantia($POST_seleccionados)){
		  $Resultado .= "#SAS_GAR_105";
		}else{
		  $Resultado .= "#ERR_GAR_105";
		}
	
	break;
}
?>
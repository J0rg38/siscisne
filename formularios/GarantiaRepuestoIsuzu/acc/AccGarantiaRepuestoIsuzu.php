<?php
switch($POST_acc){

	case 'Eliminar':
	
		if($InsGarantiaRepuestoIsuzu->MtdEliminarGarantiaRepuestoIsuzu($POST_seleccionados)){
		  $Resultado .= "#SAS_GRI_105";
		}else{
		  $Resultado .= "#ERR_GRI_105";
		}
	
	break;
}
?>
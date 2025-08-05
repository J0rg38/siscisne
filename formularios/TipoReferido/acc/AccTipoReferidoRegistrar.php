<?php
//Si se hizo click en guardar	

if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	
	$InsTipoReferido->TrfId = $_POST['CmpId'];
	$InsTipoReferido->TrfNombre = $_POST['CmpNombre'];
	$InsTipoReferido->TrfDescripcion = addslashes($_POST['CmpDescripcion']);
	$InsTipoReferido->TrfUso = $_POST['CmpUso'];	

	$InsTipoReferido->TrfEstado = $_POST['CmpEstado'];	
	$InsTipoReferido->TrfTiempoCreacion = date("Y-m-d H:i:s");
	$InsTipoReferido->TrfTiempoModificacion = date("Y-m-d H:i:s");
	$InsTipoReferido->TrfEliminado = 1;

	if($InsTipoReferido->MtdRegistrarTipoReferido()){
		unset($InsTipoReferido);
		$Resultado.='#SAS_TRF_101';
		$Registro = true;
	} else{
		$Resultado.='#ERR_TRF_101';
	}

}else{
	FncNuevo();
}

function FncNuevo(){
	
	global $InsTipoReferido;
	
	$InsTipoReferido = new ClsTipoReferido();

}
?>
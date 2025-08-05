<?php
//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	
	$InsPersonalTipo->PtiId = $_POST['CmpId'];
	$InsPersonalTipo->PtiNombre = $_POST['CmpNombre'];
	$InsPersonalTipo->PtiDescripcion = $_POST['CmpDescripcion'];
	$InsPersonalTipo->PtiEstado = $_POST['CmpEstado'];
	$InsPersonalTipo->PtiTiempoCreacion = date("Y-m-d H:i:s");
	$InsPersonalTipo->PtiTiempoModificacion = date("Y-m-d H:i:s");
	$InsPersonalTipo->PtiEliminado = 1;
	
	if($InsPersonalTipo->MtdRegistrarPersonalTipo()){
		$Resultado.='#SAS_PTI_101';
		unset($InsPersonalTipo);
	} else{
		$Resultado.='#ERR_PTI_101';
	}

}else{
	
}
?>
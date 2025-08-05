<?php
//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	$InsVehiculoTipo->VtiId = $_POST['CmpId'];
	$InsVehiculoTipo->VtiNombre = $_POST['CmpNombre'];
	$InsVehiculoTipo->VtiEstado = 1;
	$InsVehiculoTipo->VtiTiempoCreacion = date("Y-m-d H:i:s");
	$InsVehiculoTipo->VtiTiempoModificacion = date("Y-m-d H:i:s");

	
	$InsVehiculoTipo->VtiSubNombre = $_POST['CmpCategoriaNombre'];	
		
	if($InsVehiculoTipo->MtdRegistrarVehiculoTipo()){	
		$Resultado.='#SAS_VTI_101';
		unset($InsVehiculoTipo);
		//$InsVehiculoTipo = new ClsVehiculoTipo();
		//$InsVehiculoTipo->MtdGenerarVehiculoTipoId();
		
	} else{
		$Resultado.='#ERR_VTI_101';
	}

}else{
	//$InsVehiculoTipo->MtdGenerarVehiculoTipoId();
}


?>
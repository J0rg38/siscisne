<?php
//Si se hizo click en guardar	

if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	
	$InsObsequio->ObsId = $_POST['CmpId'];
	$InsObsequio->ObsNombre = $_POST['CmpNombre'];
	$InsObsequio->ObsDescripcion = addslashes($_POST['CmpDescripcion']);
	$InsObsequio->ObsUso = $_POST['CmpTipo'];
	$InsObsequio->ObsEstado = $_POST['CmpEstado'];	
	$InsObsequio->ObsTiempoCreacion = date("Y-m-d H:i:s");
	$InsObsequio->ObsTiempoModificacion = date("Y-m-d H:i:s");
	$InsObsequio->ObsEliminado = 1;

	if($InsObsequio->MtdRegistrarObsequio()){
		unset($InsObsequio);
		$Resultado.='#SAS_OBS_101';
		$Registro = true;
	} else{
		$Resultado.='#ERR_OBS_101';
	}

}else{
	FncNuevo();
}

function FncNuevo(){
	
	global $InsObsequio;
	
	$InsObsequio = new ClsObsequio();
	$InsObsequio->ObsTipo = 2;
	
}
?>
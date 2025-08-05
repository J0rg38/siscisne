<?php
//Si se hizo click en guardar	

if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	
	$InsTipoGasto->TgaId = $_POST['CmpId'];
	$InsTipoGasto->TgaNombre = $_POST['CmpNombre'];
	$InsTipoGasto->TgaDescripcion = addslashes($_POST['CmpDescripcion']);
	$InsTipoGasto->TgaUso = $_POST['CmpUso'];	

	$InsTipoGasto->TgaEstado = $_POST['CmpEstado'];	
	$InsTipoGasto->TgaTiempoCreacion = date("Y-m-d H:i:s");
	$InsTipoGasto->TgaTiempoModificacion = date("Y-m-d H:i:s");
	$InsTipoGasto->TgaEliminado = 1;

	if($InsTipoGasto->MtdRegistrarTipoGasto()){
		unset($InsTipoGasto);
		$Resultado.='#SAS_TGA_101';
		$Registro = true;
	} else{
		$Resultado.='#ERR_TGA_101';
	}

}else{
	FncNuevo();
}

function FncNuevo(){
	
	global $InsTipoGasto;
	
	$InsTipoGasto = new ClsTipoGasto();

}
?>
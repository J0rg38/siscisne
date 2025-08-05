<?php
//Si se hizo click en guardar	

if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	$InsConcesionario->OncId = $_POST['CmpId'];
	$InsConcesionario->OncCodigoDealer = $_POST['CmpCodigoDealer'];
	$InsConcesionario->OncNumeroDocumento = $_POST['CmpNumeroDocumento'];
	$InsConcesionario->OncNombre = $_POST['CmpNombre'];
	$InsConcesionario->OncDescripcion = $_POST['CmpDescripcion'];
	$InsConcesionario->OncEstado = $_POST['CmpEstado'];
	$InsConcesionario->OncTiempoCreacion = date("Y-m-d H:i:s");
	$InsConcesionario->OncTiempoModificacion = date("Y-m-d H:i:s");
	$InsConcesionario->OncEliminado = 1;

	if($InsConcesionario->MtdRegistrarConcesionario()){
		$Registro = true;
		unset($InsConcesionario);
		$Resultado.='#SAS_ONC_101';
	} else{
		$Resultado.='#ERR_ONC_101';
	}

}else{

}
?>
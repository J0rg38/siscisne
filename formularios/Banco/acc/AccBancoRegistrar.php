<?php
//Si se hizo click en guardar	

if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	
	$InsBanco->BanId = $_POST['CmpId'];
	$InsBanco->BanNombre = $_POST['CmpNombre'];
	$InsBanco->BanDescripcion = addslashes($_POST['CmpDescripcion']);
	$InsBanco->BanTiempoCreacion = date("Y-m-d H:i:s");
	$InsBanco->BanTiempoModificacion = date("Y-m-d H:i:s");
	$InsBanco->BanEliminado = 1;
		
	if($InsBanco->MtdRegistrarBanco()){
		$Registro = true;
		unset($InsBanco);
		$Resultado.='#SAS_BAN_101';
		
	} else{
		$Resultado.='#ERR_BAN_101';
	}

}else{

}
?>
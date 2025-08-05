<?php
//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	
	$InsMiembroDirectorio->MdiId = $_POST['CmpId'];
	$InsMiembroDirectorio->UsuId = $_POST['CmpUsuario'];
	$InsMiembroDirectorio->TdoId = $_POST['CmpTipoDocumento'];
	$InsMiembroDirectorio->MdiNombre = $_POST['CmpNombre'];
	$InsMiembroDirectorio->MdiApellidoPaterno = $_POST['CmpApellidoPaterno'];
	$InsMiembroDirectorio->MdiApellidoMaterno = $_POST['CmpApellidoMaterno'];
	$InsMiembroDirectorio->MdiNumeroDocumento = $_POST['CmpNumeroDocumento'];
	$InsMiembroDirectorio->MdiEmail = $_POST['CmpEmail'];
	$InsMiembroDirectorio->MdiTelefono = $_POST['CmpTelefono'];
	$InsMiembroDirectorio->MdiCelular = $_POST['CmpCelular'];
	$InsMiembroDirectorio->MdiDireccion = $_POST['CmpDireccion'];	
	$InsMiembroDirectorio->MdiFoto = $_SESSION['SesMdiFoto'];
	$InsMiembroDirectorio->MdiCargo = $_POST['CmpCargo'];
	$InsMiembroDirectorio->MdiEstado = $_POST['CmpEstado'];
	$InsMiembroDirectorio->MdiTiempoCreacion = date("Y-m-d H:i:s");
	$InsMiembroDirectorio->MdiTiempoModificacion = date("Y-m-d H:i:s");
	$InsMiembroDirectorio->MdiEliminado = 1;
	
	if($InsMiembroDirectorio->MtdRegistrarMiembroDirectorio()){
		$Resultado.='#SAS_SOC_101';
		unset($InsMiembroDirectorio);
		unset($_SESSION['SesMdiFoto']);
	} else{
		$Resultado.='#ERR_SOC_101';
	}

}else{
	unset($_SESSION['SesMdiFoto']);
}
?>
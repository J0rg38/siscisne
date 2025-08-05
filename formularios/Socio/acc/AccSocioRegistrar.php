<?php
//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	
	$InsSocio->SocId = $_POST['CmpId'];
	$InsSocio->UsuId = $_POST['CmpUsuario'];
	$InsSocio->TdoId = $_POST['CmpTipoDocumento'];
	$InsSocio->SocNombre = $_POST['CmpNombre'];
	$InsSocio->SocApellidoPaterno = $_POST['CmpApellidoPaterno'];
	$InsSocio->SocApellidoMaterno = $_POST['CmpApellidoMaterno'];

	$InsSocio->SocNumeroDocumento = $_POST['CmpNumeroDocumento'];
	$InsSocio->SocEmail = $_POST['CmpEmail'];
	$InsSocio->SocTelefono = $_POST['CmpTelefono'];
	$InsSocio->SocCelular = $_POST['CmpCelular'];
	$InsSocio->SocDireccion = $_POST['CmpDireccion'];	

	$InsSocio->SocFoto = $_SESSION['SesSocFoto'];
	$InsSocio->SocEstado = $_POST['CmpEstado'];
	$InsSocio->SocTiempoCreacion = date("Y-m-d H:i:s");
	$InsSocio->SocTiempoModificacion = date("Y-m-d H:i:s");
	$InsSocio->SocEliminado = 1;
		
	if($InsSocio->MtdRegistrarSocio()){
		$Resultado.='#SAS_SOC_101';
		unset($InsSocio);
		unset($_SESSION['SesSocFoto']);	
	} else{
		$Resultado.='#ERR_SOC_101';
	}

}else{
	unset($_SESSION['SesSocFoto']);
}
?>
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
	$InsSocio->SocTiempoModificacion = date("Y-m-d H:i:s");

		if($InsSocio->MtdEditarSocio()){
			$Resultado.='#SAS_SOC_102';
			FncCargarDatos();
		}else{
			$Resultado.='#ERR_SOC_102';
		}			
			
			
}else{
	FncCargarDatos();	
}

function FncCargarDatos(){

	global $Identificador;	
	global $GET_id;
	global $InsSocio;
	
	unset($_SESSION['SesSocFoto']);		
	
	$InsSocio->SocId = $GET_id;
	$InsSocio = $InsSocio->MtdObtenerSocio();
	
	$_SESSION['SesSocFoto'] =	$InsSocio->SocFoto;
	

	
	
}
?>
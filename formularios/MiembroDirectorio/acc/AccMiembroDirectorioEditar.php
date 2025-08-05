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
	$InsMiembroDirectorio->MdiTiempoModificacion = date("Y-m-d H:i:s");
				
				

	
		if($InsMiembroDirectorio->MtdEditarMiembroDirectorio()){
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
	global $InsMiembroDirectorio;
	
	unset($_SESSION['SesMdiFoto']);		
	
	$InsMiembroDirectorio->MdiId = $GET_id;
	$InsMiembroDirectorio = $InsMiembroDirectorio->MtdObtenerMiembroDirectorio();
	
	$_SESSION['SesMdiFoto'] =	$InsMiembroDirectorio->MdiFoto;
	

	
	
}
?>
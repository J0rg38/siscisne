<?php
//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';

	$InsPersonal->PerId = $_POST['CmpId'];
$InsPersonal->SucId = $_POST['CmpSucursal'];
	
	$InsPersonal->UsuId = $_POST['CmpUsuario'];
	$InsPersonal->AreId = $_POST['CmpAreaId'];
	$InsPersonal->TdoId = $_POST['CmpTipoDocumento'];
	$InsPersonal->PtiId = $_POST['CmpPersonalTipo'];
	$InsPersonal->PerAbreviatura = $_POST['CmpAbreviatura'];
	$InsPersonal->PerNombre = $_POST['CmpNombre'];
	$InsPersonal->PerApellidoPaterno = $_POST['CmpApellidoPaterno'];
	$InsPersonal->PerApellidoMaterno = $_POST['CmpApellidoMaterno'];
	$InsPersonal->PerFechaNacimiento = FncCambiaFechaAMysql($_POST['CmpFechaNacimiento'],true);
	$InsPersonal->PerSexo = $_POST['CmpSexo'];
	$InsPersonal->PerEstadoCivil = $_POST['CmpEstadoCivil'];
	$InsPersonal->PerCantidadHijo = $_POST['CmpCantidadHijo'];
	
	$InsPersonal->PerNumeroDocumento = $_POST['CmpNumeroDocumento'];
	$InsPersonal->PerEmail = $_POST['CmpEmail'];
	$InsPersonal->PerTelefono = $_POST['CmpTelefono'];
	$InsPersonal->PerCelular = $_POST['CmpCelular'];
	$InsPersonal->PerPais = $_POST['CmpPais'];
	$InsPersonal->PerCiudad = $_POST['CmpCiudad'];
	$InsPersonal->PerDireccion = $_POST['CmpDireccion'];	
		
	$InsPersonal->PerDepartamento = $_POST['CmpDepartamento'];	
	$InsPersonal->PerProvincicia = $_POST['CmpProvincia'];	
	$InsPersonal->PerDistrito = $_POST['CmpDistrito'];	

	$InsPersonal->PerFirma =  $_SESSION['SesPerFotoFirma'.$Identificador];
	$InsPersonal->PerFoto = $_SESSION['SesPerFoto'.$Identificador];
	
	$InsPersonal->PerTaller = $_POST['CmpTaller'];
	$InsPersonal->PerRecepcion = $_POST['CmpRecepcion'];
	$InsPersonal->PerVenta = $_POST['CmpVenta'];
	$InsPersonal->PerAlmacen = $_POST['CmpAlmacen'];
	$InsPersonal->PerFirmante = $_POST['CmpFirmante'];
	
	$InsPersonal->PerEstado = $_POST['CmpEstado'];
	$InsPersonal->PerTiempoModificacion = date("Y-m-d H:i:s");
				
	if($InsPersonal->MtdEditarPersonal()){
		$Edito = true;
		$Resultado.='#SAS_PER_102';
		FncCargarDatos();
	}else{
		$Resultado.='#ERR_PER_102';
		$InsPersonal->PerFechaNacimiento = FncCambiaFechaANormal($InsPersonal->PerFechaNacimiento,true);
	}			
			
			
}else{
	FncCargarDatos();	
}

function FncCargarDatos(){

	global $Identificador;	
	global $GET_id;
	global $InsPersonal;
	
	unset($_SESSION['SesPerFoto']);		
	
	$InsPersonal->PerId = $GET_id;
	$InsPersonal = $InsPersonal->MtdObtenerPersonal();
	
	$_SESSION['SesPerFoto'.$Identificador] =	$InsPersonal->PerFoto;
	$_SESSION['SesPerFotoFirma'.$Identificador] =	$InsPersonal->PerFirma;

	
	
}
?>
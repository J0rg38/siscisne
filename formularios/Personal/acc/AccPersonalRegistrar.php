<?php
//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	
	$InsPersonal->PerId = $_POST['CmpId'];
	$InsPersonal->SucId = $_POST['CmpSucursal'];
	
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
	$InsPersonal->PerTiempoCreacion = date("Y-m-d H:i:s");
	$InsPersonal->PerTiempoModificacion = date("Y-m-d H:i:s");
	$InsPersonal->PerEliminado = 1;
		
	if($InsPersonal->MtdRegistrarPersonal()){
		$Registro = true;
		$Resultado.='#SAS_PER_101';
		unset($InsPersonal);
		unset($_SESSION['SesPerFoto']);
		
		
	} else{
		$InsPersonal->PerFechaNacimiento = FncCambiaFechaANormal($InsPersonal->PerFechaNacimiento,true);
		$Resultado.='#ERR_PER_101';
	}

}else{

	
	unset($_SESSION['SesPerFoto'.$Identificador]);
	unset($_SESSION['SesPerFotoFirma'.$Identificador]);
	
	$InsPersonal->PerTaller = 2;
	$InsPersonal->PerRecepcion = 2;
	$InsPersonal->PerVenta = 2;
	$InsPersonal->PerAlmacen = 2;
	$InsPersonal->PerFirmante = 2;
	
	$InsPersonal->SucId = $_SESSION['SesionSucursal'];
}
?>
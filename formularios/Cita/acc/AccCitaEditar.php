<?php
//Si se hizo click en guardar	
		
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	
	$InsCita->CitId = $_POST['CmpId'];
	$InsCita->SucId = $_POST['CmpSucursal'];
	
	$InsCita->CitFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	$InsCita->CitFechaProgramada = FncCambiaFechaAMysql($_POST['CmpFechaProgramada']);
	$InsCita->CitHoraProgramada = $_POST['CmpHoraProgramada'];
	
	$InsCita->PerId = $_POST['CmpPersonal'];
	$InsCita->PerIdMecanico = $_POST['CmpPersonalMecanico'];
	$InsCita->PerIdRegistro = $_SESSION['SesionPersonal'];
	
	$InsCita->EinId = $_POST['CmpVehiculoIngresoId'];
	$InsCita->CliId = $_POST['CmpClienteId'];
	
	$InsCita->CitDescripcion = addslashes($_POST['CmpDescripcion']);
	
	$InsCita->CitDuracion = $_POST['CmpDuracion'];
	$InsCita->CitKilometrajeMantenimiento = $_POST['CmpCitaPresupuestoMantenimientoKilometraje'];
	
	$InsCita->CitVehiculoMarca = $_POST['CmpVehiculoMarca'];
	$InsCita->CitVehiculoModelo = $_POST['CmpVehiculoModelo'];
	$InsCita->CitVehiculoVersion = $_POST['CmpVehiculoVersion'];
	$InsCita->CitVehiculoPlaca = $_POST['CmpVehiculoIngresoPlaca'];
	$InsCita->CitReferencia = $_POST['CmpReferencia'];
	
	$InsCita->CitEstado = $_POST['CmpEstado'];
	$InsCita->CitTiempoModificacion = date("Y-m-d H:i:s");
	
	$InsCita->EinVIN = $_POST['CmpVehiculoIngresoVIN'];
	$InsCita->EinPlaca = $_POST['CmpVehiculoIngresoPlaca'];
				
	$InsCita->VmaNombre = $_POST['CmpVehiculoIngresoMarca'];
	$InsCita->VmoNombre = $_POST['CmpVehiculoIngresoModelo'];
	$InsCita->VveNombre = $_POST['CmpVehiculoIngresoVersion'];

	$InsCita->VmaId = $_POST['CmpVehiculoMarcaId'];
	$InsCita->VmoId = $_POST['CmpVehiculoModeloId'];
	$InsCita->VveId = $_POST['CmpVehiculoVersionId'];

	$InsCita->TdoId = $_POST['CmpClienteTipoDocumento'];
	$InsCita->CliNombreCompleto = $_POST['CmpClienteNombreCompleto'];
	$InsCita->CliNombre = $_POST['CmpClienteNombre'];
	$InsCita->CliApellidoPaterno = $_POST['CmpClienteApellidoPaterno'];
	$InsCita->CliApellidoMaterno = $_POST['CmpClienteApellidoMaterno'];
	
	$InsCita->CitUsuarioModifico = $_SESSION['SesionUsuario'];
	
				
		if($InsCita->MtdEditarCita()){	
				$Registro = true;				
			$Resultado.='#SAS_CIT_102';
			FncCargarDatos();
		}else{			
		
			$Resultado.='#ERR_CIT_102';		
		}			
		
			$InsCita->CitFecha = FncCambiaFechaANormal($InsCita->CitFecha,true);
		$InsCita->CitFechaProgramada = FncCambiaFechaANormal($InsCita->CitFechaProgramada,true);
		
			
}else{
	FncCargarDatos();
}

function FncCargarDatos(){
	
	global $GET_id;
	global $InsCita;
	$InsCita->CitId = $GET_id;
	$InsCita->MtdObtenerCita();		
		
}
?>
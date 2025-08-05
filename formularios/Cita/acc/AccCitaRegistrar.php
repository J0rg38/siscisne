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
	$InsCita->CitDuracion = $_POST['CmpDuracion'];
	$InsCita->CitKilometrajeMantenimiento = $_POST['CmpCitaPresupuestoMantenimientoKilometraje'];
	
	$InsCita->CitVehiculoMarca = $_POST['CmpVehiculoMarca'];
	$InsCita->CitVehiculoModelo = $_POST['CmpVehiculoModelo'];
	$InsCita->CitVehiculoVersion = $_POST['CmpVehiculoVersion'];
	$InsCita->CitVehiculoPlaca = $_POST['CmpVehiculoIngresoPlaca'];
	$InsCita->CitReferencia = $_POST['CmpReferencia'];
	
	$InsCita->CitEstado = $_POST['CmpEstado'];
	$InsCita->CitDescripcion = addslashes($_POST['CmpDescripcion']);
	$InsCita->CitTiempoCreacion = date("Y-m-d H:i:s");
	$InsCita->CitTiempoModificacion = date("Y-m-d H:i:s");
	$InsCita->CitEliminado = 1;

	$InsCita->EinVIN = $_POST['CmpVehiculoIngresoVIN'];
	$InsCita->EinPlaca = $_POST['CmpVehiculoIngresoPlaca'];
				
	$InsCita->VmaNombre = $_POST['CmpVehiculoIngresoMarca'];
	$InsCita->VmoNombre = $_POST['CmpVehiculoIngresoModelo'];
	$InsCita->VveNombre = $_POST['CmpVehiculoIngresoVersion'];

	$InsCita->VmaId = $_POST['CmpVehiculoMarcaId'];
	$InsCita->VmoId = $_POST['CmpVehiculoModeloId'];
	$InsCita->VveId = $_POST['CmpVehiculoVersionId'];

	$InsCita->TdoId = $_POST['CmpClienteTipoDocumento'];
	$InsCita->CliNumeroDocumento = $_POST['CmpClienteNumeroDocumento'];
	$InsCita->CliNombreCompleto = $_POST['CmpClienteNombreCompleto'];
	$InsCita->CliNombre = $_POST['CmpClienteNombre'];
	$InsCita->CliApellidoPaterno = $_POST['CmpClienteApellidoPaterno'];
	$InsCita->CliApellidoMaterno = $_POST['CmpClienteApellidoMaterno'];
	
	
	
	$InsCita->CitUsuarioRegistro = $_SESSION['SesionUsuario'];
	
	deb("SUCURSAL: ".$InsCita->SucId);
	
	$RespuestaValidacion = $InsCita->MtdValidarCita($InsCita->CitFechaProgramada,$InsCita->CitHoraProgramada.":00",$InsCita->SucId);
	
	if( $_SESSION['MysqlDeb']){
		deb($RespuestaValidacion);
	}
	
	
	if($RespuestaValidacion['respuesta']){
		
		if($InsCita->MtdRegistrarCita()){
			
			unset($InsCita);
			$Resultado.='#SAS_CIT_101';
			$Registro = true;
			
		} else{
			
			$InsCita->CitFecha = FncCambiaFechaANormal($InsCita->CitFecha,true);
			$InsCita->CitFechaProgramada = FncCambiaFechaANormal($InsCita->CitFechaProgramada,true);
			
			$Resultado.='#ERR_CIT_101';
		}
	}else{
		
		$InsCita->CitFecha = FncCambiaFechaANormal($InsCita->CitFecha,true);
		$InsCita->CitFechaProgramada = FncCambiaFechaANormal($InsCita->CitFechaProgramada,true);
			
		$Resultado.='#ERR_CIT_106';	
		
	}

}else{
	FncNuevo();
}

function FncNuevo(){
	
	global $InsCita;
	
	$InsCita = new ClsCita();
	$InsCita->SucId = $_SESSION['SesionSucursal'];
	$InsCita->CitFecha = date("d/m/Y");
	$InsCita->CitFechaProgramada = date("d/m/Y");
	$InsCita->CitHoraProgramada = date("H:i");
	$InsCita->PerId = $_SESSION['SesionPersonal'];
	$InsCita->CitEstado = 1;
	$InsCita->CitDuracion = 2;
	
	$InsCita->PerIdRegistro = $_SESSION['SesionPersonal'];
	
}
?>
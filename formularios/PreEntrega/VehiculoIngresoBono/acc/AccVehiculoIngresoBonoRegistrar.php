<?php
//Si se hizo click en guardar	

if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	
	$InsVehiculoIngresoBono->VibId = $_POST['CmpId'];
	$InsVehiculoIngresoBono->SucId = $_POST['CmpSucursal'];
	
	$InsVehiculoIngresoBono->VibFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	$InsVehiculoIngresoBono->VibFechaProgramada = FncCambiaFechaAMysql($_POST['CmpFechaProgramada']);
	$InsVehiculoIngresoBono->VibHoraProgramada = $_POST['CmpHoraProgramada'];
	
	$InsVehiculoIngresoBono->PerId = $_POST['CmpPersonal'];
	$InsVehiculoIngresoBono->PerIdMecanico = $_POST['CmpPersonalMecanico'];
	
	$InsVehiculoIngresoBono->EinId = $_POST['CmpVehiculoIngresoId'];
	$InsVehiculoIngresoBono->CliId = $_POST['CmpClienteId'];
	$InsVehiculoIngresoBono->VibDuracion = $_POST['CmpDuracion'];
	$InsVehiculoIngresoBono->VibKilometrajeMantenimiento = $_POST['CmpVehiculoIngresoBonoPresupuestoMantenimientoKilometraje'];
	
	$InsVehiculoIngresoBono->VibVehiculoMarca = $_POST['CmpVehiculoMarca'];
	$InsVehiculoIngresoBono->VibVehiculoModelo = $_POST['CmpVehiculoModelo'];
	$InsVehiculoIngresoBono->VibVehiculoVersion = $_POST['CmpVehiculoVersion'];
	$InsVehiculoIngresoBono->VibVehiculoPlaca = $_POST['CmpVehiculoIngresoPlaca'];
	$InsVehiculoIngresoBono->VibReferencia = $_POST['CmpReferencia'];
	
	$InsVehiculoIngresoBono->MonId = $_POST['CmpMonedaId'];
	$InsVehiculoIngresoBono->VibTipoCambio = $_POST['CmpTipoCambio'];
	$InsVehiculoIngresoBono->VibTotal = eregi_replace(",","",(empty($_POST['CmpTotal'])?0:$_POST['CmpTotal']));
	
	$InsVehiculoIngresoBono->VibEstado = $_POST['CmpEstado'];
	$InsVehiculoIngresoBono->VibDescripcion = addslashes($_POST['CmpDescripcion']);
	$InsVehiculoIngresoBono->VibTiempoCreacion = date("Y-m-d H:i:s");
	$InsVehiculoIngresoBono->VibTiempoModificacion = date("Y-m-d H:i:s");
	$InsVehiculoIngresoBono->VibEliminado = 1;

	$InsVehiculoIngresoBono->EinVIN = $_POST['CmpVehiculoIngresoVIN'];
	$InsVehiculoIngresoBono->EinPlaca = $_POST['CmpVehiculoIngresoPlaca'];
				
	$InsVehiculoIngresoBono->VmaNombre = $_POST['CmpVehiculoIngresoMarca'];
	$InsVehiculoIngresoBono->VmoNombre = $_POST['CmpVehiculoIngresoModelo'];
	$InsVehiculoIngresoBono->VveNombre = $_POST['CmpVehiculoIngresoVersion'];

	$InsVehiculoIngresoBono->VmaId = $_POST['CmpVehiculoMarcaId'];
	$InsVehiculoIngresoBono->VmoId = $_POST['CmpVehiculoModeloId'];
	$InsVehiculoIngresoBono->VveId = $_POST['CmpVehiculoVersionId'];

	$InsVehiculoIngresoBono->TdoId = $_POST['CmpClienteTipoDocumento'];
	$InsVehiculoIngresoBono->CliNumeroDocumento = $_POST['CmpClienteNumeroDocumento'];
	$InsVehiculoIngresoBono->CliNombreCompleto = $_POST['CmpClienteNombreCompleto'];
	$InsVehiculoIngresoBono->CliNombre = $_POST['CmpClienteNombre'];
	$InsVehiculoIngresoBono->CliApellidoPaterno = $_POST['CmpClienteApellidoPaterno'];
	$InsVehiculoIngresoBono->CliApellidoMaterno = $_POST['CmpClienteApellidoMaterno'];
	
	settype($InsVehiculoIngresoBono->VibTipoCambio,"float");
		
	if($InsVehiculoIngresoBono->MonId<>$EmpresaMonedaId){
		if(empty($InsVehiculoIngresoBono->VibTipoCambio)){
			$Guardar = false;
			$Resultado.='#ERR_VIB_600';
		}
	}

	if( $InsVehiculoIngresoBono->MonId<>$EmpresaMonedaId ){
		$InsVehiculoIngresoBono->VibTotal = $InsVehiculoIngresoBono->VibTotal * $InsVehiculoIngresoBono->VibTipoCambio;
	}else{
		$InsVehiculoIngresoBono->VibTotal = $InsVehiculoIngresoBono->VibTotal;
	}
	
	
		
	if($InsVehiculoIngresoBono->MtdRegistrarVehiculoIngresoBono()){
		
		unset($InsVehiculoIngresoBono);
		$Resultado.='#SAS_VIB_101';
		$Registro = true;
		
	} else{
		
		$InsVehiculoIngresoBono->VibFecha = FncCambiaFechaANormal($InsVehiculoIngresoBono->VibFecha,true);
		$InsVehiculoIngresoBono->VibFechaProgramada = FncCambiaFechaANormal($InsVehiculoIngresoBono->VibFechaProgramada,true);		
		$Resultado.='#ERR_VIB_101';
	}


}else{
	
	FncNuevo();
	
}

function FncNuevo(){
	
	global $InsVehiculoIngresoBono;
	
	$InsVehiculoIngresoBono = new ClsVehiculoIngresoBono();
	$InsVehiculoIngresoBono->SucId = $_SESSION['SesionSucursal'];
	$InsVehiculoIngresoBono->VibFecha = date("d/m/Y");
	$InsVehiculoIngresoBono->VibFechaProgramada = date("d/m/Y");
	$InsVehiculoIngresoBono->VibHoraProgramada = date("H:i");
	$InsVehiculoIngresoBono->PerId = $_SESSION['SesionPersonal'];
	$InsVehiculoIngresoBono->VibEstado = 1;
	$InsVehiculoIngresoBono->VibDuracion = 2;
	
}
?>
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
	
	$InsVehiculoIngresoBono->VibObservacionInterna = addslashes($_POST['CmpDescripcion']);
	
	$InsVehiculoIngresoBono->VibDuracion = $_POST['CmpDuracion'];
	$InsVehiculoIngresoBono->VibKilometrajeMantenimiento = $_POST['CmpVehiculoIngresoBonoPresupuestoMantenimientoKilometraje'];
	
	$InsVehiculoIngresoBono->VmaNombre = $_POST['CmpVehiculoMarca'];
	$InsVehiculoIngresoBono->VmoNombre = $_POST['CmpVehiculoModelo'];
	$InsVehiculoIngresoBono->VveNombre = $_POST['CmpVehiculoVersion'];
	$InsVehiculoIngresoBono->EinPlaca = $_POST['CmpVehiculoIngresoPlaca'];
	$InsVehiculoIngresoBono->VibReferencia = $_POST['CmpReferencia'];
	
	$InsVehiculoIngresoBono->MonId = $_POST['CmpMonedaId'];
	$InsVehiculoIngresoBono->VibTipoCambio = $_POST['CmpTipoCambio'];
	$InsVehiculoIngresoBono->VibMonto = preg_replace("/,/", "", (empty($_POST['CmpTotal'])?0:$_POST['CmpTotal']));
	
	$InsVehiculoIngresoBono->VibEstado = $_POST['CmpEstado'];
	$InsVehiculoIngresoBono->VibTiempoModificacion = date("Y-m-d H:i:s");
	
	$InsVehiculoIngresoBono->EinVIN = $_POST['CmpVehiculoIngresoVIN'];
	$InsVehiculoIngresoBono->EinPlaca = $_POST['CmpVehiculoIngresoPlaca'];
				
	$InsVehiculoIngresoBono->VmaNombre = $_POST['CmpVehiculoIngresoMarca'];
	$InsVehiculoIngresoBono->VmoNombre = $_POST['CmpVehiculoIngresoModelo'];
	$InsVehiculoIngresoBono->VveNombre = $_POST['CmpVehiculoIngresoVersion'];

	$InsVehiculoIngresoBono->VmaId = $_POST['CmpVehiculoMarcaId'];
	$InsVehiculoIngresoBono->VmoId = $_POST['CmpVehiculoModeloId'];
	$InsVehiculoIngresoBono->VveId = $_POST['CmpVehiculoVersionId'];

	$InsVehiculoIngresoBono->TdoId = $_POST['CmpClienteTipoDocumento'];
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
		$InsVehiculoIngresoBono->VibMonto = $InsVehiculoIngresoBono->VibMonto * $InsVehiculoIngresoBono->VibTipoCambio;
	}else{
		$InsVehiculoIngresoBono->VibMonto = $InsVehiculoIngresoBono->VibMonto;
	}
	
	if($InsVehiculoIngresoBono->MtdEditarVehiculoIngresoBono()){	
			$Registro = true;				
			$Resultado.='#SAS_VIB_102';
			FncCargarDatos();
	}else{			
	
		$Resultado.='#ERR_VIB_102';		
	}			
		
	$InsVehiculoIngresoBono->VibFecha = FncCambiaFechaANormal($InsVehiculoIngresoBono->VibFecha,true);
	$InsVehiculoIngresoBono->VibFechaProgramada = FncCambiaFechaANormal($InsVehiculoIngresoBono->VibFechaProgramada,true);

	if($InsVehiculoIngresoBono->MonId<>$EmpresaMonedaId ){
		$InsVehiculoIngresoBono->VibMonto = round($InsVehiculoIngresoBono->VibMonto / $InsVehiculoIngresoBono->VibTipoCambio,3);
	}

}else{
	
	FncCargarDatos();
	
}

function FncCargarDatos(){
	
	global $GET_id;
	global $InsVehiculoIngresoBono;
	global $EmpresaMonedaId;
	
	$InsVehiculoIngresoBono->VibId = $GET_id;
	$InsVehiculoIngresoBono->MtdObtenerVehiculoIngresoBono();	
	
	if($InsVehiculoIngresoBono->MonId<>$EmpresaMonedaId ){
		$InsVehiculoIngresoBono->VibMonto = round($InsVehiculoIngresoBono->VibMonto / $InsVehiculoIngresoBono->VibTipoCambio,3);
	}

	
		
}
?>
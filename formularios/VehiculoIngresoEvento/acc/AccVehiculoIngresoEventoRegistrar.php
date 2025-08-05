<?php
//Si se hizo click en guardar	

if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	
	$InsVehiculoIngresoEvento->VieId = $_POST['CmpId'];
	$InsVehiculoIngresoEvento->SucId = $_POST['CmpSucursal'];
	
	$InsVehiculoIngresoEvento->VieFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	$InsVehiculoIngresoEvento->VieFechaProgramada = FncCambiaFechaAMysql($_POST['CmpFechaProgramada']);
	$InsVehiculoIngresoEvento->VieHoraProgramada = $_POST['CmpHoraProgramada'];
	
	$InsVehiculoIngresoEvento->PerId = $_POST['CmpPersonal'];
	$InsVehiculoIngresoEvento->PerIdMecanico = $_POST['CmpPersonalMecanico'];
	
	$InsVehiculoIngresoEvento->EinId = $_POST['CmpVehiculoIngresoId'];
	$InsVehiculoIngresoEvento->CliId = $_POST['CmpClienteId'];
	$InsVehiculoIngresoEvento->VieDuracion = $_POST['CmpDuracion'];
	$InsVehiculoIngresoEvento->VieKilometrajeMantenimiento = $_POST['CmpVehiculoIngresoEventoPresupuestoMantenimientoKilometraje'];
	
	$InsVehiculoIngresoEvento->VmaNombre = $_POST['CmpVehiculoMarca'];
	$InsVehiculoIngresoEvento->VmoNombre = $_POST['CmpVehiculoModelo'];
	$InsVehiculoIngresoEvento->VveNombre = $_POST['CmpVehiculoVersion'];
	$InsVehiculoIngresoEvento->EinPlaca = $_POST['CmpVehiculoIngresoPlaca'];
	$InsVehiculoIngresoEvento->VieReferencia = $_POST['CmpReferencia'];
	
	$InsVehiculoIngresoEvento->MonId = $_POST['CmpMonedaId'];
	$InsVehiculoIngresoEvento->VieTipoCambio = $_POST['CmpTipoCambio'];
	$InsVehiculoIngresoEvento->VieMonto = eregi_replace(",","",(empty($_POST['CmpTotal'])?0:$_POST['CmpTotal']));
	
	$InsVehiculoIngresoEvento->VieEstado = $_POST['CmpEstado'];
	$InsVehiculoIngresoEvento->VieObservacionInterna = addslashes($_POST['CmpDescripcion']);
	$InsVehiculoIngresoEvento->VieTiempoCreacion = date("Y-m-d H:i:s");
	$InsVehiculoIngresoEvento->VieTiempoModificacion = date("Y-m-d H:i:s");
	$InsVehiculoIngresoEvento->VieEliminado = 1;

	$InsVehiculoIngresoEvento->EinVIN = $_POST['CmpVehiculoIngresoVIN'];
	$InsVehiculoIngresoEvento->EinPlaca = $_POST['CmpVehiculoIngresoPlaca'];
				
	$InsVehiculoIngresoEvento->VmaNombre = $_POST['CmpVehiculoMarca'];
	$InsVehiculoIngresoEvento->VmoNombre = $_POST['CmpVehiculoModelo'];
	$InsVehiculoIngresoEvento->VveNombre = $_POST['CmpVehiculoVersion'];

	$InsVehiculoIngresoEvento->VmaId = $_POST['CmpVehiculoMarcaId'];
	$InsVehiculoIngresoEvento->VmoId = $_POST['CmpVehiculoModeloId'];
	$InsVehiculoIngresoEvento->VveId = $_POST['CmpVehiculoVersionId'];

	$InsVehiculoIngresoEvento->TdoId = $_POST['CmpClienteTipoDocumento'];
	$InsVehiculoIngresoEvento->CliNumeroDocumento = $_POST['CmpClienteNumeroDocumento'];
	$InsVehiculoIngresoEvento->CliNombreCompleto = $_POST['CmpClienteNombreCompleto'];
	$InsVehiculoIngresoEvento->CliNombre = $_POST['CmpClienteNombre'];
	$InsVehiculoIngresoEvento->CliApellidoPaterno = $_POST['CmpClienteApellidoPaterno'];
	$InsVehiculoIngresoEvento->CliApellidoMaterno = $_POST['CmpClienteApellidoMaterno'];
	

	
		
	if($InsVehiculoIngresoEvento->MtdRegistrarVehiculoIngresoEvento()){
		
		unset($InsVehiculoIngresoEvento);
		$Resultado.='#SAS_VIE_101';
		$Registro = true;
		
	} else{
		
		$InsVehiculoIngresoEvento->VieFecha = FncCambiaFechaANormal($InsVehiculoIngresoEvento->VieFecha,true);
		$InsVehiculoIngresoEvento->VieFechaProgramada = FncCambiaFechaANormal($InsVehiculoIngresoEvento->VieFechaProgramada,true);		
		$Resultado.='#ERR_VIE_101';
	}


}else{
	
	FncNuevo();
	
}

function FncNuevo(){
	
	global $InsVehiculoIngresoEvento;
	
	$InsVehiculoIngresoEvento = new ClsVehiculoIngresoEvento();
	$InsVehiculoIngresoEvento->SucId = $_SESSION['SesionSucursal'];
	$InsVehiculoIngresoEvento->VieFecha = date("d/m/Y");
	$InsVehiculoIngresoEvento->VieFechaProgramada = date("d/m/Y");
	$InsVehiculoIngresoEvento->VieHoraProgramada = date("H:i");
	$InsVehiculoIngresoEvento->PerId = $_SESSION['SesionPersonal'];
	$InsVehiculoIngresoEvento->VieEstado = 3;
	$InsVehiculoIngresoEvento->VieDuracion = 2;
	
}
?>
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
	
	$InsVehiculoIngresoEvento->VieObservacionInterna = addslashes($_POST['CmpDescripcion']);
	
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
	$InsVehiculoIngresoEvento->VieTiempoModificacion = date("Y-m-d H:i:s");
	
	$InsVehiculoIngresoEvento->EinVIN = $_POST['CmpVehiculoIngresoVIN'];
	$InsVehiculoIngresoEvento->EinPlaca = $_POST['CmpVehiculoIngresoPlaca'];
				
	$InsVehiculoIngresoEvento->VmaNombre = $_POST['CmpVehiculoMarca'];
	$InsVehiculoIngresoEvento->VmoNombre = $_POST['CmpVehiculoModelo'];
	$InsVehiculoIngresoEvento->VveNombre = $_POST['CmpVehiculoVersion'];

	$InsVehiculoIngresoEvento->VmaId = $_POST['CmpVehiculoMarcaId'];
	$InsVehiculoIngresoEvento->VmoId = $_POST['CmpVehiculoModeloId'];
	$InsVehiculoIngresoEvento->VveId = $_POST['CmpVehiculoVersionId'];

	$InsVehiculoIngresoEvento->TdoId = $_POST['CmpClienteTipoDocumento'];
	$InsVehiculoIngresoEvento->CliNombreCompleto = $_POST['CmpClienteNombreCompleto'];
	$InsVehiculoIngresoEvento->CliNombre = $_POST['CmpClienteNombre'];
	$InsVehiculoIngresoEvento->CliApellidoPaterno = $_POST['CmpClienteApellidoPaterno'];
	$InsVehiculoIngresoEvento->CliApellidoMaterno = $_POST['CmpClienteApellidoMaterno'];
	

	
	if($InsVehiculoIngresoEvento->MtdEditarVehiculoIngresoEvento()){	
			$Registro = true;				
			$Resultado.='#SAS_VIE_102';
			FncCargarDatos();
	}else{			
	
		$Resultado.='#ERR_VIE_102';		
	}			
		
	$InsVehiculoIngresoEvento->VieFecha = FncCambiaFechaANormal($InsVehiculoIngresoEvento->VieFecha,true);
	$InsVehiculoIngresoEvento->VieFechaProgramada = FncCambiaFechaANormal($InsVehiculoIngresoEvento->VieFechaProgramada,true);

}else{
	
	FncCargarDatos();
	
}

function FncCargarDatos(){
	
	global $GET_id;
	global $InsVehiculoIngresoEvento;
	global $EmpresaMonedaId;
	
	$InsVehiculoIngresoEvento->VieId = $GET_id;
	$InsVehiculoIngresoEvento->MtdObtenerVehiculoIngresoEvento();	
	
	
		
}
?>
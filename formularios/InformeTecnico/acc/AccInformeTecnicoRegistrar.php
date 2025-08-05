<?php
//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	
	$InsInformeTecnico->IteId = $_POST['CmpId'];
	$InsInformeTecnico->FinId = $_POST['CmpFichaIngresoId'];
	$InsInformeTecnico->PerId = $_POST['CmpPersonal'];
	$InsInformeTecnico->IterCargo = $_POST['CmpPersonalCargo'];
	
	$InsInformeTecnico->IteConcesionario = $_POST['CmpConcesionario'];
	$InsInformeTecnico->IteSedeLocal = $_POST['CmpSedeLocal'];
	$InsInformeTecnico->IteFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	$InsInformeTecnico->IteFechaVenta = FncCambiaFechaAMysql($_POST['CmpFechaVenta'],true);
	$InsInformeTecnico->IteContactoGM = $_POST['CmpContactoGM'];
	
	$InsInformeTecnico->IteModelo = $_POST['CmpModelo'];	
	
	$InsInformeTecnico->ItePlaca = $_POST['CmpVehiculoIngresoPlaca'];
	$InsInformeTecnico->ItePropietario = $_POST['CmpPropietario'];
	
	$InsInformeTecnico->IteCondicion = addslashes($_POST['CmpCondicion']);
	$InsInformeTecnico->IteCausa = addslashes($_POST['CmpCausa']);
	$InsInformeTecnico->IteCorreccion = addslashes($_POST['CmpCorreccion']);
	$InsInformeTecnico->IteConclusion = addslashes($_POST['CmpConclusion']);

	$InsInformeTecnico->IteSolucionSatisfactoria = $_POST['CmpSolucionSatisfactoria'];			
	$InsInformeTecnico->IteEstado = 1;	
	$InsInformeTecnico->IteTiempoCreacion = date("Y-m-d H:i:s");
	$InsInformeTecnico->IteTiempoModificacion = date("Y-m-d H:i:s");
	$InsInformeTecnico->IteEliminado = 1;

	$InsInformeTecnico->EinVIN = $_POST['CmpVehiculoIngresoVIN'];	
	
	if($InsInformeTecnico->MtdRegistrarInformeTecnico()){
		$Resultado.='#SAS_ITE_101';
		$Registro = true;
	} else{
		$Resultado.='#ERR_ITE_101';
	}

	$InsInformeTecnico->IteFecha = FncCambiaFechaANormal($InsInformeTecnico->IteFecha);
	$InsInformeTecnico->IteFechaVenta = FncCambiaFechaANormal($InsInformeTecnico->IteFechaVenta,true);

}else{
	
	$InsFichaIngreso->FinId = $GET_FinId;
	$InsFichaIngreso->MtdObtenerFichaIngreso();
	
	$InsInformeTecnico->FinId = $InsFichaIngreso->FinId;
	$InsInformeTecnico->IteConcesionario = "C&C.SAC";
	$InsInformeTecnico->IteSedeLocal = "TACNA";
	$InsInformeTecnico->IteContactoGM = "LUIS VEGA";
	
	$InsInformeTecnico->IteFecha = date("d/m/Y");
	
	$InsInformeTecnico->EinVIN = $InsFichaIngreso->EinVIN;
	$InsInformeTecnico->ItePlaca = $InsFichaIngreso->EinPlaca;
	$InsInformeTecnico->FinVehiculoKilometraje = $InsFichaIngreso->FinVehiculoKilometraje;
	$InsInformeTecnico->ItePropietario = $InsFichaIngreso->CliNombre;
	
	$InsInformeTecnico->IteModelo = $InsFichaIngreso->VmoNombre." ".$InsFichaIngreso->VveNombre;

}
?>

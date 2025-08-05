<?php
//Si se hizo click en guardar	

	
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

//deb($_POST);
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
	
	$InsInformeTecnico->IteMotor = $_POST['CmpMotor'];
	$InsInformeTecnico->IteTipoTransmision = $_POST['CmpTipoTransmision'];
	$InsInformeTecnico->IteTipoCarroceria = $_POST['CmpTipoCarroceria'];
	$InsInformeTecnico->IteCarga = $_POST['CmpCarga'];
	$InsInformeTecnico->IteCiudad = $_POST['CmpCiudad'];
	$InsInformeTecnico->IteDepartamento = $_POST['CmpDepartamento'];
	$InsInformeTecnico->IteUsoVehiculo = $_POST['CmpUsoVehiculo'];
	$InsInformeTecnico->IteAltitud = $_POST['CmpAltitud'];			

	$InsInformeTecnico->IteEstado = 1;	
	$InsInformeTecnico->IteTiempoModificacion = date("Y-m-d H:i:s");
	$InsInformeTecnico->IteEliminado = 1;

	$InsInformeTecnico->EinVIN = $_POST['CmpVehiculoIngresoVIN'];	
	
	
	if($InsInformeTecnico->MtdEditarInformeTecnico()){		
		$Resultado.='#SAS_ITE_102';
		$Edito = true;
		FncCargarDatos();
	} else{
		$Resultado.='#ERR_ITE_102';
		$InsInformeTecnico->IteFecha = FncCambiaFechaANormal($InsInformeTecnico->IteFecha);
		$InsInformeTecnico->IteFechaVenta = FncCambiaFechaANormal($InsInformeTecnico->IteFechaVenta,true);
	}		
}else{

	FncCargarDatos();
	
}

function FncCargarDatos(){
	
	global $GET_id;
	global $Identificador;
	global $InsInformeTecnico;
		
	$InsInformeTecnico->IteId = $GET_id;
	$InsInformeTecnico = $InsInformeTecnico->MtdObtenerInformeTecnico();	

		
}
?>
<?php
//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	
	
	$Guardar = true;
	
	$Resultado = '';
	
	$InsAviso->AviId = $_POST['CmpId'];
	$InsAviso->AviFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	
	$InsAviso->EinId = $_POST['CmpVehiculoIngresoId'];
	$InsAviso->EinVIN = $_POST['CmpVehiculoIngresoVIN'];
	$InsAviso->EinPlaca = $_POST['CmpVehiculoIngresoPlaca'];
	
	$InsAviso->VmaNombre = $_POST['CmpVehiculoIngresoMarca'];
	$InsAviso->VmoNombre = $_POST['CmpVehiculoIngresoModelo'];
	$InsAviso->VveNombre = $_POST['CmpVehiculoIngresoVersion'];
	
	$InsAviso->VmaId = $_POST['CmpVehiculoIngresoMarcaId'];
	$InsAviso->VmoId = $_POST['CmpVehiculoIngresoModeloId'];
	$InsAviso->VveId = $_POST['CmpVehiculoIngresoVersionId'];
	
	$InsAviso->AviEstado = $_POST['CmpEstado'];
	$InsAviso->AviObservacion = addslashes($_POST['CmpObservacion']);
	$InsAviso->AviTiempoCreacion = date("Y-m-d H:i:s");
	$InsAviso->AviTiempoModificacion = date("Y-m-d H:i:s");
	$InsAviso->AviEliminado = 1;
		
	if(empty($InsAviso->EinId)){
		$Guardar = false;
		$Resultado.='#ERR_AVI_201';		
	}
	
	if($Guardar){
		
		if($InsAviso->MtdRegistrarAviso()){
			
			FncNuevo();
			$Registro = true;
			$Resultado.='#SAS_AVI_101';		
			unset($InsAviso);
			
		} else{
			$InsAviso->AviFecha = FncCambiaFechaANormal($InsAviso->AviFecha);
			$Resultado.='#ERR_AVI_101';
			
		}
		
	}else{
		
		$InsAviso->AviFecha = FncCambiaFechaANormal($InsAviso->AviFecha);
			
	}
	
	

}else{
	
	FncNuevo();
	
}


function FncNuevo(){
	
	global $InsAviso;
	
	$InsAviso->AviFecha = date("d/m/Y");
	
}


?>
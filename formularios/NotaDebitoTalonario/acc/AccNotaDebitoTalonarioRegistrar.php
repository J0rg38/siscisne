<?php
//Si se hizo click en guardar	

if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	
	$InsNotaDebitoTalonario->NdtId = $_POST['CmpId'];
	$InsNotaDebitoTalonario->SucId = $_POST['CmpSucursal'];
	$InsNotaDebitoTalonario->NdtNumero = $_POST['CmpNumero'];
	$InsNotaDebitoTalonario->NdtInicio = $_POST['CmpInicio'];
	$InsNotaDebitoTalonario->NdtDescripcion = $_POST['CmpDescripcion'];

	$InsNotaDebitoTalonario->NdtTiempoCreacion = date("Y-m-d H:i:s");
	$InsNotaDebitoTalonario->NdtTiempoModificacion = date("Y-m-d H:i:s");
	$InsNotaDebitoTalonario->NdtEliminado = 1;
		
	if($InsNotaDebitoTalonario->MtdRegistrarNotaDebitoTalonario()){
			$Registro = true;				
		unset($InsNotaDebitoTalonario);		
		$Resultado.='#SAS_NDT_101';
	} else{
		$Resultado.='#ERR_NDT_101';
	}

}else{

	$InsNotaDebitoTalonario->SucId = $_SESSION['SesionSucursal'];
	
}
?>
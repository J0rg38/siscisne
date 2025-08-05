<?php
//Si se hizo click en guardar	

if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	
	$InsNotaCreditoTalonario->NctId = $_POST['CmpId'];
	$InsNotaCreditoTalonario->SucId = $_POST['CmpSucursal'];
	$InsNotaCreditoTalonario->NctNumero = $_POST['CmpNumero'];
	$InsNotaCreditoTalonario->NctInicio = $_POST['CmpInicio'];
	$InsNotaCreditoTalonario->NctDescripcion = $_POST['CmpDescripcion'];

	$InsNotaCreditoTalonario->NctTiempoCreacion = date("Y-m-d H:i:s");
	$InsNotaCreditoTalonario->NctTiempoModificacion = date("Y-m-d H:i:s");
	$InsNotaCreditoTalonario->NctEliminado = 1;
		
	if($InsNotaCreditoTalonario->MtdRegistrarNotaCreditoTalonario()){
			$Registro = true;				
		unset($InsNotaCreditoTalonario);		
		$Resultado.='#SAS_NCT_101';
	} else{
		$Resultado.='#ERR_NCT_101';
	}

}else{

	$InsNotaCreditoTalonario->SucId = $_SESSION['SesionSucursal'];
	
}
?>
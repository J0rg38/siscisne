<?php
//Si se hizo click en guardar	

if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	
	$InsBoletaTalonario->BtaId = $_POST['CmpId'];
	$InsBoletaTalonario->SucId = $_POST['CmpSucursal'];
	$InsBoletaTalonario->BtaNumero = $_POST['CmpNumero'];
	$InsBoletaTalonario->BtaInicio = $_POST['CmpInicio'];
	$InsBoletaTalonario->BtaDescripcion = $_POST['CmpDescripcion'];

	$InsBoletaTalonario->BtaTiempoCreacion = date("Y-m-d H:i:s");
	$InsBoletaTalonario->BtaTiempoModificacion = date("Y-m-d H:i:s");
	$InsBoletaTalonario->BtaEliminado = 1;
		
	if($InsBoletaTalonario->MtdRegistrarBoletaTalonario()){
			$Registro = true;				
		unset($InsBoletaTalonario);		
		$Resultado.='#SAS_BTA_101';
	} else{
		$Resultado.='#ERR_BTA_101';
	}

}else{

	$InsBoletaTalonario->SucId = $_SESSION['SesionSucursal'];

}
?>
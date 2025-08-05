<?php
//Si se hizo click en guardar	

if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	
	$InsFacturaTalonario->FtaId = $_POST['CmpId'];
	$InsFacturaTalonario->SucId = $_POST['CmpSucursal'];
	$InsFacturaTalonario->FtaNumero = $_POST['CmpNumero'];
	$InsFacturaTalonario->FtaInicio = $_POST['CmpInicio'];
	$InsFacturaTalonario->FtaDescripcion = $_POST['CmpDescripcion'];

	$InsFacturaTalonario->FtaTiempoCreacion = date("Y-m-d H:i:s");
	$InsFacturaTalonario->FtaTiempoModificacion = date("Y-m-d H:i:s");
	$InsFacturaTalonario->FtaEliminado = 1;
		
	if($InsFacturaTalonario->MtdRegistrarFacturaTalonario()){
			$Registro = true;				
		unset($InsFacturaTalonario);		
		$Resultado.='#SAS_FTA_101';
	} else{
		$Resultado.='#ERR_FTA_101';
	}

}else{

	$InsFacturaTalonario->SucId = $_SESSION['SesionSucursal'];
	
}
?>
<?php
//Si se hizo click en guardar	

if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	
	$InsComprobanteRetencionTalonario->CrtId = $_POST['CmpId'];
	$InsComprobanteRetencionTalonario->CrtNumero = $_POST['CmpNumero'];
	$InsComprobanteRetencionTalonario->CrtInicio = $_POST['CmpInicio'];
	$InsComprobanteRetencionTalonario->CrtDescripcion = $_POST['CmpDescripcion'];

	$InsComprobanteRetencionTalonario->CrtTiempoCreacion = date("Y-m-d H:i:s");
	$InsComprobanteRetencionTalonario->CrtTiempoModificacion = date("Y-m-d H:i:s");
	$InsComprobanteRetencionTalonario->CrtEliminado = 1;
		
	if($InsComprobanteRetencionTalonario->MtdRegistrarComprobanteRetencionTalonario()){
		unset($InsComprobanteRetencionTalonario);		
		$Resultado.='#SAS_FTA_101';
	} else{
		$Resultado.='#ERR_FTA_101';
	}

}else{

}
?>
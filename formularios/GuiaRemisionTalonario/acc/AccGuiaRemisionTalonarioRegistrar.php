<?php
//Si se hizo click en guardar	

if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	
	$InsGuiaRemisionTalonario->GrtId = $_POST['CmpId'];
	$InsGuiaRemisionTalonario->SucId = $_POST['CmpSucursal'];
	$InsGuiaRemisionTalonario->GrtNumero = $_POST['CmpNumero'];
	$InsGuiaRemisionTalonario->GrtInicio = $_POST['CmpInicio'];
	$InsGuiaRemisionTalonario->GrtDescripcion = $_POST['CmpDescripcion'];

	$InsGuiaRemisionTalonario->GrtTiempoCreacion = date("Y-m-d H:i:s");
	$InsGuiaRemisionTalonario->GrtTiempoModificacion = date("Y-m-d H:i:s");
	$InsGuiaRemisionTalonario->GrtEliminado = 1;
		
	if($InsGuiaRemisionTalonario->MtdRegistrarGuiaRemisionTalonario()){
			$Registro = true;				
		unset($InsGuiaRemisionTalonario);		
		$Resultado.='#SAS_GRT_101';
	} else{
		$Resultado.='#ERR_GRT_101';
	}

}else{

	$InsGuiaRemisionTalonario->SucId = $_SESSION['SesionSucursal'];
	
}
?>
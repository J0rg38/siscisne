<?php
//Si se hizo click en guardar	
		
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	
	$InsNotaDebitoTalonario->NdtId = $_POST['CmpId'];
	$InsNotaDebitoTalonario->SucId = $_POST['CmpSucursal'];
	$InsNotaDebitoTalonario->NdtNumero = $_POST['CmpNumero'];
	$InsNotaDebitoTalonario->NdtInicio = $_POST['CmpInicio'];
	$InsNotaDebitoTalonario->NdtDescripcion = $_POST['CmpDescripcion'];
	$InsNotaDebitoTalonario->NdtTiempoModificacion = date("Y-m-d H:i:s");
				
		if($InsNotaDebitoTalonario->MtdEditarNotaDebitoTalonario()){	
			$Registro = true;				
			$Resultado.='#SAS_NDT_102';			
			FncCargarDatos();
		}else{			
			$Resultado.='#ERR_NDT_102';		
		}			
			
}else{
	FncCargarDatos();	
}

function FncCargarDatos(){
	
	global $GET_id;
	global $InsNotaDebitoTalonario;
	
	$InsNotaDebitoTalonario->NdtId = $GET_id;	
	$InsNotaDebitoTalonario = $InsNotaDebitoTalonario->MtdObtenerNotaDebitoTalonario();	
}
?>
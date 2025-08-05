<?php
//Si se hizo click en guardar	
		
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	
	$InsNotaCreditoTalonario->NctId = $_POST['CmpId'];
	$InsNotaCreditoTalonario->SucId = $_POST['CmpSucursal'];
	$InsNotaCreditoTalonario->NctNumero = $_POST['CmpNumero'];
	$InsNotaCreditoTalonario->NctInicio = $_POST['CmpInicio'];
	$InsNotaCreditoTalonario->NctDescripcion = $_POST['CmpDescripcion'];
	$InsNotaCreditoTalonario->NctTiempoModificacion = date("Y-m-d H:i:s");
				
		if($InsNotaCreditoTalonario->MtdEditarNotaCreditoTalonario()){	
			$Registro = true;				
			$Resultado.='#SAS_NCT_102';			
			FncCargarDatos();
		}else{			
			$Resultado.='#ERR_NCT_102';		
		}			
			
}else{
	FncCargarDatos();	
}

function FncCargarDatos(){
	
	global $GET_id;
	global $InsNotaCreditoTalonario;
	
	$InsNotaCreditoTalonario->NctId = $GET_id;	
	$InsNotaCreditoTalonario = $InsNotaCreditoTalonario->MtdObtenerNotaCreditoTalonario();	
}
?>
<?php
//Si se hizo click en guardar	
		
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	
	$InsGuiaRemisionTalonario->GrtId = $_POST['CmpId'];
	$InsGuiaRemisionTalonario->SucId = $_POST['CmpSucursal'];
	$InsGuiaRemisionTalonario->GrtNumero = $_POST['CmpNumero'];
	$InsGuiaRemisionTalonario->GrtInicio = $_POST['CmpInicio'];
	$InsGuiaRemisionTalonario->GrtDescripcion = $_POST['CmpDescripcion'];
	$InsGuiaRemisionTalonario->GrtTiempoModificacion = date("Y-m-d H:i:s");
				
		if($InsGuiaRemisionTalonario->MtdEditarGuiaRemisionTalonario()){	
			$Registro = true;				
			$Resultado.='#SAS_GRT_102';			
			FncCargarDatos();
		}else{			
			$Resultado.='#ERR_GRT_102';		
		}			
			
}else{
	FncCargarDatos();	
}

function FncCargarDatos(){
	
	global $GET_id;
	global $InsGuiaRemisionTalonario;
	
	$InsGuiaRemisionTalonario->GrtId = $GET_id;	
	$InsGuiaRemisionTalonario = $InsGuiaRemisionTalonario->MtdObtenerGuiaRemisionTalonario();	
}
?>
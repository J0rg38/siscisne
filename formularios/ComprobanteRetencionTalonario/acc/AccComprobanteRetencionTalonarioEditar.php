<?php
//Si se hizo click en guardar	
		
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	
	$InsComprobanteRetencionTalonario->CrtId = $_POST['CmpId'];
	$InsComprobanteRetencionTalonario->CrtNumero = $_POST['CmpNumero'];
	$InsComprobanteRetencionTalonario->CrtInicio = $_POST['CmpInicio'];
	$InsComprobanteRetencionTalonario->CrtDescripcion = $_POST['CmpDescripcion'];
	$InsComprobanteRetencionTalonario->CrtTiempoModificacion = date("Y-m-d H:i:s");
				
		if($InsComprobanteRetencionTalonario->MtdEditarComprobanteRetencionTalonario()){					
			$Resultado.='#SAS_FTA_102';			
			FncCargarDatos();
		}else{			
			$Resultado.='#ERR_FTA_102';		
		}			
			
}else{
	FncCargarDatos();	
}

function FncCargarDatos(){
	
	global $GET_id;
	global $InsComprobanteRetencionTalonario;
	
	$InsComprobanteRetencionTalonario->CrtId = $GET_id;	
	$InsComprobanteRetencionTalonario = $InsComprobanteRetencionTalonario->MtdObtenerComprobanteRetencionTalonario();	
}
?>
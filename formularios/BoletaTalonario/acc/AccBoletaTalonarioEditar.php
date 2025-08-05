<?php
//Si se hizo click en guardar	
		
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	
	$InsBoletaTalonario->BtaId = $_POST['CmpId'];
	$InsBoletaTalonario->SucId = $_POST['CmpSucursal'];
	$InsBoletaTalonario->BtaNumero = $_POST['CmpNumero'];
	$InsBoletaTalonario->BtaInicio = $_POST['CmpInicio'];
	$InsBoletaTalonario->BtaDescripcion = $_POST['CmpDescripcion'];
	$InsBoletaTalonario->BtaTiempoModificacion = date("Y-m-d H:i:s");
				
		if($InsBoletaTalonario->MtdEditarBoletaTalonario()){	
			$Registro = true;				
			$Resultado.='#SAS_BTA_102';			
			FncCargarDatos();
		}else{			
			$Resultado.='#ERR_BTA_102';		
		}			
			
}else{
	FncCargarDatos();	
}

function FncCargarDatos(){
	
	global $GET_id;
	global $InsBoletaTalonario;
	
	$InsBoletaTalonario->BtaId = $GET_id;	
	$InsBoletaTalonario = $InsBoletaTalonario->MtdObtenerBoletaTalonario();	
}
?>
<?php
//Si se hizo click en guardar	
		
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	
	$InsFacturaTalonario->FtaId = $_POST['CmpId'];
	$InsFacturaTalonario->SucId = $_POST['CmpSucursal'];
	$InsFacturaTalonario->FtaNumero = $_POST['CmpNumero'];
	$InsFacturaTalonario->FtaInicio = $_POST['CmpInicio'];
	$InsFacturaTalonario->FtaDescripcion = $_POST['CmpDescripcion'];
	$InsFacturaTalonario->FtaTiempoModificacion = date("Y-m-d H:i:s");
				
		if($InsFacturaTalonario->MtdEditarFacturaTalonario()){	
			$Registro = true;				
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
	global $InsFacturaTalonario;
	
	$InsFacturaTalonario->FtaId = $GET_id;	
	$InsFacturaTalonario = $InsFacturaTalonario->MtdObtenerFacturaTalonario();	
}
?>
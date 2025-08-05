<?php
//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	$InsPersonalTipo->PtiId = $_POST['CmpId'];
	$InsPersonalTipo->PtiNombre = $_POST['CmpNombre'];
	$InsPersonalTipo->PtiDescripcion = $_POST['CmpDescripcion'];
	$InsPersonalTipo->PtiEstado = $_POST['CmpEstado'];
	$InsPersonalTipo->PtiTiempoModificacion = date("Y-m-d H:i:s");
				
	if($InsPersonalTipo->MtdEditarPersonalTipo()){					
		$Resultado.='#SAS_PTI_102';		
			FncCargarDatos();	
	}else{			
		$Resultado.='#ERR_PTI_102';		
	}			
			
			
}else{
	FncCargarDatos();
}

function FncCargarDatos(){
	global $GET_id;
	global $InsPersonalTipo;
	global $Identificador;
	
	$InsPersonalTipo->PtiId = $GET_id;
	$InsPersonalTipo = $InsPersonalTipo->MtdObtenerPersonalTipo();			
	
}
?>
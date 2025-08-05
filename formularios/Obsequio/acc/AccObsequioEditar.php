<?php
//Si se hizo click en guardar	
		
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	
	$InsObsequio->ObsId = $_POST['CmpId'];
	$InsObsequio->ObsNombre = $_POST['CmpNombre'];
	$InsObsequio->ObsDescripcion = addslashes($_POST['CmpDescripcion']);
	$InsObsequio->ObsUso = $_POST['CmpTipo'];
	$InsObsequio->ObsEstado = $_POST['CmpEstado'];
	$InsObsequio->ObsTiempoModificacion = date("Y-m-d H:i:s");
			
	if($InsObsequio->MtdEditarObsequio()){	
			$Registro = true;				
		$Resultado.='#SAS_OBS_102';
		FncCargarDatos();
	}else{			
	
		$Resultado.='#ERR_OBS_102';		
	}			
	
}else{
	FncCargarDatos();
}

function FncCargarDatos(){
	
	global $GET_id;
	global $InsObsequio;
	
	$InsObsequio->ObsId = $GET_id;
	$InsObsequio->MtdObtenerObsequio();		
		
}
?>
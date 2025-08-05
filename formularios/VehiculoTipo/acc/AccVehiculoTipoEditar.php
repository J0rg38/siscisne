<?php
//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	
	$InsVehiculoTipo->VtiId = $_POST['CmpId'];
	$InsVehiculoTipo->VtiNombre = $_POST['CmpNombre'];
	$InsVehiculoTipo->VtiEstado = 1;
	$InsVehiculoTipo->VtiTiempoModificacion = date("Y-m-d H:i:s");
		
		if($InsVehiculoTipo->MtdEditarVehiculoTipo()){					
			$Resultado.='#SAS_VTI_102';
			FncCargarDatos();			
		}else{			
			$Resultado.='#ERR_VTI_102';		
		}			
			
}else{
	FncCargarDatos();
}

function FncCargarDatos(){
	global $GET_id;
	global $InsVehiculoTipo;
	$InsVehiculoTipo->VtiId = $GET_id;
	$InsVehiculoTipo = $InsVehiculoTipo->MtdObtenerVehiculoTipo();		
}

?>
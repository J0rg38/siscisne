<?php
//Si se hizo click en guardar	
		
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	
	$InsCalificacion->CalId = $_POST['CmpId'];
	$InsCalificacion->CalNombre = $_POST['CmpNombre'];
	$InsCalificacion->CalDescripcion = $_POST['CmpDescripcion'];
	$InsCalificacion->CalTiempoModificacion = date("Y-m-d H:i:s");
				
		if($InsCalificacion->MtdEditarCalificacion()){					
			$Resultado.='#SAS_CAL_102';
			FncCargarDatos();
		}else{			
			$Resultado.='#ERR_CAL_102';		
		}			
			
}else{
	FncCargarDatos();
}

function FncCargarDatos(){
	
	global $GET_id;
	global $InsCalificacion;
	$InsCalificacion->CalId = $GET_id;
	$InsCalificacion = $InsCalificacion->MtdObtenerCalificacion();		
		
}
?>
<?php
//Si se hizo click en guardar	
		
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	
	$InsTipoGasto->TgaId = $_POST['CmpId'];
	$InsTipoGasto->TgaNombre = $_POST['CmpNombre'];
	$InsTipoGasto->TgaDescripcion = addslashes($_POST['CmpDescripcion']);
	$InsTipoGasto->TgaUso = $_POST['CmpUso'];	
	
	$InsTipoGasto->TgaEstado = $_POST['CmpEstado'];
	$InsTipoGasto->TgaTiempoModificacion = date("Y-m-d H:i:s");
			
	if($InsTipoGasto->MtdEditarTipoGasto()){	
			$Registro = true;				
		$Resultado.='#SAS_TGA_102';
		FncCargarDatos();
	}else{			
	
		$Resultado.='#ERR_TGA_102';		
	}			
	
}else{
	FncCargarDatos();
}

function FncCargarDatos(){
	
	global $GET_id;
	global $InsTipoGasto;
	
	$InsTipoGasto->TgaId = $GET_id;
	$InsTipoGasto->MtdObtenerTipoGasto();		
		
}
?>
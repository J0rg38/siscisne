<?php
//Si se hizo click en guardar	
		
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	
	$InsTipoReferido->TrfId = $_POST['CmpId'];
	$InsTipoReferido->TrfNombre = $_POST['CmpNombre'];
	$InsTipoReferido->TrfDescripcion = addslashes($_POST['CmpDescripcion']);
	$InsTipoReferido->TrfUso = $_POST['CmpUso'];	
	
	$InsTipoReferido->TrfEstado = $_POST['CmpEstado'];
	$InsTipoReferido->TrfTiempoModificacion = date("Y-m-d H:i:s");
			
	if($InsTipoReferido->MtdEditarTipoReferido()){	
			$Registro = true;				
		$Resultado.='#SAS_TRF_102';
		FncCargarDatos();
	}else{			
	
		$Resultado.='#ERR_TRF_102';		
	}			
	
}else{
	FncCargarDatos();
}

function FncCargarDatos(){
	
	global $GET_id;
	global $InsTipoReferido;
	
	$InsTipoReferido->TrfId = $GET_id;
	$InsTipoReferido->MtdObtenerTipoReferido();		
		
}
?>
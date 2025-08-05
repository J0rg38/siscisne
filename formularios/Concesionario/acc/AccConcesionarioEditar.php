<?php
//Si se hizo click en guardar	
		
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	
	$InsConcesionario->OncId = $_POST['CmpId'];
	$InsConcesionario->OncCodigoDealer = $_POST['CmpCodigoDealer'];
	$InsConcesionario->OncNumeroDocumento = $_POST['CmpNumeroDocumento'];
	$InsConcesionario->OncNombre = $_POST['CmpNombre'];
	$InsConcesionario->OncDescripcion = $_POST['CmpDescripcion'];
	$InsConcesionario->OncEstado = $_POST['CmpEstado'];
	$InsConcesionario->OncTiempoModificacion = date("Y-m-d H:i:s");
				
	if($InsConcesionario->MtdEditarConcesionario()){					
		$Edito = true;
		$Resultado.='#SAS_ONC_102';
		FncCargarDatos();
	}else{			
		$Resultado.='#ERR_ONC_102';		
	}			
			
}else{
	FncCargarDatos();
}

function FncCargarDatos(){
	
	global $GET_id;
	global $InsConcesionario;
	$InsConcesionario->OncId = $GET_id;
	$InsConcesionario = $InsConcesionario->MtdObtenerConcesionario();		
		
}
?>
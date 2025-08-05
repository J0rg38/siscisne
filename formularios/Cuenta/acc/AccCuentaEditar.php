<?php
//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	$InsCuenta->CueId = $_POST['CmpId'];
	$InsCuenta->CueNumero = $_POST['CmpNumero'];
	$InsCuenta->CueCCI = $_POST['CmpCCI'];
	$InsCuenta->BanId = $_POST['CmpBanco'];
	$InsCuenta->MonId = $_POST['CmpMoneda'];
	$InsCuenta->CueDescripcion = addslashes($_POST['CmpDescripcion']);
	$InsCuenta->CueEstado = $_POST['CmpEstado'];
	$InsCuenta->CueTiempoModificacion = date("Y-m-d H:i:s");
				
			
		if($InsCuenta->MtdEditarCuenta()){		
			$Edito = true;			
			$Resultado.='#SAS_CUE_102';		
			FncCargarDatos();	
		}else{			
			$Resultado.='#ERR_CUE_102';		
		}			
			
			
}else{
	FncCargarDatos();
}

function FncCargarDatos(){
	global $GET_id;
	global $InsCuenta;
	global $Identificador;

		
	$InsCuenta->CueId = $GET_id;
	$InsCuenta->MtdObtenerCuenta();			
	
}
?>
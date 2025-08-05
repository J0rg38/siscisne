<?php
//Si se hizo click en guardar	
		
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	
	$InsBanco->BanId = $_POST['CmpId'];
	$InsBanco->BanNombre = $_POST['CmpNombre'];
	$InsBanco->BanDescripcion = addslashes($_POST['CmpDescripcion']);
	$InsBanco->BanTiempoModificacion = date("Y-m-d H:i:s");
				
		if($InsBanco->MtdEditarBanco()){		
			$Edito = true;			
			$Resultado.='#SAS_BAN_102';
			FncCargarDatos();
		}else{			
			$Resultado.='#ERR_BAN_102';		
		}			
			
}else{
	FncCargarDatos();
}

function FncCargarDatos(){
	
	global $GET_id;
	global $InsBanco;
	$InsBanco->BanId = $GET_id;
	$InsBanco = $InsBanco->MtdObtenerBanco();		
		
}
?>
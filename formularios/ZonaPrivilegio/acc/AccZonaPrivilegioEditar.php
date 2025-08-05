<?php
//Si se hizo click en guardar	
		
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	
	$InsZonaPrivilegio->ZprId = $_POST['CmpId'];
	$InsZonaPrivilegio->ZonId = $_POST['CmpZona'];
	$InsZonaPrivilegio->PriId = $_POST['CmpPrivilegio'];
				
		if($InsZonaPrivilegio->MtdEditarZonaPrivilegio()){					
			$Resultado.='#SAS_ZPR_102';
			FncCargarDatos();
		}else{			
			$Resultado.='#ERR_ZPR_102';		
		}			
			
}else{
	FncCargarDatos();
}

function FncCargarDatos(){
	
	global $GET_id;
	global $InsZonaPrivilegio;
	$InsZonaPrivilegio->ZprId = $GET_id;
	$InsZonaPrivilegio = $InsZonaPrivilegio->MtdObtenerZonaPrivilegio();		
		
}
?>
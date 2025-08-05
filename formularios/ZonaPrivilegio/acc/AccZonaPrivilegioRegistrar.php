<?php
//Si se hizo click en guardar	

if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	
	$InsZonaPrivilegio->ZprId = $_POST['CmpId'];
	$InsZonaPrivilegio->ZonId = $_POST['CmpZona'];
	$InsZonaPrivilegio->PriId = $_POST['CmpPrivilegio'];
		
	if($InsZonaPrivilegio->MtdRegistrarZonaPrivilegio()){
		unset($InsZonaPrivilegio);
		$Resultado.='#SAS_ZPR_101';
		
	} else{
		$Resultado.='#ERR_ZPR_101';
	}

}else{

}
?>
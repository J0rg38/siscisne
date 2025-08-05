<?php
//Si se hizo click en guardar	

if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	
	$InsZona->ZcaId = "ZCA-10000";
	$InsZona->ZonNombre = $_POST['CmpNombre'];
	$InsZona->ZonAlias = $_POST['CmpAlias'];

	$InsZona->ZonaPrivilegio = array();

	foreach($ArrPrivilegios as $DatPrivilegio){

		$InsZonaPrivilegio1 = new ClsZonaPrivilegio();
		$InsZonaPrivilegio1->PriId = $_POST['CmpPrivilegioId_'.$DatPrivilegio->PriId];
		
		if(!empty($InsZonaPrivilegio1->PriId)){
			$InsZona->ZonaPrivilegio[] = $InsZonaPrivilegio1;	
		}	

		$InsZonaPrivilegio1->InsMysql = NULL;
				
	}
		


	if($InsZona->MtdRegistrarZona()){
		unset($InsZona);
		$Resultado.='#SAS_ZON_101';
		
	} else{
		$Resultado.='#ERR_ZON_101';
	}

}else{

}
?>
<?php
//Si se hizo click en guardar	

if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	
	$InsRol->RolId = $_POST['CmpId'];
	$InsRol->RolNombre = $_POST['CmpNombre'];
	$InsRol->RolTiempoCreacion = date("Y-m-d H:i:s");
	$InsRol->RolTiempoModificacion = date("Y-m-d H:i:s");
	
	
		
	foreach($ArrZonas as $DatZona){
		
		$ResZonaPrivilegio = $InsZonaPrivilegio->MtdObtenerZonaPrivilegios(NULL,NULL,"ZprId","ASC",NULL,$DatZona->ZonId);
		$ArrZonaPrivilegios = $ResZonaPrivilegio['Datos'];
		
		foreach($ArrZonaPrivilegios as $DatZonaPrivilegio){
		
			if(isset($_POST['Chk_'.$DatZona->ZonId.'__'.$DatZonaPrivilegio->PriId])){
				
				$InsRolZonaPrivilegio1 = new ClsRolZonaPrivilegio();
				$InsRolZonaPrivilegio1->ZprId = $DatZonaPrivilegio->ZprId;
				
				$InsRolZonaPrivilegio1->Mysql = NULL;
				
				$InsRol->RolZonaPrivilegio[] = $InsRolZonaPrivilegio1;
				
				
			}
			
		}
		
	}
	

	if($InsRol->MtdRegistrarRol()){
		$Registro = true;
		$Resultado.='#SAS_ROL_101';
		unset($InsRol);
		//$InsRol = new ClsRol();
		//$InsRol->MtdGenerarRolId();
		
	} else{
		$Resultado.='#ERR_ROL_101';
	}

}else{
	
	//$InsRol->MtdGenerarRolId();
	
}
?>
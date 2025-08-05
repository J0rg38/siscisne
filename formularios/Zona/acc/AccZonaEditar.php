<?php
//Si se hizo click en guardar	
		
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	
	$InsZona->ZonId = $_POST['CmpId'];
	$InsZona->ZonNombre = $_POST['CmpNombre'];
	$InsZona->ZonAlias = $_POST['CmpAlias'];
				
	$InsZona->ZonaPrivilegio = array();

//deb($_POST);
	foreach($ArrPrivilegios as $DatPrivilegio){

		$InsZonaPrivilegio1 = new ClsZonaPrivilegio();
		$InsZonaPrivilegio1->ZprId = $_POST['CmpZonaPrivilegioId_'.$DatPrivilegio->PriId];
		$InsZonaPrivilegio1->PriId = $_POST['CmpPrivilegioId_'.$DatPrivilegio->PriId];

		if(!empty($InsZonaPrivilegio1->ZprId)){
			if(empty($InsZonaPrivilegio1->PriId)){
				$InsZonaPrivilegio1->ZprEliminado = 2;
			}else{
				$InsZonaPrivilegio1->ZprEliminado = 1;
			}
		}else{
			if(empty($InsZonaPrivilegio1->PriId)){
				$InsZonaPrivilegio1->ZprEliminado = 2;
			}else{
				$InsZonaPrivilegio1->ZprEliminado = 1;
			}

		}

		$InsZonaPrivilegio1->InsMysql = NULL;

		$InsZona->ZonaPrivilegio[] = $InsZonaPrivilegio1;	
				
	}

/*	for($i=0;$i<$TotalZonaPrivilegios;$i++){

		$InsZonaPrivilegio1 = new ClsZonaPrivilegio();
		$InsZonaPrivilegio1->ZprId = $_POST['CmpZonaPrivilegioId'][$i];
		$InsZonaPrivilegio1->PriId = $_POST['CmpPrivilegioId'][$i];
		
		if(!empty($InsZonaPrivilegio1->ZprId)){
			if(empty($InsZonaPrivilegio1->PriId)){
				$InsZonaPrivilegio1->ZprEliminado = 2;
			}else{
				$InsZonaPrivilegio1->ZprEliminado = 1;
			}
		}else{
			$InsZonaPrivilegio1->ZprEliminado = 1;			
		}

		$InsZonaPrivilegio1->InsMysql = NULL;

		$InsZona->ZonaPrivilegio[] = $InsZonaPrivilegio1;	

	}*/
	
	if($InsZona->MtdEditarZona()){					
		$Resultado.='#SAS_ZON_102';
		FncCargarDatos();
	}else{			
		$Resultado.='#ERR_ZON_102';		
	}			
			
}else{
	FncCargarDatos();
}

function FncCargarDatos(){
	
	global $GET_id;
	global $InsZona;
	$InsZona->ZonId = $GET_id;
	$InsZona = $InsZona->MtdObtenerZona();		
		
}
?>
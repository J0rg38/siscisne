<?php
//Si se hizo click en guardar	
		
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	
	$InsPrivilegio->PriId = $_POST['CmpId'];
	$InsPrivilegio->PriNombre = $_POST['CmpNombre'];
	$InsPrivilegio->PriAlias = $_POST['CmpAlias'];
				
		if($InsPrivilegio->MtdEditarPrivilegio()){					
			$Resultado.='#SAS_PRI_102';
			FncCargarDatos();
		}else{			
			$Resultado.='#ERR_PRI_102';		
		}			
			
}else{
	FncCargarDatos();
}

function FncCargarDatos(){
	
	global $GET_id;
	global $InsPrivilegio;
	$InsPrivilegio->PriId = $GET_id;
	$InsPrivilegio = $InsPrivilegio->MtdObtenerPrivilegio();		
		
}
?>
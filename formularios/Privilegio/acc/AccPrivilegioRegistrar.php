<?php
//Si se hizo click en guardar	

if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	
	$InsPrivilegio->PriNombre = $_POST['CmpNombre'];
	$InsPrivilegio->PriAlias = $_POST['CmpAlias'];
		
	if($InsPrivilegio->MtdRegistrarPrivilegio()){
		unset($InsPrivilegio);
		$Resultado.='#SAS_PRI_101';
		
	} else{
		$Resultado.='#ERR_PRI_101';
	}

}else{

}
?>
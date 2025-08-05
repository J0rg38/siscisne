<?php
//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	
	$InsVehiculoCategoria->VcaId = $_POST['CmpId'];
	$InsVehiculoCategoria->VcaSubId = $_POST['CmpCategoriaId'];
	$InsVehiculoCategoria->VcaNombre = $_POST['CmpNombre'];
	$InsVehiculoCategoria->VcaTiempoModificacion = date("Y-m-d H:i:s");
	$InsVehiculoCategoria->VcaSubNombre = $_POST['CmpCategoriaNombre'];
		
		if($InsVehiculoCategoria->MtdEditarVehiculoCategoria()){					
			$Resultado.='#SAS_PCA_102';
			FncCargarDatos();			
		}else{			
			$Resultado.='#ERR_PCA_102';		
		}			
			
}else{
	FncCargarDatos();
}

function FncCargarDatos(){
	global $GET_id;
	global $InsVehiculoCategoria;
	$InsVehiculoCategoria->VcaId = $GET_id;
	$InsVehiculoCategoria = $InsVehiculoCategoria->MtdObtenerVehiculoCategoria();		
}

?>
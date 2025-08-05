<?php
//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	$InsVehiculoCategoria->VcaId = $_POST['CmpId'];
	$InsVehiculoCategoria->VcaSubId = $_POST['CmpCategoriaId'];
	$InsVehiculoCategoria->VcaNombre = $_POST['CmpNombre'];
	$InsVehiculoCategoria->VcaTiempoCreacion = date("Y-m-d H:i:s");
	$InsVehiculoCategoria->VcaTiempoModificacion = date("Y-m-d H:i:s");
	$InsVehiculoCategoria->VcaEliminado = 1;
	
	$InsVehiculoCategoria->VcaSubNombre = $_POST['CmpCategoriaNombre'];	
		
	if($InsVehiculoCategoria->MtdRegistrarVehiculoCategoria()){	
		$Resultado.='#SAS_PCA_101';
		unset($InsVehiculoCategoria);
		//$InsVehiculoCategoria = new ClsVehiculoCategoria();
		//$InsVehiculoCategoria->MtdGenerarVehiculoCategoriaId();
		
	} else{
		$Resultado.='#ERR_PCA_101';
	}

}else{
	//$InsVehiculoCategoria->MtdGenerarVehiculoCategoriaId();
}


?>
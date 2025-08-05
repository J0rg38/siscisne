<?php
//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	
	$InsVehiculo->VehId = $_POST['CmpId'];
	$InsVehiculo->VmaId = $_POST['CmpVehiculoMarca'];
	$InsVehiculo->VmoId = $_POST['CmpVehiculoModelo'];
	$InsVehiculo->VveId = $_POST['CmpVehiculoVersion'];
	$InsVehiculo->VehNombre = $_POST['CmpVehiculoNombre'];
	$InsVehiculo->VehEspecificacion = $_SESSION['SesVehEspecificacion'.$Identificador];
	$InsVehiculo->VehColor = $_POST['CmpColor'];
	$InsVehiculo->VehInformacion = addslashes(preg_replace("[\n|\r|\n\r]", '',$_POST['CmpInformacion']));
	
	$InsVehiculo->VehFoto = $_SESSION['SesVehFoto'.$Identificador];
	$InsVehiculo->VehEstado = $_POST['CmpEstado'];	
	$InsVehiculo->VehTiempoCreacion = date("Y-m-d H:i:s");
	$InsVehiculo->VehTiempoModificacion = date("Y-m-d H:i:s");
	$InsVehiculo->VehEliminado = 1;

	$InsVehiculo->VcaNombre = $_POST['CmpCategoriaNombre'];

	if($InsVehiculo->MtdRegistrarVehiculo()){
		unset($_SESSION['SesVehFoto'.$Identificador]);
		unset($_SESSION['SesVehEspecificacion'.$Identificador]);
		unset($InsVehiculo);		
		$InsVehiculo= new ClsVehiculo();
		$Resultado.='#SAS_VEH_101';
	} else{
		$InsVehiculo->VcaId = $_POST['CmpCategoria'];
		$Resultado.='#ERR_VEH_101';
	}

}else{
	unset($_SESSION['SesVehFoto'.$Identificador]);
	unset($_SESSION['SesVehEspecificacion'.$Identificador]);
}
?>
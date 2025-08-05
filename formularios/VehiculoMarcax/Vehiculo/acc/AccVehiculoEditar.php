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

	$InsVehiculo->VehTiempoModificacion = date("Y-m-d H:i:s");
	$InsVehiculo->VcaNombre = $_POST['CmpCategoriaNombre'];
	
		if($InsVehiculo->MtdEditarVehiculo()){					
			$Resultado.='#SAS_VEH_102';	
			FncCargarDatos();		
		}else{			
			$Resultado.='#ERR_VEH_102';		
		}			
			
}else{
	FncCargarDatos();
}

function FncCargarDatos(){
	
	global $GET_id;
	global $InsVehiculo;
	global $Identificador;
	
	unset($_SESSION['SesVehFoto'.$Identificador]);
	unset($_SESSION['SesVehEspecificacion'.$Identificador]);
	
	$InsVehiculo->VehId = $GET_id;
	$InsVehiculo = $InsVehiculo->MtdObtenerVehiculo();		
			
	$_SESSION['SesVehFoto'.$Identificador] =	$InsVehiculo->VehFoto;
	$_SESSION['SesVehEspecificacion'.$Identificador] =	$InsVehiculo->VehEspecificacion;
	

}

?>
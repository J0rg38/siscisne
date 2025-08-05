<?php
//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	
	$InsCuenta->CueId = $_POST['CmpId'];
	$InsCuenta->CueNumero = $_POST['CmpNumero'];
	$InsCuenta->CueCCI = $_POST['CmpCCI'];
	$InsCuenta->BanId = $_POST['CmpBanco'];
	$InsCuenta->MonId = $_POST['CmpMoneda'];
	$InsCuenta->CueSaldo = 0;
	$InsCuenta->CueEstado = $_POST['CmpEstado'];
	$InsCuenta->CueDescripcion = addslashes($_POST['CmpDescripcion']);
	$InsCuenta->CueTiempoCreacion = date("Y-m-d H:i:s");
	$InsCuenta->CueTiempoModificacion = date("Y-m-d H:i:s");
	$InsCuenta->CueEliminado = 1;
		
	
	if($InsCuenta->MtdRegistrarCuenta()){
		$Registro = true;
		$Resultado.='#SAS_CUE_101';		
		unset($InsCuenta);
	} else{
		$Resultado.='#ERR_CUE_101';
	}

}else{
	
}
?>
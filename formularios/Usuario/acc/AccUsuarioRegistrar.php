<?php
//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	
	$InsUsuario->UsuId = $_POST['CmpId'];	
	$InsUsuario->RolId = $_POST['CmpRol'];	
	$InsUsuario->UsuUsuario = $_POST['CmpUsuario'];
	$InsUsuario->UsuContrasena = $_POST['CmpContrasena'];
	$InsUsuario->UsuEstado = $_POST['CmpEstado'];
	$InsUsuario->UsuFoto = $_SESSION['SesUsuFoto'];
	$InsUsuario->UsuTiempoCreacion = date("Y-m-d H:i:s");
	$InsUsuario->UsuTiempoModificacion = date("Y-m-d H:i:s");
	$InsUsuario->UsuEliminado = 1;
		

			
			
	if($InsUsuario->MtdRegistrarUsuario()){
		
		$Registro = true;
		
		$Resultado.='#SAS_USU_101';
		
		unset($InsUsuario);
		unset($_SESSION['SesUsuFoto']);
		
	} else{	
		$Resultado.='#ERR_USU_101';
	}



}else{
	unset($_SESSION['SesUsuFoto']);
}	
?>
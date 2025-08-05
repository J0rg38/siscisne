<?php
//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	$InsUsuario->RolId = $_POST['CmpRol'];
	$InsUsuario->UsuId = $_POST['CmpId'];
	$InsUsuario->UsuUsuario = $_POST['CmpUsuario'];
	$InsUsuario->UsuContrasena = $_POST['CmpContrasena'];	
	$InsUsuario->UsuFoto = $_SESSION['SesUsuFoto'];
	$InsUsuario->UsuEstado = $_POST['CmpEstado'];
	$InsUsuario->UsuTiempoModificacion = date("Y-m-d H:i:s");
			


	
		
		if($InsUsuario->MtdEditarUsuario()){		
		
		$Registro = true;
					
			$Resultado.='#SAS_USU_102';			
			
					
			if($InsUsuario->UsuId==$_SESSION['SesionId']){
				$_SESSION['SesionFoto'] = 	$InsUsuario->UsuFoto;	
			}


			FncCargarDatos();
			
			
		}else{			
			$Resultado.='#ERR_USU_102';		
		}				
}else{
	FncCargarDatos();
}

function FncCargarDatos(){
	
	unset($_SESSION['SesUsuFoto']);
	
	global $GET_id;
	global $InsUsuario;
	$InsUsuario->UsuId = $GET_id;
	$InsUsuario = $InsUsuario->MtdObtenerUsuario();	
	
	$_SESSION['SesUsuFoto'] =	$InsUsuario->UsuFoto;
}

?>
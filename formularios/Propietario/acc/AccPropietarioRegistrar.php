<?php
//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	$Guardar = true;

	$InsPropietario->ProId = $_POST['CmpId'];	
	$InsPropietario->ProOtroCodigo = $_POST['CmpOtroCodigo'];	
	$InsPropietario->ProNumeroDocumento = $_POST['CmpNumeroDocumento'];	
	$InsPropietario->ProNombre = $_POST['CmpNombre'];
	$InsPropietario->ProApellido = $_POST['CmpApellido'];
	$InsPropietario->ProDireccion = ($_POST['CmpDireccion']);
	$InsPropietario->ProTelefono = ($_POST['CmpTelefono']);
	$InsPropietario->ProCelular = ($_POST['CmpCelular']);	
	$InsPropietario->ProGarantia = ($_POST['CmpGarantia']);
	$InsPropietario->ProDeudaPendiente = ($_POST['CmpDeudaPendiente']);	
	$InsPropietario->ProFechaRecibo = FncCambiaFechaAMysql($_POST['CmpFechaRecibo'],true);
	$InsPropietario->ProFechaReingreso = FncCambiaFechaAMysql($_POST['CmpFechaReingreso'],true);
	$InsPropietario->ProEstado = $_POST['CmpEstado'];
	$InsPropietario->ProTiempoCreacion = date("Y-m-d H:i:s");
	$InsPropietario->ProTiempoModificacion = date("Y-m-d H:i:s");
	$InsPropietario->ProEliminado = 1;

	$InsPropietario->ProFoto = $_SESSION['SesProFoto'.$Identificador];

	if(!empty($InsPropietario->ProNumeroDocumento)){
		if($InsPropietario->MtdVerificarExistePropietarioDato("ProNumeroDocumento",$InsPropietario->ProNumeroDocumento,NULL)){
			$Resultado.='#ERR_PRO_203';	
			$Guardar = false;
		}	
	}
	
	if($Guardar){

		if($InsPropietario->MtdRegistrarPropietario()){
			$Resultado.='#SAS_PRO_101';	
			unset($InsPropietario);
			unset($_SESSION['SesProFoto'.$Identificador]);
		} else{	
			$InsPropietario->ProFechaRecibo = FncCambiaFechaANormal($InsPropietario->ProFechaRecibo);	
			$InsPropietario->ProFechaReingreso = FncCambiaFechaANormal($InsPropietario->ProFechaReingreso);	
			$Resultado.='#ERR_PRO_101';	
		}	
		
	}else{
	
		$InsPropietario->ProFechaRecibo = FncCambiaFechaANormal($InsPropietario->ProFechaRecibo);	
		$InsPropietario->ProFechaReingreso = FncCambiaFechaANormal($InsPropietario->ProFechaReingreso);	
	
	}



}else{

}	
?>
<?php
//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';

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
	$InsPropietario->ProTiempoModificacion = date("Y-m-d H:i:s");

	$InsPropietario->ProFoto = $_SESSION['SesProFoto'.$Identificador];
	
	if($InsPropietario->MtdEditarPropietario()){		
		$Resultado.='#SAS_PRO_102';			
		FncCargarDatos();
	}else{			
		$Resultado.='#ERR_PRO_102';		
	}				

}else{
	FncCargarDatos();
}

function FncCargarDatos(){

	global $GET_id;
	global $InsPropietario;
	global $Identificador;
	
	$InsPropietario->ProId = $GET_id;
	$InsPropietario = $InsPropietario->MtdObtenerPropietario();	
	
	$_SESSION['SesProFoto'.$Identificador] = $InsPropietario->ProFoto;
		
}

?>
<?php
//Si se hizo click en guardar	
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Guardar = true;
	$Resultado = '';

	$InsCotizacionVehiculo->CveId = $_POST['CmpId'];
	$InsCotizacionVehiculo->CveNota = addslashes($_POST['CmpNota']);
	$InsCotizacionVehiculo->CveTiempoModificacion = date("Y-m-d H:i:s");

	if($Guardar){
		if($InsCotizacionVehiculo->MtdEditarCotizacionVehiculoDato("CveNota",$InsCotizacionVehiculo->CveNota,$InsCotizacionVehiculo->CveId)){
			$Edito = true;		
			FncCargarDatos();
			$Resultado.='#SAS_CVE_106';
		} else{
			$Resultado.='#ERR_CVE_106';		
		}
	}

}else{

	FncCargarDatos();

}

function FncCargarDatos(){
	
	
	global $GET_id;
	global $Identificador;
	global $InsCotizacionVehiculo;
	global $EmpresaMonedaId;

	$InsCotizacionVehiculo->CveId = $GET_id;
	$InsCotizacionVehiculo->MtdObtenerCotizacionVehiculo(false);		

}
?>
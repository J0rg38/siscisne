<?php
//Si se hizo click en guardar	
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Guardar = true;
	$Resultado = '';

	$InsOrdenVentaVehiculo->OvvId = $_POST['CmpId'];
	$InsOrdenVentaVehiculo->OvvNota = addslashes($_POST['CmpNota']);
	$InsOrdenVentaVehiculo->OvvTiempoModificacion = date("Y-m-d H:i:s");

	if($Guardar){
		if($InsOrdenVentaVehiculo->MtdEditarOrdenVentaVehiculoDato("OvvNota",$InsOrdenVentaVehiculo->OvvNota,$InsOrdenVentaVehiculo->OvvId)){
			$Edito = true;		
			FncCargarDatos();
			$Resultado.='#SAS_OVV_106';
		} else{
			$Resultado.='#ERR_OVV_106';		
		}
	}

}else{

	FncCargarDatos();

}

function FncCargarDatos(){
	
	
	global $GET_id;
	global $Identificador;
	global $InsOrdenVentaVehiculo;
	global $EmpresaMonedaId;

	$InsOrdenVentaVehiculo->OvvId = $GET_id;
	$InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculo(false);		

}
?>
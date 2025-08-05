<?php
//Si se hizo click en guardar	

if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	
	$InsTipoCambio->TcaId = $_POST['CmpId'];
	$InsTipoCambio->MonId = $_POST['CmpMoneda'];
	$InsTipoCambio->TcaFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	$InsTipoCambio->TcaMontoCompra = $_POST['CmpMontoCompra'];
	$InsTipoCambio->TcaMontoVenta = $_POST['CmpMontoVenta'];
	$InsTipoCambio->TcaMontoComercial = $_POST['CmpMontoComercial'];
	
	$InsTipoCambio->TcaUsuarioRegistro = $_SESSION['SesionUsuario'];
	
	
	 
	$InsTipoCambio->TcaTiempoCreacion = date("Y-m-d H:i:s");
	$InsTipoCambio->TcaTiempoModificacion = date("Y-m-d H:i:s");
		
	if($InsTipoCambio->MtdRegistrarTipoCambio()){
		unset($InsTipoCambio);
		//$InsTipoCambio = new ClsTipoCambio();
		//$InsTipoCambio->MtdGenerarTipoCambioId();
		
		$Resultado.='#SAS_TCA_101';
	} else{
		$Resultado.='#ERR_TCA_101';
		
		$InsTipoCambio->TcaFecha = FncCambiaFechaANormal($InsTipoCambio->TcaFecha);
	}

}else{
	//$InsTipoCambio->MtdGenerarTipoCambioId();
}
?>